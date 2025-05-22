<?php

namespace App\Http\Controllers;
use App\Helpers\ShippingHelper;

use Illuminate\Http\Request;

class ShippingController extends Controller
{
    public function index()
    {
        return view('shipping');
    }

    public function calculate(Request $request)
    {
        $validated = $request->validate([
            'weight' => 'required|numeric|min:0',
            'distance' => 'required|numeric|min:0',
            'service' => 'required|in:regular,express',
        ]);

        $cost = ShippingHelper::calculateCost($validated['weight'], $validated['distance'], $validated['service']);

        return back()->withInput()->with('cost', $cost);
    }
}
