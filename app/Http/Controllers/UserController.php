<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\UserReservation;
use App\User;
use App\Role;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;

class UserController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
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
        $request->user()->authorizeRoles(['admin']);
         # Request
         if ($request->isMethod('post')) {
            $data['UserController_search'] = $request->input('UserController_search');
            $data['UserController_field'] = $request->input('UserController_field');
            $data['UserController_orderby'] = $request->input('UserController_orderby');
            $request->session()->flash('UserController_search', $data['UserController_search']);
            $request->session()->flash('UserController_field', $data['UserController_field']);
            $request->session()->flash('UserController_orderby', $data['UserController_orderby']);
        }else{
            if ($request->session()->has('UserController_search')) {
                $data['UserController_search'] = $request->session()->get('UserController_search');
                $request->session()->flash('UserController_search', $data['UserController_search']);
            }else{
                $data['UserController_search'] = '';
                $request->session()->forget('UserController_search');
            }
            if ($request->session()->has('UserController_field')) {
                $data['UserController_field'] = $request->session()->get('UserController_field');
                $request->session()->flash('UserController_field', $data['UserController_field']);
            }else{
                $data['UserController_field'] = 'users.id';
                $request->session()->forget('UserController_field');
            }
            if ($request->session()->has('UserController_orderby')) {
                $data['UserController_orderby'] = $request->session()->get('UserController_orderby');
                $request->session()->flash('UserController_orderby', $data['UserController_orderby']);
            }else{
                $data['UserController_orderby'] = 'desc';
                $request->session()->forget('UserController_orderby');
            }
        }
        $data['rows'] = DB::table('users')
            ->select('users.*')
            ->where('users.name', 'like', '%'.$data['UserController_search'].'%')
            ->orWhere('users.lastname', 'like', '%'.$data['UserController_search'].'%')
            ->orWhere('users.email', 'like', '%'.$data['UserController_search'].'%')
            ->orderBy($data['UserController_field'], $data['UserController_orderby'])
            ->paginate(10);
        return view('users.index', ['data' => $data]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('users.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        # Rules
        $this->validate($request, [
			'name' => 'required',
			'email' => 'required',
        ]);
        
        $rol = Role::where('role_name', 'like', '%user%')->first();

        $clave = "123456";

        $user = new User();
        $user->name = $request->name;
        $user->lastname = $request->lastname;
        $user->email = $request->email;
        $user->password = Hash::make($clave);
        $user->save();

        $user->roles()->attach(Role::where('name', 'user')->first());

        return redirect('/users')->with('success', 'Registro Guardado');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $count = User::where('id', $id)->count();
        if ($count>0) {
            # Show
            $data['row'] = User::where('id', $id)->first();
            return view('users.show', ['data' => $data]);
        }else{
            # Error
            return redirect('/users')->with('info', 'No se puede Ver el registro');
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $count = User::where('id', $id)->count();
        if ($count>0) {
            # Show
            $user = User::where('id', $id)->first();
            return view('users.edit', ['user' => $user]);
        }else{
            # Error
            return redirect('/users')->with('info', 'No se puede Ver el registro');
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $messages = [
            'name.required' => 'El nombre es un campo requerido',
            'email.required' => 'El correo es un campo requerido',
            'email.unique' => 'El correo ya esta siendo usado por otro usuario',
        ];
        $this->validate($request, [
            'name' => 'required',
            'email' => [
                'email',
                'required',
                Rule::unique('users')->ignore($id),
            ],
        ], $messages);
        # Edit
        $user = User::where('id', $id)->first();
        $user->name = $request->name;
        $user->lastname = $request->lastname;
        $user->email = $request->email;
        $user->save();

        return redirect('/users')->with('success', 'Registro Guardado');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $count = User::where('id', $id)->count();
        if ($count>0) {
            # Destroy
            $user_reservations = UserReservation::where('users_id', $id)->count();
            if($user_reservations > 0) {
                return redirect('/users')->with('danger', 'Usuario asignado a una reserva no puede ser eliminado!');
            }else{
                User::destroy($id);
                return redirect('/users')->with('success', 'Registro Eliminado');
            }
        }else{
            # Error
            return redirect('/users')->with('info', 'No se puede Eliminar el registro');
        }
    }
}
