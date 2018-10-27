<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\UserReservation;
use App\Reservation;
use Illuminate\Support\Facades\DB;

class ReportController extends Controller
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
            $data['ReportController_search'] = $request->input('ReportController_search');
            $data['ReportController_field'] = $request->input('ReportController_field');
            $data['ReportController_orderby'] = $request->input('ReportController_orderby');
            $request->session()->flash('ReportController_search', $data['ReportController_search']);
            $request->session()->flash('ReportController_field', $data['ReportController_field']);
            $request->session()->flash('ReportController_orderby', $data['ReportController_orderby']);
        }else{
            if ($request->session()->has('ReportController_search')) {
                $data['ReportController_search'] = $request->session()->get('ReportController_search');
                $request->session()->flash('ReportController_search', $data['ReportController_search']);
            }else{
                $data['ReportController_search'] = '';
                $request->session()->forget('ReportController_search');
            }
            if ($request->session()->has('ReportController_field')) {
                $data['ReportController_field'] = $request->session()->get('ReportController_field');
                $request->session()->flash('ReportController_field', $data['ReportController_field']);
            }else{
                $data['ReportController_field'] = 'reservations.id';
                $request->session()->forget('ReportController_field');
            }
            if ($request->session()->has('ReportController_orderby')) {
                $data['ReportController_orderby'] = $request->session()->get('ReportController_orderby');
                $request->session()->flash('ReportController_orderby', $data['ReportController_orderby']);
            }else{
                $data['ReportController_orderby'] = 'desc';
                $request->session()->forget('ReportController_orderby');
            }
        }
        $data['rows'] = DB::table('reservations')
            ->selectRaw('count(user_reservations.reservations_id) as reservas, reservations.*')
            ->leftjoin('user_reservations', 'user_reservations.reservations_id', 'reservations.id')
            ->where('reservations.reservation_date', 'like', '%'.$data['ReportController_search'].'%')
            ->orderBy($data['ReportController_field'], $data['ReportController_orderby'])
            ->groupBY('reservations.id')
            ->paginate(10);

        return view('reports.index', ['data' => $data]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function report($id)
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

            $puestos = array();
            for($j= 1; $j < ($data['row']->row +1); $j ++){
                for($i= 1; $i < ($data['row']->column +1); $i ++){
                    $reserva = DB::table('user_reservations')
                        ->select('users.email')
                        ->join('users', 'users.id', 'user_reservations.users_id')
                        ->where([
                            ['user_reservations.reservations_id', '=', $id],
                            ['user_reservations.row', '=', $j],
                            ['user_reservations.column', '=', $i]
                        ])
                        ->first();
                    if(isset($reserva)){
                        $puestos[] = array(
                            'row' => $j,
                            'column' => $i,
                            'user' => $reserva->email
                        );
                    } else {
                        $puestos[] = array(
                            'row' => $j,
                            'column' => $i,
                            'user' => 'Disponible'
                        );
                    }
                }
            }

            return view('reports.report', ['data' => $data, 'puestos' => $puestos]);
        }else{
            # Error
            return redirect('/reports')->with('info', 'No se puede Ver el registro');
        }
    }
}
