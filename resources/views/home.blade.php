@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-default">
                    <div class="panel-heading" style="height: 50px;">Posts <a href="{{ url('scrap') }}" class="pull-right btn btn-info">Scan</a></div>

                    <div class="panel-body">
                        @if (Session::has('success'))
                            <div class="error_message alert alert-success alert-dismissible" role="alert">
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                <p>{{ Session::get('success') }}</p>
                            </div>
                        @endif
                        @if($posts->total())
                            <table class="table table-striped table-bordered">
                                <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Title</th>
                                    <th>Description</th>
                                    <th style="min-width: 100px">Posted On</th>
                                    <th style="min-width: 100px">Actions</th>
                                </tr>
                                </thead>
                                <tbody>
                                <?php $x = 1; ?>
                                @foreach($posts as $post)
                                    <tr>
                                        <th scope="row">{{ ($posts->currentPage() - 1)*$posts->perPage() +$x}}
                                        <td>{{$post->title}}</td>
                                        <td>{{$post->description}}</td>
                                        <td style="min-width: 100px">{!!  date('H:i',strtotime($post->posted_on)). '<br>'. date('j M, Y',strtotime($post->posted_on)) !!} </td>
                                        <td style="min-width: 100px">
                                            <a href="{{ url('/post/view/' . $post->id) }}"
                                                                       class="btn btn-success btn-xs" title="View Post"><span
                                                        class="glyphicon glyphicon-eye-open" aria-hidden="true"/></a>
                                            <a href="{{ url('/post/edit/' . $post->id) }}"
                                               class="btn btn-primary btn-xs" title="Edit Post"><span
                                                        class="glyphicon glyphicon-pencil" aria-hidden="true"/></a>
                                            <button type="button" data-post = "{{ $post->id  }}"
                                                     class="btn btn-danger btn-xs remove" title="Delete Post"><span
                                                        class="glyphicon glyphicon-trash" aria-hidden="true"/></button></td>
                                    </tr>
                                    <?php $x++; ?>
                                @endforeach
                                </tbody>
                            </table>

                            <div> {!! $posts->render() !!} </div>
                        @else
                            <div class="alert alert-info" role="alert">
                                No posts found.
                            </div>
                        @endif


                    </div>
                </div>
            </div>
        </div>
    </div>
    @include('post._modal')
    <div class="se-pre-con hidden"></div>
@endsection

@section('script')
    <script>
        $('.remove').on('click',function () {
            var id= $(this).data('post');
            var url = "{{ url('post/delete/') }}" +'/' + id;
            $('#delete').attr('href',url);
            $('#open-modal').click();
        });

        $('.btn-info').on('click',function () {
            $(".se-pre-con").toggleClass('hidden');
        });
    </script>
@endsection

@section('style')
    <style>
        .se-pre-con {
            position: fixed;
            left: 0px;
            top: 0px;
            width: 100%;
            height: 100%;
            z-index: 9999;
            opacity: 0.5;
            background: url({{ url('images/Preloader.gif') }}) center no-repeat #fff;
        }
    </style>
@endsection