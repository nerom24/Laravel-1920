@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            @include('partials.alerts')
            <div class="card">
                <div class="card-header">Usuarios</div>
                {{-- <div class="card-header">
                    @include('admin.users.partials.menu')
                </div> --}}
                <div class="card-body"> 
                    @include('admin.users.partials.menu')
                    {{-- Muestra los usuarios en una tabla --}}

                    <table class="table">
                        <thead>
                          <tr>
                            <th scope="col">#</th>
                            <th scope="col">Nombre</th>
                            <th scope="col">Correo</th>
                            <th scope="col">Roles</th>
                            <th scope="col">Acciones</th>
                          </tr>
                        </thead>
                    <tbody>

                    @forelse ($users as $user)
                        <tr>
                            <td>{{ $user->id }}</td>
                            <td>{{ $user->name }}</td>
                            <td>{{ $user->email }}</td>
                            {{-- Extra los roles que tiene asignado el usuario --}}
                            <td>{{ implode(', ', $user->roles()->get()->pluck('name')->toArray()) }}</td>
                            <td>
                                @can('edit-users')
                                <a href="{{ route('admin.users.edit', $user->id) }}"> <button type="button" class="btn btn-primary inline">Editar</button></a>
                                @endcan
                                
                                @can('delete-users')
                                <form action={{route('admin.users.destroy', $user)}} method = "POST" class="list-inline-item">
                                    @csrf
                                    {{ method_field('DELETE') }}
                                    <button type="submit" class="btn btn-danger">Eliminar</button></a>
                                </form>
                                @endcan

                            </td>
                        </tr>
                    @empty
	                    <li>No hay registros seleccionados</li>
                    @endforelse

                    </tbody>
                    </table>
                    @include('admin.users.partials.paginado')
                </div>
                <div class="card-footer text-muted">
                    Total Usuarios: {{$users->count()}}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection