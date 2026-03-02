<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreInviteRequest;
use App\Mail\Invitation;
use App\Models\House;
use App\Models\Invite;
use App\Models\User;
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

        if (Auth::check()) {
            if ($invitation->isInvitee()) {
                if (auth()->user()->notReserved() || auth()->user()->role->name == 'admin') {
                    return view("inviteResponse", compact("invitation"));
                } else {
                    return redirect()->route('dashboard')
                        ->withErrors([
                            'type' => 0,
                            'general' => "Your already a member in a house"
                        ]);
                }
            } else {
                return view("inviteResponseFalse");
            }
        } else if (User::where('email', $invitation->email)->exists()) {
            return redirect("/login?invite={$invitation->token}");
        } else {
            return redirect("/register?invite={$invitation->token}");
        }
    }

    public function response($token, $action)
    {



        $invitation = Invite::where('token', $token)->get();
        $invitation = $invitation[0];
        $house = House::find($invitation->house_id);
        switch ($action) {
            case 1:
                $house->addMember(Auth::user());
                $invitation->status = 0;
                $invitation->save();
                break;
            case 2:
                $invitation->status = 0;
                $invitation->save();

                break;
            default:

                break;
        }
        return redirect(route('dashboard'));
    }
}
