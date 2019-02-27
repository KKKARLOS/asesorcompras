<?php
	// Conectando, seleccionando la base de datos
	require("cabecera.php");

	$parameters= array( 'funcion'=>"catalogoTotal");
	$result = ObtenerProductos("POST","http://localhost/php/asesorcompras/servicios/sw_anuncio.php",$parameters);
	$info = json_decode($result);
	//var_dump($info[0]->idanuncio);exit;
	
	function ObtenerProductos($method, $url, $data = false)
	{
	    $curl = curl_init();

	    switch ($method)
	    {
	        case "POST":
	            curl_setopt($curl, CURLOPT_POST, 1);

	            if ($data)
	                curl_setopt($curl, CURLOPT_POSTFIELDS, $data);

	            break;
	        default:
	            if ($data)
	                $url = sprintf("%s?%s", $url, http_build_query($data));
	    }

	    // Optional Authentication:
	    //curl_setopt($curl, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
	    //curl_setopt($curl, CURLOPT_USERPWD, "username:password");

	    curl_setopt($curl, CURLOPT_URL, $url);
	    curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);

	    $result = curl_exec($curl);

	    curl_close($curl);

	    return $result;
	}
?>
<br/><h1>Anuncios</h1>	
<div style="width:100%" align="center">
	<table id="tblCabecera" width="620px" style="margin-top:20px;margin-left:0px">
		<tr>
		<th width="395px" style='text-align:center'>Producto</th>
		<th width="102px" style='text-align:center'>Fecha</th>
		<th width="127px" style='text-align:center'>Precio</th>
		</tr>
	</table>
	<div id="divDatos" style="width:652px;height:443px;overflow-y:auto;">
		<table id="tblDatos" width="620px">
			<tbody>
				<?php for ($i=0;$i<count($info);$i++) {
				?>				
				<tr style='cursor:pointer' id='<?php echo $info[$i]->idanuncio;?>' data-url='<?php echo $info[$i]->urlportalventa;?>'><?php
					if ($info[$i]->foto=="")
						 $foto="noproduct.png"; 
					else
						 $foto=$info[$i]->foto;

					echo "	<td width='100px' style='text-align:center'><img src='".$foto."' width='60px' height='60px'</td>";		
					echo "	<td width='280px' valign='center'>".$info[$i]->nombre."</td>";	

					echo "	<td width='100px' valign='center' style='text-align:center'>".$info[$i]->fecha_alta_mod."</td>";

					echo "	<td width='90px' valign='center' style='text-align:center'>".$info[$i]->precio_venta."</td>";

					if ($info[$i]->precio_venta<=$info[$i]->precio_chollo)
					{
						$color = "verde.gif";
					}
					else if ($info[$i]->precio_venta>$info[$i]->precio_chollo&&$info[$i]->precio_venta<$info[$i]->precio_correcto){
						$color = "amarillo.gif";
					}
					else{
						$color = "rojo.gif";
					}
					echo "	<td width='30px' style='text-align:center'><img style='cursor:pointer' src='../../iconos/".$color."' width='20px' title='Color'/></td>";
					echo "</tr>"; 
				}
				?>									
			</tbody>		
		</table>
	</div>
</div>

<!--
-->
<script>

</script>
</body>
</html>
