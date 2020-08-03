<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class HomeController extends Controller
{

    private $response;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->response = Http::get('https://'
            .env('SHOPIFY_API_KEY', null)
            .':'
            .env('SHOPIFY_API_PASSWORD')
            .'@send4-avaliacao.myshopify.com/admin/api/2020-01/products.json');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        if ($this->response->failed()) {
            # code...
        }

        return view('home')->with('products', $this->response->json()['products']);
    }
}
