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

    public function deleteoffer(Request $request) {
        $user = Auth::user();
        if (!$user) {
            return response()->json(['error' => 'Not Authenticated'], 401);
        }

        $offer = Offer::find($request->id);
        if (!$offer) {
            return response()->json(['error' => 'Offer not found'], 404);
        }

        if ($offer->user_id != $user->id) {
            return response()->json(['error' => 'Not Authorized to Delete this Offer'], 403);
        }

        $offer->delete();

        return response()->json(['message' => 'Offer successfully deleted.'], 200);
    }

    public function editoffer(Request $request) {
        $user = Auth::user();
        if (!$user) {
            return response()->json(['error' => 'Not Authenticated'], 401);
        }

        $offer = Offer::find($request->id);
        if (!$offer) {
            return response()->json(['error' => 'Offer not found'], 404);
        }

        if ($offer->user_id != $user->id) {
            return response()->json(['error' => 'Not Authorized to Edit this Offer'], 403);
        }

        $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:255',
            'description' => 'required|string',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }

        $offer->update($request->all());

        return response()->json(['message' => 'Offer successfully updated.', 'Offer' => $offer], 200);
    }

    public function fetchuseroffers() {
        $user = Auth::user();
        if (!$user) {
            return response()->json(['error' => 'Not Authenticated'], 401);
        }

        if ($user->role == 1) {
            return response()->json(['error' => 'Not Authorized'], 403);
        }

        $userOffers = Offer::with('user')
                ->where('user_id', $user->id)
                ->get();

        return response()->json(['message' => 'User applications fetched successfully', 'applies' => $userOffers], 200);
    }

}
