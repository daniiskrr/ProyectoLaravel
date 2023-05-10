<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Posts;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;



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
    public function tienda(){
        $posts = Posts::all()->toArray();
        return $posts;
    }

    public function ofertas()
    {
        $ofertas = Posts::whereIn('id_suscripcion', [2, 3, 4])->get()->toArray();
        return $ofertas;
    }

}
