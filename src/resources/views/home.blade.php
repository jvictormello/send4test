@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">{{ __('Produtos') }}</div>

                <div class="card-body">
                    <div class="row">
                        @foreach($products as $product)
                            @php
                                $isFavorite = false;
                                $disableFavorite = false;
                            @endphp
                            @guest
                                <div class="media col-sm-12 col-md-3 col-lg-3">
                                    <figure>
                                        <img style="width: 150px; height: 150px;" src={{$product['image']['src']}} alt={{$product['title']}}>
                                        <figcaption>{{$product['title']}}</figcaption>
                                    </figure>
                                </div>
                            @else
                                <div class="media col-sm-12 col-md-3 col-lg-3">
                                    <figure>
                                        <img style="width: 150px; height: 150px;" src={{$product['image']['src']}} alt={{$product['title']}}>
                                        <figcaption>{{$product['title']}}</figcaption>
                                    </figure>

                                    <form method="POST" action="{{ route('add.favorite') }}">
                                        @csrf

                                        <input id="invisible_id" name="product_id" type="hidden" value={{$product['id']}}>

                                        <div class="row justify-content-center col-12">
                                            @php
                                                foreach (Auth::user()->favorites()->get() as $favorited) {

                                                    if ($favorited->product_id == $product['id']) {
                                                        $isFavorite = true;
                                                    }
                                                }

                                                if (Auth::user()->company != $product['vendor']) {
                                                    $disableFavorite = true;
                                                }
                                            @endphp

                                            @if ($disableFavorite)
                                                <button type="submit" class="btn btn-primary" disabled>
                                                    <svg width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-star" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                                                        <path fill-rule="evenodd" d="M2.866 14.85c-.078.444.36.791.746.593l4.39-2.256 4.389 2.256c.386.198.824-.149.746-.592l-.83-4.73 3.523-3.356c.329-.314.158-.888-.283-.95l-4.898-.696L8.465.792a.513.513 0 0 0-.927 0L5.354 5.12l-4.898.696c-.441.062-.612.636-.283.95l3.523 3.356-.83 4.73zm4.905-2.767l-3.686 1.894.694-3.957a.565.565 0 0 0-.163-.505L1.71 6.745l4.052-.576a.525.525 0 0 0 .393-.288l1.847-3.658 1.846 3.658a.525.525 0 0 0 .393.288l4.052.575-2.906 2.77a.564.564 0 0 0-.163.506l.694 3.957-3.686-1.894a.503.503 0 0 0-.461 0z"/>
                                                    </svg>
                                                    {{ __('Favoritar') }}
                                                </button>
                                            @else
                                                @if ($isFavorite)
                                                    <button type="submit" class="btn btn-primary" disabled>
                                                        <svg width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-star-fill" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                                                            <path d="M3.612 15.443c-.386.198-.824-.149-.746-.592l.83-4.73L.173 6.765c-.329-.314-.158-.888.283-.95l4.898-.696L7.538.792c.197-.39.73-.39.927 0l2.184 4.327 4.898.696c.441.062.612.636.283.95l-3.523 3.356.83 4.73c.078.443-.36.79-.746.592L8 13.187l-4.389 2.256z"/>
                                                        </svg>
                                                        {{ __('Favorito') }}
                                                    </button>
                                                @else
                                                    <button type="submit" class="btn btn-primary">
                                                        <svg width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-star" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                                                            <path fill-rule="evenodd" d="M2.866 14.85c-.078.444.36.791.746.593l4.39-2.256 4.389 2.256c.386.198.824-.149.746-.592l-.83-4.73 3.523-3.356c.329-.314.158-.888-.283-.95l-4.898-.696L8.465.792a.513.513 0 0 0-.927 0L5.354 5.12l-4.898.696c-.441.062-.612.636-.283.95l3.523 3.356-.83 4.73zm4.905-2.767l-3.686 1.894.694-3.957a.565.565 0 0 0-.163-.505L1.71 6.745l4.052-.576a.525.525 0 0 0 .393-.288l1.847-3.658 1.846 3.658a.525.525 0 0 0 .393.288l4.052.575-2.906 2.77a.564.564 0 0 0-.163.506l.694 3.957-3.686-1.894a.503.503 0 0 0-.461 0z"/>
                                                        </svg>
                                                        {{ __('Favoritar') }}
                                                    </button>
                                                @endif
                                            @endif
                                        </div>
                                    </form>
                                </div>
                            @endguest
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
