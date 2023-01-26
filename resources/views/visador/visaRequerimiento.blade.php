<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->

	<title>Lista de Solicitudes</title>

	<!-- Google font -->
	<link href="http://fonts.googleapis.com/css?family=Playfair+Display:900" rel="stylesheet" type="text/css" />
	<link href="http://fonts.googleapis.com/css?family=Alice:400,700" rel="stylesheet" type="text/css" />

	<!-- Bootstrap -->
	<link type="text/css" rel="stylesheet" href="{{ asset('css/bootstrap.min.css')}}" />

	<!-- Custom stlylesheet -->
	<link rel="stylesheet" href="{{ asset('css/style.css')}}">
	<meta name="csrf-token" content="{{ csrf_token() }}" />
    <link type="text/css" rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.min.css" />

    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/js-cookie/3.0.1/js.cookie.min.js"></script>
    
    <script type="text/javascript" src="https://code.jquery.com/jquery-3.5.1.js"></script>
    <script type="text/javascript" src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>

</head>
<body>
	<div id="booking" class="section">
		<div class="section-center">
			<div class="container">
				<div class="row">
					<div class="booking-form">
                        <div style="height: 98%;background: rgba(133, 104, 73, 0.33);">
                            <table id="example" class="display" style="width:100%; height:100%; margin-top: 20px; margin-left: 20px;margin-bottom: 20px;">
                                <thead>
                                    <tr>
                                        <th>N°</th>
                                        <th>Institucion</th>
                                        <th>Solicitante</th>
                                        <th>Tarea</th>
                                        <th>Fecha</th>
                                        <th>Estado</th>
                                    </tr>
                                </thead>
                                <tbody></tbody>
                                <tfoot>
                                    <tr>
                                        <th>N°</th>
                                        <th>Institucion</th>
                                        <th>Solicitante</th>
                                        <th>Tarea</th>
                                        <th>Fecha</th>
                                        <th>Prioridad</th>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>				
				</div>
			</div>
		</div>
	</div>
</body>
<script type="text/javascript">
	$(document).ready(function() {
        $('#example').DataTable({
            "dom": 'rtip',
            "paging":   true,
            "ordering": true,
            "info":     true,
        });
        $.ajaxSetup({
				headers: {
				'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
			}
		});
		//Carga combo seluciones
		var lstReq = {
            perfil: Cookies.get('id_perfil'),
            id_usuario: Cookies.get('id'),
            id_inst: Cookies.get('id_inst'),
			token : Cookies.get('accesToken'),
		}
        
		$.ajax({
			type:'POST',
			url: "{{ route('post.lstReq') }}",
			data: JSON.stringify(lstReq),
			success:function(data){
                var datos = JSON.parse(data);
                
                var t = $('#example').DataTable();
                for(var i in datos){
					t.row.add( [
                        datos[i]['id'],
                        datos[i]['nombre'],
                        datos[i]['name'],
                        datos[i]['descripcion'],
                        formatFecha(datos[i]['created_at']),
                        datos[i]['estado']
                    ] ).draw( false );
				}
                
			}
		});	
        $(document).on('click','#example tbody tr', function(){
            var id = $(this).find("td:first").html();
            var url = "{{ route('get.detalleReq',':id')}}";
            Cookies.set('id_sel', id,{expires: 1});
            url = url.replace(':id', id);
            window.location.href = url;
        });
    } );
    function formatFecha(fecha){
        var fechaFull = fecha.split(" ");
        var fechaRet = fechaFull[0].split("-");
        return fechaRet[2]+'-'+fechaRet[1]+'-'+fechaRet[0];

    }
</script>

</html>