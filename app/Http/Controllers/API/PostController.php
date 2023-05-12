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
    //Cojer todos los datos
    public function index(){
        $posts = Posts::all()->toArray();
        return $posts;
    }
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

    public function edit($id)
    {
        $post = Posts::find($id);
        return response()->json($post);
    }


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

        public function tiendaall(){
            $productito = Posts::all()->toArray();
            return $productito;
        }
        public function tienda(){
            $posts = Posts::whereIn('id_suscripcion', [1])->get()->toArray();
            return response()->json($posts);

        }

        public function ofertas(){
        $ofertas = Posts::whereIn('id_suscripcion', [2, 3, 4])->get()->toArray();

        // Obtener el usuario autenticado
        $user = auth()->user();

        // Aplicar descuento según el tipo de suscripción
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

    public function suscripciones(){
        $susc = Suscripcion::whereIn('id', [2, 3, 4])->get()->toArray();
        return response()->json($susc);
    }

    public function finalizarPedido(Request $request)
    {
        // Obtener el id del usuario actual
        $idusuario = auth()->id();

        // Obtener la fecha actual
        $fechaPedido = now();


        // Insertar los datos en la tabla 'pedido'
        Pedido::create([
            'id_usuario' => $idusuario,
            'fecha_pedido' => $fechaPedido,
            'tipo_pago' => 'Tarjeta',
            'precio_total' => $request->input('precioTotal'),
        ]);

        // Redireccionar a una página de confirmación o enviar una respuesta JSON
        return response()->json(['success' => true]);
    }

}
