<?php
	
	// Envio de correo (librerias)

	use PHPMailer\PHPMailer\PHPMailer;
	use PHPMailer\PHPMailer\Exception;
	include "PHPMailer.php";
	include "SMTP.php";
	include "Exception.php";

	require_once("CBBDD.php");
	
	class CUsuario extends CBBDD{

		// Definimos atributos
		//https://phpdelusions.net/pdo_examples/connect_to_mysql

		public $email;
		public $nombre;		
		public $password;
		public $validado;
		public $confirmado;
		public $token;
		//private $WEB_ROOT="http://asesorcompras.jc.bymhost.com/asesorcompras/vistas/usuarios/confirmar.php";
		private $WEB_ROOT="http://localhost/php/asesorcompras/vistas/usuarios/confirmar.php";

	    function __construct() {
	    	parent::__construct();
	    	//$this->conn = parent::conn;
			$this->email="";
			$this->nombre="";
			$this->password="";
			$this->validado=false;
			$this->confirmado=false;
			$this->token="";	    	
	    }	        

		public function ObtenerDatosUsuario($email){
			try {
				$sql="Select * from usuarios where email='$email'";
				if ($this->CS($sql)) {
					if ($fila=$this->mDatos->fetch_assoc()) { 	
						//Login correcto, obtenemos el código y nombre:
						$this->email=$email;
						$this->nombre=$fila["nombre"];
						$this->password=base64_decode($fila["password"]);
						$this->validado=true;
						$this->confirmado=$fila["confirmado"];
						$this->token=$fila["token"];
					}
					$this->mDatos->close();
				}
			} catch (Error $e) {
				throw $e;
			}					
		}
		private function ramdonString($longitudPass=10){
		    //Se define una cadena de caractares. Te recomiendo que uses esta.
			$cadena = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz1234567890";
		    //Obtenemos la longitud de la cadena de caracteres
			$longitudCadena=strlen($cadena);

		    //Se define la variable que va a contener la contrasena
			$pass = "";

	    	//Creamos la contrasena
			for($i=1 ; $i<=$longitudPass ; $i++){
	        //Definimos numero aleatorio entre 0 y la longitud de la cadena de caracteres-1
				$pos=rand(0,$longitudCadena-1);

	        //Vamos formando la contrasena en cada iteraccion del bucle, anadiendo a la cadena $pass la letra correspondiente a la posicion $pos en la cadena de caracteres definida.
				$pass .= substr($cadena,$pos,1);
			}
			return $pass;
		}

		private function enviarMail($to, $subject, $msg){
			$enviado = false;
			try {

				$email_user = "jc.perdiguerocarlos@gmail.com";
				$email_password = "asier2004";
				//$address_to = $to;
				// para pruebas
				$address_to = "jc.perdiguerocarlos@gmail.com";
				$from_name = "jc.perdiguerocarlos@gmail.com";

				$mail = new PHPMailer();
				$mail->Username = $email_user;
				$mail->Password = $email_password; 
	
				$mail->SMTPDebug = 0;
				$mail->SMTPSecure = 'tls';
				$mail->SMTPOptions = array(
	    			'ssl' => array(
	        		'verify_peer' => false,
	        		'verify_peer_name' => false,
	        		'allow_self_signed' => true
	    			)
				);
				$mail->Host = "smtp.gmail.com"; // GMail
				$mail->Port = 587;
				$mail->CharSet = 'UTF-8';
				$mail->IsSMTP(); // use SMTP
				$mail->SMTPAuth = true;
				$mail->setFrom($mail->Username,$from_name);
				$mail->AddAddress($address_to); // recipients email
				$mail->Subject = $subject;	
				$mail->Body =$msg;
				$mail->IsHTML(true);

				$enviado=$mail->Send();
			} catch (Error $e) {
				throw $e;
			}
			return $enviado;
		}	
		//Inserta un nuevo usuario, devuelve su nuevo id si ok, -1 si no lo consigue: 
		public function Registrar($email, $nombre, $password) {
			try {
				$sql="select count(*) as TOTAL from usuarios where email='$email'";

				$total = $this->CT($sql);
				if ($total>0) {
					throw new Exception("Mail ya existente");
					return;
				}
				//$enc_pass=md5($password);
				$enc_pass=base64_encode($password);
				//El mail no existe, creamos el token aleatorio de confirmación:
				$token = $this->ramdonString(30);
				//Insertamos el nuevo usuario con su token de confirmación:

				$this->email=$email;
				$this->nombre=$nombre;
				$this->password=$password;
				$this->validado=true;
				$this->confirmado=false;
				$this->token=$token;				
				$sql = "INSERT INTO usuarios (			
							email,
							nombre,
							password,
							confirmado,
							token 
							) 
						VALUES 
							(
							'$email',
							'$nombre',
							'$enc_pass',
							0,
							'$token'		
							)";				

				$id = $this->CE($sql,true);

				//Enviamos el mail para confirmar el registro:
				$subject = "Chollos.net: Confirmación de registro";
				$link = $this->WEB_ROOT;

				// compose message
				$message = "<p><h1 style='color:#3498db;'>Hola $nombre,</h1> Te informamos que hemos procedido a registrar tu usuario en nuestra aplicación de forma temporal. 
					</p>";
				$message .="<p>
					El token asignado es: ".$token."</p>";
				$message .="
					<p>
					Para finalizar el registro es necesario confirmar el token. </br></br>Por favor, pulse en el siguiente link: 
					</p>
					<p>$link</p>
					<p>Un saludo y gracias.</p>
			    ";					
				
				if (!$this->enviarMail($mail,$subject,$message)) {
					
					throw new Exception("No se ha podido enviar mail con nuevo password");	
				}

			}catch (Error $e) {
				throw $e;
			}
		}

		public function ActualizarMiPerfil( $email, $nombre, $password) {
			$res = 0;
			$enc_pass=base64_encode($password);

			try {
				$sql="Update usuarios set nombre='$nombre', password ='$enc_pass'
				 	where email='$email'";
				$res = $this->CE($sql,false);
				if ($res<=0) {
					throw new Exception("No se han podido modificar los datos");
				}else{
					$this->nombre=$nombre;
					$this->password=$password;	
				}		 
			} catch (Error $e) {
				throw $e;
			}
			return res;
		}

		public function confirmarRegistro($token) {
			try {
				//Comprobamos si el token pertenece a algún usuario:

				$sql = "Select email from usuarios where token='$token' and confirmado=0";
				
				if ($this->CS($sql)) {
					if ($fila=$this->mDatos->fetch_assoc()) 
					{ 	
					//Existe un usuario con ese token pdte de confirmar:
						$email=$fila["email"];
					}

					$this->mDatos->close();

					$sql = "update usuarios set confirmado='1' where email='$email'";

					$total = $this->CE($sql,false);

					if ($total<=0) {

						//No se ha podido dar por confirmado el registro:
						throw new Exception("No se ha podido confirmar su registro, por favor reintente");
						$this->confirmado=false;
						return false;
					}	
					$this->confirmado=true;	
				}
			} catch (Error $e) {
				throw $e;
			}
			return true;
		}

		//Comprueba email y clave. Si es correcto obtiene el id del usuario (us_id), llama a las funciones CargarDatos($id)
		//Si no es correcto devuelve 0:

		public function ValidarPassword($email,$password) {
			try {
				//$enc_pass = md5($password);
				$enc_pass=base64_encode($password);
				$sql="Select * from usuarios where email='$email' and password='$enc_pass' and confirmado=1";

				if ($this->CS($sql)) {
					if ($fila=$this->mDatos->fetch_assoc()) { 	
						//Login correcto, obtenemos el código y nombre:
						$this->email=$email;
						$this->nombre=$fila["nombre"];
						$this->password=$password;
						$this->validado=true;
						$this->confirmado=$fila["confirmado"];
						$this->token=$fila["token"];
					}
					$this->mDatos->close();
				}
			} catch (Error $e) {
				throw $e;
			}
		}	
	}
?>