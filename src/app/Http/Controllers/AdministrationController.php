<?php

namespace App\Http\Controllers;

use App\Models\House;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdministrationController extends Controller
{
    public function index()
    {
        $users = User::paginate(10);
        $houses = House::all();
        return view('adminDashboard', compact('users', 'houses'));
    }

    public function ban($id)
    {
        $user = User::find($id);
        $user->status = !$user->status;
        $user->save();
        return redirect()->back();
    }

    public function promote($id)
    {
        $user = User::find($id);
        if ($user->isAdmin()) {
            $user->role_id = 2;
        } else {
            $user->role_id = 1;
        }
        $user->save();
        return redirect()->back();
    }
}
