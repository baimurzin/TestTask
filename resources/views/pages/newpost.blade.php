@extends('app')

<div class="row">
    <div class="col-md-offset-2 col-md-8">
        <div class="box-body pad">
            <form method="post" action="/posts">
                <input type="hidden" name="_token" value="{{csrf_token()}}">
                        <textarea name="text" class="textarea" placeholder="Текст поста"
                                  style="width: 100%; height: 200px; font-size: 14px; line-height: 18px; border: 1px solid #dddddd; padding: 10px;"></textarea>
                <input type="submit" class="btn btn-success">
            </form>
        </div>
    </div>
</div>


@section('scripts')
    <script>

    </script>
@stop