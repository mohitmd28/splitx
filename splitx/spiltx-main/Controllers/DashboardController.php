<?php

namespace Controllers;

class DashboardController extends Controller
{
    public function __construct()
    {
        parent::__construct();

        if (!user())
            redirect('login');
    }

    /**
     * Displays dashboard
     * 
     * @return void
     */
    public function show(): void
    {
        view('dashboard');
    }
}
