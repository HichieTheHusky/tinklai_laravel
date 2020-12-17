@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">{{ __('Pridekite preke') }}</div>

                    <div class="card-body">
                        @if (session('status'))
                            <div class="alert alert-success" role="alert">
                                {{ session('status') }}
                            </div>
                        @endif


                        <form method="post" action="{{ route('createPreke') }}">
                            @csrf
                            <div class="form-group">
                                <label for="pavadinimas">Pavadinimas</label>
                                <input type="text" class="form-control" name="pavadinimas" id="pavadinimas" aria-describedby="emailHelp" placeholder="Įveskite Pavadinima">
                                @error('pavadinimas')
                                <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="kaina">Kaina</label>
                                <input type="float" class="form-control" name="kaina" id="kaina" aria-describedby="emailHelp" placeholder="Įveskite kaina ">
                                @error('kaina')
                                <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="tekstas">Aprasymas</label>
                                <input type="text" class="form-control" name="tekstas" id="tekstas" aria-describedby="emailHelp" placeholder="Įveskite aprasyma">
                                @error('tekstas')
                                <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="url">Nuotraukos URL</label>
                                <input type="text" class="form-control" name="url" id="url" aria-describedby="emailHelp" placeholder="Įveskite nuotraukos url">
                                @error('tekstas')
                                <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="color">Spalva</label>
                                <input type="text" class="form-control" name="color" id="color" aria-describedby="emailHelp" placeholder="Įveskite spalva produkto">
                                @error('color')
                                <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="quantity">Kiekis</label>
                                <input type="number" class="form-control" name="quantity" id="quantity" aria-describedby="emailHelp" placeholder="Įveskite kieki produkto">
                                @error('quantity')
                                <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="size">Dydi</label>
                                <input type="text" class="form-control" name="size" id="size" aria-describedby="emailHelp" placeholder="Įveskite dydi">
                                @error('size')
                                <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="weight">Svoris</label>
                                <input type="text" class="form-control" name="weight" id="weight" aria-describedby="emailHelp" placeholder="Įveskite svori">
                                @error('weight')
                                <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="maxweight">Maksimalu svoris</label>
                                <input type="text" class="form-control" name="maxweight" id="maxweight" aria-describedby="emailHelp" placeholder="Įveskite svori">
                                @error('maxweight')
                                <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                @enderror
                            </div>
                            <input type="hidden" id="kategory" name="kategory" value={{'Ratas'}}>
                            <button type="submit" class="btn btn-success">Sukurti produkta</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
