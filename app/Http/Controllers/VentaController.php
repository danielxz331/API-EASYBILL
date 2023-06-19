<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Venta;
use App\Http\Controllers\AsignaController;

class VentaController extends Controller
{
    public function venta(Request $request)
    {
        $venta = new Venta();
        $venta->id_user = $request->id_user;
        $venta->metodo_pago = $request->metodo_pago;
        $venta->identificacion_cliente = $request->identificacion_cliente;
        $venta->nombre_cliente = $request->nombre_cliente;
        $venta->save();

        return response()->json([
            'message' => 'venta creada exitosamente!',
            'venta' => $venta
        ], 201);
    }

}
