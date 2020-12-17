@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">{{ __('Krepšelis') }}</div>
                    <div class="card-body">
                        <table id="cart" class="table table-hover table-condensed">
                            <thead>
                            <tr>
                                <th style="width:50%">Produktas</th>
                                <th style="width:10%">Kaina</th>
                                <th style="width:8%">Kiekis</th>
                                <th style="width:22%" class="text-center">Tarpinė suma</th>
                                <th style="width:10%"></th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php $total = 0 ?>
                            <?php $totalq = 0 ?>
                            @if(session('cart'))
                                @foreach(session('cart') as $id => $details)
                                    <?php $total += $details['price'] * $details['quantity'] ?>
                                    @if($details['quantity'] > $details['maxquantity'])
                                    <?php $totalq += 1 ?>
                                    @endif
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
                                                                                    <form style="display: inline;" method="post" action="{{ route('update-cart') }}" onclick="return confirm('Ar tikrai norite keisti?')">
                                        <td data-th="Quantity">
                                            <input type="number" id="Quantity" name="Quantity" value="{{ $details['quantity'] }}" class="form-control quantity" />
                                            @if($details['quantity'] > $details['maxquantity'])
                                                    <div style="color: red">----------</div>
                                            @endif
                                        </td>
                                        <td data-th="Subtotal" class="text-center">{{ $details['price'] * $details['quantity'] }} €</td>
                                        <td class="actions" data-th="">
                                                                                        <input type="hidden" id="id" name="id" value={{ $id }}>
                                                                                        @csrf
                                                                                        @method('patch')
                                                                                        <button type="submit" class="btn btn-sm btn-primary">Atnaujinti</button>
                                                                                    </form>
                                            <form style="display: inline;" method="post" action="{{ route('remove-from-cart') }}" onclick="return confirm('Ar tikrai norite pašalinti?')">
                                                <input type="hidden" id="id" name="id" value={{ $id }}>
                                                @csrf
                                                @method('delete')
                                                <button type="submit" class="btn btn-sm btn-danger">Trinti</button>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                            @endif
                            </tbody>
                            <tfoot>
                            <tr class="visible-xl">
                                @if($totalq > 0)
                                <td class="text-center" style="color: red"><strong>Prašome atkreipti dėmesi, kad užsiakinėjate daugiau produktų negų šią akimirką yra sandelyje</strong></td>
                                @endif
                            </tr>
                            <tr>
                                <td><a href="{{ route('viewProducts') }}" class="btn btn-warning"><i class="fa fa-angle-left"></i>Tęsti apsipirkimą</a></td>
                                <td colspan="2" class="hidden-xs"></td>
                                <td class="hidden-xs text-center"><strong>Suma {{ $total }} €</strong></td>
                            </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">{{ __('Užsakymas') }}</div>
                    <div class="card-body">

                        <form method="post" action="{{ route('buyPreke') }}">
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
                            <input type="hidden" id="assembly" name="assembly" value='0'>
                            @if(session('cart'))
                            <button type="submit" class="btn btn-success">Sukurti užsakymą</button>
                            @endif
                        </form>

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

