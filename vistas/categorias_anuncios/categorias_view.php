<?php
	// Conectando, seleccionando la base de datos
	require("cabecera.php");
?>
<br/><h1>Categorias/Anuncios</h1>	
<div style="width:100%" align="left">
	<table id="tblCabecera" width="620px" style="margin-top:20px;margin-left:300px;">
		<tr>
		<th width="225p	x">Nombre</th>
		<th width="296px" style='text-align:center'>Imagen</th>
		<th width="101px" style='text-align:center'>Anuncios</th>
		</tr>
	</table>
	<div id="divDatos" style="width:638px;height:443px;overflow-y:auto;margin-left:300px;">
		<table id="tblDatos" width="620px">		
			<tbody>				
			</tbody>
		</table>
	</div>
</div>

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
		pintarCategorias();
	});	

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
				$("#tblDatos tbody").html("");
			
				$.each(categorias, function( key, value ) {
					var fila="";
					fila+="<tr id='"+value.idcategoria+"'>";
					fila+="	<td width='224px' valign='center'>"+value.nombre+"</td>";	
					var foto=(value.foto=="")? "noproduct.png" : value.foto;
					fila+="	<td width='296px' style='text-align:center'><img src='../../images/Categories/"+foto+"' width='60px' height='60px'</td>";			

					fila+="	<td width='103px' style='text-align:center'><img style='cursor:pointer;margin-left:20px' onclick='anuncios("+value.idcategoria+")' src='../../iconos/search.png' width='20px' title='Anuncios'/>					</td>";
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
	function anuncios(idcategoria){
		location.href="anuncios_view.php?idcategoria="+idcategoria;
	}	
</script>
</body>
</html>
