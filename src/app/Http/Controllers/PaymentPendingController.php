<?php

namespace App\Http\Controllers;

use App\Models\Expences;
use App\Models\House;
use App\Models\PaymentPending;
use Carbon\Carbon;
use Illuminate\Http\Request;

class PaymentPendingController extends Controller
{
    public function create(Expences $expence)
    {

        $house = House::find($expence->house_id);
        $count = count($house->user);
        $perUser = $expence->amount / $count;

        foreach ($house->user as $user) {
            $payment = new PaymentPending();
            $payment->amount = $perUser;
            $payment->user_id = $user->id;
            $payment->expence_id = $expence->id;
            $payment->save();
        }

        $payment = PaymentPending::where('user_id', $expence->user_id)->where('expence_id', $expence->id)->get();
        $payment[0]->status = true;
        $payment[0]->payment_date = Carbon::today()->toDateString();
        $payment[0]->save();
    }

    public function statusChange($id)
    {   
        $payment = PaymentPending::find($id);
        $payment->status = !$payment->status;
        $payment->status ? $payment->payment_date = Carbon::today()->toDateString() : $payment->payment_date = null ;
        $payment->save();

        return redirect()->back();
    }
}
