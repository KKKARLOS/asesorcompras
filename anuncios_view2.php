<?php
	// Conectando, seleccionando la base de datos
	require("cabecera.php");
?>
<br/><h1>Anuncios</h1>	
<div style="width:100%" align="margin-left">
	<table id="tblCabecera" width="620px" style="margin-top:20px;margin-left:200px">
		<tr>
		<th width="395px" style='text-align:center'>Producto</th>
		<th width="102px" style='text-align:center'>Fecha</th>
		<th width="127px" style='text-align:center'>Precio</th>
		</tr>
	</table>
	<div id="divDatos" style="width:638px;height:443px;overflow-y:auto;margin-left:200px">
		<table id="tblDatos" width="620px">
			<tbody>			
			</tbody>		
		</table>
	</div>
</div>
<!--
-->
<script>
	var idcategoria = "<?php echo $_GET["idcategoria"];?>";

	$(function(){
		pintarAnuncios();		
	});

	function pintarAnuncios(){
		if (idcategoria=="0")
			parameters={
				funcion: "catalogoTotal"
			};			
		else if (idcategoria=="V"||idcategoria=="A"||idcategoria=="R")
			parameters={
				funcion: "catalogoPrecio",
				color: idcategoria
			};
		else
			parameters={
				funcion: "catalogoCategoria",
				idcategoria: idcategoria
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
					fila+="<tr style='cursor:pointer' id='"+value.idanuncio+"' data-url='"+value.urlportalventa+"'>";
					var foto=(value.foto=="")? "noproduct.png" : value.foto;
					fila+="	<td width='100px' style='text-align:center'><img src='"+foto+"' width='60px' height='60px'</td>";		
					fila+="	<td width='280px' valign='center'>"+value.nombre+"</td>";	

					fila+="	<td width='100px' valign='center' style='text-align:center'>"+moment(value.fecha_alta_mod).format('DD/MM/YYYY');+"</td>";

					fila+="	<td width='90px' valign='center' style='text-align:center'>"+value.precio_venta+"</td>";

					if (parseFloat(value.precio_venta)<=parseFloat(value.precio_chollo))
					{
						color = "verde.gif";
					}
					else if (parseFloat(value.precio_venta)>parseFloat(value.precio_chollo)&&parseFloat(value.precio_venta)<parseFloat(value.precio_correcto)){
						color="amarillo.gif";
					}
					else{
						color = "rojo.gif";
					}
					fila+="	<td width='30px' style='text-align:center'><img style='cursor:pointer' src='../../iconos/"+color+"' width='20px' title='Color'/>					</td>";
					fila+="</tr>"; 
					$("#tblDatos tbody").append(fila);
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
