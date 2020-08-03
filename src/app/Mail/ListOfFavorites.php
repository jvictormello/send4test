<?php

namespace App\Mail;

use App\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Http;

use stdClass;

class ListOfFavorites extends Mailable
{
    use Queueable, SerializesModels;

    private $user;
    private $favorites;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(User $user)
    {
        //
        $this->user = $user;
        $this->favorites = [];

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
                $this->favorites[] = $response->json()['product'];
            }
        }
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $this->subject('Lista de Favoritos Atualizada');
        $this->to($this->user->email, $this->user->name);

        return $this->markdown('mail.listOfFavorites', [
            'user' => $this->user,
            'favorites' => $this->favorites
        ]);
    }
}
