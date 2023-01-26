<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->

	<title>Crea Solicitud</title>
	
	<!-- Google font -->
	<link href="http://fonts.googleapis.com/css?family=Playfair+Display:900" rel="stylesheet" type="text/css" />
	<link href="http://fonts.googleapis.com/css?family=Alice:400,700" rel="stylesheet" type="text/css" />

	<!-- Bootstrap -->
	<link type="text/css" rel="stylesheet" href="{{ asset('css/bootstrap.min.css')}}" />

	<!-- Custom stlylesheet -->
	<link rel="stylesheet" href="{{ asset('css/style.css')}}">
	<meta name="csrf-token" content="{{ csrf_token() }}" />


    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/js-cookie/3.0.1/js.cookie.min.js"></script>

	<script type="text/javascript" src="https://code.jquery.com/jquery-3.5.1.js"></script>
	<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.3/jquery.validate.min.js"></script>

</head>
<body>
    <div id="booking" class="section">
		<div class="section-center">
			<div class="container">
				<div class="row">
					<div class="booking-form">
						<div class="row">
							<div class="row">
								<div class="col-md-6">
									<div class="form-group">
										<span class="form-label">Tipo de Solución</span>
										<select id="selSolucion" class="form-control">
										<!-- -->	
										</select>
										<span class="select-arrow"></span>
									</div>
								</div>
								<div class="col-md-6">
									<div class="form-group dvMembrete">
										<!--<h4 id="name"></h4>-->
										<label class="nombre" id="name"></label>
										<br>
										<span id="spnInst" class="form-label" style="font-size: 10px;"></span>
									</div>
								</div>
							</div>
							<div class="row">
								<div class="col-md-6">
									<div class="form-group">
										<span class="form-label">Detalle</span>
										<textarea class="form-control" name="detalle" id="detalle" cols="1" rows="10"></textarea>
										
									</div>
								</div>
							</div>
							<div class="row">
								<div class="col-md-6">
									<div class="form-group">
										<input type="file"  style="font-size:15px" onchange="uploadFile(this)"  name="fotro" id="foto">
									  </div>
								</div>
							</div>
							<div class="form-btn center" style="display: flex; justify-content: space-between; align-items: center;">z
								<button id="genSol" class="submit-btn" style="width:30%;margin-left: 15%;" >Generar Solicitud</button>
								<button id="lstSol" class="submit-btn" style="width:30%;margin-right: 15%;">Lista de Solicitudes</button>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</body>
<script type="text/javascript">
	var binaryBlob;
    var reader = new FileReader();        
	$(document).ready(function() {
        $('#name').text(Cookies.get('name'));

		$.ajaxSetup({
				headers: {
				'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
			}
		});
		
		//Carga combo seluciones
		var solu = {
			token : Cookies.get('accesToken'),
			
		}
		$.ajax({
			type:'POST',
			url: "{{ route('post.desc') }}",
			data: JSON.stringify(solu),
			success:function(data){
				var soluciones = JSON.parse(data);
				var result = "";
				for(var i in soluciones){
					result = result + "<option value ='"+soluciones[i]['id']+"''>"+soluciones[i]['descripcion']+"</option>";
				}
				$('#selSolucion').append(result);
			}
		});	

       //Carga Nombre de Institucion id_inst
		var inst = {
			id: Cookies.get('id_inst'),
			token : Cookies.get('accesToken'),
			
		}
		$.ajax({
			type:'POST',
			url: "{{ route('post.inst') }}",
			data: JSON.stringify(inst),
			success:function(data){
				var inst = JSON.parse(data);
				$('#spnInst').text(inst[0]['nombre']);
			}
		});	

		$('#genSol').click(function(){
			
			

			cd = (new Date()).toISOString().split('T')[0];
			var addreq = {
			id_usuario: Cookies.get('id'),
			id_inst: Cookies.get('id_inst'),
			id_desc: $('#selSolucion').val(),
			detalle: $('textarea#detalle').val(),
			foto: reader.result,
			id_estado: 1,
			created_at: cd,
			updated_at: cd,
			token : Cookies.get('accesToken'),
			}
			
			$.ajax({
				type:'POST',
				url: "{{ route('post.addreq') }}",
				data: JSON.stringify(addreq),
				success:function(data){
					alert('Su requerimiento es el N°: ' + data);
					location.reload();
				}
			});
		});
		$('#lstSol').click(function(){
			window.location.href = "{{ route('get.lstReq')}}";
		});
    } );

	/******************for base 64 *****************************/
	function uploadFile(inputElement) {
		var file = inputElement.files[0];
		//var reader = new FileReader();
		reader.onloadend = function() {
			//console.log('Encoded Base 64 File String:', reader.result);
			
			/******************* for Binary ***********************/
			var data=(reader.result).split(',')[1];
			binaryBlob = atob(data);
			//console.log('Encoded Binary File String:', binaryBlob);
		}
		reader.readAsDataURL(file);
	}
</script>
</html>