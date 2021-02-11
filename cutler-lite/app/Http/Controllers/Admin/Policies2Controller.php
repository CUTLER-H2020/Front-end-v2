<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Policy;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class Policies2Controller extends Controller
{
    public function __construct()
    {
        $this->page['title'] = 'Policies 2';
        $this->page['sub_title'] = '';
    }

    public function index(Request $request)
    {
        $policies = Policy::whereUserId(Auth::user()->id)->orderBy('id', 'DESC')->get();
        return view('admin.policies2.index', compact('policies'))->with('page', $this->page);
    }
}
