<?php 
	require_once("../modelos/csitioweb.php");
	$sitioweb = new CSitioWeb();
	$desc="";
	$status=0;

	switch ($_POST["funcion"]) {

		case "insertar":
			try {
				$sitioweb->insertar($_POST["nombre"],$_POST["url"]);
				$res=$sitioweb;
				$status=200;
					
			} catch (Error $e) {
				$status=451;
				$desc=$e->getMessage();
				$data = array('status' => 451, 'error' => $desc);
				http_response_code($status);
				echo json_encode($data);
				return;
			}
			break;


		case "actualizar":

			//session_unset();
			try {
				$sitioweb->actualizar($_POST["idsitioweb"],$_POST["nombre"],$_POST["url"]);
				$res=$sitioweb;
				$status=200;					
	
			} catch (Error $e) {
				$status=451;
				$data = array('status' => 451, 'error' => $e->getMessage());
				http_response_code($status);
				echo json_encode($data);
				return;
			}			
			break;
						
		case "eliminar":

			try {
				$sitioweb->eliminar($_POST["idsitioweb"]);
				$res=$sitioweb;
				$status=200;
	
			} catch (Error $e) {
				$status=451;
				$data = array('status' => 451, 'error' => $e->getMessage());
				http_response_code($status);
				echo json_encode($data);
				return;
			}			
			break;

		case "catalogo":

			try {
				$res=$sitioweb->catalogo();
				$status=200;					

			} catch (Error $e) {
				$status=451;
				$data = array('status' => 451, 'error' => $e->getMessage());
				http_response_code($status);
				echo json_encode($data);
				return;
			}			
			break;
		case "obtenerDatos":	
	
			try {
				$sitioweb->ObtenerDatos($_POST["idsitioweb"]);
				$res=$sitioweb;
				$status=200;				

			} catch (Error $e) {
				$status=451;
				$data = array('status' => 451, 'error' => $e->getMessage());
				http_response_code($status);
				echo json_encode($data);
				return;
			}			
			break;			
	}

	http_response_code($status);
	echo json_encode($res, JSON_UNESCAPED_UNICODE);
?>