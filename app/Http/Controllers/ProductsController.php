<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Product;
use App\Carrito;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class ProductsController extends Controller
{
    //
    public function index(Request $request)
    {
        if ($request->isJson()) {
            $products = Product::all();
            return response()->json($products, 200);
        } else {
            return response()->json(['Error' => 'Unauthorized'], 401, []);
        }
    }

    public function createProducts(Request $request)
    {
        try {
            //dd($request->query());
            if ($request->isJson()) {

                $data = $this->validate($request, [
                    'nombre' => 'required|max:255',
                    'precio' => 'required',
                    'descripcion' => 'required',

                ]);

                $producto = Product::create([
                    'nombre' => $data['nombre'],
                    'precio' => $data['precio'],
                    'descripcion' => $data['descripcion']
                ]);

                return response()->json($producto, 201);
            } else {
                return response()->json(['Error' => 'Unauthorized'], 401, []);
            }
        } catch (Exception $ex) {
            return response()->json(['Error' => 'Error de api'], 410);
        }
    }

    public function updateProducts(Request $request, $id)
    {
        try {
            if ($request->isJson()) {

                $data = $this->validate($request, [
                    'nombre' => 'required',
                    'descripcion' => 'required',
                ]);

                $producto = Product::findOrFail($id);
                $producto->nombre = $data['nombre'];
                $producto->precio = $data['precio'];
                $producto->descripcion = $data['descripcion'];
                $producto->save();

                return response()->json($producto, 200);
            } else {
                return response()->json(['Error' => 'Unauthorized'], 401, []);
            }
        } catch (ModelNotFoundException $ex) {
            return response()->json(['Error' => 'No content'], 406, []);
        }
    }

    public function deleteProducts(Request $request, $id)
    {
        if ($request->isJson()) {

            try {
                $producto = Product::findOrFail($id);
                $producto->delete();

                return response()->json($producto, 200);
            } catch (ModelNotFoundException $ex) {
                return response()->json(['Error' => 'No content'], 406, []);
            }
        } else {
            return response()->json(['Error' => 'Unauthorized'], 401, []);
        }
    }

    public function addProductsCarrito(Request $request, $id, $id_p)
    {
        try {
            //dd($request->query());
            if ($request->isJson()) {

                try {
                    $producto1 = Product::findOrFail($id_p);
                    $producto = Carrito::create([
                        'id_orden' => $id,
                        'id_producto' => $id_p,
                        'nombre' => $producto1->nombre,
                        'precio' => $producto1->precio,
                        'cantidad' => 1,
                        'descripcion' => $producto1->descripcion
                    ]);


                    return response()->json($producto, 200);
                } catch (ModelNotFoundException $ex) {
                    return response()->json(['Error' => 'No content'], 406, []);
                }

            } else {
                return response()->json(['Error' => 'Unauthorized'], 401, []);
            }
        } catch (Exception $ex) {
            return response()->json(['Error' => 'Error de api'], 410);
        }
    }

    public function indexCarrito( Request $request, $id ){

        if ($request->isJson()) {
            //$carrito = Carrito::all();
            $carrito = Carrito::where('id_orden', '=', $id)->get();
            //$carrito = DB::table('carrito')->where('id_orden', '=', $id)->get();
            return response()->json($carrito, 200);
        } else {
            return response()->json(['Error' => 'Unauthorized'], 401, []);
        }

    }

    public function deleteProductsCarrito( Request $request, $id, $id_p ){

        if ($request->isJson()) {

            try {
                $producto = Carrito::where('id_orden','=',$id)->where('id_producto','=',$id_p)->delete();
                //$producto->delete();

                return response()->json($producto, 200);
            } catch (ModelNotFoundException $ex) {
                return response()->json(['Error' => 'No content'], 406, []);
            }
        } else {
            return response()->json(['Error' => 'Unauthorized'], 401, []);
        }

    }

}
