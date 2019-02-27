<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
include "PHPMailer.php";
include "SMTP.php";
include "Exception.php";

$email_user = "jc.perdiguerocarlos@gmail.com";
$email_password = "asier2004";
$the_subject = "Phpmailer prueba by karlos.com";
$address_to = "jc.perdiguerocarlos@gmail.com";
$from_name = "jc.perdiguerocarlos@gmail.com";
$phpmailer = new PHPMailer();
// ---------- datos de la cuenta de Gmail -------------------------------
$phpmailer->Username = $email_user;
$phpmailer->Password = $email_password; 
//-----------------------------------------------------------------------
$phpmailer->SMTPDebug = 0;
$phpmailer->SMTPSecure = 'tls';
$phpmailer->SMTPOptions = array(
    'ssl' => array(
        'verify_peer' => false,
        'verify_peer_name' => false,
        'allow_self_signed' => true
    )
);
$phpmailer->Host = "smtp.gmail.com"; // GMail
$phpmailer->Port = 587;
$phpmailer->IsSMTP(); // use SMTP
$phpmailer->SMTPAuth = true;
$phpmailer->setFrom($phpmailer->Username,$from_name);
$phpmailer->AddAddress($address_to); // recipients email
$phpmailer->Subject = $the_subject;	
$phpmailer->Body .="<h1 style='color:#3498db;'>Hola Mundo!</h1>";
$phpmailer->Body .= "<p>Mensaje personalizado</p>";
$phpmailer->Body .= "<p>Fecha y Hora: ".date("d-m-Y h:i:s")."</p>";
$phpmailer->IsHTML(true);
echo $phpmailer->Body;
try{
	$estado=$phpmailer->Send();
	if ($estado) echo "</br>Enviado correctamente</br>";
	else echo "</br>Error en el envio</br>";
} catch (Exception $e) {
	echo $e;
}
?>