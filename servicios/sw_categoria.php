<?php 
	require_once("../modelos/ccategoria.php");
	$categoria = new CCategoria();
	$desc="";
	$status=0;

	switch ($_POST["funcion"]) {

		case "insertar":
			try {
				$categoria->insertar($_POST["nombre"],$_POST["imagen"]);
				$res=$categoria;
				$status=200;
					
			} catch (Exception $e) {
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
				$categoria->actualizar($_POST["idcategoria"],$_POST["nombre"],$_POST["imagen"]);
				$res=$categoria;
				$status=200;					
	
			} catch (Exception $e) {
				$status=451;
				$data = array('status' => 451, 'error' => $e->getMessage());
				http_response_code($status);
				echo json_encode($data);
				return;
			}			
			break;
						
		case "eliminar":

			try {
				$categoria->eliminar($_POST["idcategoria"]);
				$res=$categoria;
				$status=200;
	
			} catch (Exception $e) {
				$status=451;
				$data = array('status' => 451, 'error' => $e->getMessage());
				http_response_code($status);
				echo json_encode($data);
				return;
			}			
			break;

		case "catalogo":

			try {
				$res=$categoria->catalogo();
				$status=200;					

			} catch (Exception $e) {
				$status=451;
				$data = array('status' => 451, 'error' => $e->getMessage());
				http_response_code($status);
				echo json_encode($data);
				return;
			}			
			break;
		case "obtenerDatos":	
	
			try {
				$categoria->ObtenerDatos($_POST["idcategoria"]);
				$res=$categoria;
				$status=200;				

			} catch (Exception $e) {
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