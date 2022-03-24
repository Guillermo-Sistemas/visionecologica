<?php
	inlude: "../conexion.php";

if(!empty($_POST)){
	if($_POST['action']=='searchCliente')
	{
		if(!empty($_POST['cliente']))
		{
			$nombre=$_POST['cliente'];

			$query=mysqli_query($conexion,"SELECT * FROM cliente WHERE nombre LIKE '$nombre'");
			mysqli_close($conexion);
			$result=mysqli_num_rows($query);

			$data='';
			
			if($result>0){ 
					$data=mysqli_fetch_assoc($query);
			}else{ 
				$data=0;
			}
			echo json_encode($data, JSON_UNESCAPED_UNICODE);
			
		}
		exit;
	}

















}//fin del empty principal
	



	
    
 ?>
        

