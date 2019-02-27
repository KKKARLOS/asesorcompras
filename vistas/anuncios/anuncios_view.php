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

	#tblCabecera, #tblDatos {border: 1px solid #ddd;border-collapse: collapse;margin-left: 15px;}

	#tblDatos td{border: 1px solid #ddd;text-align:left;padding-left:4px  }

	#tblCabecera th {
	  padding-top: 12px;
	  padding-bottom: 12px;
	  padding-left:4px;
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

<!--Ventana Alta de Anuncios-->

<div id="AltaModiDialog" class="oculta" title="Alta de anuncios">
<table width="700px" style="margin-top:5px" border="0px" align="center" cellpadding="5px">
	<tr>
		<td width="400px">
		    <label for="txtNombre">Nombre</label></br>
		    <input type="text" id="txtNombre" style="width:400px" value="" autocomplete="off" class="text ui-widget-content ui-corner-all">
		</td>

		<td rowspan="8" valign="top">
		    <div class="showImage" style="width:280px;text-align:center;vertical-align: top;">
		    </div>			
		</td>			

	</tr>
	<tr>
		<td>
	      	<label for="txtFoto">Foto</label></br>
	      	<input type="text" id="txtFoto" style="width:400px" value="" autocomplete="off" class="text ui-widget-content ui-corner-all">	
		</td>
	</tr>
	<tr>
		<td>
			<label for="cboCategorias">Categoría</label></br>
	        <select id="cboCategorias">
  			<option value="0">Elije una categoría</option>
  			</select>				
		</td>
	</tr>	
	<tr>
		<td>
			<label for="cboSitiosWeb">Sitio Web</label></br>
	        <select id="cboSitiosWeb" name="cboSitiosWeb">
  			<option value="0">Elije un sitio web</option>
  			</select>				
		</td>
	</tr>
	<tr>
		<td>
	      	<label for="txtUrlPortalVenta">Url Anuncio</label></br>
	      	<input type="text" id="txtUrlPortalVenta" style="width:400px" value="" autocomplete="off" class="text ui-widget-content ui-corner-all">	
		</td>
	</tr>
	<tr>
		<td>
	      <label for="name">txtPrecioVenta</label></br>
	      <input type="number" id="txtPrecioVenta" value="" class="text ui-widget-content ui-corner-all"/>
		</td>
	</tr>	
	<tr>
		<td>
	      <label for="name">txtPrecioCorrecto</label></br>
	      <input type="number" id="txtPrecioCorrecto" value="" class="text ui-widget-content ui-corner-all"/>
		</td>
	</tr>
	<tr>
		<td>
	      <label for="name">txtPrecioChollo</label></br>
	      <input type="number" id="txtPrecioChollo" value="" class="text ui-widget-content ui-corner-all"/>
		</td>
	</tr>		
 </table>

</div>

<!--Ventana de Mensajes-->

<div id="ErrorDialog" class="oculta" title="Error">
	<br/><br/>
	<div id="divError">	
	</div>
</div>
<div id="CatologoDialog" class="oculta" title="Listado de anuncios">
	<div style="text-align: center; margin-top:0px;"> 
		<input style="width:170px;height: 30px; margin:20px;background:url(../../iconos/anadir.png) no-repeat; background-position: 6px 4px;text-align: right; background-color: #d7e9f6" class="ui-button ui-corner-all ui-widget" type="button" name="btnAlta" id="btnAlta" value="Alta Anuncio" />
	</div>
	<table id="tblCabecera" width="620px">
		<tr>
		<th width="223px">Nombre</th>
		<th width="296px" style='text-align:center'>URL</th>
		<th width="104px" style='text-align:center'>Acciones</th>
		</tr>
	</table>
	<div id="divDatos" style="width:652px;height:380px;overflow-y:auto;">
		<table id="tblDatos" width="620px">
			<tbody>			
			</tbody>		
		</table>
	</div>
</div>
<div id="mensaje"></div>
<!--
-->
<script>
	var idanuncio=0;
	var ventanaDialog="";
	var modo="";
	var email = "<?php echo $_GET["email"];?>";

	$(function(){

		// Inicializar ventana de Catálogo de anuncios

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
		// Inicializar ventana de alta de anuncios

		dialog = $("#AltaModiDialog" ).dialog({
		  autoOpen: false,
		  show: {
        		effect: "slideDown",
        		duration: 700
      	  },		  
		  height: 650,
		  width: 800,
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

				if ($("#txtFoto").val()=="")
				{
					$("#divError").text("Debes indicar la foto.");
					$("#ErrorDialog" ).dialog("open");
					return;	
				}
				if ($("#cboCategorias").val()=="0")
				{
					$("#divError").text("Debes indicar una categoría.");
					$("#ErrorDialog" ).dialog("open");
					return;	
				}
				if ($("#cboSitiosWeb").val()=="0")
				{
					$("#divError").text("Debes indicar un sitio web.");
					$("#ErrorDialog" ).dialog("open");
					return;	
				}
				if ($("#txtUrlPortalVenta").val()=="")
				{
					$("#divError").text("Debes indicar la URL del anuncio.");
					$("#ErrorDialog" ).dialog("open");
					return;	
				}				
				if ($("#txtPrecioVenta").val()==""||$("#txtPrecioVenta").val()<=0)
				{
					$("#divError").text("Debes indicar el precio de venta.");
					$("#ErrorDialog" ).dialog("open");
					return;	
				}	
				if ($("#txtPrecioCorrecto").val()==""||$("#txtPrecioVenta").val()<=0)
				{
					$("#divError").text("Debes indicar el precio de correcto.");
					$("#ErrorDialog" ).dialog("open");
					return;	
				}
				if ($("#txtPrecioChollo").val()==""||$("#txtPrecioVenta").val()<=0)
				{
					$("#divError").text("Debes indicar el precio chollo.");
					$("#ErrorDialog" ).dialog("open");
					return;	
				}																
				parameters={
					funcion: modo,//insertar,actualizar
					idanuncio: idanuncio,
					nombre:  $("#txtNombre").val(),
					foto:  $("#txtFoto").val(),
					precio_venta: $("#txtPrecioVenta").val(),
					urlportalventa:$("#txtUrlPortalVenta").val(),
					idsitioweb: $("#cboSitiosWeb").val(),
					email: email,		
					precio_correcto:$("#txtPrecioCorrecto").val(),
					precio_chollo:$("#txtPrecioChollo").val(),
					idcategoria:$("#cboCategorias").val()
				};
								
				$.ajax({
					type: "POST",
					url: "../../servicios/sw_anuncio.php",
					data: parameters,
					success: function(data){
						anuncio = JSON.parse(data);
						idanuncio=anuncio.idanuncio;
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
		  height: 340,
		  width: 600,
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
			$("#AltaModiDialog").dialog('option', 'title', 'Alta de anuncios');
			limpiar();
			modo="insertar";
			$( "#cboCategorias" ).selectmenu();
			$( "#cboSitiosWeb" ).selectmenu();
			$("#AltaModiDialog").dialog("open");
		});

		$("#btnRegresar").on("click",function(){
			location.href="../intranet/intranet_view.php?email="+email;
		});
		$("#txtFoto").on("focusout",function(){
 	    	$(".showImage").html("</br><img src='"+$(this).val()+"' style='width:200px;height:200px'/>");  
		}); 
		/*
		$("#txtUrlPortalVenta").on("focusout",function(){
 	    	$(".showImage2").load($(this).val());  
		});			
		*/    	
		pintarAnuncios();
		pintarSitiosWeb();
		pintarCategorias();
	});
	function limpiar(){
		$("#txtNombre").val("");
		$("#txtFoto").val("");
		$(".showImage").html("");
		$("#txtPrecioVenta").val("");
		$("#txtUrlPortalVenta").val("");
		$("#cboSitiosWeb").val("0");

		$("#txtPrecioCorrecto").val("");
		$("#txtPrecioChollo").val("");
		$("#cboCategorias").val("0");
	}
	function SalidaAltaModif(){
	  $("#txtNombre").val("");
	  $("#txtFoto").val("");
	  $("#AltaModiDialog" ).dialog( "close" );
	  pintarAnuncios();
	  $("#CatologoDialog" ).dialog("open");		
	}
	function pintarAnuncios(){

		parameters={
				funcion: "catalogo",
				email: email
		};
		$.ajax({
			type: 'POST',
			url: "../../servicios/sw_anuncio.php",
			data: parameters,
			success: function(data){
				anuncios = JSON.parse(data);
				$("#tblDatos tbody").html("");
			
				$.each(anuncios, function( key, value ) {
					var fila="";
					fila+="<tr id='"+value.idanuncio+"'>";
					fila+="	<td width='224px' valign='center'>"+value.nombre+"</td>";	
					var foto=(value.foto=="")? "noproduct.png" : value.foto;
					fila+="	<td width='296px' style='text-align:center'><img src='"+foto+"' width='60px' height='60px'</td>";			
					fila+="	<td width='103px' style='text-align:center'><img style='cursor:pointer' onclick='confirmarEliminar("+value.idanuncio+")' src='../../iconos/delete.png' width='20px' title='Borrar'/><img style='cursor:pointer;margin-left:20px' onclick='editar("+value.idanuncio+")' src='../../iconos/edit.png' width='20px' title='Editar'/>					</td>";
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

	function confirmarEliminar(idanuncio){
		valor=confirm("Seguro que deseas eliminar el registro?");
		if (!valor) return false;

		parameters={
			funcion: "eliminar",
			idanuncio: idanuncio
		};
		$.ajax({
			type: 'POST',
			url: "../../servicios/sw_anuncio.php",
			data: parameters,
			success: function(data){
				pintarAnuncios();
			},			
			error: function (xhr, status, error) {
				responseText = JSON.parse(xhr.responseText);
				$("#divError").text(responseText.error);
	    		$("#ErrorDialog" ).dialog("open");
			}
		});
	}
	function editar(identificador){
		$("#AltaModiDialog").dialog('option', 'title', 'Modificacion de anuncios');
		idanuncio = identificador;
		parameters={
			funcion: "obtenerDatos",
			idanuncio: idanuncio
		};
		$.ajax({
			type: 'POST',
			url: "../../servicios/sw_anuncio.php",
			data: parameters,
			success: function(data){
				anuncio = JSON.parse(data);
				//$( "#cboCategorias" ).selectmenu();
				//$( "#cboSitiosWeb" ).selectmenu();
				//pintarSitiosWeb();
				//pintarCategorias();

				$("#txtNombre").val(anuncio.nombre);
				$("#txtFoto").val(anuncio.foto);
				$(".showImage").html("</br><img src='"+anuncio.foto+"' style='width:200px;height:200px'/>");
				$("#txtPrecioVenta").val(anuncio.precio_venta);
				$("#txtUrlPortalVenta").val(anuncio.urlportalventa);
				$("#cboSitiosWeb").val(anuncio.idsitioweb);

				$("#txtPrecioCorrecto").val(anuncio.precio_correcto);
				$("#txtPrecioChollo").val(anuncio.precio_chollo);
				$("#cboCategorias").val(anuncio.idcategoria);	 
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
	function pintarCategorias(){
		parameters={
			funcion: "catalogo"
		};
		$.ajax({
			type: 'POST',
			url: "../../servicios/sw_categoria.php",
			data: parameters,
			success: function(data){
				console.log(data);
				categorias = JSON.parse(data);
				//recorremos el data
				$.each(categorias, function( key, value ) {
					$("#cboCategorias").append("<option value='"+value.idcategoria+"'>"+value.nombre+"</option>");			  
				});			
			},
			error: function (xhr, status, error) {
				responseText = JSON.parse(xhr.responseText);
				$("#divError").text(responseText.error);
	    		$("#ErrorDialog" ).dialog("open");
			}
		});
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
				console.log(data);
				sitiosweb = JSON.parse(data);
				//recorremos el data
				$.each(sitiosweb, function( key, value ) {
					$("#cboSitiosWeb").append("<option value='"+value.idsitioweb+"'>"+value.nombre+"</option>");			  
				});			
			},
			error: function (xhr, status, error) {
				responseText = JSON.parse(xhr.responseText);
				$("#divError").text(responseText.error);
	    		$("#ErrorDialog" ).dialog("open");
			}
		});
	}
</script>
</body>
</html>
