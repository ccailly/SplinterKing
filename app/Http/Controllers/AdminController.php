<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AdminController extends Controller
{
    function registerUser(Request $request)
    {
        return view('auth.register-user');
    }

    function storeUser(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
        ]);

        $user = new User();
        $user->name = $request->name;
        $user->email = $request->email;
        $user->is_admin = $request->has('admin');
        $user->password = Hash::make(time());
        $user->save();

        return redirect()->route('admin.registerUser')->with('success', ['title' => 'Utilisateur ajouté', 'message' => 'L\'utilisateur a été ajouté avec succès.']);
    }
}
