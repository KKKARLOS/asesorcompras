<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Documento sin título</title>
<link href="../../css/jquery-ui.css" rel="stylesheet">
<script src="../../js/jquery.js"></script>
<script src="../../js/jquery-ui.js"></script>
<title>Documento sin título</title>
<style type="text/css">
	.oculta{display: none;}

	.ui-dialog .ui-dialog-buttonpane .ui-dialog-buttonset {text-align: center; 
		float: none !important; 
	}

	table {border: 1px solid #ddd;border-collapse: collapse;margin-left: 15px;}

	td{border: 1px solid #ddd;text-align:left;padding-left:4px  }

	#tblCabecera th {
	  padding-top: 12px;
	  padding-bottom: 12px;
	  text-align: left;
	  background-color: #6ea7d2;
	  color: white;
	  border: 1px solid #ddd;
	  height: 25px;
	}		

	#tblDatos tr:nth-child(odd){background-color:#ffffff;}
	#tblDatos tr:nth-child(even){background-color:#f2f2f2;}
	#tblDatos tr:hover {
		background-color:  #ddd; //mostrar el fondo gris del li activo
	}
    .messages{
        float: left;
        font-family: sans-serif;
        display: none;
    }
    .info{
        padding: 10px;
        border-radius: 10px;
        background: orange;
        color: #fff;
        font-size: 12px;
        text-align: center;
    }
    .before{
        padding: 10px;
        border-radius: 10px;
        background: blue;
        color: #fff;
        font-size: 12px;
        text-align: center;
    }
    .success{
        padding: 10px;
        border-radius: 10px;
        background: green;
        color: #fff;
        font-size: 12px;
        text-align: center;
    }
    .error{
        padding: 10px;
        border-radius: 10px;
        background: red;
        color: #fff;
        font-size: 12px;
        text-align: center;
    }			
</style>
</head>
<body>

<!--Ventana Alta de Sitios Web-->

<div id="AltaModiDialog" class="oculta" title="Alta de sitios web">
	<br/>
	<form>
  	  	</br> 	
	    <label for="name">Nombre</label></br>
	    <input type="text" id="txtNombre" style="width:330px" value="" autocomplete="off" class="text ui-widget-content ui-corner-all"></br></br>
      	<label for="name">URL</label></br>
      	<input type="text" id="txtURL" style="width:330px" value="" autocomplete="off" class="text ui-widget-content ui-corner-all"></br></br>
  	</form>  
</div>

<!--Ventana de Mensajes-->

<div id="ErrorDialog" class="oculta" title="Error">
	<br/><br/>
	<div id="divError">	
	</div>
</div>
<div id="CatologoDialog" class="oculta" title="Listado de sitios web">
	<div style="text-align: center; margin-top:0px;"> 
		<input style="width:200px;height: 30px; margin:20px;background:url(../../iconos/anadir.png) no-repeat; background-position: 6px 4px;text-align: right; background-color: #d7e9f6" class="ui-button ui-corner-all ui-widget" type="button" name="btnAlta" id="btnAlta" value="Alta Sitio Web" />
	</div>
	<table id="tblCabecera" width="620px">
		<tr>
		<th width="225p	x">Nombre</th>
		<th width="296px" style='text-align:center'>URL</th>
		<th width="101px" style='text-align:center'>Acciones</th>
		</tr>
	</table>
	<div id="divDatos" style="width:652px;height:380px;overflow-y:auto;">
		<table id="tblDatos" width="620px">
			<tbody id="tbodyTab">			
			</tbody>		
		</table>
	</div>
</div>
<div id="mensaje"></div>
<!--
-->
<script>
	var idsitioweb=0;
	var ventanaDialog="";
	var modo="";
	var email = "<?php echo $_GET["email"];?>";

	$(function(){

		// Inicializar ventana de Catálogo de sitios web

		dialog = $("#CatologoDialog" ).dialog({
		  autoOpen: false,
		  show: {
        		effect: "slideDown",
        		duration: 700
      	  },		  
		  height: 650,
		  width: 690,
		  modal: true,
		  buttons:[
		  {
		  	id: "btnSalir",
		  	text: "Salir",
			click: function() {
			location.href="../intranet/intranet_view.php?email="+email;
			  $("#CatologoDialog" ).dialog( "close" );
			}
		  }],
		  close: function() {
			location.href="../intranet/intranet_view.php?email="+email;
		  }
		});	
		// Inicializar ventana de alta de sitios web

		dialog = $("#AltaModiDialog" ).dialog({
		  autoOpen: false,
		  show: {
        		effect: "slideDown",
        		duration: 700
      	  },		  
		  height: 400,
		  width: 620,
		  modal: true,
		  buttons:[
		  {
		  	id: "btnGrabar",
		  	text: "Grabar",
			click: function() {
				// Validación de datos
				ventanaDialog="altaModif";	
				if ($("#txtNombre").val()=="")
				{
					$("#divError").text("Debes indicar el nombre.");
					$("#ErrorDialog" ).dialog("open");
					return;	
				}

				if ($("#txtURL").val()=="")
				{
					$("#divError").text("Debes indicar la URL.");
					$("#ErrorDialog" ).dialog("open");
					return;	
				}

				parameters={
					funcion: modo,//insertar,actualizar
					idsitioweb: idsitioweb,
					nombre:  $("#txtNombre").val(),
					url:  $("#txtURL").val()
				};
								
				$.ajax({
					type: "POST",
					url: "../../servicios/sw_sitioweb.php",
					data: parameters,
					success: function(data){
						sitioweb = JSON.parse(data);
						idsitioweb=sitioweb.idsitioweb;
						SalidaAltaModif();
					},			
					error: function(xhr, status, error) {
						responseText = JSON.parse(xhr.responseText);
						$("#divError").text(responseText.error);
			    		$("#ErrorDialog" ).dialog("open");
					}
				});			  
			}
		  },
		  {
		  	id: "btnSalir",
		  	text: "Salir",
			click: function() {
				SalidaAltaModif();
			}
		  }],
		  close: function() {
		  	SalidaAltaModif();
		  }
		});	

		dialog = $( "#ErrorDialog" ).dialog({
		  dialogClass: 'no-close',
		  autoOpen: false,
		  show: {
        		effect: "slideDown",
        		duration: 700
      	  },
		  height: 240,
		  width: 350,
		  modal: true,
		  buttons: {
			Continuar: function() {
			  $("#ErrorDialog" ).dialog("close");
			  if (ventanaDialog=="altaModif")
			  	$("#AltaModiDialog").dialog("open");
			}
		  },
		  close: function() {
			return false;
			//form[ 0 ].reset();
			//allFields.removeClass( "ui-state-error" );
		  }
		});			
	
		$("div").removeClass("oculta");							
		$("#CatologoDialog" ).dialog("open");

		$("#btnAlta").on("click",function(){
			$("#AltaModiDialog").dialog('option', 'title', 'Alta de sitios web');
			modo="insertar";
			$("#AltaModiDialog").dialog("open");
		});

		$("#btnRegresar").on("click",function(){
			location.href="../intranet/intranet_view.php?email="+email;
		});
   
		pintarSitiosWeb();
	});

	function SalidaAltaModif(){
	  $("#txtNombre").val("");
	  $("#txtURL").val("");
	  $("#AltaModiDialog" ).dialog( "close" );
	  pintarSitiosWeb();
	  $("#CatologoDialog" ).dialog("open");		
	}
	function pintarSitiosWeb(){

		parameters={
				funcion: "catalogo"
		};
		$.ajax({
			type: 'POST',
			url: "../../servicios/sw_sitioweb.php",
			data: parameters,
			success: function(data){
				sitioswebs = JSON.parse(data);
				$("#tbodyTab").html("");
			
				$.each(sitioswebs, function( key, value ) {
					var fila="";
					fila+="<tr id='"+value.idsitioweb+"'>";
					fila+="	<td width='226px' valign='center'>"+value.nombre+"</td>";	
					fila+="	<td width='295px' valign='center'>"+value.url+"</td>";				
					fila+="	<td width='101px' style='text-align:center'><img style='cursor:pointer' onclick='confirmarEliminar("+value.idsitioweb+")' src='../../iconos/delete.png' width='20px' title='Borrar'/><img style='cursor:pointer;margin-left:20px' onclick='editar	("+value.idsitioweb+")' src='../../iconos/edit.png' width='20px' title='Editar'/>					</td>";
					fila+="</tr>"; 
					$("#tblDatos").append(fila);
				});	
			},			
			error: function(xhr, status, error) {
				responseText = JSON.parse(xhr.responseText);
				$("#divError").text(responseText.error);
	    		$("#ErrorDialog" ).dialog("open");
			}
		});
	}

	function confirmarEliminar(idsitioweb){
		valor=confirm("Seguro que deseas eliminar el registro?");
		if (!valor) return false;

		parameters={
			funcion: "eliminar",
			idsitioweb: idsitioweb
		};
		$.ajax({
			type: 'POST',
			url: "../../servicios/sw_sitioweb.php",
			data: parameters,
			success: function(data){
				pintarSitiosWeb();
			},			
			error: function (xhr, status, error) {
				responseText = JSON.parse(xhr.responseText);
				$("#divError").text(responseText.error);
	    		$("#ErrorDialog" ).dialog("open");
			}
		});
	}
	function editar(identificador){
		$("#AltaModiDialog").dialog('option', 'title', 'Modificacion de sitios web');
		idsitioweb = identificador;
		parameters={
			funcion: "obtenerDatos",
			idsitioweb: idsitioweb
		};
		$.ajax({
			type: 'POST',
			url: "../../servicios/sw_sitioweb.php",
			data: parameters,
			success: function(data){
				sitioweb = JSON.parse(data);
				$("#txtNombre").val(sitioweb.nombre);
				$("#txtURL").val(sitioweb.url);
			},			
			error: function (xhr, status, error) {
				responseText = JSON.parse(xhr.responseText);
				$("#divError").text(responseText.error);
	    		$("#ErrorDialog" ).dialog("open");
			}
		});
		modo="actualizar";
		$("#AltaModiDialog").dialog("open");
	}	
</script>
</body>
</html>
