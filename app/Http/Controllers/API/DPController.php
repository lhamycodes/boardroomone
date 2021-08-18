<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Services\Sirv;
use App\Transformers\Json;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class DPController extends Controller
{
    public function index(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'image' => 'required|image|max:2048',
        ]);

        if ($validator->fails()) {
            return response()->json(Json::response(false, ['errors' => $validator->errors()], "Validation error"), 422);
        }

        $path = rand(1, 1000) . '_dp_' . time() . '.' . $request->image->getClientOriginalExtension();
        $uploadPath = $request->image->store('profile_pictures', ['disk' => 'public']);

        $filePath = Storage::url($uploadPath);
        $sirv = new Sirv;
        $sirvBaseUrl = env("SIRV_BASE_URL");

        $sirvPath = "uploaded_pictures/{$path}";
        $uploadDone = $sirv->uploadFile(public_path($filePath), $sirvPath);

        if ($uploadDone) {
            $sirvImageUrl = "$sirvBaseUrl/{$sirvPath}";
            $croppedImageUrl = "{$sirvImageUrl}?crop.type=face";
            
            return response()->json(Json::response(true, [], "Profile Image Uploaded Successfully"), 200);
        } else {
            return response()->json(Json::response(true, [], "Profile Picture could not be uploaded"), 200);
        }
    }
}
