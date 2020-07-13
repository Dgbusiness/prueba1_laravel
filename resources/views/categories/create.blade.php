@extends('layouts.app')

@section('content')

    <div class="card card-default">
        <div class="card-header">
            {{ isset($category) ? 'Edit Category' : 'Create Category' }}
        </div>
        <div class="card-body">
            {!! Form::open(array('route' => isset($category) ? ['categories.update', $category->id] : 'categories.store')) !!}
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
                @if (isset($category))
                    @method('PUT')    
                @endif
                <div class="form-group">
                    {!! Form::label("name", "Name", []) !!}
                    {!! Form::text("name",isset($category) ? $category->name : "",["id" => "name", "class" => "form-control"]) !!}
                </div>
                <div class="form-group">
                    {!! Form::submit(isset($category) ? "Update Category" : "Add Category", ["class" => "btn btn-success"]) !!}
                </div>
            {!! Form::close() !!}
        </div>
    </div>    
@endsection