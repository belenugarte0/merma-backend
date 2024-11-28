<?php

namespace App\Http\Controllers\Report;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\User;


class ReportController extends Controller
{

    public function dashboard()
    {
        return response()->json([
            'dashboard' => [[
                'users' => User::count(),
            ]],
        ]);
    }

    
}