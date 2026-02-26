<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreHouseRequest;
use App\Http\Requests\UpdateHouseRequest;
use App\Models\Category;
use App\Models\Expences;
use App\Models\House;
use App\Models\PaymentPending;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Request;

class HouseController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index() {}

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('houseCreate');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreHouseRequest $request)
    {
        $validated = $request->validated();
        House::create([
            'title' => $validated['title'],
            'description' => $validated['description']
        ])->user()->attach(Auth::user(), ['is_owner' => 1]);

        return redirect()->route('dashboard');
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $house = House::find($id);
        $categories = Category::where('house_id', $id)->get();
        $expences = Expences::where('house_id', $id)->get();
        return view('house', compact('house', 'categories', 'expences'));
    }



    public function exit($id)
    {
        $house = House::find($id);
        $Auser = auth()->user();
        foreach ($house->user as $user) {
            if ($user->id === $Auser->id) $user->pivot->delete();
        }
        if (count($Auser->needToPay($house->id)) > 0) {
            $Auser->reputation - 1;
        } else {
            $Auser->reputation + 1;
        }

        return redirect()->route('dashboard');
    }

    public function cleanHouse($house) {}

    public function action(Request $request, $id, $user, $action)
    {
        $house = House::find($id);
        $user = User::find($user);

        switch ($action) {
            case 'kick':
                $this->kickUser($house, $user);
                break;
            case 'promote':
                $this->promote($house, $user);
                break;
            default:
                break;
        }
    }
    public function promote($house, $user)
    {
        foreach ($house->user as $Uuser) {
            if ($Uuser->id == $user->id) $Uuser->pivot->is_owner = 1;
            if ($Uuser->id == auth()->user()->id) $Uuser->pivot->is_owner = 0;
        }

        return redirect()->back();
    }
    public function kickUser($house, $user)
    {

        if (count($user->needToPay($house->id)) == 0) {
            foreach ($house->user as $Uuser) {
                if ($Uuser->id == $user->id) $Uuser->pivot->delete();
            }
        } else {
            foreach ($user->needToPay($house->id) as $payment) {
                $Npayment = new PaymentPending();
                $Npayment->amount = $payment->amount;
                $Npayment->user_id = $house->owner[0]->id;
                $Npayment->expence_id = $payment->expence_id;
                $Npayment->save();
                $payment->delete();
            }
            foreach ($house->user as $Uuser) {
                if ($Uuser->id == $user->id) $Uuser->pivot->delete();
            }
        }

        return redirect()->back();
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(House $house)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateHouseRequest $request, House $house)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        if (count(auth()->user()->needToPay()) == 0) {
            $house = House::find($id);
            $house->status = false;
            $house->delete();
            return redirect()->route('dashboard')
                ->withErrors([
                    "type" => 1,
                    'general' => 'Success.'
                ]);
        } else {
            return redirect()->back()
                ->withErrors([
                    'type' => 0,
                    'general' => "You can't cancel when you have pending payments"
                ]);
        }
    }
}
