<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->

	<title>Validar Solicitud</title>

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


</head>

<body>
	<div id="booking" class="section">
		<div class="section-center">
			<div class="container">
				<div class="row">
					<div class="booking-form">
						<div>
							<div class="row">
								<!--<div class="col-md-6">
									<div class="form-group">
										<span class="form-label">Check Inaaaa</span>
										<input class="form-control" type="date" required>
									</div>
								</div>-->
								
								<div class="row">
									<div class="col-md-6">
										<div class="form-group">
											<span class="form-label">Tipo de Solución</span>
											<select id="selSolucion" class="form-control" disabled>
												
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
											<span class="form-label">Prioridad</span>
											<select id="selPrio" class="form-control">
												<option value="3" >Alta</option>
												<option value="2"  selected="selected">Media</option>
												<option value="1" >Baja</option>
											</select>
											<span class="select-arrow"></span>
										</div>
									</div>
									
									
								</div>

                                
								
								<div id ="dvBotones" class="form-btn center" style="display: flex; justify-content: space-between; align-items: center;">
									<button class="submit-btn" id="enviarSol" style="width:25%;" >Enviar Solicitud</button>
									<button class="submit-btn" id="verImg" style="width:25%;%;" >Ver Imagen</button>
                                    <button class="submit-btn" id="btnRechazo" style="width:25%; background-color: red;" onclick="OpenModal()" >Rechazar Solicitud</button>
								</div>

							</div>
						</div>	
						
					</div>
				</div>
			</div>
		</div>
	</div>
    <div class="overlay" id="overlay">
        <div class="popup">
          	<div id="cerrarModal" class="CloseIcon">&#10006;</div>
          	<div class="row">
            	<div class="col-md-6">
                	<div>
						<span class="form-label">Motivo Rechazo</span>
						<textarea class="TaRechazo" name="rechazo" id="rechazo" cols="1" rows="10"></textarea>
						<button class=".submit-btnPopUp" >Devolver Solicitud</button>
               		</div>
            	</div>
        	</div>
    	</div>
    </div>

	<div class="overlay" id="overlayImg" style="display: none">
        <div class="popup" style="height: 90%; top:10px">
          	<div id="cerrarModalImg" class="CloseIcon">&#10006;</div>
          	
                	<input  style="height: 90%; width:100%" type="image" id="img" src="" alt="">
    
    	</div>
    </div>
	  
</body>
<script type="text/javascript">
            
    $(document).ready(function() {
		$('#name').text(Cookies.get('name'));

        $.ajaxSetup({
                headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        
        /*function OpenModal() {
            alert("HHHH");
            $('#overlay').show();
        }
        function CloseModal() {
            $('#overlay').hide();
        }*/
        $('#btnRechazo').click(function(){
            $('#overlay').fadeIn(900);
        });
        
        $('#cerrarModal').click(function(){
            $('#overlay').fadeOut(900);
        });

		$('#verImg').click(function(){
			//Carga imagen
			var inst = {
				id: Cookies.get('id_sel'),
				token : Cookies.get('accesToken'),
				
			}
			$.ajax({
				type:'POST',
				url: "{{ route('post.imagen') }}",
				data: JSON.stringify(inst),
				success:function(data){
					var img = JSON.parse(data);
					var image = new Image();
					image.src = img[0]['foto'];
					$('#img').attr("src",img[0]['foto']);
					
				}
			});
            $('#overlayImg').fadeIn(900);
        });
        
        $('#cerrarModalImg').click(function(){
            $('#overlayImg').fadeOut(900);
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

        var bscDet = {
			id: Cookies.get('id_sel'),
			token : Cookies.get('accesToken'),
		}
        $.ajax({
			type:'POST',
			url: "{{ route('post.detReq') }}",
			data: JSON.stringify(bscDet),
			success:function(data){
				var inst = JSON.parse(data);
				$('#selSolucion').append("<option>"+inst[0]['descripcion']+"</option>");
                $('#detalle').text(inst[0]['detalle']);
                

                if(inst[0]['id_estado'] > 1){
                    $('#dvBotones').addClass('divDisabled');
                    $('#selPrio').val(inst[0]['prioridad']);
                    $('#selPrio').prop( "disabled", true );
                    $('#detalle').prop( "disabled", true );
                }
			}
		});

		


        $('#enviarSol').click(function(){
            cd = (new Date()).toISOString().split('T')[0];
            var ActDet = {
                id: Cookies.get('id_sel'),
                detalle: $('textarea#detalle').val(),
                prioridad : $('#selPrio').val(),
                updated_at :cd,
                token : Cookies.get('accesToken'),
            }
            $.ajax({
                type:'POST',
                url: "{{ route('post.actReq') }}",
                data: JSON.stringify(ActDet),
                success:function(data){
                    //console.log(data);
                    window.location.href = "{{ route('get.visador')}}";
                }
            });
        });
        
        




        
    } );
</script>

</html>