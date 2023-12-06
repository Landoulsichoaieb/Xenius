<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use App\models\Offer;

class OfferController extends Controller
{
    public function addoffer(Request $request){
        $user = Auth::user();
        if (!$user) {
            return response()->json(['error' => 'Not Authenticated'], 401);
        }if($user->role == 1){
            $validator = Validator::make($request->all(), [
                'title' => 'required|string|max:255',
                'description' => 'required|string',
            ]);

            if ($validator->fails()) {
                return response()->json($validator->errors(), 400);
            }
            $Offerdata = $request->all();
            $Offerdata['user_id'] = $user->id;
            $Offer = Offer::create($Offerdata);

            return response()->json(['message' => 'Offer successfully created.', 'Offer' => $Offer], 201);
        }else{
            return response()->json(['error' => 'Not Allowed to Add an Offer'], 401);
        }
    }
}
