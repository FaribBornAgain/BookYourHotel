<?php
// File: app/Http/Controllers/HomeController.php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Room;

class HomeController extends Controller
{
    public function index()
    {
        $rooms = Room::all();
        return view('home', compact('rooms'));
    }

    public function facilities()
    {
        return view('facilities');
    }

    public function about()
    {
        return view('about');
    }
}