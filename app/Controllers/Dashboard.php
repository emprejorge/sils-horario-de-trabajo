<?php

namespace App\Controllers;

use CodeIgniter\Controller;

class Dashboard extends Controller
{
    public function index()
    {
        if (! session()->get('user')) {
            return redirect()->to('/login');
        }

        
        $data['user'] = session()->get('user');

        return view('dashboard', $data);
    }
}