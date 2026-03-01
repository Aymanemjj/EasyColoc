<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreInviteRequest;
use App\Mail\Invitation;
use App\Models\House;
use App\Models\Invite;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

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
        $validated['token'] = Str::random(16);
        $validated['user_id'] = auth()->user()->id;
        $validated['house_id'] = $id;
        $invitation = new Invite();
        foreach ($validated as $key => $value) {
            $invitation->$key = $value;
        }
        $invitation->save();

        Mail::to($invitation->email)->send(new Invitation($invitation));

        return redirect()->route('house.show', $id)
            ->withErrors([
                'type' => 1,
                'general' => "Invite sent to " . $invitation->email . " | Here is the token: " . $invitation->token
            ]);
    }


    public function verification($token)
    {
        $invitation = Invite::where('token', $token)->get();
        $invitation = $invitation[0];

        if(Auth::check()){
            return view("inviteResponse", compact("invitation"));
        }else{
            
        }

        

    }

    public function response() {}
}
