@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">{{ __('Prideti Preke') }}</div>

                    <div class="card-body">
                        @if (session('status'))
                            <div class="alert alert-success" role="alert">
                                {{ session('status') }}
                            </div>
                        @endif

                        <a class="btn btn-primary" href="{{ route('addAcc') }}">{{ __('Prideti prieda') }}</a>
                        <a class="btn btn-primary" href="{{ route('addBase') }}">{{ __('Prideti base') }}</a>
                        <a class="btn btn-primary" href="{{ route('addBrake') }}">{{ __('Prideti stabdi') }}</a>
                        <a class="btn btn-primary" href="{{ route('addSaddle') }}">{{ __('Prideti sedyne') }}</a>
                        <a class="btn btn-primary" href="{{ route('addTyre') }}">{{ __('Prideti rata') }}</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
