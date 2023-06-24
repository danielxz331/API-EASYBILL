<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Caja;
use Carbon\Carbon;
use App\Models\Venta;
use App\Models\Asigna;

class CajaController extends Controller
{
    public function openCaja(Request $request)
    {
        $caja = new Caja();
        $caja->id_user = $request->user_id;
        $caja->estado = "abierta";
        $caja->monto = $request->monto;
        $caja->save();
        return response()->json([
            'message' => 'Caja abierta correctamente',
            'caja' => $caja
        ], 201);
    }

    public function validateCaja()
    {
        $inicioDia = Carbon::now()->startOfDay();
        $finDia = Carbon::now()->endOfDay();
        $caja = Caja::where('estado', "abierta")->where('created_at', '>', $inicioDia)->where('created_at', '<', $finDia)->first();
        if ($caja == null) {
            return response()->json([
                'message' => 'No hay caja abierta'
            ], 208);
        } else {
            return response()->json([
                'message' => 'Caja abierta',
                'caja' => $caja
            ], 203);
        }
    }

    public function closeCaja(Request $request)
    {

        $inicioDia = Carbon::now()->startOfDay();
        $finDia = Carbon::now()->endOfDay();

        $caja = new Caja();
        $caja->id_user = $request->user_id;
        $caja->estado = "cerrada";

        $cajaAbierta = Caja::where('estado', "abierta")->where('created_at', '>', $inicioDia)->where('created_at', '<', $finDia)->first();

        $totalVentas = Venta::where('metodo_pago', 'efectivo')
            ->whereBetween('created_at', [$inicioDia, $finDia])
            ->with('asigna') // asumiendo que la relación en el modelo Venta se llama 'asignas'
            ->get()
            ->reduce(function ($carry, $venta) {
                return $carry + $venta->asigna->sum('total_por_producto'); // asumiendo que el campo en 'asigna' se llama 'total_por_producto'
            });
    

        $caja->monto = $cajaAbierta->monto + $totalVentas;

        $caja->save();
        return response()->json([
            'message' => 'Caja cerrada correctamente',
            'caja' => $caja
        ], 201);
    }
}
