<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ValidationController extends Controller
{
    public function validateForm(Request $request)
    {
        $validateData = $request->validate([
            'name'  => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'age'   => 'required|integer|min:18|max:100',
        ]);

        return redirect()
            ->back()
            ->with('success', 'Dati validati con successo');
    }
}