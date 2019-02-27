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
	.no-close .ui-dialog-titlebar-close {display: none }
	.ui-dialog .ui-dialog-buttonpane .ui-dialog-buttonset {text-align: center; 
		float: none !important; 
	.ui-dialog-titlebar {
	    background: #00BCD4 !important;
	}
</style>
</head>
<body>
<!--<body background="../images/banco.jpg">
Ventana de bienvenida-->

<div id="InicioDialog" class="oculta" title="Inicio">
  <h4>Bienvenido/a.</br></br> 
  Indicar la operación a realizar</h4>
</div>

<!--Ventana de Login-->

<div id="LoginDialog" class="oculta" title="Login">
  <h3><label id="lblBienvenidaLogin"></label></h3>
 
  <form autocomplete="off">
      <label for="name">Email</label></br>
      <input type="text" id="txtEmailLog" style="width:330px" value="" autocomplete="off" class="text ui-widget-content ui-corner-all"></br></br>
      <label for="pin">Password</label></br>
      <input type="password" id="txtPasswordLog" style="width:330px" value="" class="text ui-widget-content ui-corner-all"/>
  </form>
</div>

<!--Ventana de Creación de cuenta-->

<div id="RegistrarDialog" class="oculta" title="Registro Usuario">
  <form autocomplete="off">
  	  </br> 
      <label for="name">Email</label></br>
      <input type="text" id="txtEmailReg" style="width:330px" value="" autocomplete="off" class="text ui-widget-content ui-corner-all"></br></br>  	
      <label for="name">Nombre</label></br>
      <input type="text" id="txtNombreReg" style="width:330px" value="" autocomplete="off" class="text ui-widget-content ui-corner-all"></br></br>
      <label for="password">Password</label></br>
      <input type="password" id="txtPasswordReg" value="" class="text ui-widget-content ui-corner-all"/>
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
		var ventanaDialog="";
		var email;
		// Inicializar ventana de inicio

		dialog = $( "#InicioDialog" ).dialog({
		  dialogClass: 'no-close',
		  autoOpen: false,
		  show: {
        		effect: "slideDown",
        		duration: 700
      	  },
		  height: 260,
		  width: 350,
		  modal: true,
		  buttons: {
			Login: function() {
			  	$("#txtEmailLog").val("");
			  	$("#txtPasswordLog").val("");		
			  	$("#InicioDialog").dialog("close");
			  	$("#LoginDialog").dialog( "open" );
			  	$("#txtEmailLog").focus();
			},
		    Registrarse: function() {
		      	$("#txtEmailReg").val("");
		      	$("#txtNombreReg").val("");
			  	$("#txtPasswordReg").val("");
			  	$("#InicioDialog" ).dialog("close");
			  	$("#RegistrarDialog").dialog( "open" );
			}
		  },
		  close: function() {
			return false;
			//form[ 0 ].reset();
			//allFields.removeClass( "ui-state-error" );
		  }
		});
			
		// Inicializar ventana de login 
			
		dialog = $( "#LoginDialog" ).dialog({
		  autoOpen: false,
		  show: {
        		effect: "slideDown",
        		duration: 700
      	  },		  
		  height: 290,
		  width: 350,
		  modal: true,
		  buttons: {
			Aceptar: function() {
				ventanaDialog="login";	
				if ($("#txtEmailLog").val()=="")
				{
					$("#divError").text("Debes indicar el email.");
					$("#LoginDialog").dialog( "close" );
					$("#ErrorDialog").dialog("open");
					return;
				}	
				if ($("#txtPasswordLog").val()=="")
				{
					$("#divError").text("Debes indicar el password.");	
					$("#LoginDialog" ).dialog( "close" );
					$("#ErrorDialog" ).dialog("open");
					return;							
				}

			    $("#LoginDialog").dialog("close" );
				parameters={
					funcion: "ValidarPassword", 
					email: $("#txtEmailLog").val(),
					password: $("#txtPasswordLog").val()
				};				
				$.ajax({
					type: "POST",
					url: "../../servicios/sw_usuario.php",
					data: parameters,
					success: function(data){
						usuario = JSON.parse(data);
						email=usuario.email;

						if (usuario.validado==true)
						{
							location.href="../intranet/intranet_view.php?email="+email;
						}
						else 
						{
							$("#divError").text("Email o Password incorrectos.");
							$("#LoginDialog" ).dialog( "close" );
							$("#ErrorDialog" ).dialog("open");	
							ventanaDialog="login";		
						}
					},			
					error: function (xhr, status, error) {
						alert("error:"+error.Message);
					}
				});				  
			},
			Cancelar: function() {
			  $("#LoginDialog" ).dialog( "close" );
			  $("#InicioDialog" ).dialog("open");
			}
		  },
		  close: function() {
			  $("#LoginDialog" ).dialog( "close" );
			  $("#InicioDialog" ).dialog("open");
		  }
		});
		
		// Inicializar ventana de Registro

		dialog = $( "#RegistrarDialog" ).dialog({
		  autoOpen: false,
		  show: {
        		effect: "slideDown",
        		duration: 700
      	  },		  
		  height: 350,
		  width: 370,
		  modal: true,
		  buttons: {
			Grabar: function() {
				// Validación de datos
				ventanaDialog="registro";	
				if ($("#txtEmailReg").val()=="")
				{
					$("#divError").text("Debes indicar el email.");
					$("#RegistrarDialog" ).dialog( "close" );
					$("#ErrorDialog" ).dialog("open");
					return;
				}
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

				$("#RegistrarDialog" ).dialog( "close" );
				parameters={
					funcion: "Registrar",
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
			    		$("#RegistrarDialog" ).dialog( "close" );
			    		$("#ErrorDialog" ).dialog("open");
					}
				});			  
			    $("#RegistrarDialog" ).dialog( "close" );
			    $("#InicioDialog" ).dialog("open");
			},
			Salir: function() {
			  $("#RegistrarDialog" ).dialog( "close" );
			  $("#InicioDialog" ).dialog("open");
			}
		  },
		  close: function() {
			  $("#RegistrarDialog" ).dialog( "close" );
			  	$("#InicioDialog" ).dialog("open");
		  }
		});


		// Inicializar ventana de mi Perfil

		dialog = $( "#MiPerfilDialog" ).dialog({
		  autoOpen: false,
		  show: {
        		effect: "slideDown",
        		duration: 700
      	  },		  
		  height: 230,
		  width: 350,
		  modal: true,
		  buttons: {
			Continuar: function() {
				parameters={
					funcion: "MiPerfil", 
					email: email, 
					nombre: $("#txtNombrePerfil").val(),
					password: $("#txtPasswordPerfil").val()
				};				
				$.ajax({
					type: "POST",
					url: "../../servicios/sw_usuario.php",
					data: parameters,
					success: function(data){
						usuario = JSON.parse(data);
					  	$("#LoginDialog").dialog( "open" );	
					},			
					error: function (xhr, status, error) {
						alert("error:"+error.Message);
					}
				});
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
		  height: 340,
		  width: 600,
		  modal: true,
		  buttons: {
			Continuar: function() {
			  $("#ErrorDialog" ).dialog("close");
			  if (ventanaDialog=="login")
			  	$("#LoginDialog").dialog( "open" );
			  else //(ventanaDialog=="registro")	
			  	$("#RegistrarDialog").dialog( "open" );
			}
		  },
		  close: function() {
			return false;
			//form[ 0 ].reset();
			//allFields.removeClass( "ui-state-error" );
		  }
		});


		$("div").removeClass("oculta");		
		$("#InicioDialog" ).dialog("open");	
		$("#txtNombreReg").keydown(function (event) {
	        if (event.keyCode == $.ui.keyCode.ENTER) {
	            return false;
	        }
	    });
	    $("#txtPinBien").keydown(function (event) {
	        if (event.keyCode == $.ui.keyCode.ENTER) {
	            return false;
	        }
	    }); 

	});	
</script>
</body>
</html>
