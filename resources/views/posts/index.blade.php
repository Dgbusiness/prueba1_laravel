@extends('layouts.app')

@section('content')

    <div class="dflex justify-content-end mb-2">
        <a href="{{ route("posts.create") }}" class="btn btn-success">Add Post</a>
    </div>

    <div class="card card-default">
        {{-- En esta vista se recibe una coleccion de post para ser listados, de no haber, se muestra el mensaje
        "No posts yet" --}}
        
        <div class="card-header">Posts</div>
        <div class="card-body">
            @if ($posts->count() > 0)
                <table class="table">
                    <thead>
                        <th>Image</th>
                        <th>Title</th>
                        <th>Options</th>
                    </thead>
                    <tbody>
                        @foreach ($posts as $post)
                            <tr>
                                <td>
                                    <img src="{{ asset("/storage/".$post->image) }}" width="150px" height="100px" alt="">
                                </td>
                                <td>
                                    {{ $post->title }}
                                </td>
                                <td>
                                    @if (!$post->trashed())
                                        <a href="{{ route('posts.edit', $post->id) }}" class="btn btn-info btn-sm">Edit</a>                                    
                                    @endif


                                    {!! Form::open(array("route" => ["posts.destroy", $post->id])) !!}
                                        @csrf
                                        @method("Delete")
                                        {!! Form::submit($post->trashed() ? "Delete" : "Trash", ["class" => "btn btn-danger btn-sm"]) !!}
                                    {!! Form::close() !!}
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>                
            @else
                <h3 class="text-center">No posts yet</h3>
            @endif

            {{-- {!! Form::open(array('id' => 'deleteCategoryForm')) !!}
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
            {!! Form::close() !!} --}}
        </div>
    </div>
@endsection