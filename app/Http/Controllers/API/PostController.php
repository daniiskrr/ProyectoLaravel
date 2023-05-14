<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Posts;
use App\Models\Suscripcion;
use App\Models\Pedido;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use App\Models\User;
use App\Models\Role;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;



class PostController extends Controller
{
    //Mostrar todos los datos para Posts (Panel Productos)
    public function index(){
        $posts = Posts::all()->toArray();
        return $posts;
    }
    //Funcion para poder añadir productos a la web
    public function add(Request $request){

        $request->validate([
            'nombre' => 'required',
            'descripcion' => 'required',
            'id_suscripcion' => 'required',
            'precio' => 'required',
            'file' => 'required|image|mimes:jpeg,png,jpg,gif,svg,webp|max:2048',
        ]);

        $input = $request->all();
        $imageName = NULL;

        if($image = $request->file('file')){
            $destinationPath = 'img/';
            $imageName = date('YmdHis') . "." . $image->getClientOriginalExtension();
            $image->move($destinationPath, $imageName);
            $input['image'] = $imageName;
        }

        Posts::create($input);
        return response()->json(['success' => 'Producto creado correctamente']);
    }
    //Función para eliminar productos de la web
    public function eliminaProducto($id)
    {
        $producto = Posts::findOrFail($id);
        $image_path = public_path('img/' . $producto->image);
        if (File::exists($image_path)) {
            File::delete($image_path); // Elimina la foto del producto
        }
        $producto->delete();
        return response()->json(['success' => 'Producto eliminado correctamente']);
    }
    //Función para obtener los datos de los productos y posteriormente, poderlos editar gracias a la función "update"
    public function edit($id)
    {
        $post = Posts::find($id);
        return response()->json($post);
    }

    //Función para mandar los datos de los productos y actualizar los datos en la BBDD
    public function update(Request $request, $id)
    {
        $post = Posts::find($id);
        if (!$post) {
            return response()->json(['error' => 'El post no existe'], 404);
        }
        $request->validate([
            'nombre' => 'required',
            'descripcion' => 'required',
            'id_suscripcion' => 'required',
            'precio' => 'required',
            'img' => 'image|mimes:jpeg,png,jpg,gif,svg,webp|max:2048',
        ]);

        $input = $request->all();
        $imageName = NULL;
        if ($image = $request->file('file')) {
            $destinationPath = 'img/';
            $imageName = date('YmdHis') . "." . $image->getClientOriginalExtension();
            $image->move($destinationPath, $imageName);
            $input['image'] = $imageName;
            if ($post->image) {
                unlink('img/'.$post->image);
            }
        }
        $post->update($input);
        return response()->json(['success'=> 'Producto Actualizado']);
    }

        //Función para mostrar los productos en la tienda
        public function tiendaall(){
            $productito = Posts::all()->toArray();
            return $productito;
        }
        //Función para mostrar los productos que no tengan ninguna suscripción. Los productos se mostrarán a todos los usuarios incluso sin login
        public function tienda(){
            $posts = Posts::whereIn('id_suscripcion', [1])->get()->toArray();
            return response()->json($posts);

        }
        //Función para mostrar los productos que tengan cualquier suscripción. Las ofertas solo se mostrarán a los usuarios que tengan plus.
        public function ofertas(){
        $ofertas = Posts::whereIn('id_suscripcion', [2, 3, 4])->get()->toArray();

        //Obtenemos el usuario autenticado
        $user = auth()->user();

        //Aplicamos descuento según el tipo de suscripción
        foreach ($ofertas as &$oferta) {
            if ($user->tipo_suscripcion == 'PsPlus Essential') { //Si usuario es Essential 20% descuento y juegos Essential gratis
                $oferta['precio'] = number_format($oferta['precio'] * 0.8, 2);
                if ($oferta['id_suscripcion'] == 2) {
                    $oferta['precio'] = 0.00;
                }
            } elseif ($user->tipo_suscripcion == 'PsPlus Extra') { //Si usuario es Extra 40% descuento y juegos Extra gratis
                if ($oferta['id_suscripcion'] == 3) {
                    $oferta['precio'] = 0.00;
                } else {
                    $oferta['precio'] = $oferta['precio'] * 0.6;
                }
            } elseif ($user->tipo_suscripcion == 'PsPlus Premium') { //Si usuario es Premium 60% descuento y juegos Premium gratis
                if ($oferta['id_suscripcion'] == 4) {
                    $oferta['precio'] = 0.00;
                } else {
                    $oferta['precio'] = number_format($oferta['precio'] * 0.4, 2);
                }
            }
        }
        return $ofertas;
    }
    //Función para mostrar las suscripciones a los usuarios que no tengan ninguna.
    public function suscripciones(){
        $susc = Suscripcion::whereIn('id', [2, 3, 4])->get()->toArray();
        return response()->json($susc);
    }
    //Función para insertar los datos del pedido de los usuarios.
    public function finalizarPedido(Request $request)
    {
        //Obtenemos el id del usuario actual
        $idusuario = auth()->id();

        //Obtenemos la fecha actual
        $fechaPedido = now();

        //Insertamos los datos en la tabla pedido
        Pedido::create([
            'id_usuario' => $idusuario,
            'fecha_pedido' => $fechaPedido,
            'tipo_pago' => 'Tarjeta',
            'precio_total' => $request->input('precioTotal'),
        ]);

        //Redireccionar a una página de confirmación o enviar una respuesta JSON
        return response()->json(['success' => true]);
    }
    //Si el usuario con sesión iniciada, compra una suscripción en su pedido, se actualizará su tipo_suscripción en la tabla users y en sus sesion iniciada actual.
    public function actualizarSuscripciones(Request $request)
    {
        $usuarioId = auth()->id();
        $suscripcion = $request->input('suscripcion');

        if (!$usuarioId) {
            return response()->json(['error' => 'Debe estar autenticado para actualizar su suscripción'], 401);
        }

        if (empty($suscripcion['nombre_suscripcion'])) {
            return response()->json(['error' => 'Debe proporcionar el nombre de la suscripción'], 400);
        }

        $usuario = User::find($usuarioId);

        if (!$usuario) {
            return response()->json(['error' => 'No se ha encontrado el usuario'], 404);
        }

        $usuario->tipo_suscripcion = $suscripcion['nombre_suscripcion'];
        $usuario->duracion = 365;
        $usuario->save();

        // Actualizar suscripción en la sesión del usuario
        session(['tipo_suscripcion' => $suscripcion['nombre_suscripcion']]);

        return response()->json(['mensaje' => 'Suscripción actualizada correctamente.']);
    }
    //Obtenemos los pedidos para mostrarlos en el dashboard del usuario
    public function obtenerPedidos($id) {
        try {
            $pedidos = Pedido::where('id_usuario', $id)
                ->select('id', 'fecha_pedido', 'tipo_pago', 'precio_total')
                ->get();
            return response()->json($pedidos);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Error al obtener los pedidos del usuario.'], 500);
        }
    }





}
