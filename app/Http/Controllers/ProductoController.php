<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Producto;

class ProductoController extends Controller
{
    //trae todos los productos
    public function allproducts()
    {
        $productos = Producto::all();

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


        if($request->has('nombre_producto'))
        {
            $producto->nombre_producto = $request->nombre_producto;
        }

        if($request->has('precio'))
        {
            $producto->precio = $request->precio;
        }

        if($request->has('file'))
        {
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
        $producto = Producto::find($id);

        if (!$producto) {
            return response()->json(['mensaje' => 'El producto no existe'], 404);
        }

        $producto->delete();

        return response()->json(['mensaje' => 'Producto eliminado con éxito'], 200);
    }
}
