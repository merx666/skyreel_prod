<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class UserController extends Controller
{
    /**
     * Return the authenticated user for API requests.
     */
    public function current(Request $request)
    {
        return $request->user();
    }
}