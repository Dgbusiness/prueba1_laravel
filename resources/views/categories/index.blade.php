@extends('layouts.app')

@section('content')

    <div class="dflex justify-content-end mb-2">
        <a href="{{ route("categories.create") }}" class="btn btn-success">Add Category</a>
    </div>

    <div class="card card-default">
        {{-- En esta vista se recibe una coleccion de categories para ser listados, de no haber, se muestra el mensaje
        "No categories yet" --}}

        <div class="card-header">Categories</div>
        <div class="card-body">

            @if ($categories->count() > 0)
                <table class="table">
                    <thead>
                        <th>Name</th>
                    </thead>
                    <tbody>
                        @foreach ($categories as $category)
                            <tr>
                                <td>
                                    {{ $category->name }}
                                </td>
                                <td>
                                    <a href="{{ route('categories.edit', $category->id) }}" class="btn btn-info btn-sm">Edit</a>
                                    <a href="#" class="btn btn-danger btn-sm" onclick="handleDelete({{ $category->id }})">Delete</a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>                
            @else
                <h3 class="text-center">No categories yet</h3>                
            @endif


            {!! Form::open(array('id' => 'deleteCategoryForm')) !!}
                @method('Delete')
                @csrf
                <div class="modal fade" id="deleteModal" tabindex="-1" role="dialog" aria-labelledby="deleteModalLabel" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="deleteModalLabel">Modal title</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <p class="text-center text-bold">
                                Are you sure you want to delete this category?
                            </p>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-primary" data-dismiss="modal">No, go back</button>
                            <button type="submit" class="btn btn-danger">Yes, delete</button>
                        </div>
                        </div>
                    </div>
                </div>
            {!! Form::close() !!}
        </div>
    </div>    
@endsection

@section('scripts')
    <script>
        function handleDelete(id) {

            var form = document.getElementById("deleteCategoryForm");

            form.action = '/categories/' + id;
            
            $('#deleteModal').modal('show');
        }
    </script>
    
@endsection