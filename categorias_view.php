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

	table {border: 1px solid #ddd;border-collapse: collapse;margin-left: 0px;}

	td{border: 1px solid #ddd;text-align:left;padding-left:4px  }

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

<!--Ventana Alta de Categorias-->

<div id="AltaModiDialog" class="oculta" title="Alta de categorías">
	<br/>
	<form enctype="multipart/form-data" class="formulario">
	      <label for="name">Nombre</label></br>
	      <input type="text" id="txtNombre" style="width:330px" value="" autocomplete="off" class="text ui-widget-content ui-corner-all"></br></br>
	      <label for="imagen">Imagen</label></br>
	      <input name="archivo" type="file" id="imagen" class="text ui-widget-content ui-corner-all"/>
	      <br/><br/>
	      <input id="btnSubir" type="hidden" value="Subir imagen" />
  	</form>  
  	<!--div para visualizar en el caso de imagen-->
    <div class="showImage" style="width:500px;text-align:center"></div>
    <br/><br/>
  	<!--div para visualizar mensajes-->
    <div class="messages" style="width:500px;text-align:center"></div><br /><br />

</div>

<!--Ventana de Mensajes-->

<div id="ErrorDialog" class="oculta" title="Error">
	<br/><br/>
	<div id="divError">	
	</div>
</div>
<div id="CatologoDialog" align="left" class="oculta" title="Listado de Categorías">
	<div style="text-align: left; margin-top:0px;"> 
		<input style="width:180px;height: 30px; margin:20px;background:url(../../iconos/anadir.png) no-repeat; background-position: 6px 4px;text-align: right; background-color: #d7e9f6" class="ui-button ui-corner-all ui-widget" type="button" name="btnAlta" id="btnAlta" value="Alta Categoría" />
	</div>
	<table id="tblCabecera" width="620px style="margin-left:200px;">
		<tr>
		<th width="225p	x">Nombre</th>
		<th width="296px" style='text-align:center'>Imagen</th>
		<th width="101px" style='text-align:center'>Acciones</th>
		</tr>
	</table>
	<div id="divDatos" style="width:652px;height:380px;overflow-y:auto;margin-left:200px;">
		<table id="tblDatos" width="620px">		
			<tbody id="tFilas">
			</tbody>
		</table>
	</div>
</div>
<div id="mensaje"></div>
<!--
-->
<script>
	var idcategoria=0;
	var ventanaDialog="";
	var modo="";
	var email = "<?php echo $_GET["email"];?>";

	$(function(){

		// Inicializar ventana de Catálogo de categorias

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
		// Inicializar ventana de alta de categorias

		dialog = $("#AltaModiDialog" ).dialog({
		  autoOpen: false,
		  show: {
        		effect: "slideDown",
        		duration: 700
      	  },		  
		  height: 600,
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
				if ($("#imagen").val()!="")
					$("#btnSubir").click();

				parameters={
					funcion: modo,//insertar,actualizar
					idcategoria: idcategoria,
					nombre:  $("#txtNombre").val(),
					imagen:  $('input[type=file]').val().replace(/.*(\/|\\)/, '')
				};
								
				$.ajax({
					type: "POST",
					url: "../../servicios/sw_categoria.php",
					data: parameters,
					success: function(data){
						categoria = JSON.parse(data);
						idcategoria=categoria.idcategoria;
						$("#btnGrabar").button("disable");
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
			$("#AltaModiDialog").dialog('option', 'title', 'Alta de categorías');
			modo="insertar";
			$("#AltaModiDialog").dialog("open");
		});

		$("#btnRegresar").on("click",function(){
			location.href="../intranet/intranet_view.php?email="+email;
		});

	    $(".messages").hide();
	    //queremos que esta variable sea global
	    var fileExtension = "";
	    //función que observa los cambios del campo file y obtiene información
	    $(':file').change(function()
	    {
	        //obtenemos un array con los datos del archivo
	        var file = $("#imagen")[0].files[0];
	        //obtenemos el nombre del archivo
	        var fileName = file.name;
	        //obtenemos la extensión del archivo
	        fileExtension = fileName.substring(fileName.lastIndexOf('.') + 1);
	        //obtenemos el tamaño del archivo
	        var fileSize = file.size;
	        //obtenemos el tipo de archivo image/png ejemplo
	        var fileType = file.type;
	        //mensaje con la información del archivo
	        showMessage("<span class='info'>Archivo para subir: "+fileName+", peso total: "+fileSize+" bytes.</span>");
	    });

	    //al enviar el formulario
	    $('#btnSubir').click(function(){
	        //información del formulario
	        var formData = new FormData($(".formulario")[0]);
	        var message = ""; 
	        //hacemos la petición ajax  
	        $.ajax({
	            url: 'upload.php',  
	            type: 'POST',
	            // Form data
	            //datos del formulario
	            data: formData,
	            //necesario para subir archivos via ajax
	            cache: false,
	            contentType: false,
	            processData: false,
	            //mientras enviamos el archivo
	            beforeSend: function(){
	                message = $("<span class='before'>Subiendo la imagen, por favor espere...</span>");
	                showMessage(message)        
	            },
	            //una vez finalizado correctamente
	            success: function(data){
	                message = $("<span class='success'>La imagen se ha subido correctamente. Grabación correcta.</span>");
	                showMessage(message);
	                if(isImage(fileExtension))
	                {
	                    $(".showImage").html("</br><img src='../../images/Categories/"+data+"' style='width:200px;height:200px'/>");
	                }
	            },
	            //si ha ocurrido un error
	            error: function(){
	                message = $("<span class='error'>Ha ocurrido un error.</span>");
	                showMessage(message);
	            }
	        });
	    });	    
		pintarCategorias();
	});	
	function SalidaAltaModif(){
	  $("#txtNombre").val("");
	  $("image").val("");
	  $('input[type=file]').val("");
	  $("#imagen")[0].files[0]="";
	  $(".messages").html("").show();
	  $(".showImage").html("");
	  $("#btnGrabar").button("enable");
	  $("#AltaModiDialog" ).dialog( "close" );
	  $("#CatologoDialog" ).dialog("open");
	  pintarCategorias();		
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
				categorias = JSON.parse(data);
				$("#tFilas").html("");
				var filas="";			
				$.each(categorias, function( key, value ) {
					filas+="<tr id='"+value.idcategoria+"'>";
					filas+="	<td width='224px' valign='center'>"+value.nombre+"</td>";	
					var foto=(value.foto=="")? "noproduct.png" : value.foto;
					filas+="	<td width='296px' style='text-align:center'><img src='../../images/Categories/"+foto+"' width='60px' height='60px'</td>";
					filas+="	<td width='103px' style='text-align:center'><img style='cursor:pointer' onclick='confirmarEliminar("+value.idcategoria+")' src='../../iconos/delete.png' width='20px' title='Borrar'/><img style='cursor:pointer;margin-left:20px' onclick='editar	("+value.idcategoria+")' src='../../iconos/edit.png' width='20px' title='Editar'/>					</td>";
					filas+="</tr>"; 
				});	
				$("#tFilas").html(filas);
			},			
			error: function(xhr, status, error) {
				responseText = JSON.parse(xhr.responseText);
				$("#divError").text(responseText.error);
	    		$("#ErrorDialog" ).dialog("open");
			}
		});
	}

	//como la utilizamos demasiadas veces, creamos una función para 
	//evitar repetición de código

	function showMessage(message){
	    $(".messages").html("").show();
	    $(".messages").html(message);
	}

	//comprobamos si el archivo a subir es una imagen
	//para visualizarla una vez haya subido
	function isImage(extension)
	{
	    switch(extension.toLowerCase()) 
	    {
	        case 'jpg': case 'gif': case 'png': case 'jpeg':
	            return true;
	        break;
	        default:
	            return false;
	        break;
	    }
	}

	function confirmarEliminar(idcategoria){
		valor=confirm("Seguro que deseas eliminar el registro?");
		if (!valor) return false;

		parameters={
			funcion: "eliminar",
			idcategoria: idcategoria
		};
		$.ajax({
			type: 'POST',
			url: "../../servicios/sw_categoria.php",
			data: parameters,
			success: function(data){
				pintarCategorias();
			},			
			error: function (xhr, status, error) {
				responseText = JSON.parse(xhr.responseText);
				$("#divError").text(responseText.error);
	    		$("#ErrorDialog" ).dialog("open");
			}
		});
	}
	function editar(idCategoria){
		$("#AltaModiDialog").dialog('option', 'title', 'Modificacion de categorías');
		idcategoria = idCategoria;
		parameters={
			funcion: "obtenerDatos",
			idcategoria: idcategoria
		};
		$.ajax({
			type: 'POST',
			url: "../../servicios/sw_categoria.php",
			data: parameters,
			success: function(data){
				categoria = JSON.parse(data);
				$("#txtNombre").val(categoria.nombre);
				if (categoria.foto=="")	categoria.foto="noproduct.png";
				$(".showImage").html("</br><img src='../../images/Categories/"+categoria.foto+"' style='width:200px;height:200px'/>");
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
