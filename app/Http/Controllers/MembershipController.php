<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class MembershipController extends Controller
{
    public function store(Request $request)
    {
        $validated = $request->validate([
            'duration' => ['required', 'integer', 'between:1,12'],
        ]);

        return response()->json([
            'message' => 'Membership duration is valid.',
            'data' => $validated,
        ], 200);
    }
}
