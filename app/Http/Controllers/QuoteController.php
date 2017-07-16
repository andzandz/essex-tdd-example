<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class QuoteController extends Controller
{
    public function page()
    {
        return view('quote', [
            'quote_amount' => null
        ]);
    }

    public function calculate(Request $request)
    {
        $this->validate($request, [
            'num_gnomes' => 'numeric|min:0|nullable',
        ], [
            'num_gnomes.numeric' => 'The number of gnomes must be a number',
            'num_gnomes.min' => 'Anti-gnomes are not allowed'
        ]);

        $quote_amount = 25 + 5 * $request->get('num_gnomes') + 50 * $request->get('chocolate_fountains');

        return view('quote', [
            'request' => $request->all(),
            'quote_amount' => $quote_amount
        ]);
    }
}
