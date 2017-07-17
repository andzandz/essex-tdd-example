<?php

namespace App\Http\Controllers;

use App\QuoteCalculator;
use Illuminate\Http\Request;

class QuoteController extends Controller
{
    /** @var QuoteCalculator */
    private $quote_calculator;

    public function __construct($options)
    {
        $this->quote_calculator = $options['quote_calculator'];
    }

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
            'chocolate_fountains' => 'numeric|min:0|nullable',
        ], [
            'num_gnomes.numeric' => 'The number of gnomes must be a number',
            'num_gnomes.min' => 'Anti-gnomes are not allowed',
            'chocolate_fountains.min' => 'Anti-fountains are not allowed',
            'chocolate_fountains.numeric' => 'The number of fountains must be a number',
        ]);

//        $quote_amount = 25 + 5 * $request->get('num_gnomes') + 50 * $request->get('chocolate_fountains')
//        + $request->get('astro_width') * $request->get('astro_depth') * 4;

        return view('quote', [
            'request' => $request->all(),
            'quote_amount' => $this->quote_calculator->calculate($request->all())
        ]);
    }
}
