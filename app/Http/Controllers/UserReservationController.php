<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\UserReservation;
use App\Reservation;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class UserReservationController extends Controller
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
            ->selectRaw('count(user_reservations.reservations_id) as reservas, reservations.*')
            ->leftjoin('user_reservations', 'user_reservations.reservations_id', 'reservations.id')
            ->where('reservations.reservation_date', 'like', '%'.$data['ReservationController_search'].'%')
            ->orderBy($data['ReservationController_field'], $data['ReservationController_orderby'])
            ->groupBY('reservations.id')
            ->paginate(10);
        return view('users-reservations.index', ['data' => $data]);
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
        # Rules
        $this->validate($request, [
			'column' => 'required',
			'row' => 'required',
        ]);
        
        $users_reservations = new UserReservation();
        $users_reservations->users_id = Auth::id();
        $users_reservations->reservations_id = $request->reserva;
        $users_reservations->column = $request->column;
        $users_reservations->row = $request->row;
        $users_reservations->save();

        return redirect('/users-reservations/select/'.$request->reserva)->with('success', 'Registro Guardado');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function select($id)
    {
        $count = Reservation::where('id', $id)->count();
        if ($count>0) {
            # Show
            $data['row'] = DB::table('reservations')
                ->selectRaw('count(user_reservations.reservations_id) as reservas, reservations.*')
                ->leftjoin('user_reservations', 'user_reservations.reservations_id', 'reservations.id')
                ->where('reservations.id', '=', $id)
                ->orderBy('reservations.id', 'DESC')
                ->groupBY('reservations.id')
                ->first();
            
            $data['row-user'] = DB::table('user_reservations')
                ->select('user_reservations.*')
                ->where([
                    ['user_reservations.reservations_id', '=', $id],
                    ['user_reservations.users_id', '=', Auth::id()],
                ])
                ->get();
            
            $reservas = DB::table('user_reservations')
                ->select('user_reservations.*')
                ->where('user_reservations.reservations_id', '=', $id)
                ->get();

            $columns = array();
            for($i= 1; $i < ($data['row']->column +1); $i ++){
                $cont = 0;
                foreach($reservas as $r){
                    if($i == $r->column){
                        $cont ++;
                    }
                }

                if($cont < $data['row']->row){
                    $columns[$i] = $i;
                }
            }

            return view('users-reservations.select', ['data' => $data, 'columns' => $columns]);
        }else{
            # Error
            return redirect('/users-reservations')->with('info', 'No se puede Ver el registro');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function searchRow($id, $column)
    {
        $count = Reservation::where('id', $id)->count();
        if ($count>0) {
            # Show
            $data['row'] = DB::table('reservations')
                ->selectRaw('count(user_reservations.reservations_id) as reservas, reservations.*')
                ->leftjoin('user_reservations', 'user_reservations.reservations_id', 'reservations.id')
                ->where('reservations.id', '=', $id)
                ->orderBy('reservations.id', 'DESC')
                ->groupBY('reservations.id')
                ->first();
            
            $reservas = DB::table('user_reservations')
                ->select('user_reservations.*')
                ->where('user_reservations.reservations_id', '=', $id)
                ->get();

            $rows = array();
            for($i= 1; $i < ($data['row']->row +1); $i ++){
                $cont = 0;
                foreach($reservas as $r){
                    if($column == $r->column && $r->row == $i){
                        $cont ++;
                    }
                }

                if($cont == 0){
                    $rows[] = $i;
                }
            }

            return $rows;
        }else{
            # Error
            return redirect('/users-reservations')->with('info', 'No se puede Ver el registro');
        }
    }
}
