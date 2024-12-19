<?php

namespace Controllers;

use Core\Database\Database;

class GroupController extends Controller
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
     * Show the group listing screen
     * 
     * @return void
     */
    public function index(): void
    {
        $page       = (int) ($_GET['page'] ?? 1);
        $perPage    = 10;
        $offset     = ($page - 1) * $perPage;

        $totalRecords   = Database::table('groups')->count();
        $pages          = ceil($totalRecords / $perPage);

        $groups = Database::table('groups')
            ->select('id', 'name', 'created_at', 'COUNT(group_id) as members')
            ->join('members', 'groups.id', '=', 'members.group_id', 'LEFT')
            ->where('groups.user_id', user()->id)
            ->groupBy('id')
            ->orderBy('created_at', 'DESC')
            ->limit($offset, $perPage)
            ->get();

        view('group/index', compact('groups', 'pages'));
    }

    /**
     * Show group create screen
     * 
     * @return void
     */
    public function create(): void
    {
        $members = [];
        $group   = null;

        if (old('members'))
            $members = database()
                ->table('users')
                ->select('id', 'first_name', 'last_name', 'code')
                ->whereIn('code', old('members'))
                ->get();

        view('group/create', compact('group', 'members'));
    }

    /**
     * Store new group
     * 
     * @return void
     */
    public function store(): void
    {
        $data = array_values_by_keys($_POST, ['name', 'members']);

        $this->validate($data);

        if (!empty($this->errors)) {
            session()->flash('errors', $this->errors);
            session()->flash('old', $data);
            redirect('groups/create');
        }

        $group = Database::table('groups')
            ->insertGetId(array_merge(
                array_values_by_keys($data, "name"),
                ['user_id' => user()->id]
            ));

        Database::table('members')
            ->insert(array_map(
                fn ($member) => ['group_id' => $group, 'user_id' => $member],
                $data['members']
            ));

        $this->session->flash('success', 'Group successfully created');

        redirect('groups/create');
    }

    /**
     * Show group edit screen
     * 
     * @return void
     */
    public function edit(): void
    {
        if (!($_GET['id'] ?? false))
            abort();

        $group = Database::table('groups')
            ->where('id', $_GET['id'])
            ->where('user_id', user()->id)
            ->first();

        if (!$group) abort();

        $membersIds = Database::table('members')
            ->select('user_id')
            ->where('group_id', $group->id)
            ->get();

        $members = Database::table('users')
            ->whereIn('id', array_column($membersIds, 'user_id'))
            ->get();

        view('group/edit', compact('group', 'members'));
    }

    /**
     * Update group
     * 
     * @return void
     */
    public function update()
    {
        if (!($_GET['id'] ?? false))
            abort();

        $group = Database::table('groups')
            ->where('id', $_GET['id'])
            ->where('user_id', user()->id)
            ->first();

        if (!$group) abort();

        $data = array_values_by_keys($_POST, ['name', 'members']);

        $this->validate($data);

        if (!empty($this->errors)) {
            session()->flash('errors', $this->errors);
            session()->flash('old', $data);
            redirect('groups/edit?id=' . $group->id);
        }

        Database::table('groups')
            ->where('id', $group->id)
            ->update(array_merge([
                'name' => $data['name'],
            ], array_values_by_keys(generate_timestamp_fields(), ['updated_at'])));

        Database::table('members')
            ->where('group_id', $group->id)
            ->delete();

        Database::table('members')
            ->insert(array_map(
                fn ($member) => ['group_id' => $group->id, 'user_id' => $member],
                $data['members']
            ));

        $this->session->flash('success', 'Group successfully updated');

        redirect('groups/edit?id=' . $group->id);
    }

    /**
     * Delete a sepcific group
     * 
     * @return void
     */
    public function delete()
    {
        if (!($_POST['id'] ?? false))
            abort();

        $group = Database::table('groups')
            ->where('id', $_POST['id'])
            ->where('user_id', user()->id)
            ->first();

        if (!$group) abort();

        Database::table('groups')
            ->where('id', $group->id)
            ->delete();

        $this->session->flash('success', 'Group successfully deleted');

        redirectBack();
    }

    /**
     * Search user by code
     * 
     * @return void
     */
    public function searchUser()
    {
        $user = null;

        if (($code = $_GET['code'] ?? null)) {
            $user = Database::table('users')
                ->select('id', 'first_name', 'last_name', 'code')
                ->where('code', $code)
                ->where('id', '<>', user()->id)
                ->first();
        }

        header('Content-Type: application/json; charset=utf-8');
        echo json_encode($user ?? null);
        exit();
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
        $this->validateMembers($data['members'] ?? []);
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
     * Validate memebrs field
     * 
     * @param array $members
     * @return void
     */
    private function validateMembers(array $members): void
    {
        if (!$this->validator->notEmpty($members)) {
            $this->errors['members'] = "Members are required";
            return;
        }
    }
}
