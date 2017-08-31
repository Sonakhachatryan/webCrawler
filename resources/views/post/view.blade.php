@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-default">
                    <div class="panel-heading">{{ $post->url }}</div>

                    <div class="panel-body">
                        @if (Session::has('success'))
                            <div class="error_message alert alert-success alert-dismissible" role="alert">
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                <p>{{ Session::get('success') }}</p>
                            </div>
                        @endif
                        <h1>
                            {{ $post->title }}
                            <a href="{{ url('/post/edit/' . $post->id ) }}"
                               class="btn btn-primary btn-xs" title="Edit Post"><span
                                        class="glyphicon glyphicon-pencil" aria-hidden="true"/></a>
                            <button  type="button" data-post = "{{ $post->id  }}"
                               class="btn btn-danger btn-xs remove" title="Delete Post"><span
                                        class="glyphicon glyphicon-trash" aria-hidden="true"/></button>
                        </h1>
                        <p> {{ $post->description }}</p>
                        <small>Posted on  : {{ date('j M, Y, H:i',strtotime($post->posted_on)) }}</small>
                        <div class="row">
                            <div class="col-md-6"><img class = "img-preview" src="{{ $post->img_original_url }}"></div>
                            <div class="col-md-6"><img class = "img-preview" src="{{ url('uploads/' .  $post->img) }}"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @include('post._modal')
@endsection
@section('script')
    <script>
        $('.remove').on('click',function () {
            var id= $(this).data('post');
            var url = "{{ url('post/delete/') }}" +'/' + id;
            $('#delete').attr('href',url);
            $('#open-modal').click();
        })
    </script>
@endsection

@section('style')
    <style>
        .img-preview{
            max-width: 200px;
            max-height: 200px;
        }
    </style>
@endsection