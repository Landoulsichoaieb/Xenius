<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Offer;
use App\Models\Apply;

class ApplyController extends Controller
{
    public function apply(Request $request){
        $user = Auth::user();
        if (!$user) {
            return response()->json(['error' => 'Not Authenticated'], 401);
        }if($user->role == 0){
            $offer = Offer::find($request->offer_id);
                if (!$offer) {
                    return response()->json(['error' => 'Offer not found'], 404);
                }
            $Applydata['user_id'] = $user->id;
            $Applydata['offer_id'] = $request->offer_id;
            $Apply = Apply::create($Applydata);

            return response()->json(['message' => 'successfully Applied.', 'Apply' => $Apply], 201);
        }else{
            return response()->json(['error' => 'Not Allowed to Apply'], 401);
        }
    }
}
