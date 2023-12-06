<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use App\Models\Cv;
use PDF;
class CvController extends Controller
{
    public function addCv(Request $request)
{
    $user = Auth::user();
    if (!$user) {
        return response()->json(['error' => 'Not Authenticated'], 401);
    }
    $validator = Validator::make($request->all(), [
        'firstname' => 'required|string|max:255',
        'lastname' => 'required|string|max:255',
        'email' => 'required|email',
        'phone' => 'required|string',
        'about' => 'required|string',
        'experience' => 'required|string',
        'skills' => 'required|string',
    ]);

    if ($validator->fails()) {
        return response()->json($validator->errors(), 400);
    }


    $existingCv = Cv::where('user_id', $user->id)->first();
    if ($existingCv) {
        return response()->json(['message' => 'A CV is already exists.'], 409);
    }

    $cvData = $request->all();
    $cvData['user_id'] = $user->id;
    $cv = Cv::create($cvData);

    return response()->json(['message' => 'CV successfully created.', 'cv' => $cv], 201);
}


public function generateCvPdf($cvId)
{
    $user = Auth::user();
    if (!$user) {
        return response()->json(['error' => 'Not Authenticated'], 401);
    }
    $cv = Cv::findOrFail($cvId);
    $pdf = PDF::loadView('cv', ['cv' => $cv]);
    return $pdf->download('cv.pdf');
}

public function genCvPdfByIdUser($userid)
{
    $user = Auth::user();
    if (!$user) {
        return response()->json(['error' => 'Not Authenticated'], 401);
    }
    $cv = Cv::where('user_id', $userid)->firstOrFail();
    $pdf = PDF::loadView('cv', ['cv' => $cv]);
    return $pdf->download('cv.pdf');
}

}
