<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Inertia\Inertia;

class DashboardController extends Controller
{
    public function index (){
        $data = [
            'title' => 'Dashboard',
            'description' => 'This is the dashboard page',
        ];
        return Inertia::render('Dashboard' , compact('data'));
    }

    public function page($name){
        return Inertia::render('Dashboard/SinglePage');
    }
}
