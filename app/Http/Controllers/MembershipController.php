<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests\StoreMembershipRequest;

class MembershipController extends Controller
{
    public function store(StoreMembershipRequest $request)
    {
        return response()->json([
            'message' => 'Membership created successfully.',
            'data' => $request->validated(),
        ], 201);
    }
}
