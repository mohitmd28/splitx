<?php

namespace Controllers;

abstract class Controller
{
    /**
     * @var \Core\Database\Database
     */
    protected $database;

    /**
     * @var \Core\Session
     */
    protected $session;

    /**
     * @var \Core\Validator
     */
    protected $validator;

    /**
     * Initialization
     * 
     * @return void
     */
    public function __construct()
    {
        $this->database = database();
        $this->session = session();
        $this->validator = validator();
    }
}
