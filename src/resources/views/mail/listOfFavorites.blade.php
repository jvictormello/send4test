@component('mail::message')
    <h1>Lista de Favoritos</h1>
    @foreach($favorites as $favorite)
        <div class="row">
            <div class="media col-sm-12 col-md-3 col-lg-3">
                <figure>
                    <img style="width: 150px; height: 150px;" src={{$favorite['image']['src']}} alt={{$favorite['title']}}>
                    <figcaption>{{$favorite['title']}}</figcaption>
                </figure>
            </div>
        </div>
    @endforeach
@endcomponent

