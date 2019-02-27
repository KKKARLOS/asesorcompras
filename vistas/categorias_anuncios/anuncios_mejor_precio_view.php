<?php
	// Conectando, seleccionando la base de datos
	require("cabecera.php");
?>
<br/><h1>Bienvenido/a 'Chollos.net' donde encontrarás los mejores precios del mercado</h1>	
<div style="width:100%" align="center">
	<table id="tblCabecera" width="620px" style="margin-top:20px;">
		<tr>
		<th width="250px">Categoria</th>
		<th width="150px" style='text-align:center'>Anuncio</th>
		<th width="120px" style='text-align:center'>Precio</th>
		</tr>
	</table>
	<div id="divDatos" style="width:652px;height:380px;overflow-y:auto;">
		<table id="tblDatos" width="620px">
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
		pintarAnuncios();
	});

	function pintarAnuncios(){
		parameters={
			funcion: "catalogoCategoriaPrecioMin"
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

					fila+="<tr style='cursor:pointer' data-url='"+value.urlportalventa+"'>";

					var foto=(value.foto=="")? "noproduct.png" : value.foto;

					fila+="	<td width='100px' style='text-align:center'><img src='../../images/Categories/"+foto+"' width='60px' height='60px'</td>";

					fila+="	<td width='150px' valign='center'>"+value.nom_categoria+"</td>";	

					fila+="	<td width='150px' valign='center'>"+value.nom_anuncio+"</td>";

					fila+="	<td width='120px' valign='center'> Desde "+value.precio_venta+" euros</td>";

					fila+="</tr>"; 
					$("#tblDatos").append(fila);
				});
				// enlazo evento click a las filas
				$("#tblDatos tbody>tr").on("click",function(){
					location.href=$(this).attr("data-url");
				});					
			},			
			error: function(xhr, status, error) {
				responseText = JSON.parse(xhr.responseText);
				$("#divError").text(responseText.error);
	    		$("#ErrorDialog" ).dialog("open");
			}
		});
	}
</script>
</body>
</html>
