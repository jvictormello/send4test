<?php

namespace App\Http\Controllers;

use App\Jobs\ListOfFavorites;
use App\UserProduct;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class FavoritesController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index(Request $request)
    {
        $user = $request->user();
        $favorites = [];

        foreach ($user->favorites()->get() as $favorite) {
            # code...
            $response = Http::get('https://'
            . env('SHOPIFY_API_KEY', null)
            . ':'
            . env('SHOPIFY_API_PASSWORD')
            . '@send4-avaliacao.myshopify.com/admin/api/2020-01/products/'
            . $favorite->product_id
            . '.json');

            if ($response->successful()) {
                $favorites[] = $response->json()['product'];
            }
        }

        return view('favorites')->with('favorites', $favorites);
    }

    public function add(Request $request) {
        $user = $request->user();
        $product_id = $request->input('product_id');

        $response = Http::get('https://'
            . env('SHOPIFY_API_KEY', null)
            . ':'
            . env('SHOPIFY_API_PASSWORD')
            . '@send4-avaliacao.myshopify.com/admin/api/2020-01/products/'
            . $product_id
            . '.json');

        if ($response->successful()
            && ($response->json()['product']['vendor'] == $user->company)) {

            $searched = UserProduct::where([
                ['user_id', '=', $user->id],
                ['product_id', '=', $product_id],
            ])->first();

            if (!$searched) {
                UserProduct::create(
                    ['user_id' => $user->id,
                    'product_id' => $product_id]
                );

                ListOfFavorites::dispatch($user)->delay(now()->addMinutes(2));
            }
        }

        return redirect()->route('home');
    }

    public function remove(Request $request) {
        $user = $request->user();
        $product_id = $request->input('product_id');

        $searched = UserProduct::where([
            ['user_id', '=', $user->id],
            ['product_id', '=', $product_id],
        ])->get();

        if ($searched->isNotEmpty()) {
            foreach ($searched as $register) {
                # code...
                $register->delete();
            }

            ListOfFavorites::dispatch($user)->delay(now()->addMinutes(2));
        }

        return redirect()->route('favorites');
    }
}
