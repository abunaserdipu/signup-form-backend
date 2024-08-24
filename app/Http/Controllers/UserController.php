<?php
// app/Http/Controllers/UserController.php

namespace App\Http\Controllers;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email|unique:users',
            'username' => 'required|string|min:3|max:255|unique:users',
            'password' => 'required|confirmed|min:6',
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'contact_no' => 'required|string|max:15',
            'alternate_contact_no' => 'nullable|string|max:15',
            'photo' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            'signature_photo' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        // Handle file uploads
        $photoPath = $request->file('photo')->store('photos', 'public');
        $signaturePhotoPath = $request->file('signature_photo')->store('signature_photos', 'public');

        $user = new User();
        $user->email = $request->email;
        $user->username = $request->username;
        $user->password = Hash::make($request->password);
        $user->first_name = $request->first_name;
        $user->last_name = $request->last_name;
        $user->contact_no = $request->contact_no;
        $user->alternate_contact_no = $request->alternate_contact_no;
        $user->photo = $photoPath;
        $user->signature_photo = $signaturePhotoPath;
        $user->save();

        return response()->json(['message' => 'User registered successfully.'], 201);
    }
}
