<?php 

error_reporting(0);

$email_dominio = "isaac.centenario@gmail.com"; // email que recebe

if( $_SERVER['REQUEST_METHOD'] == 'POST' ) :

	$nome = htmlentities( $_POST["nome"] );
	$email = htmlentities( $_POST["email"] );
	$assunto = htmlentities( $_POST["assunto"] );
	$mensagem = htmlentities( $_POST["mensagem"] );

	$headers = "MIME-Version: 1.0\r\n";
	$headers .= "Content-type: text/html; charset=utf-8\r\n";
	$headers .= "From: \"$nome\" <$email>\r\n";
	$content = "
		<strong>Nome: </strong> $nome <br />
		<strong>Email: </strong> $email <br />
		<strong>Assunto: </strong> $assunto <br />
		<strong>Mensagem: </strong><br /><i>$mensagem</i>
	";
	//envia o email sem anexo iso-8859-1
	echo json_encode( array( 'send' => mail($email_dominio, $assunto, $content, $headers ) ) );

endif;