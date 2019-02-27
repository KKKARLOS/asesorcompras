<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Documento sin título</title>
<link href="../../css/jquery-ui.css" rel="stylesheet">
<script src="../../js/jquery.js"></script>
<script src="../../js/jquery-ui.js"></script>
<script src="../../js/moment.js"></script>
<style type="text/css">
	.oculta{display: none;}

	.ui-dialog .ui-dialog-buttonpane .ui-dialog-buttonset {text-align: center; 
		float: none !important; 
	}

	table {border: 1px solid #ddd;border-collapse: collapse;margin-left: 15px;}

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
		background-color:  #ddd; //mostrar el fondo gris del li activo: 	;
	}
	#content {
		margin:0px auto;
		width:400px;
		z-index: 1000;
	}
    .cabecera{
    	overflow: auto;
    	clear: both;
        padding: 10px;
        border-radius: 10px;
        background: #6DA7D2;
        color: #fff;
        font-size: 18px;
        text-align: center;
        margin-top:10px;
        width:490px;
    }
	ul.menu {
 		float:left;
 		display:block;
		 margin-top: 5px;
 		list-style-type:none;
 	}
 	.menu li {
 		line-height:20x;
 		font-size:15px;
 		position:relative;
 		float:left;
 	}
 	.menu li a {
 		color: #000;
 		text-transform:uppercase;
 		padding: 5px 20px;
 		text-decoration:none;
 	}
 	.menu li a:hover {
 		background: #6DA7D2;
 		color: white;
 	}
 	.menu li ul {
 		display:none;
 		position:absolute;
 		top:20px;
 		width: 240px;
 		background-color: #f4f4f4;
 		padding:0;
 		list-style-type:none;
 	}
 	.menu li ul li {
 		width: 200px;
 		border: 1px solid #6DA7D2;
 		border-top:none;
 		padding: 10px 20px;
 	}
 	.menu li ul li:first-child {
 		border-top: 1px solid #6DA7D2;
 	}
	.menu li ul li a {
 		width: 240px;
 		margin: 0;
 		padding:0;
 	}
	.menu li ul li a:hover {
 		width: 240px;
 		margin: 0;
 		color: blue;
 		background:none;
 	}
</style>
</head>
<body align="center">
	<div id="content">
		<ul class="menu">
 		<li><a href="anuncios_mejor_precio_view.php">Inicio</a></li>
 		<li><a href="categorias_view.php">Categorías</a>
 		<li><a href="anuncios_view.php?idcategoria=0">Anuncios</a></li> 		
 		</ul>
	</div>	