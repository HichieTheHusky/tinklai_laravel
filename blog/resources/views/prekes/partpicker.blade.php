@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">{{ __('Bazė') }}</div>
                    <div class="card-body">
                    <?php $total = 0 ?>
                    @if(session('Base'))
                        <table id="cart" class="table table-hover table-condensed">
                            <thead>
                            <tr>
                                <th style="width:50%">Product</th>
                                <th style="width:10%">Price</th>
                                <th style="width:10%"></th>
                            </tr>
                            </thead>
                            <tbody>
                                @foreach(session('Base') as $id => $details)
                                    <?php $total += $details['price'] * $details['quantity'] ?>
                                    <tr>
                                        <td data-th="Product">
                                            <div class="row">
                                                <div class="col-sm-3 hidden-xs"><img src="{{ $details['photo'] }}" width="100" height="100" class="img-responsive"/></div>
                                                <div class="col-sm-9">
                                                    <h4 class="nomargin">{{ $details['name'] }}</h4>
                                                </div>
                                            </div>
                                        </td>
                                        <td data-th="Price">{{ $details['price'] }} €</td>
                                        <td>
                                        <form style="display: inline;" method="post" action="{{ route('remove-from-picker') }}" onclick="return confirm('Ar tikrai norite pašalinti?')">
                                            <input type="hidden" id="id" name="id" value={{ $id }}>
                                            <input type="hidden" id="category" name="category" value={{ \App\Models\product::TYPE_BASE }}>
                                            @csrf
                                            @method('delete')
                                            <button type="submit" class="btn btn-sm btn-danger">Trinti</button>
                                        </form>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                            <tfoot>
                            <tr class="visible-xl">
                                @if($details['maxquantity'] == 0)
                                    <td class="text-center" style="color: #ff0000"><strong>Prašome atkreipti dėmesi! Šio produkto nėra sandelyje</strong></td>
                                @endif
                            </tr>

                            </tfoot>
                        </table>
                        @else
                            <form style="display: inline;" method="post" action="{{ route('viewPickerProducts') }}">
                                <input type="hidden" id="category" name="category" value={{ \App\Models\product::TYPE_BASE }}>
                                @csrf
                                @method('get')
                                <button type="submit" class="btn btn-xl btn-primary">Pridėti</button>
                            </form>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">{{ __('Stabdis') }}</div>
                    <div class="card-body">
                    @if(session(\App\Models\product::TYPE_BRAKE))
                        <table id="cart" class="table table-hover table-condensed">
                            <thead>
                            <tr>
                                <th style="width:50%">Product</th>
                                <th style="width:10%">Price</th>
                                <th style="width:10%"></th>
                            </tr>
                            </thead>
                            <tbody>
                                @foreach(session(\App\Models\product::TYPE_BRAKE) as $id => $details)
                                    <?php $total += $details['price'] * $details['quantity'] ?>
                                    <tr>
                                        <td data-th="Product">
                                            <div class="row">
                                                <div class="col-sm-3 hidden-xs"><img src="{{ $details['photo'] }}" width="100" height="100" class="img-responsive"/></div>
                                                <div class="col-sm-9">
                                                    <h4 class="nomargin">{{ $details['name'] }}</h4>
                                                </div>
                                            </div>
                                        </td>
                                        <td data-th="Price">{{ $details['price'] }} €</td>
                                        <td>
                                        <form style="display: inline;" method="post" action="{{ route('remove-from-picker') }}" onclick="return confirm('Ar tikrai norite pašalinti?')">
                                            <input type="hidden" id="id" name="id" value={{ $id }}>
                                            <input type="hidden" id="category" name="category" value={{ \App\Models\product::TYPE_BRAKE }}>
                                            @csrf
                                            @method('delete')
                                            <button type="submit" class="btn btn-sm btn-danger">Trinti</button>
                                        </form>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                            <tfoot>
                            <tr class="visible-xl">
                                @if($details['maxquantity'] == 0)
                                    <td class="text-center" style="color: #ff0000"><strong>Prašome atkreipti dėmesi! Šio produkto nėra sandelyje</strong></td>
                                @endif
                            </tr>
                            </tfoot>
                        </table>
                        @else
                            <form style="display: inline;" method="post" action="{{ route('viewPickerProducts') }}">
                                <input type="hidden" id="category" name="category" value={{ \App\Models\product::TYPE_BRAKE }}>
                                @csrf
                                @method('get')
                                <button type="submit" class="btn btn-xl btn-primary">Pridėti</button>
                            </form>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">{{ __('Sedynė') }}</div>
                    <div class="card-body">
                    @if(session(\App\Models\product::TYPE_SADDLE))
                        <table id="cart" class="table table-hover table-condensed">
                            <thead>
                            <tr>
                                <th style="width:50%">Product</th>
                                <th style="width:10%">Price</th>
                                <th style="width:10%"></th>
                            </tr>
                            </thead>
                            <tbody>
                                @foreach(session(\App\Models\product::TYPE_SADDLE) as $id => $details)
                                    <?php $total += $details['price'] * $details['quantity'] ?>
                                    <tr>
                                        <td data-th="Product">
                                            <div class="row">
                                                <div class="col-sm-3 hidden-xs"><img src="{{ $details['photo'] }}" width="100" height="100" class="img-responsive"/></div>
                                                <div class="col-sm-9">
                                                    <h4 class="nomargin">{{ $details['name'] }}</h4>
                                                </div>
                                            </div>
                                        </td>
                                        <td data-th="Price">{{ $details['price'] }} €</td>
                                        <td>
                                        <form style="display: inline;" method="post" action="{{ route('remove-from-picker') }}" onclick="return confirm('Ar tikrai norite pašalinti?')">
                                            <input type="hidden" id="id" name="id" value={{ $id }}>
                                            <input type="hidden" id="category" name="category" value={{ \App\Models\product::TYPE_SADDLE }}>
                                            @csrf
                                            @method('delete')
                                            <button type="submit" class="btn btn-sm btn-danger">Trinti</button>
                                        </form>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                            <tfoot>
                            <tr class="visible-xl">
                                @if($details['maxquantity'] == 0)
                                    <td class="text-center" style="color: #ff0000"><strong>Prašome atkreipti dėmesi! Šio produkto nėra sandelyje</strong></td>
                                @endif
                            </tr>
                            </tfoot>
                        </table>
                        @else
                            <form style="display: inline;" method="post" action="{{ route('viewPickerProducts') }}">
                                <input type="hidden" id="category" name="category" value={{ \App\Models\product::TYPE_SADDLE }}>
                                @csrf
                                @method('get')
                                <button type="submit" class="btn btn-xl btn-primary">Pridėti</button>
                            </form>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">{{ __('Ratas') }}</div>
                    <div class="card-body">
                    @if(session(\App\Models\product::TYPE_TYRE))
                        <table id="cart" class="table table-hover table-condensed">
                            <thead>
                            <tr>
                                <th style="width:50%">Product</th>
                                <th style="width:10%">Price</th>
                                <th style="width:10%"></th>
                            </tr>
                            </thead>
                            <tbody>
                                @foreach(session(\App\Models\product::TYPE_TYRE) as $id => $details)
                                    <?php $total += $details['price'] * $details['quantity'] ?>
                                    <tr>
                                        <td data-th="Product">
                                            <div class="row">
                                                <div class="col-sm-3 hidden-xs"><img src="{{ $details['photo'] }}" width="100" height="100" class="img-responsive"/></div>
                                                <div class="col-sm-9">
                                                    <h4 class="nomargin">{{ $details['name'] }}</h4>
                                                </div>
                                            </div>
                                        </td>
                                        <td data-th="Price">{{ $details['price'] }} €</td>
                                        <td>
                                        <form style="display: inline;" method="post" action="{{ route('remove-from-picker') }}" onclick="return confirm('Ar tikrai norite pašalinti?')">
                                            <input type="hidden" id="id" name="id" value={{ $id }}>
                                            <input type="hidden" id="category" name="category" value={{ \App\Models\product::TYPE_TYRE }}>
                                            @csrf
                                            @method('delete')
                                            <button type="submit" class="btn btn-sm btn-danger">Trinti</button>
                                        </form>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                            <tfoot>
                            <tr class="visible-xl">
                                @if($details['maxquantity'] == 0)
                                    <td class="text-center" style="color: #ff0000"><strong>Prašome atkreipti dėmesi! Šio produkto nėra sandelyje</strong></td>
                                @endif
                            </tr>
                            </tfoot>
                        </table>
                        @else
                            <form style="display: inline;" method="post" action="{{ route('viewPickerProducts') }}">
                                <input type="hidden" id="category" name="category" value={{ \App\Models\product::TYPE_TYRE }}>
                                @csrf
                                @method('get')
                                <button type="submit" class="btn btn-xl btn-primary">Pridėti</button>
                            </form>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">{{ __('Priedas') }}</div>
                    <div class="card-body">
                    @if(session(\App\Models\product::TYPE_ACC))
                        <table id="cart" class="table table-hover table-condensed">
                            <thead>
                            <tr>
                                <th style="width:50%">Product</th>
                                <th style="width:10%">Price</th>
                                <th style="width:10%"></th>
                            </tr>
                            </thead>
                            <tbody>
                                @foreach(session(\App\Models\product::TYPE_ACC) as $id => $details)
                                    <?php $total += $details['price'] * $details['quantity'] ?>
                                    <tr>
                                        <td data-th="Product">
                                            <div class="row">
                                                <div class="col-sm-3 hidden-xs"><img src="{{ $details['photo'] }}" width="100" height="100" class="img-responsive"/></div>
                                                <div class="col-sm-9">
                                                    <h4 class="nomargin">{{ $details['name'] }}</h4>
                                                </div>
                                            </div>
                                        </td>
                                        <td data-th="Price">{{ $details['price'] }} €</td>
                                        <td>
                                        <form style="display: inline;" method="post" action="{{ route('remove-from-picker') }}" onclick="return confirm('Ar tikrai norite pašalinti?')">
                                            <input type="hidden" id="id" name="id" value={{ $id }}>
                                            <input type="hidden" id="category" name="category" value={{ \App\Models\product::TYPE_ACC }}>
                                            @csrf
                                            @method('delete')
                                            <button type="submit" class="btn btn-sm btn-danger">Trinti</button>
                                        </form>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                            <tfoot>
                            <tr class="visible-xl">
                                @if($details['maxquantity'] == 0)
                                    <td class="text-center" style="color: #ff0000"><strong>Prašome atkreipti dėmesi! Šio produkto nėra sandelyje</strong></td>
                                @endif
                            </tr>
                            </tfoot>
                        </table>
                        @endif
                        <form style="display: inline;" method="post" action="{{ route('viewPickerProducts') }}">
                                <input type="hidden" id="category" name="category" value={{ \App\Models\product::TYPE_ACC }}>
                                @csrf
                                @method('get')
                                <button type="submit" class="btn btn-xl btn-primary">Pridėti</button>
                            </form>
                    </div>
                </div>
            </div>
        </div>



        <div class="col-md-12">
            <div class="card">
                <div class="card-header">{{ __('Užsakymas') }}</div>
                <div class="card-body">
                    <table id="cart" class="table table-hover table-condensed">
                        <tfoot>
                        <tr>
                            <td><a href="{{ route('viewProducts') }}" class="btn btn-warning"><i class="fa fa-angle-left"></i>Tęsti apsipirkimą</a></td>
                            <td colspan="2" class="hidden-xs"></td>
                            <td class="hidden-xs text-center"><strong>Suma {{ $total }} €</strong></td>
                        </tr>
                        </tfoot>
                    </table>


                        <form method="post" action="{{ route('buyBike') }}">
                            @csrf
                            <div class="form-group">
                                <label for="adress">Pilnas adresas</label>
                                <input type="text" class="form-control" name="adress" id="adress" aria-describedby="emailHelp" placeholder="Įveskite adresa pvz.: Lietuva, Kaunas, Studentų g. 50 ">
                                @error('adress')
                                <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                @enderror
                            </div>

                            @csrf
                            <div class="form-group">
                                <label for="number">Korteles numeris</label>
                                <input type="text" class="form-control" name="number" id="number" aria-describedby="emailHelp" placeholder="Įveskite numeri">
                                @error('number')
                                <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="kaina">Korteles galiojimo data</label>
                                <input type="float" class="form-control" name="date" id="date" aria-describedby="emailHelp" placeholder="Įveskite data ">
                                @error('date')
                                <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="cvc">Korteles CVC</label>
                                <input type="text" class="form-control" name="cvc" id="cvc" aria-describedby="emailHelp" placeholder="Įveskite cvc">
                                @error('cvc')
                                <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                @enderror
                            </div>
                            <input type="hidden" id="assembly" name="assembly" value='1'>
                            @if(session('Base'))
                                @if(session(\App\Models\product::TYPE_BRAKE))
                                    @if(session(\App\Models\product::TYPE_SADDLE))
                                        @if(session(\App\Models\product::TYPE_TYRE))
                                            @if(session(\App\Models\product::TYPE_ACC))

                                    <button type="submit" class="btn btn-success">Sukurti užsakymą</button>
                                            @endif
                                        @endif
                                    @endif
                                @endif
                            @endif
                        </form>

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

