<?php

namespace App\Http\Controllers;

use App\Http\Requests\Posts\CreatePostRequest;
use App\Http\Requests\Posts\UpdatePostRequest;
use App\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;


class PostsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //Despliega la vista index con una coleccion de todos los post que no esten en trash
        return view("posts.index")->with("posts", Post::all());
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //Despliega la vista para crear posts
        return view("posts.create");
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CreatePostRequest $request)
    {
        //Crea una variable image donde almacena la ruta de la imagen almacenada
        $image = $request->image->store('posts');

        //Crea y almacena el nuevo Post
        Post::create([
            'title' => $request->title,
            'description' => $request->description,
            'content' => $request->content,
            'image' => $image,
        ]);

        //Avisa al usuario de que el post ha sido creado exitosamente
        session()->flash('success', 'Post created successfully');

        return redirect(route('posts.index'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show()
    {
        //
    }
    
    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Post $post)
    {
        //Despliega la vista create pero con un post, para cambiar el estado del formulario a edit
        return view("posts.create")->with("post", $post);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdatePostRequest $request, Post $post)
    {
        //se crea un arreglo con la data necesaria
        $data = $request->only(['title', 'description', 'published_at', 'content']);

        //De haber una nueva imagen, se borra la almacenada y se guarda la nueva
        if ($request->hasFile('image')) {
            $image = $request->image->store('posts');

            Storage::delete($post->image);

            $data['image'] = $image;

        }

        //Se actualiza la data
        $post->update($data);

        //Avisa al usuario de que el post fue actualizado exitosamente
        session()->flash('success', 'Post updated successfully');

        return redirect(route('posts.index'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //Esta funcion tiene dos niveles. El primer nivel verifica si el post esta Trasheado o en papelera.
        $post=Post::withTrashed()->where("id", $id)->firstOrFail();

        if ($post->trashed()) {
            //De estarlo lo Borra finalmente de la BD
            Storage::delete($post->image);
            $post->forceDelete();

        } else {
            // Sino, lo pone en el estado trashed
            $post->delete();

        }
        
        //Avisa al usuario de que el post ha sido borrado exitosamente
        session()->flash('success', 'Post deleted successfully');

        return redirect(route('posts.index'));
    }

    /**
     *  Display a listing of the trashed resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function trashed()
    {
        //Esta funcion crea y retorna una coleccion de todos los post, incluso los eliminados (trashed) 
        $trashed = Post::withTrashed()->get();

        return view("posts.index")->withPosts($trashed);
    }
}
