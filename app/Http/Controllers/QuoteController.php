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
        $quote_amount = 25 + 5*$request->get('num_gnomes');

        return view('quote', [
            'request' => $request->all(),
            'quote_amount' => $quote_amount
        ]);
    }
}
