@extends('app')
<input id="postid" type="hidden" data-postid="{{$post->id}}">
<div class="col-lg-8 col-md-offset-2">

    {{--title--}}
    <h1>Пост # {{$post->id}} </h1>
    <p class="lead">
        by <a href="#">{{$post->user->name}}</a>
    </p>

    <hr>
    {{--date--}}
    <p><span class="glyphicon glyphicon-time"></span> {{$post->created_at}}</p>
    
    <hr>

    {{--content--}}
    <p>{{$post->text}}</p>

    <hr>

    <div class="well">
        <h4>Добавить комментарий </h4>
        <form id="form_message" method="post" role="form" action="/posts/{{$post->id}}/comments">
            <div class="form-group">
                <input type="hidden" name="_token" value="{{csrf_token()}}">
                <input id="parent_reply_id" type="hidden" name="parent_id" value="">
                <textarea name="text" class="form-control" rows="3"></textarea>
            </div>
            <input type="submit" class="btn btn-success">
        </form>
    </div>
    <hr>

    <div class="all-comment">
        @foreach($comments as $comment)
            <div class="comment-parent" data-score="{{$comment->score}}">
                @include('comments.show', ['comment' => $comment])
            </div>
        @endforeach
    </div>

</div>

<div class="modal fade" id="edit_comment" tabindex="-1" role="dialog" aria-labelledby="logoutLabel"
     aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">

            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"
                        aria-hidden="true">&times;</button>
                <h4 class="modal-title" id="myModalLabel">Редактировать</h4>
            </div>

            <div class="modal-body">
                <div class="row">
                    <div class="col-md-12">
                        <form id="commentEdit" method="post" role="form" action="/posts/{{$post->id}}/comments/edit">
                            <div class="form-group">
                                <input type="hidden" name="_token" value="{{csrf_token()}}">
                                <input id="parent_reply_id" type="hidden" name="parent_id" value="">
                                <input id="comment_id" type="hidden" name="comment_id" value="">
                                <textarea id="textarea_edit" name="text" class="form-control" rows="3"></textarea>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <div class="modal-footer">
                <button type="submit" form="commentEdit" class="btn btn-success btn-large">Редактировать</button>
                <button type="button" class="btn btn-default" data-dismiss="modal">Отмена</button>
            </div>

        </div>
    </div>
</div>

@section('scripts')
    <script>

        $(document).ready(function (e) {
            var grid = $('.all-comment').isotope({
                itemSelector: '.comment-parent',
                layoutMode: 'fitRows',
                getSortData: {
                    number: '.score parseInt'
                }
            });

            grid.isotope({ sortBy: 'number', sortAscending: false });
        });
        $(function () {
            $.ajaxSetup({
                headers: {'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')}
            });
        });
        $('.reply_link').click(function (e) {
            var input = $('#parent_reply_id');
            var data = $(this).data('replyid');
            input.val(data);
        });

        $('.edit').click(function (e) {
            e.preventDefault();
            var $postId = $('#postid').data('postid');
            var $commentId = $(this).data('commentid');
            $('#comment_id').val($commentId);
            var test = $("p[data-commentId=" + $commentId + "]");
            $('#textarea_edit').html(test.html());
            $('#edit_comment').modal('show');
        });

        $('.arrow_top').click(function (e) {
            e.preventDefault();
            var $postId = $('#postid').data('postid');
            var $commentId = $(this).data('commentid');

            $.ajax({
                url: '/posts/' + $postId + '/comments/' + $commentId + '/up',
                type: 'post',
                data: {
                    comment_id: $commentId
                },
                success: function (resp) {
                    location.reload();
                },
                error: console.log
            })
        });

        $('.arrow_bot').click(function (e) {
            e.preventDefault();
            var $postId = $('#postid').data('postid');
            var $commentId = $(this).data('commentid');

            $.ajax({
                url: '/posts/' + $postId + '/comments/' + $commentId + '/down',
                type: 'post',
                data: {
                    comment_id: $commentId
                },
                success: function (resp) {
                    location.reload();
                },
                error: console.log
            })
        });

        $('.remove_link').click(function (e) {
            e.preventDefault();
            var $postId = $('#postid').data('postid');
            var $commentId = $(this).data('commentid');
            $.ajax({
                url: '/posts/' + $postId + '/comments/' + $commentId,
                type: 'delete',
                data: {
                    comment_id: $commentId
                },
                success: function (resp) {
                    location.reload();
                },
                error: console.log
            });
        });
    </script>
@stop
