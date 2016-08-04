@extends('app')

@section('content')
    <div class="container-fluid">
        <div class="row">

            <div class="col-md-4 col-md-offset-4" style="margin-top: 200px;">
                <div class="panel panel-default">

                    <div class="panel-body">
                        @if (count($errors) > 0)
                            <div class="alert alert-danger">
                                <center><strong>Ошибка!</strong></center><br>
                                <ul>
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif
                        <br>
                        <strong><center><font size="4" color="#003b59">ВХОД В ЛИЧНЫЙ КАБИНЕТ</font></center></strong>
                        <br>
                        <form class="form-horizontal" role="form" method="POST" action="{{ url('/auth/login') }}">
                            <input type="hidden" name="_token" value="{{ csrf_token() }}">

                            <div class="form-group">

                                <div class="col-md-12">
                                    <input style="background-color:#f0f0f0; border-radius:0px; text-align: center;" placeholder="Логин" type="email" class="form-control" name="email" value="{{ old('email') }}">
                                </div>
                            </div>

                            <div class="form-group">

                                <div class="col-md-12">
                                    <input style="background-color:#f0f0f0; border-radius:0px; text-align: center;" placeholder="Пароль" type="password" class="form-control" name="password">
                                </div>
                            </div>

                            <div class="form-group">
                                <div class="col-xs-12">

                                    <a class="btn btn-link" style="padding-left: 0px;" href="{{ url('/password/email') }}">Забыли пароль?</a>
                                    <a class="btn btn-link" style="padding-left: 0px;" href="{{ url('/auth/register') }}">Нет аккаунта?</a>

                                    <button style="position:absolute;right:0;margin-right: 15px;padding-top: 3px;padding-bottom: 1px;padding-left: 3px;padding-right: 3px; border-radius:0px;" type="submit" class="btn btn-primary">ВОЙТИ</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
