<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class MembershipController extends Controller
{
    public function calculate(Request $request)
    {
        $request->validate([
            'type' => 'required|string|in:basic,premium',
            'is_student' => 'required|boolean',
            'age' => 'required|integer',
            'is_weekend' => 'required|boolean',
        ]);

        $basePrice = $request->type === 'premium' ? 100 : 50;
        $discount = 0;
        $messages = [];

        if ($request->type === 'premium') {
            $messages[] = 'premium';
        }

        if ($request->is_student) {
            $discount = 0.20 * $basePrice;
            $messages[] = 'discount';
        }

        if ($request->age >= 60) {
            $discount = max($discount, 0.30 * $basePrice);
            if (!in_array('discount', $messages)) {
                $messages[] = 'discount';
            }
        }

        $weekendFee = 0;
        if ($request->is_weekend) {
            $weekendFee = 5;
            $messages[] = 'weekend';
        }

        $finalPrice = $basePrice - $discount + $weekendFee;

        return response()->json([
            'status' => 'success',
            'final_price' => $finalPrice,
            'info' => implode(' ', $messages),
        ], 200);
    }
}
