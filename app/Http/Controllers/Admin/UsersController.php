<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\User;
use App\Role;
use Illuminate\Support\Facades\Gate;
use Illuminate\Http\Request;


class UsersController extends Controller
{
    
    public function __construct()
    {
        $this->middleware('auth');
    }
    
    
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users= User::all();
        return view('admin.users.index', compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function show(User $user)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function edit(User $user)
    {
        // Control de acceso Gate
        if (Gate::denies('edit-users')) {
            return redirect(route('admin.users.index'));
        }

        $roles = Role::all();
        return view('admin.users.edit', compact('user', 'roles'));

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, User $user)
    {
        if (Gate::denies('edit-users')) {
            return redirect(route('admin.users.index'));
        }
        
        // Sync Acepta una matriz de roles para colocar en la tabla user_role
        // los valores que no estén los elimina
        $user->roles()->sync($request->roles);

        // Actualizar user sin validación
        $user->name = $request->name;
        $user->email = $request->email;
        
        if($user->save()) {
            $request->session()->flash('success',$user->name. ' ha sido actualizado'); 
        }else {
            $request->session()->flash('error','Ocurrió un error en la actualización'); 
        }
        
        return redirect()->route('admin.users.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        // Control de acceso Gate
        if (Gate::denies('delete-users')) {
            return redirect(route('admin.users.index'));
        }

        // Elimina los roles de este usuario
        $user->roles()->detach();
        $user->delete();

        return redirect()->route('admin.users.index');
    }
}
