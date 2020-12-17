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
                                <th scope="col">Sukurtas</th>
                                <th scope="col">Statusas</th>
                                <th scope="col">Sudeliojimas</th>
                                <th scope="col">Adresas</th>
                                <th scope="col">Prekių vnt</th>
                                <th scope="col">Prekiu busena</th>
                                <th scope="col">Kaina</th>
                                <th scope="col">Veiskmai</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($orders as $order)
                                <tr>
                                    <th scope="row">{{$loop->index+1}}</th>
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
                                    <td>
                                        @if(auth()->user()->user_type == \App\Models\User::ROLE_WORKER && $order->available && $order->status == 0)
                                            <form style="display: inline;" method="post" action="{{ route('approveOrder') }}" onclick="return confirm('Ar tikrai norite patvirtinti?')">
                                                <input type="hidden" id="id" name="id" value={{ $order->id }}>
                                                @csrf
                                                @method('post')
                                                <button type="submit" class="btn btn-sm btn-primary">Patvirtinti</button>
                                            </form>
                                        @endif
                                        @if(auth()->user()->user_type == \App\Models\User::ROLE_USER && $order->status == 0)
                                                <form style="display: inline;" method="post" action="{{ route('deleteOrder') }}" onclick="return confirm('Ar tikrai norite pašalinti?')">
                                                    <input type="hidden" id="id" name="id" value={{ $order->id }}>
                                                    @csrf
                                                    @method('delete')
                                                    <button type="submit" class="btn btn-sm btn-danger">Atšaukti</button>
                                                </form>
                                        @else
                                            Dėl atšaukimo teiraukites pas administratoriu.
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
