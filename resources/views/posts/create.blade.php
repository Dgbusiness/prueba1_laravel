@extends('layouts.app')

@section('content')
    <div class="card card-default">
        <div class="card-header">
            {{-- En esta vista se controlaran ambos procesos, tanto crear como editar posts.             --}}

            {{ isset($post) ? 'Edit Post' : 'Create Post' }}
        </div>
        <div class="card-body">
            {{-- Si desde el controlador es enviada data, el formulario cambiara su estado a Editar,
            de lo contrario, el estado default es el de crear post --}}

            {!! Form::open(array('route' => isset($post) ? ['posts.update', $post->id] : 'posts.store', "enctype" => "multipart/form-data")) !!}
                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul class="list-group">
                            @foreach ($errors->all() as $error)
                                <li class="list-group-item text-danger">
                                    {{ $error }}
                                </li>
                            @endforeach
                        </ul>
                    </div>              
                @endif
                @csrf
                @if (isset($post))
                    @method('PUT')    
                @endif
                <div class="form-group">
                    {{-- Titulo del post --}}
                    {!! Form::label("title", "Title", []) !!}
                    {!! Form::text("title",isset($post) ? $post->title : "",["id" => "title", "class" => "form-control"]) !!}
                </div>
                <div class="form-group">
                    {{-- Descripcion del post --}}
                    {!! Form::label("description", "Description", []) !!}
                    {!! Form::textarea("description",isset($post) ? $post->description : "",["id" => "description", "class" => "form-control"]) !!}
                </div>
                <div class="form-group">
                    {{-- Contenido del post --}}
                    {!! Form::label("content", "Content", []) !!}
                    {!! Form::textarea("content",isset($post) ? $post->content : "",["id" => "content", "class" => "form-control"]) !!}
                </div>
                <div class="form-group">
                    {{-- Imagen del post --}}
                    {!! Form::label("image", "Image", []) !!}
                    {!! Form::file("image",["id" => "image", "class" => "form-control"]) !!}
                </div>
                <div class="form-group">
                    {!! Form::submit(isset($post) ? "Update Post" : "Add Post", ["class" => "btn btn-success"]) !!}
                </div>
            {!! Form::close() !!}
        </div>
    </div>
@endsection