<?php

class Email {
	
	
	var $nombre;
	var $mail;
	var $mailr;
	var $asunto;
	var $msn;
	var $adjunto;
	private $sender;
	private $url;

	//función constructora
	public function __construct(){
		//cada uno de ellos es el parámetro que enviamos desde el formulario
		/*$this->nombre = $n;
		$this->mail = $m;
		$this->mailr = $mr;
		$this->asunto = $a;
		$this->msn = $ms;
		$this->adjunto = $ad;*/
	}

	
	public function enviar($n,$m,$mr,$a,$ms,$ad){
	
		if(isset($_POST)){

		
			if($ad) {
				
				$dir_subida = 'fichero_';
				
				$fichero_ok = $dir_subida . basename($ad);
				
				move_uploaded_file($_FILES['adjunto']['tmp_name'], $fichero_ok);
			}
			//Customisar el mensaje
			$contenido = '
				<h1>Mensaje del correo</h1>
				
					
					
					
							<br><h2><b>'.$ms.'</b></h2><br>
			';
			
			require_once 'AttachMailer.php';

			//           (emisor,receptor,asunto,mensaje)
			$this->sender = new AttachMailer($m, $mr, $a, $contenido);
			$this->sender->attachFile($fichero_ok);
			unlink($fichero_ok);
			$this->sender->send();
			//url para redireccionar
			$this->url = 'https://github.com/Rumpelstiltsquin';
			//redireccionamos a la misma url conforme se ha enviado correctamente con la variable si
			header('Location:'.$this->url.'?s=si');
		}
		else{
			//redireccionamos a la misma url conforme NO se ha enviado correctamente con la variable no
			header('Location:'.$this->url.'?s=no');
		}
	}
}


$obj = new Email();
$obj->enviar($_POST['nombre'], $_POST['email'], $_POST['emailr'], $_POST['asunto'], $_POST['msn'], $_FILES['adjunto']['name']);

?>