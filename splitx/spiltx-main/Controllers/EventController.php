<?php

namespace Controllers;

use Core\Database\Database;
use DateTime;

class EventController extends Controller
{
    /**
     * @var array
     */
    private $errors = [];

    public function __construct()
    {
        parent::__construct();

        if (!user())
            redirect('login');
    }

    /**
     * Show the event listing screen
     * 
     * @return void
     */
    public function index(): void
    {
        $page       = (int) ($_GET['page'] ?? 1);
        $perPage    = 10;
        $offset     = ($page - 1) * $perPage;

        $totalRecords   = Database::table('events')->count();
        $pages          = ceil($totalRecords / $perPage);

        $events = Database::table('events')
            ->select('events.id', 'events.name', 'events.date', 'groups.name AS gname')
            ->join('groups', 'groups.id', '=', 'events.group_id')
            ->where('events.created_by', user()->id)
            ->orderBy('events.id', 'DESC')
            ->limit($offset, $perPage)
            ->get();

        view('event/index', compact('events', 'pages'));
    }

    /**
     * Show create screen
     * 
     * @return void
     */
    public function create(): void
    {
        $event = null;
        $groups = Database::table('groups')
            ->where('user_id', user()->id)
            ->orderBy('name', 'ASC')
            ->get();

        view('event/create', compact('event', 'groups'));
    }

    /**
     * Store new event
     * 
     * @return void
     */
    public function store(): void
    {
        $data = array_values_by_keys($_POST, ['name', 'group_id', 'date']);

        $this->validate($data);

        if (!empty($this->errors)) {
            session()->flash('errors', $this->errors);
            session()->flash('old', $data);
            redirect('events/create');
        }

        Database::table('events')
            ->insert(array_merge($data, generate_timestamp_fields(), [
                'created_by' => user()->id
            ]));

        $this->session->flash('success', 'Event successfully created');

        redirect('events/create');
    }

    /**
     * Show event edit screen
     * 
     * @return void
     */
    public function edit(): void
    {
        if (!($_GET['id'] ?? false))
            abort();

        $event = Database::table('events')
            ->where('id', $_GET['id'])
            ->where('created_by', user()->id)
            ->first();

        if (!$event) abort();

        $groups = Database::table('groups')
            ->where('user_id', user()->id)
            ->orderBy('created_at', 'DESC')
            ->get();

        view('event/edit', compact('event', 'groups'));
    }

    /**
     * Update event
     * 
     * @return void
     */
    public function update()
    {
        if (!($_GET['id'] ?? false))
            abort();

        $event = Database::table('events')
            ->where('id', $_GET['id'])
            ->where('created_by', user()->id)
            ->first();

        if (!$event) abort();

        $data = array_values_by_keys($_POST, ['name', 'group_id', 'date']);

        $this->validate($data);

        if (!empty($this->errors)) {
            session()->flash('errors', $this->errors);
            session()->flash('old', $data);
            redirect('events/edit?id=' . $event->id);
        }

        Database::table('events')
            ->where('id', $event->id)
            ->update(array_merge(
                $data,
                array_values_by_keys(generate_timestamp_fields(), ['updated_at'])
            ));

        $this->session->flash('success', 'Event successfully updated');

        redirect('events/edit?id=' . $event->id);
    }

    /**
     * Delete a specific event
     * 
     * @return void
     */
    public function delete()
    {
        if (!($_POST['id'] ?? false))
            abort();

        $event = Database::table('events')
            ->where('id', $_POST['id'])
            ->where('created_by', user()->id)
            ->first();

        if (!$event) abort();

        Database::table('events')
            ->where('id', $event->id)
            ->delete();

        $this->session->flash('success', 'Event successfully deleted');

        redirectBack();
    }

    /**
     * Validate the inputs
     * 
     * @param array $data
     * @return void 
     */
    private function validate(array $data): void
    {
        $this->validateName($data['name']);
        $this->validateGroup($data['group_id']);
        $this->validateDate($data['date']);
    }

    /**
     * Validate name field
     * 
     * @param string $name
     * @return void
     */
    private function validateName(string $name): void
    {
        if (!$this->validator->notEmpty($name)) {
            $this->errors['name'] = "Name is required";
            return;
        }

        if (!$this->validator->stringLength($name))
            $this->errors['name'] = "Name must be less than or equal to 255 characters";
    }

    /**
     * Validate group field
     * 
     * @param string $groupId
     * @return void
     */
    private function validateGroup(string $groupId): void
    {
        if (!$this->validator->notEmpty($groupId)) {
            $this->errors['group_id'] = "Group is required";
            return;
        }

        $groupRecord = Database::table('groups')
            ->where('id', $groupId)
            ->where('user_id', user()->id)
            ->first();

        if (!$groupRecord)
            $this->errors['group_id'] = "Invalid Group selected";
    }

    /**
     * Validate date field
     * 
     * @param string $date
     * @return void
     */
    private function validateDate(string $date): void
    {
        if (!$this->validator->notEmpty($date)) {
            $this->errors['date'] = "Date is required";
            return;
        }

        $dateObject = DateTime::createFromFormat('Y-m-d', $date);

        if (!$dateObject)
            $this->errors['date'] = "Invalid date provided";
    }
}
