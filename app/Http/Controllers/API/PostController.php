<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Posts;
use Illuminate\Http\Request;

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
        $producto->delete();
        return response()->json(['success' => 'Producto eliminado correctamente']);
    }

    public function editarProducto(Request $request, $id)
    {
        $request->validate([
            'nombre' => 'required',
            'descripcion' => 'required',
            'id_suscripcion' => 'required',
            'precio' => 'required',
            'file' => 'image|mimes:jpeg,png,jpg,gif,svg,webp|max:2048',
        ]);

        $input = $request->all();
        $post = Posts::findOrFail($id);
        $imageName = $post->image;

        if ($request->hasFile('file')) {
            if ($imageName != null) {
                $imagePath = public_path('img/') . $imageName;
                if (file_exists($imagePath)) {
                    unlink($imagePath);
                }
            }
            $image = $request->file('file');
            $imageName = date('YmdHis') . "." . $image->getClientOriginalExtension();
            $destinationPath = public_path('img/');
            $image->move($destinationPath, $imageName);
        }

        $post->update([
            'nombre' => $input['nombre'],
            'descripcion' => $input['descripcion'],
            'id_suscripcion' => $input['id_suscripcion'],
            'precio' => $input['precio'],
            'image' => $imageName,
        ]);

        return response()->json(['success' => 'Producto actualizado correctamente']);
    }
}
