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
use Illuminate\Support\Facades\Gate;
use Symfony\Component\HttpFoundation\Request;

class HouseController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $user = auth()->user();

        $query = $user->allPayments()->with(['expence.category', 'expence.house']);

        if ($request->month != "0") {
            $query->whereHas('expence', fn($q) => $q->where('date', $request->month));
        }


        $paymentHistory = $query->paginate(10);



        $totalPaid = $user->allPayments()->where('status', 1)->sum('amount') ?? 0;
        $availableMonths = [];
        foreach ($user->allPayments as $payment) {
            if (!in_array($payment->expence->date, $availableMonths)) {
                array_push($availableMonths, $payment->expence->date);
            }
        }
        return view('dashboard', compact('totalPaid', 'availableMonths', 'paymentHistory'));
    }


    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $house = House::find($id);
        $user = auth()->user();

        Gate::authorize('view', $house);

        $payments = $user->allPayments()->where('status', 1)->get();
        $totalPaid = 0;

        foreach ($payments as $payment) {
            if ($payment->expence->house->id == $house->id) {
                $totalPaid += $payment->amount;
            }
        }

        $yourShare = $totalPaid / $house->user->count();
        $balance = $totalPaid - $yourShare;

        $categories = Category::where('house_id', $id)->get();
        $expences = Expences::where('house_id', $id)->get();
        return view('house', compact('house', 'categories', 'expences', 'totalPaid', 'yourShare', 'balance'));
    }






    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {

        Gate::authorize('create', House::class);

        if (!auth()->user()->notReserved() && auth()->user()->role->name != 'admin') {
            return redirect()->route('dashboard')
                ->withErrors([
                    'type' => 0,
                    'general' => "Your already a member in a house"
                ]);
        }
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

        return redirect()->route('dashboard')
            ->withErrors([
                'type' => 1,
                'general' => "House created successfully"
            ]);
    }




    public function exit($id)
    {
        $house = House::find($id);
        $Auser = auth()->user();

        if (count($house->user) > 1) {
            $collection = $house->user;
            $sorted = $collection->sortByDesc('reputation');

            if ($Auser->id == $house->owner[0]->id) {
                $this->promote($house, $sorted[1]);
            } else {
                $this->promote($house, $sorted[0]);
            }
        } else {
            $this->destroy($house->id);
        }

        $payments = $Auser->needToPay($house->id);
        if (count($payments) > 0) {
            $Auser->reputation -= 1;
            foreach ($payments as $payment) {
                $payment->delete();
            }
        } else {
            $Auser->reputation += 1;
        }

        foreach ($house->user as $user) {
            if ($user->id === $Auser->id) {
                $user->pivot->status = 0;
                $user->pivot->delete();
            }
        }

        $Auser->save();



        return redirect()->route('dashboard')
            ->withErrors([
                'type' => 1,
                'general' => "You left the House"
            ]);
    }


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
        return redirect()->back();
    }
    public function promote($house, $user)
    {

        Gate::authorize('promote', $house);


        foreach ($house->user as $Uuser) {
            if ($Uuser->id == $user->id) $Uuser->pivot->is_owner = 1;
            if ($Uuser->id == auth()->user()->id) $Uuser->pivot->is_owner = 0;
            $Uuser->pivot->save();
        }
    }
    public function kickUser($house, $user)
    {

        Gate::authorize('kickUser', $house);


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
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {

        $house = House::find($id);

        Gate::authorize('update', [House::class, $house]);

        return view('houseEdit', compact('house'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateHouseRequest $request, $id)
    {
        $validated = $request->validated();

        $house = House::find($id);
        $house->update($validated);
        return redirect()->route('house.show', $house->id)
            ->withErrors([
                'type' => 1,
                'general' => "House Edited"
            ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $house = House::find($id);

        Gate::authorize('delete', $house);


        if (count(auth()->user()->needToPay($house->id)) == 0 && count($house->user) == 1) {

            foreach ($house->user as $Uuser) {
                $Uuser->pivot->status = 0;
                $Uuser->pivot->delete();
            }

            $house->status = false;
            $house->save();
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
                    'general' => "You can't cancel or leave when you, the Owner, have pending payments or are not alone"
                ]);
        }
    }
}
