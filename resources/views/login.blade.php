<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">

	<title>Login</title>
	
	<!-- Google font -->
	<link href="http://fonts.googleapis.com/css?family=Playfair+Display:900" rel="stylesheet" type="text/css" />
	<link href="http://fonts.googleapis.com/css?family=Alice:400,700" rel="stylesheet" type="text/css" />

	<!-- Bootstrap -->
	<link type="text/css" rel="stylesheet" href="{{ asset('css/bootstrap.min.css')}}" />

	<!-- Custom stlylesheet -->
	<link rel="stylesheet" href="{{ asset('css/style.css')}}">
	<meta name="csrf-token" content="{{ csrf_token() }}" />

	<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/js-cookie/3.0.1/js.cookie.min.js"></script>

	<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
    
</head>

<body>
	<div id="booking" class="section">
		<div class="section-center">
			<div class="container">
				<div class="row">
					<div class="booking-form" style="width:440px; text-align: center;">
						<form>
							<div>
								<div>
									<img src="{{ asset('img/logo.png')}}" alt="Registro de Requerimientos">
								</div>
								<div class="row"  style="padding-top:30px">
									<div class="row">
										<div class="col-md-6">
											<div class="form-group">
												<input type="text" name="rut" id="rut"  placeholder="Ingese Rut">
												
											</div>
										</div>
									</div>
									<div class="row">
										<div class="col-md-6">
											<div class="form-group">
												<input type="password" name="pass" id="password"  autocomplete="on" placeholder="Ingrese Password">
											</div>
										</div>
									</div>
									<div class="form-btn center" style="display: flex; justify-content: space-between; align-items: center;">
										<!--<button class="submit-btn" id="submit" >Enviar Solicitud</button>-->
										<img id="submit" style="width:250px; height:100px; margin-left: 20%" src="{{ asset('img/login.png')}}" >
									</div>
	
								</div>
							</div>	
						</form>
					</div>
				</div>
			</div>
		</div>
	</div>
    
</body>
<script type="text/javascript">
         
	$(document).ready(function() {
		$("#rut").bind('keypress', function(event) {
			var regex = new RegExp("^[0-9kK]+$");
			var key = String.fromCharCode(!event.charCode ? event.which : event.charCode);
			if (!regex.test(key)) {
				event.preventDefault();
				return false;
			}
		});
		$('#rut').keyup(function(){
			var rt = $('#rut').val().replace('-','');
			var i = rt.length;
			if(i > 1){
				p = rt.substring(0, (i-1)) + '-' + rt.substr(-1);
				$('#rut').val('');
				$('#rut').val(p);
			}
		});
		$(document).on('click','#submit',function(e){
			e.preventDefault();
			var form = {
				rut : $('#rut').val(),
				password : $('#password').val(),
			}
			$.ajaxSetup({
				headers: {
					'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
				}
			});
			$.ajax({
				type:'POST',
				url: "{{ route('post.Login') }}",
				data: JSON.stringify(form),
				success:function(data){
					var respuesta = JSON.parse(data);
					Cookies.set('id', respuesta['user']['id'],{expires: 1});
					Cookies.set('rut', respuesta['user']['rut'],{expires: 1});
					Cookies.set('name', respuesta['user']['name'],{expires: 1});
					Cookies.set('email', respuesta['user']['email'],{expires: 1});
					Cookies.set('id_perfil', respuesta['user']['id_perfil'],{expires: 1});
					Cookies.set('id_inst', respuesta['user']['id_inst'],{expires: 1});
					Cookies.set('accesToken', respuesta['accesToken'],{expires: 1});
					switch(respuesta['user']['id_perfil']){
						case 1:
							console.log('Administrador');
							break;
						case 2:
							window.location.href = "{{ route('get.ejecutor')}}";
							break;
						case 3:
							window.location.href = "{{ route('get.visador')}}";
							break;
						case 4:
							window.location.href = "{{ route('get.creador')}}";
							break;
					}
				}
			});			
		});              
		
	} );

    
</script>

</html>