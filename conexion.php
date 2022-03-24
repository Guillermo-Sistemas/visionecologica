<?php
//conectar a la base de datos

	$host="localhost";
	$usuario="root";
	$clave="";
	$bd="visionecologica";

	$conexion=mysqli_connect($host,$usuario,$clave,$bd);

	//mysqli_close($conexion);	
	if(!$conexion){
		echo("ERROR EN LA CONEXIÓN");
	}
?>

