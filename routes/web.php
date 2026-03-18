<?php

use Illuminate\Http\Request; 
use App\Http\Controllers\MyController; 
use App\Models\User;

Route::get('/fakemarche', function () {
    return view('fakemarketViews.fakemarket');
});

Route::get('/users', function () {
    $users = User::all();
    return view('users.index', compact('users'));
});


Route::post('/recap', function (Request $request) {
    return view('fakemarketViews.recap', [
        'prenom' => $request->prenom,
        'nom' => $request->nom,
        'telephone' => $request->telephone
    ]);
});