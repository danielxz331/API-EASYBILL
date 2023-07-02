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

    public function totalPedidosDia()
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

    public function totalPedidosSemana()
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

    public function totalPedidosMes()
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

    public function usuarioConMasVentas()
    {
        // Primer día del mes
        $inicioMes = Carbon::now()->startOfMonth();

        // Último día del mes
        $finMes = Carbon::now()->endOfMonth();

        // Consulta
        $ventas = Venta::whereBetween('created_at', [$inicioMes, $finMes])
            ->with(['asigna', 'usuario'])
            ->get()
            ->groupBy('id_user')
            ->map(function ($ventas) {
                return [
                    'usuario' => $ventas[0]->usuario->name, // asumiendo que el campo de nombre es 'name' en el modelo de usuario
                    'ruta_imagen_usuario' => $ventas[0]->usuario->ruta_imagen_usuario, // asumiendo que el campo de ruta de imagen es 'ruta_imagen_usuario' en el modelo de usuario
                    'ventas' => $ventas->count(),
                    'total_venta' => $ventas->sum(function ($venta) {
                        return $venta->asigna->sum('total_por_producto'); // asumiendo que el campo de precio es 'precio' en el modelo de asigna
                    }),
                ];
            });

        // Encuentra el usuario con más ventas
        $usuarioConMasVentas = $ventas->sortByDesc('total_venta')->first();

        // Retorna el resultado como un JSON
        return response()->json($usuarioConMasVentas);
    }

    public function mejorDiaDeVentas()
    {
        // Inicio y final del mes
        $inicioMes = Carbon::now()->startOfMonth();
        $finMes = Carbon::now()->endOfMonth();

        // Consulta
        $ventas = Venta::whereBetween('created_at', [$inicioMes, $finMes])
            ->with(['asigna', 'usuario'])
            ->get()
            ->groupBy(function ($venta) {
                return Carbon::parse($venta->created_at)->format('Y-m-d'); // Agrupa las ventas por día
            })
            ->map(function ($ventasPorDia, $dia) {
                return [
                    'dia' => $dia, // Agrega el día al resultado
                    'ventas' => $ventasPorDia->count(),
                    'total_venta' => $ventasPorDia->sum(function ($venta) {
                        return $venta->asigna->sum('total_por_producto'); // asumiendo que el campo de precio es 'precio' en el modelo de asigna
                    }),
                ];
            });

        // Encuentra el día con más ventas
        $mejorDiaDeVentas = $ventas->sortByDesc('total_venta')->first();

        // Retorna el resultado como un JSON
        return response()->json($mejorDiaDeVentas);
    }

    public function mejorSemanaDeVentas()
    {
        // Inicio y final del mes
        $inicioMes = Carbon::now()->startOfMonth();
        $finMes = Carbon::now()->endOfMonth();
    
        // Consulta
        $ventas = Venta::whereBetween('created_at', [$inicioMes, $finMes])
            ->with(['asigna', 'usuario'])
            ->get()
            ->groupBy(function ($venta) {
                return Carbon::parse($venta->created_at)->format('W'); // Agrupa las ventas por semana
            })
            ->map(function ($ventasPorSemana, $semana) {
                $inicioSemana = Carbon::now()->startOfYear()->addWeeks($semana)->startOfWeek();
                $finSemana = Carbon::now()->startOfYear()->addWeeks($semana)->endOfWeek();
    
                return [
                    'semana' => $semana, // Agrega la semana al resultado
                    'inicio_semana' => $inicioSemana->toDateString(), // Agrega el inicio de la semana al resultado
                    'fin_semana' => $finSemana->toDateString(), // Agrega el final de la semana al resultado
                    'ventas' => $ventasPorSemana->count(),
                    'total_venta' => $ventasPorSemana->sum(function ($venta) {
                        return $venta->asigna->sum('total_por_producto'); // asumiendo que el campo de precio es 'precio' en el modelo de asigna
                    }),
                ];
            });
    
        // Encuentra la semana con más ventas
        $mejorSemanaDeVentas = $ventas->sortByDesc('total_venta')->first();
    
        // Retorna el resultado como un JSON
        return response()->json($mejorSemanaDeVentas);
    }

    public function TotalCantidadVentas()
    {
        $ventas = Venta::all();

        return response()->json([
            'total_ventas' => $ventas->count(),
        ], 201);
    }
}
