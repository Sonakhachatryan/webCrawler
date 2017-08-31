@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-default">
                    <div class="panel-heading">{{ $post->id }}</div>

                    <div class="panel-body">
                        {!! Form::model($post, [
                                       'method' => 'post',
                                       'url' => ['/post/update', $post->id],
                                       'class' => 'form-horizontal',
                                       'files' => true
                                   ]) !!}

                        {{--<div class="form-group">--}}
                            {{--<div class="col-sm-offset-3 col-sm-6">--}}
                                {{--<div id="imagePreview" style="width: 120px;--}}
                                        {{--height: 120px;--}}
                                        {{--background-position: center center;--}}
                                        {{--background-size: cover;--}}
                                        {{--background-image: url( {{url('images/caterers/' . $caterer->avatar)}} );--}}
                                        {{---webkit-box-shadow: 0 0 1px 1px rgba(0, 0, 0, .3)"></div>--}}
                            {{--</div>--}}
                        {{--</div>--}}
                        <div class="form-group {{ $errors->has('url') ? 'has-error' : ''}}">
                            {!! Form::label('url', 'Post Url', ['class' => 'col-sm-3 control-label']) !!}
                            <div class="col-sm-6">
                                {!! Form::text('url', null, ['class' => 'form-control', 'required' => 'required']) !!}
                                {!! $errors->first('url', '<p class="help-block">:message</p>') !!}
                            </div>
                        </div>
                        <div class="form-group {{ $errors->has('title') ? 'has-error' : ''}}">
                            {!! Form::label('title', 'Title', ['class' => 'col-sm-3 control-label']) !!}
                            <div class="col-sm-6">
                                {!! Form::textarea('title', null, ['class' => 'form-control', 'required' => 'required']) !!}
                                {!! $errors->first('title', '<p class="help-block">:message</p>') !!}
                            </div>
                        </div>
                        <div class="form-group {{ $errors->has('description') ? 'has-error' : ''}}">
                            {!! Form::label('description', 'Description', ['class' => 'col-sm-3 control-label']) !!}
                            <div class="col-sm-6">
                                {!! Form::textarea('description', null, ['class' => 'form-control', 'required' => 'required']) !!}
                                {!! $errors->first('description', '<p class="help-block">:message</p>') !!}
                            </div>
                        </div>
                        <div class="form-group {{ $errors->has('img_original_url') ? 'has-error' : ''}}">
                            {!! Form::label('img_original_url', 'Original Image Url', ['class' => 'col-sm-3 control-label']) !!}
                            <div class="col-sm-6">
                                {!! Form::text('img_original_url', null, ['class' => 'form-control', 'required' => 'required']) !!}
                                {!! $errors->first('img_original_url', '<p class="help-block">:message</p>') !!}
                            </div>
                        </div>
                        <div class="form-group {{ $errors->has('posted_on') ? 'has-error' : ''}}">
                            {!! Form::label('posted_on', 'Posted On', ['class' => 'col-sm-3 control-label']) !!}
                            <div class="col-sm-6">
                                {!! Form::text('posted_on', null, ['class' => 'form-control', 'required' => 'required']) !!}
                                {!! $errors->first('posted_on', '<p class="help-block">:message</p>') !!}
                            </div>
                        </div>
                        <div class="form-group {{ $errors->has('image') ? 'has-error' : ''}}">
                            {!! Form::label('image', 'Image', ['class' => 'col-sm-3 control-label']) !!}
                            <div class="col-sm-6">
                                <img src="{{ url('uploads/' .  $post->img) }}" class="img-preview">
                                {!! Form::file('image', null, ['class' => 'form-control']) !!}
                                {!! $errors->first('image', '<p class="help-block">:message</p>') !!}
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-sm-offset-3 col-sm-3">
                                <button type="submit" name="edit"  value="ci_edit" class="btn btn-primary form-control">Update</button>
                            </div>
                        </div>

                        {!! Form::close() !!}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('style')
    <style>
        .img-preview{
            max-width: 200px;
            max-height: 200px;
        }
    </style>
@endsection

@section('script')
    <script>
        $('#image').on('change',function () {
            var input = this;
            if (input.files && input.files[0]) {
                var reader = new FileReader();

                reader.onload = function (e) {
                    $('.img-preview').attr('src', e.target.result);
                }

                reader.readAsDataURL(input.files[0]);
            }
        })
    </script>
@endsection