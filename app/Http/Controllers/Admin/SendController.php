<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class SendController extends Controller
{
    public function send()
    {
        return view('admin.employees.send');
    }
}
