@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
            </div>
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">{{ __('Prekiu pridejimas') }}</div>


                    <div class="card-body">
                        @if (session('status'))
                            <div class="alert alert-success" role="alert">
                                {{ session('status') }}
                            </div>
                        @endif


                        <form method="post" action="{{ route('addPreke') }}">
                            @csrf
                            <div class="form-group">
                                <label for="quantity">Kiekis</label>
                                <input type="number" class="form-control" name="quantity" id="quantity" aria-describedby="emailHelp">
                                @error('quantity')
                                <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                @enderror
                            </div>
                            <input type="hidden" id="id" name="id" value={{$product->id}}>
                            <button type="submit" class="btn btn-success">Prideti prekiu</button>
                        </form>
                    </div>
                </div>
                <div class="card">
                    <div class="card-header">{{ __('Pridekite preke') }}</div>

                    <div class="card-body">
                        @if (session('status'))
                            <div class="alert alert-success" role="alert">
                                {{ session('status') }}
                            </div>
                        @endif


                        <form method="post" action="{{ route('updatePreke') }}">
                            @csrf
                            <div class="form-group">
                                <label for="pavadinimas">Pavadinimas</label>
                                <input type="text" class="form-control" name="pavadinimas" id="pavadinimas" aria-describedby="emailHelp" value="{{$product->name}}">
                                @error('pavadinimas')
                                <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="kaina">Kaina</label>
                                <input type="float" class="form-control" name="kaina" id="kaina" aria-describedby="emailHelp" value="{{$product->price}}">
                                @error('kaina')
                                <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="tekstas">Aprasymas</label>
                                <input type="text" class="form-control" name="tekstas" id="tekstas" aria-describedby="emailHelp" value="{{$product->description}}">
                                @error('tekstas')
                                <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="url">Nuotraukos URL</label>
                                <input type="text" class="form-control" name="url" id="url" aria-describedby="emailHelp" value="{{$product->photo}}">
                                @error('tekstas')
                                <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="color">Spalva</label>
                                <input type="text" class="form-control" name="color" id="color" aria-describedby="emailHelp" value="{{$product->color}}">
                                @error('color')
                                <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="quantity">Kiekis</label>
                                <input type="number" class="form-control" name="quantity" id="quantity" aria-describedby="emailHelp" value="{{$product->quantity}}">
                                @error('quantity')
                                <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                @enderror
                            </div>
                            <input type="hidden" id="id" name="id" value={{$product->id}}>
                            <button type="submit" class="btn btn-success">Atnaujinti produkta</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
