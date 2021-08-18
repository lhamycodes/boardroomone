<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Services\Sirv;
use App\Transformers\Json;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Mtownsend\RemoveBg\RemoveBg;

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

        $sirvBaseUrl = env("SIRV_BASE_URL");
        $removebgKey = env("REMOVEBG_API_KEY");

        $path = rand(1, 1000) . '_dp_' . time() . '.' . $request->image->getClientOriginalExtension();
        $uploadPath = $request->image->store('profile_pictures', ['disk' => 'public']);

        $filePath = Storage::url($uploadPath);
        $sirv = new Sirv;

        $removebg = new RemoveBg($removebgKey);

        $sirvPath = "uploaded_pictures/{$path}";
        $uploadDone = $sirv->uploadFile(public_path($filePath), $sirvPath);

        if ($uploadDone) {
            $sirvImageUrl = "$sirvBaseUrl/{$sirvPath}";
            $croppedImageUrl = "{$sirvImageUrl}?crop.type=face";

            $removebg->url($croppedImageUrl)->save(public_path(Storage::url("processed_pictures/{$path}")));

            return response()->json(Json::response(true, [], "Profile Image Uploaded Successfully"), 200);
        } else {
            return response()->json(Json::response(true, [], "Profile Picture could not be uploaded"), 200);
        }
    }
}
