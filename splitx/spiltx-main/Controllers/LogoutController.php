<?php

namespace Controllers;


class LogoutController extends Controller
{
    /**
     * Initialization
     */
    public function __construct()
    {
        parent::__construct();

        if (!user())
            redirect('login');
    }

    /**
     * Logout user
     * 
     * @return void
     */
    public function logout(): void
    {
        $this->session->destroy();

        redirect('login');
    }
}
