@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">{{ __('Administratoriaus') }}</div>

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
                            <th scope="col">Vartotojas</th>
                            <th scope="col">elektroninis paštas</th>
                            <th scope="col">Paskyra sukurta</th>
                            <th scope="col">Paskyra atnaujinta</th>
                            <th scope="col">Paskyros tipas</th>
                            <th scope="col">Veiskmai</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($users as $user)
                            <tr>
                                <th scope="row">{{$loop->index+1}}</th>
                                <td>{{$user->name }}</td>
                                <td>{{$user->email}}</td>
                                <td>{{$user->created_at }}</td>
                                <td>{{$user->updated_at }}</td>

                                @if($user->user_type != 'blokuotas')
                                <form style="display: inline;" method="post" action="{{ route('updateUser')}}" >
                                <td>
                                    <div class="form-group">
                                        <select type="text" class="form-control" name="kategorija" id="kategorija" aria-describedby="emailHelp" placeholder="Įveskite kategorija uzklausos">
                                            <option>{{$user->user_type}}</option>
                                            @if($user->user_type != 'administratorius')
                                            <option>administratorius</option>
                                            @endif
                                            @if($user->user_type !='naudotojas')
                                            <option>naudotojas</option>
                                            @endif
                                            @if($user->user_type != 'darbuotojas')
                                            <option>darbuotojas</option>
                                            @endif
                                        </select>
                                        @error('kategorija')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                </td>
                                <td>
                                        <input type="hidden" id="id" name="id" value={{ $user->id }}>
                                        @csrf
                                        @method('post')
                                        <button type="submit" onclick="return confirm('Ar tikrai norite pakeisti?')" class="btn btn-sm btn-danger">Saugoti</button>
                                </form>

                                    <form style="display: inline;" method="post" action="{{ route('blockUser') }}" onclick="return confirm('Ar tikrai norite pašalinti?')">
                                        <input type="hidden" id="id" name="id" value={{ $user->id }}>
                                        @csrf
                                        @method('post')
                                        <button type="submit" class="btn btn-sm btn-danger">Blokuoti</button>
                                    </form>
                                    <div class="row justify-content-center">
                                        <form style="display: inline;" method="post" action="{{ route('deleteUser') }}" onclick="return confirm('Ar tikrai norite pašalinti?')">
                                            <input type="hidden" id="id" name="id" value={{ $user->id }}>
                                            @csrf
                                            @method('delete')
                                            <button type="submit" class="btn btn-sm btn-danger">Trinti</button>
                                        </form>
                                    </div>
                                </td>
                                @else
                                    <td>
                                        Blokuotas Vartotojas
                                    </td>
                                    <td>

                                    </td>
                                @endif
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
