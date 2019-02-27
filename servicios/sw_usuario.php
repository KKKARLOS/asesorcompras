<?php session_start();

	require_once("../modelos/cusuario.php");

	$usuario = new CUsuario();
	$res=0;
	$desc="";
	$status=0;

	switch ($_POST["funcion"]) {

		case "Registrar":
		
			//session_unset();
			try {
				$usuario->Registrar($_POST["email"],$_POST["nombre"],$_POST["password"]);
				$status=200;

			} catch (Error $e) {
				$status=451;
				$desc=$e->getMessage();
				$data = array('status' => 451, 'error' => $desc);
				http_response_code($status);
				echo json_encode($data);
				return;
			}

		case "ValidarPassword":

			//session_unset();
			try {
				$usuario->ValidarPassword($_POST["email"],$_POST["password"]);
				$status=200;

			} catch (Error $e) {
				$status=451;
				$data = array('status' => 451, 'error' => $e->getMessage());
				http_response_code($status);
				echo json_encode($data);
				return;
			}			
			break;
						
		case "ActualizarMiPerfil":
	
			try {
				$usuario->ActualizarMiPerfil($_POST["email"], $_POST["nombre"], $_POST["password"]);
				$status=200;					

			} catch (Error $e) {
				$status=451;
				$data = array('status' => 451, 'error' => $e->getMessage());
				http_response_code($status);
				echo json_encode($data);
				return;
			}			
			break;

		case "confirmarRegistro":
	
			try {
				$usuario->confirmarRegistro($_POST["token"]);
				$status=200;				
			} catch (Error $e) {
				$status=451;
				$data = array('status' => 451, 'error' => $e->getMessage());
				http_response_code($status);
				echo json_encode($data);
				return;
			}			
			break;
		case "ObtenerDatosUsuario":	
		
			try {
				$usuario->ObtenerDatosUsuario($_POST["email"]);
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
	echo json_encode($usuario, JSON_UNESCAPED_UNICODE);
?>