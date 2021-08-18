<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
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

        $uploadPath = $request->image->store('profile_pictures', ['disk' => 'public']);
        
        $filePath = Storage::url($uploadPath);
    }
}
