@extends('app')

@section('content')


<div class="container-fluid">
	<div class="row">
		<div class="col-md-4 col-md-offset-4" style="margin-top: 200px;"> 
		<img style="position:relatative;top:0;padding-right: 14px;top -83px;bottom: 185px;" src="/asa11a/logo.png">
			<div class="panel panel-default">
				
				<div class="panel-body">
					@if (session('status'))
						<div class="alert alert-success">
							{{ session('status') }}
						</div>
					@endif

					@if (count($errors) > 0)
						<div class="alert alert-danger">
							<strong>Ошибка!<br><br>
							<ul>
								@foreach ($errors->all() as $error)
									<li>{{ $error }}</li>
								@endforeach
							</ul>
						</div>
					@endif

					<br>
<strong><center><font size="4" color="#003b59">ВОСТАНОВЛЕНИЕ ПАРОЛЯ</font></center></strong>
<br>
					
					<form class="form-horizontal" role="form" method="POST" action="{{ url('/password/email') }}">
						<input type="hidden" name="_token" value="{{ csrf_token() }}">

						<div class="form-group">
						
							
							<div class="col-xs-12">
							<input style="background-color:#f0f0f0; border-radius:0px; text-align: center;" placeholder="Email" type="email" class="form-control" name="email" value="{{ old('email') }}">
							</div>
						</div>

						<div class="form-group">
							<div class="col-md-12 ">
								<button style="position:absolute;right:0;margin-right: 15px;padding-top: 3px;padding-bottom: 1px;padding-left: 3px;padding-right: 3px; border-radius:0px;" type="submit" class="btn btn-primary">
									Отправить заявку
								</button>
							</div>
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>
</div>
@endsection
