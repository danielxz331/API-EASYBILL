<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Venta;
use Carbon\Carbon;
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

    public function totalVentasDelDia()
    {
        // Inicio y final del día
        $inicioDia = Carbon::now()->startOfDay();
        $finDia = Carbon::now()->endOfDay();

        // Consulta
        $ventas = Venta::whereBetween('created_at', [$inicioDia, $finDia])
            ->with(['asigna', 'usuario'])
            ->get()
            ->map(function ($venta) {
                return [
                    'venta_id' => $venta->id,
                    'total_venta' => $venta->asigna->sum('total_por_producto'),
                    'nombre_usuario' => $venta->usuario->name,
                    'nombre_cliente' => $venta->nombre_cliente,
                    'identificacion_cliente' => $venta->identificacion_cliente,
                    'metodo_pago' => $venta->metodo_pago,
                    'fecha_venta' => $venta->created_at,
                ];
            });

        $totalVentas = $ventas->sum('total_venta');

        return response()->json([
            'total_ventas' => $totalVentas,
            'detalle_ventas' => $ventas,
        ], 201);
    }

    public function totalVentaSemana()
    {
        // Primer día de la semana (lunes)
        $inicioSemana = Carbon::now()->startOfWeek();

        // Último día de la semana (domingo)
        $finSemana = Carbon::now()->endOfWeek();

        // Consulta
        $ventas = Venta::whereBetween('created_at', [$inicioSemana, $finSemana])
            ->with(['asigna', 'usuario'])
            ->get()
            ->map(function ($venta) {
                return [
                    'venta_id' => $venta->id,
                    'total_venta' => $venta->asigna->sum('total_por_producto'),
                    'nombre_usuario' => $venta->usuario->name,
                    'nombre_cliente' => $venta->nombre_cliente,
                    'identificacion_cliente' => $venta->identificacion_cliente,
                    'metodo_pago' => $venta->metodo_pago,
                    'fecha_venta' => $venta->created_at,
                ];
            });

        $totalVentas = $ventas->sum('total_venta');

        return response()->json([
            'total_ventas' => $totalVentas,
            'detalle_ventas' => $ventas,
        ], 201);
    }

    public function totalVentaMes()
    {

        // Primer día del mes
        $inicioMes = Carbon::now()->startOfMonth();

        // Último día del mes
        $finMes = Carbon::now()->endOfMonth();

        // Consulta
        $ventas = Venta::whereBetween('created_at', [$inicioMes, $finMes])
            ->with(['asigna', 'usuario'])
            ->get()
            ->map(function ($venta) {
                return [
                    'venta_id' => $venta->id,
                    'total_venta' => $venta->asigna->sum('total_por_producto'),
                    'nombre_usuario' => $venta->usuario->name,
                    'nombre_cliente' => $venta->nombre_cliente,
                    'identificacion_cliente' => $venta->identificacion_cliente,
                    'metodo_pago' => $venta->metodo_pago,
                    'fecha_venta' => $venta->created_at,
                ];
            });

        $totalVentas = $ventas->sum('total_venta');

        return response()->json([
            'total_ventas' => $totalVentas,
            'detalle_ventas' => $ventas,
        ], 201);
    }
}
