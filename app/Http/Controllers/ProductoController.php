<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Producto;

class ProductoController extends Controller
{
    //trae todos los productos
    public function index()
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
        $producto->ruta_imagen_producto = $request->ruta_imagen_producto;
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

        // Si el producto no existe, devolver una respuesta con código 404
        if (!$producto) {
            return response()->json(['message' => 'Producto no encontrado'], 404);
        }

        // Validar los datos recibidos en la petición
        $validatedData = $request->validate([
            'nombre_producto' => 'required|max:255',
            'precio' => 'required|numeric',
            'ruta_imagen_producto' => 'required|max:255'
        ]);

        // Actualizar los campos del producto con los nuevos valores recibidos
        $producto->nombre_producto = $validatedData['nombre_producto'];
        $producto->precio = $validatedData['precio'];
        $producto->ruta_imagen_producto = $validatedData['ruta_imagen_producto'];

        // Guardar los cambios en la base de datos
        $producto->save();

        // Devolver una respuesta con el producto actualizado y un código 200 de éxito
        return response()->json(['producto' => $producto], 200);
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
