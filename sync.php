<?php


	die();

	$echo = (isset($_GET['echo'])?$_GET['echo']:"");

	$echo = ($echo == 'off')?false:true;



	if($echo)

	{

?>

	<style>



		body

		{

			font-family: Arial;

		}



	</style>

<?php

	}



	set_time_limit (200);

	define('BASEPATH', '/');

	define('DATA_PATH','/home/bricks/data/');

	define('REMOTE_PATH','/FTP-TXT/');

	define('ZIP_FILE','Century21.zip');

	
	$id_oficina = 23646;

	$ftp_server="173.243.114.132"; 

        $ftp_user_name="extsync@century21.com.ve";
        
        $ftp_user_pass="$7century7$";
	//$ftp_user_name="bricc1@century21.com.ve"; 

	//$ftp_user_pass="nBr2013Ccs$%";

	$local_file = DATA_PATH.ZIP_FILE;

	$local_path = DATA_PATH;

	$remote_file = REMOTE_PATH.ZIP_FILE;



	if($echo)

	{

		echo "Conectando al FTP...<br/>";

		flush();

	}



	$conn_id = ftp_connect($ftp_server);



	if($echo)

	{

		echo "Conexión establecida<br/>";

		echo "Iniciando sesión...<br/>";

		flush();	

	} else {
                echo "No se pudo conectar al server con esas credenciales";
                die();
        }



	$login_result = ftp_login($conn_id, $ftp_user_name, $ftp_user_pass); 



	if($echo)

	{

		echo "Conectado<br/><br/>";

		flush();	

	} else {
	
		echo "No se pudo autenticar con las credenciales";
		die();
	
	}



	ftp_pasv($conn_id, true);



	if($echo)

	{

		echo "Descargando ".ZIP_FILE."....<br />";

    	flush();

    }



    if (ftp_get($conn_id, $local_file, $remote_file, FTP_BINARY)) 

    {

	    if($echo)

	    {

	    	echo "Se ha guardado satisfactoriamente en $local_file<br/><br/>";

	    	flush();

		}

	} 

	else 

	{

	    die("Hubo un problema en la transferencia del archivo");

	}



	// close the connection 

	ftp_close($conn_id);



	if($echo)

	{

		echo "Extrayendo los archivos<br/>";

		flush();	

	}

	system("unzip $local_file");
	die;

	/*
	$zip = new ZipArchive;

	if ($zip->open($local_file) === TRUE)

	{

	    $zip->extractTo($local_path);

	    $zip->close();

	}

	else

	{

	    die('Hubo un problema en la extracción');

	}
	*/



	if($echo)

	{

		echo "Conectado a la Base de Datos<br/><br />";

		flush();	

	}

	

	$db = mysql_connect("127.0.0.1", "bricks_pagina", "NVSFVBO9UX11IUKTV6") or die("Could not connect.");



	$registros = 0;



	if(!$db)

		die("no db");







	if(!mysql_select_db("bricks_century21",$db))

		die("No database selected.");



		



	if($echo)

	{

		$time_start = microtime(true);

	}



	



	// Importamos las Ciudades

	if (($gestor = fopen(DATA_PATH."ciudades.csv", "r")) !== FALSE) {

		mysql_query("DELETE FROM ciudades");

		while (($datos = fgetcsv($gestor, 1000, ",",'"')) !== FALSE) {



			$import = "INSERT INTO ciudades values ($datos[0],'$datos[1]','$datos[2]')";



			mysql_query($import);



			$registros++;



		}



		fclose($gestor);



	}







	//Cambiamos las ciudades Caracas - Baruta, Caracas - Chacao, Caracas - El Hatillo y Caracas - Sucre a Distrito Capital



	mysql_query("update ciudades set id_estado = 'Distrito Capital' where id in (57481,57214,57238,57157)");	



	mysql_query("update ciudades set id_estado = 'Distrito Capital' where id_estado = 'Distrito Federal'");	



	



	if($echo)



	{



		$time_end = microtime(true);



		$time = $time_end - $time_start;



		echo "Importación de Ciudades completada<br />";



		echo "Tiempo de ejecución: $time segundos<br />";	



		echo "Registros importados $registros<br /><br />";



		flush();



		$time_start = microtime(true);



		$registros = 0;



	}



	



	// Importamos las Urbanizaciones



	if (($gestor = fopen(DATA_PATH."urbanizaciones.csv", "r")) !== FALSE) {



		mysql_query("DELETE FROM urbanizaciones");



		while (($datos = fgetcsv($gestor, 1000, ",",'"')) !== FALSE) {



			$import = "INSERT INTO urbanizaciones values ($datos[0],'$datos[1]','$datos[2]')";



			mysql_query($import) ;



			$registros++;



		}



		fclose($gestor);



	}



	



	if($echo)



	{



		$time_end = microtime(true);



		$time = $time_end - $time_start;



		echo "Importación de Urbanizaciones completada<br />";



		echo "Tiempo de ejecución: $time segundos<br />";	



		echo "Registros importados $registros<br /><br />";



		flush();



		$time_start = microtime(true);



		$registros = 0;



	}



	



	// Importamos las Propiedades



	if (($gestor = fopen(DATA_PATH."propiedades.csv", "r")) !== FALSE) {



		mysql_query("DELETE FROM propiedades");







		while (($datos = fgetcsv($gestor, 0, ",",'"')) !== FALSE) {



			$import = "INSERT INTO propiedades values (



											 '".mysql_real_escape_string($datos[0])."',



											 '".mysql_real_escape_string($datos[1])."',



											 '".mysql_real_escape_string($datos[2])."',



											 '".mysql_real_escape_string($datos[3])."',



											 '".mysql_real_escape_string($datos[4])."',



											 '".mysql_real_escape_string($datos[5])."',



											 '".mysql_real_escape_string($datos[6])."',



											 '".mysql_real_escape_string($datos[7])."',



											 '".mysql_real_escape_string($datos[8])."',



											 '".mysql_real_escape_string($datos[9])."',



											 '".mysql_real_escape_string($datos[10])."',



											 '".mysql_real_escape_string($datos[11])."',



											 trim('".mysql_real_escape_string($datos[12])."'),



											 '".mysql_real_escape_string($datos[13])."',



											 '".mysql_real_escape_string($datos[14])."',



											 '".mysql_real_escape_string($datos[15])."',



											 '".mysql_real_escape_string($datos[16])."',



											 '".mysql_real_escape_string($datos[17])."',



											 '".mysql_real_escape_string($datos[18])."',



											 '".mysql_real_escape_string($datos[19])."',



											 '".mysql_real_escape_string($datos[20])."',



											 '".mysql_real_escape_string($datos[21])."',



											 '".mysql_real_escape_string($datos[22])."',



											 '".mysql_real_escape_string($datos[23])."',



											 '".mysql_real_escape_string($datos[24])."',



											 '".mysql_real_escape_string($datos[25])."'



											 )";



											 



			$result = mysql_query("SELECT * FROM propiedades where id_mls = '".mysql_real_escape_string($datos[1])."'");



			$num_rows = mysql_num_rows($result);		



			if($num_rows==0)



			{



				mysql_query($import);



				$registros++;



			}



		}



		fclose($gestor);



	}



	//Actualizacion de las propiedades en Caracas - Baruta, Caracas - Chacao, Caracas - El Hatillo y Caracas - Sucre a Distrito Capital



	mysql_query("update propiedades set estado = 'DISTRITO CAPITAL' where id_ciudad in (57481,57214,57238,57157)") ;



	



	//Actualizacion DISTRITO FEDERAL A DISTRITO CAPITAL



	mysql_query("update propiedades set estado = 'DISTRITO CAPITAL' where estado = 'DISTRITO FEDERAL'") ;



	



	//Cambiamos el Tipo de Negocio "Pre-Venta" a Venta



	mysql_query("update propiedades set tipo_negocio = 'Venta' where tipo_negocio = 'Pre-Venta'") ;



	



	//Cambiamos a null las propiedades sin Urbanizacion



	mysql_query("update propiedades set id_urbanizacion = null where id_urbanizacion = 0") ;



	



	//Eliminamos las propiedades con precio menor a 1



	mysql_query("delete from propiedades where precio < 1 ");



	



	if($echo)



	{



		$time_end = microtime(true);



		$time = $time_end - $time_start;



		echo "Importación de Propiedades completada<br />";



		echo "Tiempo de ejecución: $time segundos<br />";	



		echo "Registros importados $registros<br /><br />";



		flush();



		$time_start = microtime(true);



		$registros = 0;



	}

	



	// Importamos las Fotos



	if (($gestor = fopen(DATA_PATH."media.csv", "r")) !== FALSE) {



		mysql_query("DELETE FROM media");



		while (($datos = fgetcsv($gestor, 1000, ",",'"')) !== FALSE) {



			$import = "INSERT INTO media values ('$datos[0]','$datos[1]')";



			mysql_query($import);



			$registros++;



		}



		fclose($gestor);



	}



	



	if($echo)



	{



		$time_end = microtime(true);



		$time = $time_end - $time_start;



		echo "Importación de Fotos completada<br />";



		echo "Tiempo de ejecución: $time segundos<br />";	



		echo "Registros importados $registros<br /><br />";



		flush();



		$time_start = microtime(true);



	}



	$sql = "INSERT INTO asesores( id, nombre, telefono, celular, email ) 

		SELECT DISTINCT id_asesor, @agente := agente, 

		@telefono:=agente_telefono, @celular:=agente_celular, @mail:=agente_email

		FROM propiedades

		WHERE id_oficina =$id_oficina ON DUPLICATE 

		KEY UPDATE nombre = @agente, telefono=@telefono, celular=@celular, email:=@mail";

	

	mysql_query($sql);



	$resultado = mysql_query("SELECT email,id FROM `asesores` WHERE `status` = 1");



	while ($fila = mysql_fetch_assoc($resultado)) 

	{

			$ccs_result = split("@",$fila['email']);

			$id = $ccs_result[0];



		    $server_output = curl_get ("http://www.century21.com.ve/@$id");

			$server_output = split("http://200.74.221.42/getmedia.asp\?id=",$server_output);

	

		    $id = substr($server_output[1],0,8);



			mysql_query("UPDATE asesores SET media='$id' WHERE id=".$fila['id']);

	}



	if($echo)

	{

		echo "Eliminando archivos temporales<br/><br/>";

		flush();

	}



	unlink($local_file);

	$mask = DATA_PATH."*.csv";

   	array_map( "unlink", glob( $mask ) );



   	if($echo)

	{

		echo "Proceso culminado con éxito.<br/><br/>";

		flush();

	}



	function curl_get($url) 

	 {    

	     $defaults = array( 

	         CURLOPT_URL => $url, 

	         CURLOPT_HEADER => 0, 

	         CURLOPT_RETURNTRANSFER => TRUE, 

	     ); 

     

	     $ch = curl_init(); 

	     curl_setopt_array($ch, $defaults); 

	     if( ! $result = curl_exec($ch)) 

	     { 

	         //trigger_error(curl_error($ch)); 

	     } 

	     curl_close($ch); 

	     return $result; 

	 } 