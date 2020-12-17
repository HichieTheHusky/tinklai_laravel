@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <h2 class="card-header">{{$product->name}}</h2>

                    <div class="card-body">
                        @if (session('status'))
                            <div class="alert alert-success" role="alert">
                                {{ session('status') }}
                            </div>
                        @endif
                        <div></div>
                            <div class="max-w-6xl mx-auto sm:px-6 lg:px-8 col-lg-4 col-sm-4 col-4 cart-detail-img">
                                <img src="{{$product->photo}}" />
                            </div>
                            <table class="table table-bordered">
                                <tbody>
                                <tr>
                                    <td class="explenation">Kaina</td>
                                    <td class="content">{{$product->price}} €</td>
                                </tr>
                                <tr>
                                    <td class="explenation">Kategorija</td>
                                    <td class="content">{{$product->category}}</td>
                                </tr>
                                <tr>
                                    <td class="explenation">Apibūdinimas</td>
                                    <td class="content">{{$product->description}}</td>
                                </tr>
                                <tr>
                                    <td class="explenation">Kiekis</td>
                                    <td class="content">{{$product->quantity }}</td>
                                </tr>
                                <tr>
                                    <td class="explenation">Spalva</td>
                                    <td class="content">{{$product->color}}</td>
                                </tr>
                                @if($product->category == \App\Models\product::TYPE_BASE)
                                    <tr>
                                        <td class="explenation">Paskirtis</td>
                                        <td class="content">{{$specific_product->usecase}}</td>
                                    </tr>
                                    <tr>
                                        <td class="explenation">Svoris</td>
                                        <td class="content">{{$specific_product->weight}} KG</td>
                                    </tr>
                                    <tr>
                                        <td class="explenation">Medziaga</td>
                                        <td class="content">{{$specific_product->material}}</td>
                                    </tr>
                                @endif
                                @if($product->category == \App\Models\product::TYPE_ACC)
                                    <tr>
                                        <td class="explenation">Tipas</td>
                                        <td class="content">{{$specific_product->type}}</td>
                                    </tr>
                                    <tr>
                                        <td class="explenation">Medziaga</td>
                                        <td class="content">{{$specific_product->materials}}</td>
                                    </tr>
                                @endif
                                @if($product->category == \App\Models\product::TYPE_BRAKE)
                                    <tr>
                                        <td class="explenation">Tipas</td>
                                        <td class="content">{{$specific_product->type}}</td>
                                    </tr>
                                    <tr>
                                        <td class="explenation">Medziaga</td>
                                        <td class="content">{{$specific_product->material}}</td>
                                    </tr>
                                @endif
                                @if($product->category == \App\Models\product::TYPE_SADDLE || $product->category == \App\Models\product::TYPE_TYRE)
                                    <tr>
                                        <td class="explenation">Dydis</td>
                                        <td class="content">{{$specific_product->size}}</td>
                                    </tr>
                                    <tr>
                                        <td class="explenation">Svoris</td>
                                        <td class="content">{{$specific_product->weight}}</td>
                                    </tr>
                                    <tr>
                                        <td class="explenation">Palaikomas svoris</td>
                                        <td class="content">{{$specific_product->maxload}}</td>
                                    </tr>
                                @endif
                                </tbody>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
