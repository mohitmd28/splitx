<?php

namespace Controllers;

use Core\Database\Database;

class LoginController extends Controller
{
    /**
     * @var array
     */
    private $errors = [];

    /**
     * Initialization
     */
    public function __construct()
    {
        parent::__construct();

        if (user())
            redirect('dashboard');
    }

    /**
     * Display login page
     * 
     * @return void
     */
    public function show(): void
    {
        view('auth/login');
    }

    /**
     * Verify user information
     * 
     * @return void
     */
    public function verify(): void
    {
        $this->validate($_POST);

        $email      = $_POST['email'];
        $password   = $_POST['password'];

        $user = Database::table('users')
            ->where('email', $email)
            ->where('password', md5($password))
            ->first();

        if (!$user) {
            $this->session->flash(
                'errors',
                ['auth_failed' => "Credentials don't match"]
            );
            session()->flash('old', compact('email'));

            redirect('login');
        }

        $this->session->put('user', $user);

        redirect('dashboard');
    }

    /**
     * Validate the inputs
     * 
     * @return void 
     */
    private function validate(array $data): void
    {
        $email      = $data['email'] ?? false;
        $password   = $data["password"] ?? false;;

        $this->validateEmail($email);
        $this->validatePassword($password);

        if (!empty($this->errors)) {
            session()->flash('errors', $this->errors);
            session()->flash('old', compact('email'));
            redirect('login');
        }
    }

    /**
     * Validate Email
     * 
     * @param string $email
     * @return void
     */
    private function validateEmail(string $email): void
    {
        if (!$this->validator->notEmpty($email)) {
            $this->errors['email'] = "Email is required";
            return;
        }

        if (!$this->validator->stringLength($email)) {
            $this->errors['email'] = "Email must be less than or equal to 255 characters";
            return;
        }

        if ($this->validator->email($email)) {
            $this->errors['email'] = "Email is invalid";
        }
    }

    /**
     * Validate Passwoprd
     * 
     * @param string $password
     * @return void
     */
    private function validatePassword(string $password): void
    {
        if (!$this->validator->notEmpty($password)) {
            $this->errors['password'] = "Password is required";
            return;
        }

        if (!$this->validator->stringLength($password))
            $this->errors['password'] = "Password must be less than or equal to 255 characters";
    }
}
