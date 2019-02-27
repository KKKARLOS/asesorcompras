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
</style>
</head>
<body>

<!--Ventana de Opciones-->

<div id="OpcionesDialog" class="oculta" title="Opciones disponibles">
  <h3><label id="lblBienvenida"></label></h3>
  </br>
  <form style="text-align:center">
      <input type="button" style="width:200px" id="btnMiPerfil" value="Mi Perfil" /></br></br>
      <input type="button" style="width:200px" id="btnSitiosWeb" value="Sitios Web" /></br></br>
      <input type="button" style="width:200px" id="btnCategorias" value="Categorías" /></br></br>
      <input type="button" style="width:200px" id="btnAnuncios" value="Anuncios" /></br></br>
      <input type="button" style="width:200px" id="btnEstadisticas" value="Estadísticas" /></br></br>
      <input type="button" style="width:200px" id="btnLogout" value="Salir" ></br></br>      
  </form>
</div>

<!--Ventana de mi Perfil-->

<div id="MiPerfilDialog" class="oculta" title="Mi Perfil">
	<br/>
  <form autocomplete="off">
      <label for="name">Email</label></br>
      <input type="text" id="txtEmailReg" style="width:330px" value="" disabled autocomplete="off" class="text ui-widget-content ui-corner-all"></br></br>  	
      <label for="name">Nombre</label></br>
      <input type="text" id="txtNombreReg" style="width:330px" value="" autocomplete="off" class="text ui-widget-content ui-corner-all"></br></br>
      <label for="password">Password</label></br>
      <input type="text" id="txtPasswordReg" value="" class="text ui-widget-content ui-corner-all"/>
  </form>
</div>
<!--Ventana de Mensajes-->

<div id="ErrorDialog" class="oculta" title="Error">
	<br/><br/>
	<div id="divError">	
	</div>
</div>
<!--
-->
<script>
	$(function(){
		var email = "<?php echo $_GET["email"];?>";
		var ventanaDialog="";

		// Inicializar ventana de opciones 	
		dialog = $( "#OpcionesDialog" ).dialog({
		  autoOpen: false,
		  show: {
        		effect: "slideDown",
        		duration: 700
      	  },
		  height: 450,
		  width: 460,
		  modal: true,
		  close: function() {
		  	
		  }
		});

		// Inicializar ventana de mi Perfil

		dialog = $( "#MiPerfilDialog" ).dialog({
		  autoOpen: false,
		  show: {
        		effect: "slideDown",
        		duration: 700
      	  },		  
		  height: 360,
		  width: 370,
		  modal: true,
		  buttons: {
			Grabar: function() {
				// Validación de datos
				ventanaDialog="miperfil";	
				if ($("#txtNombreReg").val()=="")
				{
					$("#divError").text("Debes indicar el nombre.");
					$("#RegistrarDialog" ).dialog( "close" );
					$("#ErrorDialog" ).dialog("open");
					return;	
				}
				if ($("#txtPasswordReg").val()=="")
				{
					$("#divError").text("Debes indicar el password.");	
					$("#RegistrarDialog" ).dialog( "close" );
					$("#ErrorDialog" ).dialog("open");
					return;							
				}				

				$("#MiPerfilDialog" ).dialog( "close" );
				parameters={
					funcion: "ActualizarMiPerfil",
					email:  $("#txtEmailReg").val(),
					nombre: $("#txtNombreReg").val(),
					password: $("#txtPasswordReg").val()
				};				
				$.ajax({
					type: "POST",
					url: "../../servicios/sw_usuario.php",
					data: parameters,
					success: function(data){
						usuario = JSON.parse(data);
						email= usuario.email;
					},			
					error: function(xhr, status, error) {
						responseText = JSON.parse(xhr.responseText);
						$("#divError").text(responseText.error);
			    		$("#MiPerfilDialog" ).dialog( "close" );
			    		$("#ErrorDialog" ).dialog("open");
					}
				});			  
			    $("#MiPerfilDialog" ).dialog( "close" );
			    $("#OpcionesDialog" ).dialog("open");
			},
			Salir: function() {
			  $("#MiPerfilDialog" ).dialog( "close" );
			  $("#OpcionesDialog" ).dialog("open");
			}
		  },
		  close: function() {
			//form[ 0 ].reset();
			//allFields.removeClass( "ui-state-error" );
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
			  if (ventanaDialog=="miperfil")
			  	$("#MiPerfilDialog").dialog("open");
			}
		  },
		  close: function() {
			return false;
			//form[ 0 ].reset();
			//allFields.removeClass( "ui-state-error" );
		  }
		});			
	
		$("div").removeClass("oculta");							
		$("#OpcionesDialog" ).dialog("open");


		$("#btnMiPerfil" ).on("click",function(){
			$("#OpcionesDialog" ).dialog("close");
			$("#MiPerfilDialog" ).dialog( "open" );

		});

		$("#btnSitiosWeb" ).on("click",function(){
			location.href="../sitiosweb/sitiosweb_view.php?email="+email;
		});

		$("#btnCategorias" ).on("click",function(){
			location.href="../categorias/categorias_view.php?email="+email;
		});

		$("#btnAnuncios" ).on("click",function(){
			location.href="../anuncios/anuncios_view.php?email="+email;
		});

		$("#btnEstadisticas" ).on("click",function(){
			location.href="../categorias_anuncios/estadisticas_view.php?email="+email;
		});

		$("#btnLogout" ).on("click",function(){
			location.href="../usuarios/login_registro_view.php";
		});	
		pintarMiPerfil(email);
	});	

	function pintarMiPerfil(email){

		parameters={
				funcion: "ObtenerDatosUsuario",
				email: email
		};
		$.ajax({
			type: 'POST',
			url: "../../servicios/sw_usuario.php",
			data: parameters,
			success: function(data){
				usuario = JSON.parse(data);
				$("#lblBienvenida").text("Bienvenido/a " + usuario.nombre);
					$("#txtEmailReg").val(usuario.email),
					$("#txtNombreReg").val(usuario.nombre),
					$("#txtPasswordReg").val(usuario.password)
			},			
			error: function(xhr, status, error) {
				responseText = JSON.parse(xhr.responseText);
				$("#divError").text(responseText.error);
	    		$("#MiPerfilDialog" ).dialog( "close" );
	    		$("#ErrorDialog" ).dialog("open");
			}
		});
	}			
</script>
</body>
</html>
