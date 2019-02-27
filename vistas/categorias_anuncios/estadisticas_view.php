<?php
	// Conectando, seleccionando la base de datos
	require("cabecera.php");
?>
<br/><h1>Estadísticas</h1>	
<div style="width:100%" align="center">
	<table id="tblCabecera" width="320px">
	<table id="tblCabecera" width="320px" style="margin-top:20px;">
		<tr>
		<th width="320px" style='text-align:center'>Anuncios</th>
		</tr>
	</table>
	<div id="divDatos" style="width:338px;height:380px;overflow-y:auto;">
		<table id="tblDatos" width="320px">
			<tbody>			
			</tbody>		
		</table>
	</div>
</div>
<!--
-->
<script>
	$(function(){
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
		pintarEstadisticas();		
	});

	function pintarEstadisticas(){
		parameters={
			funcion: "estadisticas"
		};
		$.ajax({
			type: 'POST',
			url: "../../servicios/sw_anuncio.php",
			data: parameters,
			success: function(data){
				anuncios = JSON.parse(data);
				$("#tblDatos tbody").html("");
			
				pintarFila("0","Total: "+anuncios[0].TOTAL_ANUNCIOS);
				pintarFila("V","Total precio chollo: "+anuncios[0].TOTAL_PRECIO_CHOLLO);
				pintarFila("A","Total precio correcto: "+anuncios[0].TOTAL_PRECIO_CORRECTO);
				pintarFila("R","Total precio alto: "+anuncios[0].TOTAL_PRECIO_ALTO);

				// enlazo evento click a las filas
				$("#tblDatos tbody>tr").on("click",function(){
						location.href="anuncios_view.php?idcategoria="+$(this).attr("data-color");
				});				
			},			
			error: function(xhr, status, error) {
				responseText = JSON.parse(xhr.responseText);
				$("#divError").text(responseText.error);
	    		$("#ErrorDialog" ).dialog("open");
			}
		});
		function pintarFila(opcion,strCon){
			var fila="";
			fila+="<tr data-color='"+opcion+"'  style='cursor:pointer'>";
			fila+="	<td valign='center' style='text-align:center'>"+strCon+"</td>";
			fila+="</tr>"; 
			$("#tblDatos tbody").append(fila);	
		};		
	}
</script>
</body>
</html>
