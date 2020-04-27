<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Mail\MailRegister;
use App\User;
use App\Role;
use Illuminate\Support\Facades\Gate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Validation\Rule;


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
    public function index(Request $request)
    {
        $users= User::search($request->search)->paginate(8);
        return view('admin.users.index', compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        // Control de acceso mediante Gate
        if (Gate::denies('create-users')) {
            session()->flash('error','Acción no autorizada');
            return redirect(route('admin.users.index'));
        }

        return view('admin.users.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // Control de acceso Gate
        if (Gate::denies('create-users')) {
            return redirect(route('admin.users.index'));
        }

        // Validación del formulario
        $validatedData = $request->validate
        ([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);

        $user = User::create([
            'name' => $request['name'],
            'email' => $request['email'],
            'password' => Hash::make($request['password']),
        ]);

        // Usuario que se acaba de registrar le asignamos perfil user
        $role = Role::select('id')->where('name','user')->first();
        $user->roles()->attach($role);

        if($user) {
            $request->session()->flash('success','Usuario creado con éxito'); 
        }else {
            $request->session()->flash('error','Formulario no validado'); 
        }

        // Enviar email de confirmación al usuario registrado
        Mail::to($user->email)->send(new MailRegister($user));

        return redirect()->route('admin.users.index');
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

        // Validación de update
        $validatedData = $request->validate
        ([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 
                       Rule::unique('users')->ignore($user->id)]
        ]);
        

        
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
