@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">{{ __('Užsakymas') }}</div>

                    <div class="card-body">
                        @if (session('status'))
                            <div class="alert alert-success" role="alert">
                                {{ session('status') }}
                            </div>
                        @endif

                        <table class="table table-bordered">
                            <thead class="thead-dark">
                            <tr>
                                <th scope="col">Sukurtas</th>
                                <th scope="col">Statusas</th>
                                <th scope="col">Sudeliojimas</th>
                                <th scope="col">Adresas</th>
                                <th scope="col">Prekių vnt</th>
                                <th scope="col">Prekiu busena</th>
                                <th scope="col">Kaina</th>
                            </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>{{$order->created_at }}</td>
                                    <td>
                                        @if($order->status == 0)
                                            <p style="color:red">Nepatvirtintas</p>
                                        @else
                                            <p style="color:green"> Patvirtintas</p>
                                        @endif
                                    </td>
                                    <td>
                                        @if($order->assembly == 0)
                                            Nesudelioti
                                        @else
                                            Sudelioti
                                        @endif
                                    </td>
                                    <td>{{$order->adress}}</td>
                                    <td>{{$order->items->count()}}</td>
                                    <td>
                                        @if($order->available)
                                            <p style="color:green">Prekes rezervuotos</p>
                                        @else
                                            <p style="color:red"> Prekes nerezervuotos</p>
                                        @endif
                                    </td>
                                    <td>{{$order->items->sum('price')}}€</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">{{ __('Produktai') }}</div>

                    <div class="card-body">
                            <table class="table table-bordered">
                                <thead class="thead-dark">
                                <tr>
                                    <th scope="col">Nr.</th>
                                    <th scope="col">Nuotrauka</th>
                                    <th scope="col">Pavadinimas</th>
                                    <th scope="col">Kaina</th>
                                    <th scope="col">Kategorija</th>
                                    <th scope="col">Aprašas</th>
                                    <th scope="col">Būsena</th>
                                    <th scope="col">Kiekis</th>
                                    <th scope="col">Spalva</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($order->items as $product)
                                    <tr>
                                        <th scope="row">{{$loop->index+1}}</th>
                                        <td>
                                            <figure style=" max-width: 100px;max-height: 100px;">
                                                <img src="{{$product->photo }}" alt="Turetu buti foto" style="width: 100%;height: 100%;">
                                            </figure>
                                        </td>
                                        <td>{{$product->name }}</td>
                                        <td>{{$product->price}} €</td>
                                        <td>{{$product->category}}</td>
                                        <td>{{substr($product->description,0,50) }}</td>
                                        <td>@if($product->pivot->status)
                                                Rezervuotas
                                            @else
                                                nerezervuotas
                                            @endif
                                        </td>
                                        <td>{{$product->pivot->quantity }}</td>
                                        <td>{{$product->color}}</td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                    </div>`
                </div>
            </div>
        </div>
    </div>
@endsection
