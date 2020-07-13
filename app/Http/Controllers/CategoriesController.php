<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Category;
use App\Http\Requests\Categories\UpdateCategoryRequest;
use App\Http\Requests\Categories\CreateCategoryRequest;

class CategoriesController extends Controller
{
    // Este controlador esta documentado en ingles ya que sus funciones fueron generadas automaticamente
    // gracias a un comando, lo cual explica el objetivo principal de cada funcion.

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // Esta funcion despliega la vista index y le manda una coleccion de categorias

        return view("categories.index")->with('categories', Category::all());
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view("categories.create");
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CreateCategoryRequest $request)
    {
        //Se crea una nueva instancia de Category a partir del request
        Category::create([
            'name' => $request->name
        ]);

        //Se avisa el usuario de la creacion exitosa
        session()->flash('success', 'Category created successfully');

        //Redirije al index
        return redirect(route('categories.index'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Category $category)
    {
        //Despliega la vista create pero con una categoria para cambiar el estado del formulario
        return view('categories.create')->with('category', $category);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateCategoryRequest $request, Category $category)
    {
        //Actualiza el nombre de la categoría en cuestion
        $category->name = $request->name;

        //Guarda los cambios
        $category->save();

        //Avisa al usuario de la actualización exitosa
        session()->flash('success', 'Category updated successfully');

        //Redirije al index
        return redirect(route('categories.index'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Category $category)
    {
        //Borra la categoría en cuestion
        $category->delete();

        //Avisa al usuario que la categoria ha sido borrada exitosamente
        session()->flash('success', 'Category deleted successfully');

        return redirect(route('categories.index'));

    }
}
