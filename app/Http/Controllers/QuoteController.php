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

    public function calculate()
    {
        return view('quote', [
            'quote_amount' => 25
        ]);
    }
}
