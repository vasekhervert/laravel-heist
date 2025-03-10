<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index() {
        return response()->json([
            'message' => 'Zobraz všem uživatelům nějaký výpis',
        ]);
    }
}
