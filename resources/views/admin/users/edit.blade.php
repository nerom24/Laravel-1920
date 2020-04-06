@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
            <div class="card-header">Editar {{$user->name}}</div>

                <div class="card-body">
                    
                    {{-- Formulario de edición  con método PUT y csrf token de seguridad --}}
                    <form action={{route('admin.users.update', $user)}} method = "POST">
                        
                        @csrf
                        {{ method_field('PUT') }}

                        {{-- Campo Name --}}
                        <div class="form-group">
                            <label class="form-label">{{ __('Nombre') }}</label>
                            <input id="name" type="text" name="name" class="form-control @error('name') is-invalid @enderror"  value="{{ $user->name }}">
                            @error('name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                            @enderror
                        </div>

                        {{-- Campo Email --}}
                        <div class="form-group">
                            <label class="form-label">{{ __('Email') }}</label>
                            <input id="email" type="email" name="email" class="form-control @error('email') is-invalid @enderror"  value={{$user->email}}>
                            @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                            @enderror
                        </div>

                        <label class="form-label">{{ __('Roles') }}</label>
                        @foreach ($roles as $role)

                            <div class="form-check"> 
                            <input class="form-check-input" type="checkbox" name="roles[]" value="{{$role->id}}" 
                            @if($user->roles->pluck('id')->contains($role->id)) checked @endif>
                                <label class="form-check-label" for="defaultCheck1">
                                    {{$role->name}}
                                </label>
                            </div>
                        
                        @endforeach
                        <hr>
                        <a class="btn btn-secondary" href="{{route('admin.users.index')}}" role="button">Cancelar</a>
                        <button type="submit" class="btn btn-primary">Actualizar</button>

                    </form>

                </div>
            </div>
        </div>
    </div>
</div>
@endsection