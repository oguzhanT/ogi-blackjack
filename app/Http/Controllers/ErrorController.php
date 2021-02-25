<?php

namespace App\Http\Controllers;

class ErrorController extends Controller
{
    public function fatal()
    {
        return view('errors.500');
    }
}
