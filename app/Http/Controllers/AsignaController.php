<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Asigna;
class AsignaController extends Controller
{
    public function asigna(Request $request)
    {
        $asigna = new Asigna();
        $asigna->id_producto = $request->id_producto;
        $asigna->id_venta = $request->id_venta;
        $asigna->cantidad = $request->cantidad;
        $asigna->total_por_producto = $request->total_por_producto;
        $asigna->save();

        return response()->json([
            'message' => 'asignacion creada exitosamente!',
            'asigna' => $asigna
        ], 201);
    }

    public function TotalIngresos()
    {
        $ingresos = Asigna::sum('total_por_producto');

        return response()->json([
            'total_ingresos' => $ingresos,
        ], 201);
    }
}
