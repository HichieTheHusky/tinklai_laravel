@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">{{ __('Prekes') }}</div>

                    <div class="card-body">
                        @if (session('status'))
                            <div class="alert alert-success" role="alert">
                                {{ session('status') }}
                            </div>
                        @endif

                        <table class="table table-bordered">
                            <thead class="thead-dark">
                            <tr>
                                <th scope="col">Nr.</th>
                                <th scope="col">Nuotrauka</th>
                                <th scope="col">Pavadinimas</th>
                                <th scope="col">Kaina</th>
                                <th scope="col">Kategorija</th>
                                <th scope="col">Aprašas</th>
                                <th scope="col">Kiekis</th>
                                <th scope="col">Spalva</th>
                                <th scope="col">Veiskmai</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($products as $product)
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
                                    <td>{{$product->quantity }}</td>
                                    <td>{{$product->color}}</td>
                                    <td>
                                        @if(auth()->user()->user_type == \App\Models\User::ROLE_WORKER)
                                        <form style="display: inline;" method="post" action="{{ route('changePreke') }}" onclick="return confirm('Ar tikrai norite keisti?')">
                                            <input type="hidden" id="id" name="id" value={{ $product->id }}>
                                            @csrf
                                            @method('get')
                                            <button type="submit" class="btn btn-sm btn-primary">Keisti</button>
                                        </form>
                                        <form style="display: inline;" method="post" action="{{ route('deleteProduct') }}" onclick="return confirm('Ar tikrai norite pašalinti?')">
                                            <input type="hidden" id="id" name="id" value={{ $product->id }}>
                                            @csrf
                                            @method('delete')
                                            <button type="submit" class="btn btn-sm btn-danger">Trinti</button>
                                        </form>
                                        @endif
                                        @if(auth()->user()->user_type == \App\Models\User::ROLE_USER)
                                            <p class="btn-holder"><a href="{{ url('Vartotojas/add-to-cart/'.$product->id) }}" class="btn btn-warning btn-block text-center" role="button">Add to cart</a> </p>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
