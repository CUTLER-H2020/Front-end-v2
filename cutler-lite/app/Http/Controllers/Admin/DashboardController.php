<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Analytics;
use App\Models\Policy;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        return redirect()->route('policy.index');
    }

    public function getOnlineUsersCount()
    {
        $onlineUsersCount = User::whereIsOnline(1)->get()->count();
        return $onlineUsersCount;
    }
}
