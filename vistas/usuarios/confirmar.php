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

<div id="ConfirmacionDialog" class="oculta" title="Confirmación">
  <h4>Introduzca el token enviado y pulse el botón aceptar</h4></br></br>
  <input type="text" id="txtToken" style="width:400px" value="" autocomplete="off" class="text ui-widget-content ui-corner-all">  
</div>
<!--Ventana de Mensajes-->

<div id="MensajeDialog" class="oculta" title="Informativo">
	<br/><br/>
	<div id="divMensaje">	
	</div>
</div>
<!--
-->
<script>
	$(function(){
		// Inicializar ventana de inicio

		dialog = $("#ConfirmacionDialog" ).dialog({
		  dialogClass: 'no-close',
		  autoOpen: false,
		  show: {
        		effect: "slideDown",
        		duration: 700
      	  },
		  height: 350,
		  width: 450,
		  modal: true,
		  buttons: {
			Aceptar: function() {
				parameters={
					funcion: "confirmarRegistro", 
					token: $("#txtToken").val()
				};
				$.ajax({
					type: "POST",
					url: "../../servicios/sw_usuario.php",
					data: parameters,
					success: function(data){
						usuario = JSON.parse(data);
						if (usuario.confirmado==true)
						{
							$("#MensajeDialog").dialog('option', 'title', 'Informativo');								
							$("#divMensaje").text("Confirmación de registro correcta.");				
							$("#ConfirmacionDialog").dialog( "close" );
							$("#MensajeDialog" ).dialog("open");		
						}
						else 
						{
							$("#MensajeDialog").dialog('option', 'title', 'Error');							
							$("#divMensaje").text("No se ha podido confirmar el registro.");
							$("#ConfirmacionDialog").dialog( "close" );							
							$("#MensajeDialog" ).dialog("open");	
						}
					},			
					error: function (xhr, status, error) {
						alert("error:"+error.Message);
					}
				});
			},
		    Login: function() {
		    	location.href="login_registro_view.php";
			}
		  },
		  close: function() {
			return false;
			//form[ 0 ].reset();
			//allFields.removeClass( "ui-state-error" );
		  }
		});
		dialog = $( "#MensajeDialog" ).dialog({
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
			  location.href="login_registro_view.php";
			  $("#MensajeDialog" ).dialog("close");
  		  	  $("#ConfirmacionDialog").dialog( "open" );
			}
		  },
		  close: function() {
			return false;
			//form[ 0 ].reset();
			//allFields.removeClass( "ui-state-error" );
		  }
		});

		$("div").removeClass("oculta");		
		$("#ConfirmacionDialog" ).dialog("open");	
	});	
</script>
</body>
</html>
			