<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Organizer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;

class OrganizerAuthController extends Controller
{
    public function showLogin()
    {
        return view('organizer.login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        $organizer = Organizer::where('email', $request->email)->first();

        if (!$organizer || !Hash::check($request->password, $organizer->password)) {
            return back()->withErrors(['email' => 'Identifiants invalides']);
        }

        Session::put('organizer_id', $organizer->id);
        Session::put('organizer_name', $organizer->name);

        return redirect()->route('admin.dashboard');
    }

    public function logout()
    {
        Session::forget('organizer_id');
        Session::forget('organizer_name');

        return redirect()->route('organizer.login');
    }
}
