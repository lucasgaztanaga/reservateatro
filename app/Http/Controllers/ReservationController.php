<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Reservation;
use App\UserReservation;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;

class ReservationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        # Request
        if ($request->isMethod('post')) {
            $data['ReservationController_search'] = $request->input('ReservationController_search');
            $data['ReservationController_field'] = $request->input('ReservationController_field');
            $data['ReservationController_orderby'] = $request->input('ReservationController_orderby');
            $request->session()->flash('ReservationController_search', $data['ReservationController_search']);
            $request->session()->flash('ReservationController_field', $data['ReservationController_field']);
            $request->session()->flash('ReservationController_orderby', $data['ReservationController_orderby']);
        }else{
            if ($request->session()->has('ReservationController_search')) {
                $data['ReservationController_search'] = $request->session()->get('ReservationController_search');
                $request->session()->flash('ReservationController_search', $data['ReservationController_search']);
            }else{
                $data['ReservationController_search'] = '';
                $request->session()->forget('ReservationController_search');
            }
            if ($request->session()->has('ReservationController_field')) {
                $data['ReservationController_field'] = $request->session()->get('ReservationController_field');
                $request->session()->flash('ReservationController_field', $data['ReservationController_field']);
            }else{
                $data['ReservationController_field'] = 'reservations.id';
                $request->session()->forget('ReservationController_field');
            }
            if ($request->session()->has('ReservationController_orderby')) {
                $data['ReservationController_orderby'] = $request->session()->get('ReservationController_orderby');
                $request->session()->flash('ReservationController_orderby', $data['ReservationController_orderby']);
            }else{
                $data['ReservationController_orderby'] = 'desc';
                $request->session()->forget('ReservationController_orderby');
            }
        }
        $data['rows'] = DB::table('reservations')
            ->select('reservations.*')
            ->where('reservations.reservation_date', 'like', '%'.$data['ReservationController_search'].'%')
            ->orWhere('reservations.numbers_people', 'like', '%'.$data['ReservationController_search'].'%')
            ->orWhere('reservations.row', 'like', '%'.$data['ReservationController_search'].'%')
            ->orWhere('reservations.column', 'like', '%'.$data['ReservationController_search'].'%')
            ->orderBy($data['ReservationController_field'], $data['ReservationController_orderby'])
            ->paginate(10);
        return view('reservations.index', ['data' => $data]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('reservations.create');
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
			'numbers_people' => 'required',
			'row' => 'required',
			'column' => 'required',
        ]);
        
        $fecha = $this->fecha_to_date($request->reservation_date);
        $reservation = new Reservation();
        $reservation->reservation_date = $fecha;
        $reservation->numbers_people = $request->numbers_people;
        $reservation->row = $request->row;
        $reservation->column = $request->column;
        $reservation->save();

        return redirect('/reservations')->with('success', 'Registro Guardado');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $count = Reservation::where('id', $id)->count();
        if ($count>0) {
            # Show
            $data['row'] = Reservation::where('id', $id)->first();
            return view('reservations.show', ['data' => $data]);
        }else{
            # Error
            return redirect('/reservations')->with('info', 'No se puede Ver el registro');
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
        $count = Reservation::where('id', $id)->count();
        if ($count>0) {
            # Show
            $reservation = Reservation::where('id', $id)->first();
            return view('reservations.edit', ['reservation' => $reservation]);
        }else{
            # Error
            return redirect('/reservations')->with('info', 'No se puede Ver el registro');
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
            'numbers_people.required' => 'Número de puestos es un campo requerido',
            'row.required' => 'Filas es un campo requerido',
            'column.unique' => 'Columnas ya esta siendo usado por otro usuario',
        ];
        $this->validate($request, [
            'numbers_people' => 'required',
			'row' => 'required',
			'column' => 'required',
        ], $messages);
        # Edit
        $fecha = $this->fecha_to_date($request->reservation_date);
        $reservation = Reservation::where('id', $id)->first();
        $reservation->reservation_date = $fecha;
        $reservation->numbers_people = $request->numbers_people;
        $reservation->row = $request->row;
        $reservation->column = $request->column;
        $reservation->save();

        return redirect('/reservations')->with('success', 'Registro Guardado');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $count = Reservation::where('id', $id)->count();
        if ($count>0) {
            # Destroy
            $user_reservations = UserReservation::where('reservations_id', $id)->count();
            if($user_reservations > 0) {
                return redirect('/reservations')->with('danger', 'Reserva utilizada por un usuario no puede ser eliminado!');
            }else{
                Reservation::destroy($id);
                return redirect('/reservations')->with('success', 'Registro Eliminado');
            }
        }else{
            # Error
            return redirect('/reservations')->with('info', 'No se puede Eliminar el registro');
        }
    }

    public function fecha_to_date($data){
        $date_temp = explode('/', $data);
        $data = $date_temp[2].'-'.$date_temp[1].'-'.$date_temp[0];
        return $data;
    }
}
