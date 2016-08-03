@extends('app')


@foreach($posts as $post)
    <div class="row">
        <div class="col-md-8">
            <div class="row">
                <div class="col-md-8">
                    <h4><strong><a href="/posts/{{$post->id}}">Пост #{{$post->id}} by {{$post->user->name}}</a></strong></h4>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6 col-md-offset-2">
                    <p>
                        {{$post->text}}
                    </p>
                    <p>
                        <a class="btn" href="/posts/{{$post->id}}">Открыть пост</a>
                    </p>
                </div>
            </div>

            <div class="row">
                <div class="col-md-8">
                    <p></p>
                    <p>
                        <i class="glyphicon-user glyphicon"></i> by <a href="#">{{$post->user->name}}</a>
                        | <i class="glyphicon-calendar glyphicon"></i> <span class="date">{{$post->created_at}}</span>
                        | <i class="glyphicon-comment glyphicon"></i> <a href="/posts/{{$post->id}}"> {{$post->comments->count()}} Comments</a>
                    </p>
                </div>
            </div>
        </div>

    </div>

@endforeach