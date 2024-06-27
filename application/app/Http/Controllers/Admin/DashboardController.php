<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth:admin', 'verified']);
    }

    public function index()
    {
        $data['user'] = User::where('id', Auth::user()->id)->with('fileManager')->first();
        return view('admin.dashboard.home', $data);
    }
}
