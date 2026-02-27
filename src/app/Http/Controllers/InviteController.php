<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreInviteRequest;
use App\Models\House;
use App\Models\Invite;
use Illuminate\Http\Request;

class InviteController extends Controller
{
    public function create($id)
    {
        $house = House::find($id);
        return view('inviteCreate', compact('house'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreInviteRequest $request, $id)
    {
        $validated = $request->validated();

        
    }
}
