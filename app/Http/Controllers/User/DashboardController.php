<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Earning;
use App\Models\Payment;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{

    public function payments()
    {
        $payments = Payment::where('user_id', Auth::user()->id)->orderBy('created_at', 'desc')->get();
        return view('user.dashboard.payments', ['payments' => $payments]);
    }

    public function viewers()
    {
        Earning::where('sender_id', Auth::user()->id)->update([
            'seen' => 2
        ]);
        $viewers = Earning::where('sender_id', Auth::user()->id)->orderBy('created_at', 'desc')->get();
        return view('user.dashboard.viewers', ['viewers' => $viewers]);
    }

    public function mark_as_read()
    {
        $update = Earning::where('sender_id', Auth::user()->id)->update([
            'seen' => 2
        ]);

        if($update == true)
        {
            return response()->json([
                'bool'=>true
            ]);

        } else {
            return response()->json([
                'bool'=>false
            ]);
        }
    }

}
