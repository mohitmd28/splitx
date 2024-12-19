<?php

namespace Controllers;

use Core\Database\Database;

class RegisterController extends Controller
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
     * Display the register form
     * 
     * @return void
     */
    public function show(): void
    {
        view('auth/register');
    }

    /**
     * Register the user
     * 
     * @return void
     */
    public function register(): void
    {
        $data = array_values_by_keys($_POST, ['first_name', 'last_name', 'email', 'password']);

        $this->validate($data);

        $id = Database::table('users')
            ->insertGetId(array_merge($data, [
                'password' => md5($data['password']),
                'code' => $this->generateUniqueCode()
            ], generate_timestamp_fields()));

        $user = Database::table('users')->where('id', $id)->first();

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
        $this->validateFirstName($data['first_name']);
        $this->validateLastName($data['last_name']);
        $this->validateEmail($data['email']);
        $this->validatePassword($data['password']);

        if (!empty($this->errors)) {
            session()->flash('errors', $this->errors);
            session()->flash('old', array_values_by_keys($data, ['first_name', 'last_name', 'email']));
            redirect('register');
        }
    }

    /**
     * Validate first name field
     * 
     * @param string $firstName
     * @return void
     */
    private function validateFirstName(string $firstName): void
    {
        $this->validateFieldNotEmpytAndInLength('first_name', 'First Name', $firstName);
    }

    /**
     * Validate last name field
     * 
     * @param string $firstName
     * @return void
     */
    private function validateLastName(string $lastName): void
    {
        if (
            $this->validator->notEmpty($lastName) &&
            !$this->validator->stringLength($lastName)
        ) {
            $this->errors['last_name'] = "Last Name must be less than or equal to 255 characters";
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
        $this->validateFieldNotEmpytAndInLength('email', 'Email', $email);

        if ($this->validator->email($email)) {
            $this->errors['email'] = "Email is invalid";
            return;
        }

        $user = Database::table('users')->where('email', $email)->first();

        if ($user)
            $this->errors['email'] = "Email is already registerd. Pleas use another email";
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

        if (!$this->validator->stringLength($password, 8, 20))
            $this->errors['password'] = "Password must be between 8 to 20 characters";
    }

    /**
     * Validate that the field is not empty and less than or
     * equal to 255 characters
     * 
     * @param string $key
     * @param string $label
     * @param string $value
     * @return void
     */
    private function validateFieldNotEmpytAndInLength(string $key, string $label, string $value): void
    {
        if (!$this->validator->notEmpty($value)) {
            $this->errors[$key] = "$label is required";
            return;
        }

        if (!$this->validator->stringLength($value))
            $this->errors[$key] = "$label must be less than or equal to 255 characters";
    }

    /**
     * Generate a unique code for user
     * 
     * @return string
     */
    private function generateUniqueCode()
    {
        do {
            $code = str_random(10);
        } while (Database::table('users')->select('code')->where('code', $code)->first());

        return $code;
    }
}
