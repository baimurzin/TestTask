<div class="media comment-item ">
    <div class="pull-left">
        <a class="arrow_top" href="#" data-commentId="{{$comment->id}}">
            @if(is_null($comment->voted))
                <i class="glyphicon glyphicon-arrow-up"></i>
            @else
                @if($comment->voted)
                    <i class="glyphicon glyphicon-arrow-up voted"></i>
                @else
                    <i class="glyphicon glyphicon-arrow-up"></i>
                @endif
            @endif
        </a>
        <a class="arrow_bot" href="#" data-commentId="{{$comment->id}}">
            @if(is_null($comment->voted))
                <i class="glyphicon glyphicon-arrow-down"></i>
            @else
                @if(!$comment->voted)
                    <i class="glyphicon glyphicon-arrow-down voted"></i>
                @else
                    <i class="glyphicon glyphicon-arrow-down"></i>
                @endif
            @endif
        </a>
    </div>
    <div class="media-body">
        <h4 class="media-heading">{{$comment->author->name}}
            <small class="date">{{$comment->created_at}}</small>
            |
            <small>
                <a class="text-muted reply_link" data-replyId="{{$comment->id}}" href="#form_message">Ответить</a>
            </small>
            |
            <small><a class="text-muted edit" data-commentId="{{$comment->id}}" href="">Редактировать</a></small>
            |
            <small><a class="text-muted remove_link" data-commentId="{{$comment->id}}" href="#">Удалить</a></small>
            |
            <small> Rating: <span class="score">{{$comment->score}}</span> </small>
        </h4>
        <p data-commentId="{{$comment->id}}" class="comment_text">{{$comment->text}}</p>
    </div>
</div>
<hr>

@if ($comment->children->count() > 0)
    @foreach ($comment->children as $comment)
        <div style="margin-left: 30px">
            @include('comments.show', ['comment' => $comment])
        </div>
    @endforeach
@endif