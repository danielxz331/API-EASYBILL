<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Producto;
use App\Models\Asigna;
use Carbon\Carbon;

class ProductoController extends Controller
{
    //trae todos los productos
    public function allproducts()
    {
        $productos = Producto::where('activo', 1)->get();

        return response()->json($productos);
    }

    //crea producto
    public function store(Request $request)
    {
        $producto = new Producto();
        $producto->nombre_producto = $request->nombre_producto;
        $producto->precio = $request->precio;

        $archivo_solicitud = $request->file('file');
        $destinationPath = date('FY') . '/';
        $profileImage = time() . '.' . $request->file('file')->getClientOriginalExtension();
        $ruta = $archivo_solicitud->move('storage/' . $destinationPath, $profileImage);

        $producto->ruta_imagen_producto = "$ruta";
        $producto->save();

        return response()->json([
            'message' => 'Producto creado exitosamente!',
            'producto' => $producto
        ], 201);
    }

    //actualiza producto
    public function update(Request $request, $id)
    {
        // Buscar el producto a actualizar en la base de datos
        $producto = Producto::find($id);


        if ($request->has('nombre_producto')) {
            $producto->nombre_producto = $request->nombre_producto;
        }

        if ($request->has('precio')) {
            $producto->precio = $request->precio;
        }

        if ($request->has('file')) {
            $archivo_solicitud = $request->file('file');
            $destinationPath = date('FY') . '/';
            $profileImage = time() . '.' . $request->file('file')->getClientOriginalExtension();
            $ruta = $archivo_solicitud->move('storage/' . $destinationPath, $profileImage);

            $producto->ruta_imagen_producto = "$ruta";
        }
        $producto->save();

        return response()->json([
            'message' => 'Producto actualizado exitosamente!',
            'producto' => $producto
        ], 201);
    }

    //elimina producto
    public function destroy($id)
    {

        $asigna = Asigna::where('id_producto', $id)->get();
        $producto = Producto::find($id);

        if (count($asigna) > 0) {
            $producto->activo = 0;
            $producto->save();
            return response()->json(['mensaje' => 'El producto bloqueado'], 200);
        } else {
            $producto->delete();
            return response()->json(['mensaje' => 'Producto eliminado con éxito'], 200);
        }

        

        if (!$producto) {
            return response()->json(['mensaje' => 'El producto no existe'], 404);
        }
    }

    public function show($id)
    {
        $producto = Producto::find($id);

        if (!$producto) {
            return response()->json(['mensaje' => 'El producto no existe'], 404);
        }

        return response()->json($producto, 200);
    }

    public function totalVentasDia()
    {
        // Inicio y final del día
        $inicioDia = Carbon::now()->startOfDay();
        $finDia = Carbon::now()->endOfDay();

        // Consulta
        $productosVendidos = Asigna::whereBetween('created_at', [$inicioDia, $finDia])
            ->with('producto')
            ->get()
            ->groupBy('id_producto')
            ->map(function ($asignaciones) {
                return [
                    'producto' => $asignaciones[0]->producto->nombre_producto,
                    'ruta_imagen_producto' => $asignaciones[0]->producto->ruta_imagen_producto,
                    'cantidad' => $asignaciones->sum('cantidad'),
                    'total' => $asignaciones->sum('total_por_producto'),
                ];
            });

        // Retorna el resultado como un JSON
        return response()->json($productosVendidos);
    }

    public function totalVentasSemana()
    {
        // Inicio y final de la semana
        $inicioSemana = Carbon::now()->startOfWeek();
        $finSemana = Carbon::now()->endOfWeek();

        // Consulta
        $productosVendidos = Asigna::whereBetween('created_at', [$inicioSemana, $finSemana])
            ->with('producto')
            ->get()
            ->groupBy('id_producto')
            ->map(function ($asignaciones) {
                return [
                    'producto' => $asignaciones[0]->producto->nombre_producto,
                    'ruta_imagen_producto' => $asignaciones[0]->producto->ruta_imagen_producto,
                    'cantidad' => $asignaciones->sum('cantidad'),
                    'total' => $asignaciones->sum('total_por_producto'),
                ];
            });

        // Retorna el resultado como un JSON
        return response()->json($productosVendidos);
    }

    public function totalVentasMes()
    {
        // Inicio y final del mes
        $inicioMes = Carbon::now()->startOfMonth();
        $finMes = Carbon::now()->endOfMonth();

        // Consulta
        $productosVendidos = Asigna::whereBetween('created_at', [$inicioMes, $finMes])
            ->with('producto')
            ->get()
            ->groupBy('id_producto')
            ->map(function ($asignaciones) {
                return [
                    'producto' => $asignaciones[0]->producto->nombre_producto,
                    'ruta_imagen_producto' => $asignaciones[0]->producto->ruta_imagen_producto,
                    'cantidad' => $asignaciones->sum('cantidad'),
                    'total' => $asignaciones->sum('total_por_producto'),
                ];
            });

        // Retorna el resultado como un JSON
        return response()->json($productosVendidos);
    }

    public function platoMasVendidoDelDia() {
        // Inicio y final del día
        $inicioDia = Carbon::now()->startOfDay();
        $finDia = Carbon::now()->endOfDay();
    
        // Consulta
        $productosVendidos = Asigna::whereBetween('created_at', [$inicioDia, $finDia])
            ->with('producto')
            ->get()
            ->groupBy('id_producto')
            ->map(function ($asignaciones) {
                return [
                    'producto' => $asignaciones[0]->producto->nombre_producto,
                    'cantidad' => $asignaciones->sum('cantidad'),
                    'ruta_imagen_producto' => $asignaciones[0]->producto->ruta_imagen_producto,
                ];
            });
    
        // Encuentra el producto más vendido
        $productoMasVendido = $productosVendidos->sortByDesc('cantidad')->first();
    
        // Retorna el resultado como un JSON
        return response()->json($productoMasVendido);
    }

    public function platoMasVendidoDeLaSemana()
    {
        // Inicio y final de la semana
        $inicioSemana = Carbon::now()->startOfWeek();
        $finSemana = Carbon::now()->endOfWeek();

        // Consulta
        $productosVendidos = Asigna::whereBetween('created_at', [$inicioSemana, $finSemana])
            ->with('producto')
            ->get()
            ->groupBy('id_producto')
            ->map(function ($asignaciones) {
                return [
                    'producto' => $asignaciones[0]->producto->nombre_producto,
                    'cantidad' => $asignaciones->sum('cantidad'),
                    'ruta_imagen_producto' => $asignaciones[0]->producto->ruta_imagen_producto,
                ];
            });

        // Encuentra el producto más vendido
        $productoMasVendido = $productosVendidos->sortByDesc('cantidad')->first();

        // Retorna el resultado como un JSON
        return response()->json($productoMasVendido);
    }

    public function platoMasVendidoDelMes()
    {
        // Inicio y final del mes
        $inicioMes = Carbon::now()->startOfMonth();
        $finMes = Carbon::now()->endOfMonth();

        // Consulta
        $productosVendidos = Asigna::whereBetween('created_at', [$inicioMes, $finMes])
            ->with('producto')
            ->get()
            ->groupBy('id_producto')
            ->map(function ($asignaciones) {
                return [
                    'producto' => $asignaciones[0]->producto->nombre_producto,
                    'cantidad' => $asignaciones->sum('cantidad'),
                    'ruta_imagen_producto' => $asignaciones[0]->producto->ruta_imagen_producto,
                ];
            });

        // Encuentra el producto más vendido
        $productoMasVendido = $productosVendidos->sortByDesc('cantidad')->first();

        // Retorna el resultado como un JSON
        return response()->json($productoMasVendido);
    }
}
