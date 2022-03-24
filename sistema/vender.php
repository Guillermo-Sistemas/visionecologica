<?php
	include "../conexion.php";
	mysqli_set_charset($conexion,'utf8'); 

	session_start();

	if($_SESSION['rol']<1)
    {
		header('location:../');
    }

	$iduser=$_SESSION['idUser'];

	$tipo="";
	$bandera=0;
	$remision="";
	
	$iduser=$_SESSION['idUser'];

	//nuevo cliente en calcular compra
	if (!empty($_POST['nuevocliente'])){
		$nuevocliente=$_POST['nuevocliente'];

		


		$query_insert=mysqli_query($conexion, "INSERT INTO cliente(nit, nombrec, telefono, direccion, tipo_cliente)
                                    VALUES ('0','$nuevocliente', '0', 'No tiene','temporal')");
							$inicio=mysqli_query($conexion, "select MAX(idcliente) from cliente");
							$inicio1= mysqli_fetch_array($inicio);
							$controlcliente=$inicio1[0];

							$idcliente=$controlcliente;
							$nomcliente=$nuevocliente;

	}else{//sin nuevo cliente
		$idcliente=$_POST['idcliente'];
		$nomcliente=$_POST['nomcliente'];
	}

	
	

	if (!empty($_POST['remision']))
		$remision=$_POST['remision'];

		
	$ajuste=$_POST['ajuste'];
	if (!empty($_POST['credito'])){
		$tipo=$_POST['credito'];
	}


	//variables
	$idproducto0=0; $descripcion0=""; $peso0=0; $valor0=0; $subtotal0=0;
	$idproducto1=0; $descripcion1=""; $peso1=0; $valor1=0; $subtotal1=0;
	$idproducto2=0; $descripcion2=""; $peso2=0; $valor2=0; $subtotal2=0;
	$idproducto3=0; $descripcion3=""; $peso3=0; $valor3=0; $subtotal3=0;
	$idproducto4=0; $descripcion4=""; $peso4=0; $valor4=0; $subtotal4=0;
	$idproducto5=0; $descripcion5=""; $peso5=0; $valor5=0; $subtotal5=0;
	$idproducto6=0; $descripcion6=""; $peso6=0; $valor6=0; $subtotal6=0;
	$idproducto7=0; $descripcion7=""; $peso7=0; $valor7=0; $subtotal7=0;
	$idproducto8=0; $descripcion8=""; $peso8=0; $valor8=0; $subtotal8=0;
	$idproducto9=0; $descripcion9=""; $peso9=0; $valor9=0; $subtotal9=0;
	$idproductoA=0; $descripcionA=""; $pesoA=0; $valorA=0; $subtotalA=0;
	$idproductoB=0; $descripcionB=""; $pesoB=0; $valorB=0; $subtotalB=0;

	$subtotalS1=0; $subtotalS2=0; $subtotalS3=0; $subtotalS4=0;
	$subtotalS5=0; $subtotalS6=0; $subtotalS7=0;
	$pesoS1=0; $pesoS2=0; $pesoS3=0; $pesoS4=0;
	$pesoS5=0; $pesoS6=0; $pesoS7=0;
	
	$art1=0; $art2=0; $art3=0;
	$subtotalA1=0; $subtotalA2=0; $subtotalA3=0;

	//DATOS DEL PRODUCTO 0
	if (!empty($_POST['idproducto0'])){
		$idproducto0=$_POST['idproducto0'];
		$descripcion0=$_POST['descripcion0'];
		$peso0=$_POST['peso0'];
		$valor0=$_POST['valor0'];
		$subtotal0=$_POST['subtotal0'];
	}

	//DATOS DEL PRODUCTO 1
    if (!empty($_POST['idproducto1'])){
        $idproducto1=$_POST['idproducto1'];
        $descripcion1=$_POST['descripcion1'];
        $peso1=$_POST['peso1'];
        $valor1=$_POST['valor1'];
        $subtotal1=$_POST['subtotal1'];
    }

	//DATOS DEL PRODUCTO 2
    if (!empty($_POST['idproducto2'])){
        $idproducto2=$_POST['idproducto2'];
        $descripcion2=$_POST['descripcion2'];
        $peso2=$_POST['peso2'];
        $valor2=$_POST['valor2'];
        $subtotal2=$_POST['subtotal2'];
    }

	//DATOS DEL PRODUCTO 3
    if (!empty($_POST['idproducto3'])){
        $idproducto3=$_POST['idproducto3'];
        $descripcion3=$_POST['descripcion3'];
        $peso3=$_POST['peso3'];
        $valor3=$_POST['valor3'];
        $subtotal3=$_POST['subtotal3'];
    }

	//DATOS DEL PRODUCTO 4
    if (!empty($_POST['idproducto4'])){
        $idproducto4=$_POST['idproducto4'];
        $descripcion4=$_POST['descripcion4'];
        $peso4=$_POST['peso4'];
        $valor4=$_POST['valor4'];
        $subtotal4=$_POST['subtotal4'];
    }

	//DATOS DEL PRODUCTO 5
    if (!empty($_POST['idproducto5'])){
        $idproducto5=$_POST['idproducto5'];
        $descripcion5=$_POST['descripcion5'];
        $peso5=$_POST['peso5'];
        $valor5=$_POST['valor5'];
        $subtotal5=$_POST['subtotal5'];
    }


	//DATOS DEL PRODUCTO 6
    if (!empty($_POST['idproducto6'])){
        $idproducto6=$_POST['idproducto6'];
        $descripcion6=$_POST['descripcion6'];
        $peso6=$_POST['peso6'];
        $valor6=$_POST['valor6'];
        $subtotal6=$_POST['subtotal6'];
    }

	//DATOS DEL PRODUCTO 7
    if (!empty($_POST['idproducto7'])){
        $idproducto7=$_POST['idproducto7'];
        $descripcion7=$_POST['descripcion7'];
        $peso7=$_POST['peso7'];
        $valor7=$_POST['valor7'];
        $subtotal7=$_POST['subtotal7'];
    }

	//DATOS DEL PRODUCTO 8
    if (!empty($_POST['idproducto8'])){
        $idproducto8=$_POST['idproducto8'];
        $descripcion8=$_POST['descripcion8'];
        $peso8=$_POST['peso8'];
        $valor8=$_POST['valor8'];
        $subtotal8=$_POST['subtotal8'];
    }

	//DATOS DEL PRODUCTO 9
    if (!empty($_POST['idproducto9'])){
        $idproducto9=$_POST['idproducto9'];
        $descripcion9=$_POST['descripcion9'];
        $peso9=$_POST['peso9'];
        $valor9=$_POST['valor9'];
        $subtotal9=$_POST['subtotal9'];
    }

	//DATOS DEL PRODUCTO A
    if (!empty($_POST['idproductoA'])){
        $idproductoA=$_POST['idproductoA'];
        $descripcionA=$_POST['descripcionA'];
        $pesoA=$_POST['pesoA'];
        $valorA=$_POST['valorA'];
        $subtotalA=$_POST['subtotalA'];
    }

	//DATOS DEL PRODUCTO B
    if (!empty($_POST['idproductoB'])){
        $idproductoB=$_POST['idproductoB'];
        $descripcionB=$_POST['descripcionB'];
        $pesoB=$_POST['pesoB'];
        $valorB=$_POST['valorB'];
        $subtotalB=$_POST['subtotalB'];
    }

	//DATOS DEL SUBPRODUCTO 1
    if (!empty($_POST['idS1'])){
        $idS1=$_POST['idS1'];
        $descripcionS1=$_POST['descripcionS1'];
        $pesoS1=$_POST['pesoS1'];
        $valorS1=$_POST['valorS1'];
        $subtotalS1=$_POST['subtotalS1'];
    }

	//DATOS DEL SUBPRODUCTO 2
    if (!empty($_POST['idS2'])){
        $idS2=$_POST['idS2'];
        $descripcionS2=$_POST['descripcionS2'];
        $pesoS2=$_POST['pesoS2'];
        $valorS2=$_POST['valorS2'];
        $subtotalS2=$_POST['subtotalS2'];
    }

	//DATOS DEL SUBPRODUCTO 3
    if (!empty($_POST['idS3'])){
        $idS3=$_POST['idS3'];
        $descripcionS3=$_POST['descripcionS3'];
        $pesoS3=$_POST['pesoS3'];
        $valorS3=$_POST['valorS3'];
        $subtotalS3=$_POST['subtotalS3'];
    }

	//DATOS DEL SUBPRODUCTO 4
    if (!empty($_POST['idS4'])){
        $idS4=$_POST['idS4'];
        $descripcionS4=$_POST['descripcionS4'];
        $pesoS4=$_POST['pesoS4'];
        $valorS4=$_POST['valorS4'];
        $subtotalS4=$_POST['subtotalS4'];
    }


	//DATOS DEL SUBPRODUCTO 5
    if (!empty($_POST['idS5'])){
        $idS5=$_POST['idS5'];
        $descripcionS5=$_POST['descripcionS5'];
        $pesoS5=$_POST['pesoS5'];
        $valorS5=$_POST['valorS5'];
        $subtotalS5=$_POST['subtotalS5'];
    }

	//DATOS DEL SUBPRODUCTO 6
	if (!empty($_POST['idS6'])){
		$idS6=$_POST['idS6'];
		$descripcionS6=$_POST['descripcionS6'];
		$pesoS6=$_POST['pesoS6'];
		$valorS6=$_POST['valorS6'];
		$subtotalS6=$_POST['subtotalS6'];
	}

	//DATOS DEL SUBPRODUCTO 7
    if (!empty($_POST['idS7'])){
        $idS7=$_POST['idS7'];
        $descripcionS7=$_POST['descripcionS7'];
        $pesoS7=$_POST['pesoS7'];
        $valorS7=$_POST['valorS7'];
        $subtotalS7=$_POST['subtotalS7'];
    }

	if (!empty($_POST['valorA1'])){ 
	    $art1=$_POST['art1'];
		$descripcionA1=$_POST['descripcionA1'];
		$valorA1=$_POST['valorA1'];
		$subtotalA1=$valorA1;
	}

    if (!empty($_POST['valorA2'])){ 
	    $art2=$_POST['art2'];
		$descripcionA2=$_POST['descripcionA2'];
		$valorA2=$_POST['valorA2'];
		$subtotalA2=$valorA2;
	}

	if (!empty($_POST['valorA3'])){ 
	    $art3=$_POST['art3'];
		$descripcionA3=$_POST['descripcionA3'];
		$valorA3=$_POST['valorA3'];
		$subtotalA3=$valorA3;
	}


	$total=$subtotal0+$subtotal1+$subtotal2+$subtotal3+$subtotal4+$subtotal5+$subtotal6+$subtotal7+$subtotal8+$subtotal9+$subtotalA+$subtotalB+
           $subtotalS1+$subtotalS2+$subtotalS3+$subtotalS4+$subtotalS5+$subtotalS6+$subtotalS7+$subtotalA1+$subtotalA2+$subtotalA3;
	$total=round($total);

	

	$modulo=($total%100);

	

	if ($modulo>0 && $modulo<25 ){ 
		$ajuste=-$modulo;
		$total=$total+($ajuste);
		
	}
	if ($modulo>=25 && $modulo<51 ){ 
		$ajuste=50-$modulo;
		if ($ajuste!=0 ){ 
			$total=$total+($ajuste);
		}
	}
	if ($modulo>50 && $modulo<76 ){ 
		$ajuste=$modulo-50;
		$total=$total-($ajuste);
		$ajuste=-$ajuste;	
	}
	if ($modulo>75 && $modulo<101 ){ 
		$ajuste=100-$modulo;
		if ($ajuste!=0 ){ 
			$total=$total+($ajuste);
		}
	}

	

	//echo  "llillo".$total;

	
	//SE GENERA FACTURA
	date_default_timezone_set('America/Bogota');
    $fechaactual2 = Date('Y-m-d H:i:s', time());

	if (!empty($_POST['credito'])){ 
		$tipo=2;

		//echo $tipo."sipi";

		//SE GENERA FACTURA CREDITO
		$query_factura=mysqli_query($conexion, "INSERT INTO facturaV (fecha, usuario, codcliente, ajuste, totalfactura, tipofactura, remision)
		VALUES ('$fechaactual2', '$iduser','$idcliente','$ajuste', '$total', '$tipo', '$remision')");
		$bandera=1;

		//ultima factura
		$numfactura=mysqli_query($conexion, "SELECT MAX(nofacturav) from facturaV");
		$numfactura1= mysqli_fetch_array($numfactura);
		$numerofacturav=$numfactura1[0];

	}else{ 
		//SE GENERA FACTURA
		$query_factura=mysqli_query($conexion, "INSERT INTO facturaV (fecha, usuario, codcliente, ajuste, totalfactura, remision)
                                VALUES ('$fechaactual2', '$iduser','$idcliente','$ajuste', '$total', '$remision')");
								
		//ultima factura
		$numfactura=mysqli_query($conexion, "SELECT MAX(nofacturav) from facturaV");
		$numfactura1= mysqli_fetch_array($numfactura);
		$numerofacturav=$numfactura1[0];

		//SE MODIFICA EL INGRESO
		$inicio=mysqli_query($conexion, "SELECT MAX(idcuadre) from cuadre");
		$inicio1= mysqli_fetch_array($inicio);
		$controlinicial=$inicio1[0];

		$inicio2=mysqli_query($conexion, "SELECT ingresos from cuadre WHERE idcuadre='$controlinicial'");
		$datoinicio=mysqli_fetch_array($inicio2);

		$ingresos= $datoinicio["ingresos"];
		$ingresos=$ingresos+$total;
		$query_cuadre=mysqli_query($conexion, "UPDATE cuadre SET ingresos=$ingresos WHERE idcuadre='$controlinicial'"); 
	}




	//DATOS DEL PRODUCTO 0
	if (!empty($_POST['idproducto0'])){
		
		//se afecta la existencia del producto 0
		$inicio0=mysqli_query($conexion, "SELECT existencia from producto WHERE codproducto='$idproducto0'");
		$datoinicio0=mysqli_fetch_array($inicio0);

		$existencia0= $datoinicio0["existencia"];
		$existencia0=$existencia0-$peso0;
		$query_existencia0=mysqli_query($conexion, "UPDATE producto SET existencia=$existencia0 WHERE codproducto='$idproducto0'");

		//se agrega detalle de la factura producto 0
		$query_producto1 = mysqli_query($conexion, "INSERT INTO detallefacturaV (nofacturav, 
							nomproducto, cantidad, valorkilo,  subtotal)
							VALUES ('$numerofacturav','$descripcion0', '$peso0', '$valor0','$subtotal0')");
	}

	//DATOS DEL PRODUCTO 1
	if (!empty($_POST['idproducto1'])){
		
		//se afecta la existencia del producto 1
		$inicio1=mysqli_query($conexion, "SELECT existencia from producto WHERE codproducto='$idproducto1'");
		$datoinicio1=mysqli_fetch_array($inicio1);

		$existencia1= $datoinicio1["existencia"];
		$existencia1=$existencia1-$peso1;
		$query_existencia1=mysqli_query($conexion, "UPDATE producto SET existencia=$existencia1 WHERE codproducto='$idproducto1'");

		//se agrega detalle de la factura producto 1
		$query_producto1 = mysqli_query($conexion, "INSERT INTO detallefacturaV (nofacturav, 
							nomproducto, cantidad, valorkilo,  subtotal)
							VALUES ('$numerofacturav','$descripcion1', '$peso1', '$valor1','$subtotal1')");
	}

    //DATOS DEL PRODUCTO 2
	if (!empty($_POST['idproducto2'])){
		
		//se afecta la existencia del producto 2
		$inicio2=mysqli_query($conexion, "SELECT existencia from producto WHERE codproducto='$idproducto2'");
		$datoinicio2=mysqli_fetch_array($inicio2);

		$existencia2= $datoinicio2["existencia"];
		$existencia2=$existencia2-$peso2;
		$query_existencia2=mysqli_query($conexion, "UPDATE producto SET existencia=$existencia2 WHERE codproducto='$idproducto2'");

		//se agrega detalle de la factura producto 2
		$query_producto2 = mysqli_query($conexion, "INSERT INTO detallefacturaV (nofacturav, 
						nomproducto, cantidad, valorkilo,  subtotal)
						VALUES ('$numerofacturav','$descripcion2','$peso2', '$valor2','$subtotal2')");
	}


     //DATOS DEL PRODUCTO 3
	if (!empty($_POST['idproducto3'])){
		//se afecta la existencia del producto 3
		$inicio3=mysqli_query($conexion, "SELECT existencia from producto WHERE codproducto='$idproducto3'");
		$datoinicio3=mysqli_fetch_array($inicio3);

		$existencia3= $datoinicio3["existencia"];
		$existencia3=$existencia3-$peso3;
		$query_existencia3=mysqli_query($conexion, "UPDATE producto SET existencia=$existencia3 WHERE codproducto='$idproducto3'");

		 //se agrega detalle de la factura producto 3
		$query_producto3 = mysqli_query($conexion, "INSERT INTO detallefacturaV (nofacturav, 
						nomproducto, cantidad, valorkilo,  subtotal)
						VALUES ('$numerofacturav','$descripcion3', '$peso3', '$valor3','$subtotal3')");
	}


     //DATOS DEL PRODUCTO 4
	
	 if (!empty($_POST['idproducto4'])){
		
		//se afecta la existencia del producto 4
		$inicio4=mysqli_query($conexion, "SELECT existencia from producto WHERE codproducto='$idproducto4'");
		$datoinicio4=mysqli_fetch_array($inicio4);

		$existencia4= $datoinicio4["existencia"];
		$existencia4=$existencia4-$peso4;
		$query_existencia4=mysqli_query($conexion, "UPDATE producto SET existencia=$existencia4 WHERE codproducto='$idproducto4'");

		 //se agrega detalle de la factura producto 4
		$query_producto4 = mysqli_query($conexion, "INSERT INTO detallefacturaV (nofacturav, 
					nomproducto, cantidad, valorkilo,  subtotal)
					VALUES ('$numerofacturav','$descripcion4', '$peso4', '$valor4','$subtotal4')");
	}

    //DATOS DEL PRODUCTO 5
	
	 if (!empty($_POST['idproducto5'])){
		
		//se afecta la existencia del producto 5
		$inicio5=mysqli_query($conexion, "SELECT existencia from producto WHERE codproducto='$idproducto5'");
		$datoinicio5=mysqli_fetch_array($inicio5);

		$existencia5= $datoinicio5["existencia"];
		$existencia5=$existencia5-$peso5;
		$query_existencia5=mysqli_query($conexion, "UPDATE producto SET existencia=$existencia5 WHERE codproducto='$idproducto5'");

		 //se agrega detalle de la factura producto 5
		$query_producto5 = mysqli_query($conexion, "INSERT INTO detallefacturaV (nofacturav, 
					nomproducto, cantidad, valorkilo,  subtotal)
					VALUES ('$numerofacturav','$descripcion5', '$peso5', '$valor5','$subtotal5')");
	}

//DATOS DEL PRODUCTO 6
	
	 if (!empty($_POST['idproducto6'])){
		
		//se afecta la existencia del producto 6
		$inicio6=mysqli_query($conexion, "SELECT existencia from producto WHERE codproducto='$idproducto6'");
		$datoinicio6=mysqli_fetch_array($inicio6);

		$existencia6= $datoinicio6["existencia"];
		$existencia6=$existencia6-$peso6;
		$query_existencia6=mysqli_query($conexion, "UPDATE producto SET existencia=$existencia6 WHERE codproducto='$idproducto6'");

		 //se agrega detalle de la factura producto 6
		$query_producto6 = mysqli_query($conexion, "INSERT INTO detallefacturaV (nofacturav, 
					nomproducto, cantidad, valorkilo,  subtotal)
					VALUES ('$numerofacturav','$descripcion6', '$peso6', '$valor6','$subtotal6')");
	}

    //DATOS DEL PRODUCTO 7
	
	 if (!empty($_POST['idproducto7'])){
		
		//se afecta la existencia del producto 7
		$inicio7=mysqli_query($conexion, "SELECT existencia from producto WHERE codproducto='$idproducto7'");
		$datoinicio7=mysqli_fetch_array($inicio7);

		$existencia7= $datoinicio7["existencia"];
		$existencia7=$existencia7-$peso7;
		$query_existencia7=mysqli_query($conexion, "UPDATE producto SET existencia=$existencia7 WHERE codproducto='$idproducto7'");

		 //se agrega detalle de la factura producto 7
		$query_producto7 = mysqli_query($conexion, "INSERT INTO detallefacturaV (nofacturav, 
					nomproducto, cantidad, valorkilo,  subtotal)
					VALUES ('$numerofacturav','$descripcion7', '$peso7', '$valor7','$subtotal7')");
	}

    //DATOS DEL PRODUCTO 8
	
	 if (!empty($_POST['idproducto8'])){
		
		//se afecta la existencia del producto 8
		$inicio8=mysqli_query($conexion, "SELECT existencia from producto WHERE codproducto='$idproducto8'");
		$datoinicio8=mysqli_fetch_array($inicio8);

		$existencia8= $datoinicio8["existencia"];
		$existencia8=$existencia8-$peso8;
		$query_existencia8=mysqli_query($conexion, "UPDATE producto SET existencia=$existencia8 WHERE codproducto='$idproducto8'");

		 //se agrega detalle de la factura producto 8
		$query_producto8 = mysqli_query($conexion, "INSERT INTO detallefacturaV (nofacturav, 
					nomproducto, cantidad, valorkilo,  subtotal)
					VALUES ('$numerofacturav','$descripcion8', '$peso8', '$valor8','$subtotal8')");
	}

    //DATOS DEL PRODUCTO 9
	
	 if (!empty($_POST['idproducto9'])){
		
		//se afecta la existencia del producto 9
		$inicio9=mysqli_query($conexion, "SELECT existencia from producto WHERE codproducto='$idproducto9'");
		$datoinicio9=mysqli_fetch_array($inicio9);

		$existencia9= $datoinicio9["existencia"];
		$existencia9=$existencia9-$peso9;
		$query_existencia9=mysqli_query($conexion, "UPDATE producto SET existencia=$existencia9 WHERE codproducto='$idproducto9'");

		 //se agrega detalle de la factura producto 9
		$query_producto9 = mysqli_query($conexion, "INSERT INTO detallefacturaV (nofacturav, 
					nomproducto, cantidad, valorkilo,  subtotal)
					VALUES ('$numerofacturav','$descripcion9', '$peso9', '$valor9','$subtotal9')");
	}

    //DATOS DEL PRODUCTO A
	
	 if (!empty($_POST['idproductoA'])){
		
		//se afecta la existencia del producto A
		$inicioA=mysqli_query($conexion, "SELECT existencia from producto WHERE codproducto='$idproductoA'");
		$datoinicioA=mysqli_fetch_array($inicioA);

		$existenciaA= $datoinicioA["existencia"];
		$existenciaA=$existenciaA-$pesoA;
		$query_existenciaA=mysqli_query($conexion, "UPDATE producto SET existencia=$existenciaA WHERE codproducto='$idproductoA'");

		 //se agrega detalle de la factura producto A
		$query_productoA = mysqli_query($conexion, "INSERT INTO detallefacturaV (nofacturav, 
					nomproducto, cantidad, valorkilo,  subtotal)
					VALUES ('$numerofacturav','$descripcionA', '$pesoA', '$valorA','$subtotalA')");
	}

    //DATOS DEL PRODUCTO B
	
	 if (!empty($_POST['idproductoB'])){
		
		//se afecta la existencia del producto B
		$inicioB=mysqli_query($conexion, "SELECT existencia from producto WHERE codproducto='$idproductoB'");
		$datoinicioB=mysqli_fetch_array($inicioB);

		$existenciaB= $datoinicioB["existencia"];
		$existenciaB=$existenciaB-$pesoB;
		$query_existenciaB=mysqli_query($conexion, "UPDATE producto SET existencia=$existenciaB WHERE codproducto='$idproductoB'");

		 //se agrega detalle de la factura producto B
		$query_productoB = mysqli_query($conexion, "INSERT INTO detallefacturaV (nofacturav, 
					nomproducto, cantidad, valorkilo,  subtotal)
					VALUES ('$numerofacturav','$descripcionB', '$pesoB', '$valorB','$subtotalB')");
	}




   

   

     //QUERY DEL SUBPRODUCTO 1
    if (!empty($_POST['idS1'])){
	   
	    //se BUSCA EL PRODUCTO DEL SUBPRODUCTO
	    $inicioS1=mysqli_query($conexion, "SELECT codproducto from subproducto WHERE codsubproducto='$idS1'");
        $datoinicioS1=mysqli_fetch_array($inicioS1);
	    $idproductoS1=$datoinicioS1["codproducto"];

	    //se afecta la existencia del producto 1
	    $queryS1=mysqli_query($conexion, "SELECT existencia from producto WHERE codproducto='$idproductoS1'");
        $queryinicioS1=mysqli_fetch_array($queryS1);

        $existenciaS1= $queryinicioS1["existencia"];
       	$existenciaS1=$existenciaS1-$pesoS1;
	    $query_existenciaS1=mysqli_query($conexion, "UPDATE producto SET existencia=$existenciaS1 WHERE codproducto='$idproductoS1'");

	    //se agrega detalle de la factura subproducto 1
	    $query_S1 = mysqli_query($conexion, "INSERT INTO detallefacturaV (nofacturav, 
									    nomproducto, codproducto, cantidad, valorkilo,  subtotal)
									    VALUES ('$numerofacturav','$descripcionS1','$idproductoS1', 
									    '$pesoS1', '$valorS1','$subtotalS1')");
    }

    //QUERY DEL SUBPRODUCTO 2
    if (!empty($_POST['idS2'])){
	   
	    //se BUSCA EL PRODUCTO DEL SUBPRODUCTO
	    $inicioS2=mysqli_query($conexion, "SELECT codproducto from subproducto WHERE codsubproducto='$idS2'");
        $datoinicioS2=mysqli_fetch_array($inicioS2);
	    $idproductoS2=$datoinicioS2["codproducto"];

	    //se afecta la existencia del producto 2
	    $queryS2=mysqli_query($conexion, "SELECT existencia from producto WHERE codproducto='$idproductoS2'");
        $queryinicioS2=mysqli_fetch_array($queryS2);

        $existenciaS2= $queryinicioS2["existencia"];
       	$existenciaS2=$existenciaS2-$pesoS2;
	    $query_existenciaS2=mysqli_query($conexion, "UPDATE producto SET existencia=$existenciaS2 WHERE codproducto='$idproductoS2'");

	    //se agrega detalle de la factura subproducto 2
	    $query_S2 = mysqli_query($conexion, "INSERT INTO detallefacturaV (nofacturav, 
									    nomproducto, codproducto, cantidad, valorkilo,  subtotal)
									    VALUES ('$numerofacturav','$descripcionS2','$idproductoS2', 
									    '$pesoS2', '$valorS2','$subtotalS2')");
    }

    //QUERY DEL SUBPRODUCTO 3
    if (!empty($_POST['idS3'])){
	   
	    //se BUSCA EL PRODUCTO DEL SUBPRODUCTO
	    $inicioS3=mysqli_query($conexion, "SELECT codproducto from subproducto WHERE codsubproducto='$idS3'");
        $datoinicioS3=mysqli_fetch_array($inicioS3);
	    $idproductoS3=$datoinicioS3["codproducto"];

	    //se afecta la existencia del producto 3
	    $queryS3=mysqli_query($conexion, "SELECT existencia from producto WHERE codproducto='$idproductoS3'");
        $queryinicioS3=mysqli_fetch_array($queryS3);

        $existenciaS3= $queryinicioS3["existencia"];
       	$existenciaS3=$existenciaS3-$pesoS3;
	    $query_existenciaS3=mysqli_query($conexion, "UPDATE producto SET existencia=$existenciaS3 WHERE codproducto='$idproductoS3'");

	    //se agrega detalle de la factura subproducto 3
	    $query_S3 = mysqli_query($conexion, "INSERT INTO detallefacturaV (nofacturav, 
									    nomproducto, codproducto, cantidad, valorkilo,  subtotal)
									    VALUES ('$numerofacturav','$descripcionS3','$idproductoS3', 
									    '$pesoS3', '$valorS3','$subtotalS3')");
    }

    //QUERY DEL SUBPRODUCTO 4
    if (!empty($_POST['idS4'])){
	   
	    //se BUSCA EL PRODUCTO DEL SUBPRODUCTO
	    $inicioS4=mysqli_query($conexion, "SELECT codproducto from subproducto WHERE codsubproducto='$idS4'");
        $datoinicioS4=mysqli_fetch_array($inicioS4);
	    $idproductoS4=$datoinicioS4["codproducto"];

	    //se afecta la existencia del producto 4
	    $queryS4=mysqli_query($conexion, "SELECT existencia from producto WHERE codproducto='$idproductoS4'");
        $queryinicioS4=mysqli_fetch_array($queryS4);

        $existenciaS4= $queryinicioS4["existencia"];
       	$existenciaS4=$existenciaS4-$pesoS4;
	    $query_existenciaS4=mysqli_query($conexion, "UPDATE producto SET existencia=$existenciaS4 WHERE codproducto='$idproductoS4'");

	    //se agrega detalle de la factura subproducto 4
	    $query_S4 = mysqli_query($conexion, "INSERT INTO detallefacturaV (nofacturav, 
									    nomproducto, codproducto, cantidad, valorkilo,  subtotal)
									    VALUES ('$numerofacturav','$descripcionS4','$idproductoS4', 
									    '$pesoS4', '$valorS4','$subtotalS4')");
    }

    //QUERY DEL SUBPRODUCTO 5
    if (!empty($_POST['idS5'])){
	   
	    //se BUSCA EL PRODUCTO DEL SUBPRODUCTO
	    $inicioS5=mysqli_query($conexion, "SELECT codproducto from subproducto WHERE codsubproducto='$idS5'");
        $datoinicioS5=mysqli_fetch_array($inicioS5);
	    $idproductoS5=$datoinicioS5["codproducto"];

	    //se afecta la existencia del producto 5
	    $queryS5=mysqli_query($conexion, "SELECT existencia from producto WHERE codproducto='$idproductoS5'");
        $queryinicioS5=mysqli_fetch_array($queryS5);

        $existenciaS5= $queryinicioS5["existencia"];
       	$existenciaS5=$existenciaS5-$pesoS5;
	    $query_existenciaS5=mysqli_query($conexion, "UPDATE producto SET existencia=$existenciaS5 WHERE codproducto='$idproductoS5'");

	    //se agrega detalle de la factura subproducto 5
	    $query_S5 = mysqli_query($conexion, "INSERT INTO detallefacturaV (nofacturav, 
									    nomproducto, codproducto, cantidad, valorkilo,  subtotal)
									    VALUES ('$numerofacturav','$descripcionS5','$idproductoS5', 
									    '$pesoS5', '$valorS5','$subtotalS5')");
    }

    //QUERY DEL SUBPRODUCTO 6
    if (!empty($_POST['idS6'])){
	   
	    //se BUSCA EL PRODUCTO DEL SUBPRODUCTO
	    $inicioS6=mysqli_query($conexion, "SELECT codproducto from subproducto WHERE codsubproducto='$idS6'");
        $datoinicioS6=mysqli_fetch_array($inicioS6);
	    $idproductoS6=$datoinicioS6["codproducto"];

	    //se afecta la existencia del producto 6
	    $queryS6=mysqli_query($conexion, "SELECT existencia from producto WHERE codproducto='$idproductoS6'");
        $queryinicioS6=mysqli_fetch_array($queryS6);

        $existenciaS6= $queryinicioS6["existencia"];
       	$existenciaS6=$existenciaS6-$pesoS6;
	    $query_existenciaS6=mysqli_query($conexion, "UPDATE producto SET existencia=$existenciaS6 WHERE codproducto='$idproductoS6'");

	    //se agrega detalle de la factura subproducto 6
	    $query_S6 = mysqli_query($conexion, "INSERT INTO detallefacturaV (nofacturav, 
									    nomproducto, codproducto, cantidad, valorkilo,  subtotal)
									    VALUES ('$numerofacturav','$descripcionS6','$idproductoS6', 
									    '$pesoS6', '$valorS6','$subtotalS6')");
    }

    //QUERY DEL SUBPRODUCTO 7
    if (!empty($_POST['idS7'])){
	   
	    //se BUSCA EL PRODUCTO DEL SUBPRODUCTO
	    $inicioS7=mysqli_query($conexion, "SELECT codproducto from subproducto WHERE codsubproducto='$idS7'");
        $datoinicioS7=mysqli_fetch_array($inicioS7);
	    $idproductoS7=$datoinicioS7["codproducto"];

	    //se afecta la existencia del producto 7
	    $queryS7=mysqli_query($conexion, "SELECT existencia from producto WHERE codproducto='$idproductoS7'");
        $queryinicioS7=mysqli_fetch_array($queryS7);

        $existenciaS7= $queryinicioS7["existencia"];
       	$existenciaS7=$existenciaS7-$pesoS7;
	    $query_existenciaS7=mysqli_query($conexion, "UPDATE producto SET existencia=$existenciaS7 WHERE codproducto='$idproductoS7'");

	    //se agrega detalle de la factura subproducto 7
	    $query_S7 = mysqli_query($conexion, "INSERT INTO detallefacturaV (nofacturav, 
									    nomproducto, codproducto, cantidad, valorkilo,  subtotal)
									    VALUES ('$numerofacturav','$descripcionS7','$idproductoS7', 
									    '$pesoS7', '$valorS7','$subtotalS7')");
    }




    //query del articulo 1
	if (!empty($_POST['valorA1'])){
		//$codrecuperado=$_POST['codrecuperado1'];

		date_default_timezone_set('America/Bogota');
		$fechaactual2 = Date('Y-m-d H:i:s', time());
		

		$inicio1=mysqli_query($conexion,"UPDATE recuperado SET fechaventa_recuperado='$fechaactual2',
								precioventa_recuperado=$valorA1, 
								idcliente=$idcliente, nofactura=$numerofacturav, estatus=2
								WHERE codrecuperado=$art1");
		//se consulta el articulo
		$query=mysqli_query($conexion,"SELECT descripcion_recuperado, peso_recuperado, precioventa_recuperado 
		FROM recuperado WHERE codrecuperado=$art1 ");

		$result =mysqli_num_rows($query);

		if($result > 0){
				while($data=mysqli_fetch_array($query)){
					$descripcionA1=$data['descripcion_recuperado'];
					
				}

		//se agrega detalle de la factura articulo 1
		$query_articulo1 = mysqli_query($conexion, "INSERT INTO detallefacturaV (nofacturav, 
							nomproducto, cantidad, valorkilo,  subtotal)
							VALUES ('$numerofacturav','$descripcionA1', 1 , '$valorA1','$valorA1')");
		}
	}

     //query del articulo 2
	if (!empty($_POST['valorA2'])){
		//$codrecuperado=$_POST['codrecuperado2'];

		date_default_timezone_set('America/Bogota');
		$fechaactual2 = Date('Y-m-d H:i:s', time());
		

		//los articulos vendidos quedan en estatus 2
		$inicio1=mysqli_query($conexion,"UPDATE recuperado SET fechaventa_recuperado='$fechaactual2',
								precioventa_recuperado=$valorA2, 
								idcliente=$idcliente, nofactura=$numerofacturav, estatus=2
								WHERE codrecuperado=$art2");
		//se consulta el articulo
		$query=mysqli_query($conexion,"SELECT descripcion_recuperado, peso_recuperado, precioventa_recuperado 
		FROM recuperado WHERE codrecuperado=$art2 ");

		$result =mysqli_num_rows($query);

		if($result > 0){
				while($data=mysqli_fetch_array($query)){
					$descripcionA2=$data['descripcion_recuperado'];
					
				}

		//se agrega detalle de la factura articulo 2
		$query_articulo2 = mysqli_query($conexion, "INSERT INTO detallefacturaV (nofacturav, 
							nomproducto, cantidad, valorkilo,  subtotal)
							VALUES ('$numerofacturav','$descripcionA2', 1 , '$valorA2','$valorA2')");
		}
	}

     //query del articulo 3
	if (!empty($_POST['valorA3'])){
		//$codrecuperado=$_POST['codrecuperado3'];

		date_default_timezone_set('America/Bogota');
		$fechaactual2 = Date('Y-m-d H:i:s', time());
		

		//los articulos vendidos quedan en estatus 2
		$inicio1=mysqli_query($conexion,"UPDATE recuperado SET fechaventa_recuperado='$fechaactual2',
								precioventa_recuperado=$valorA3, 
								idcliente=$idcliente, nofactura=$numerofacturav, estatus=2
								WHERE codrecuperado=$art3");
		//se consulta el articulo
		$query=mysqli_query($conexion,"SELECT descripcion_recuperado, peso_recuperado, precioventa_recuperado 
		FROM recuperado WHERE codrecuperado=$art3 ");

		$result =mysqli_num_rows($query);

		if($result > 0){
				while($data=mysqli_fetch_array($query)){
					$descripcionA3=$data['descripcion_recuperado'];
					
				}

		//se agrega detalle de la factura articulo 3
		$query_articulo3 = mysqli_query($conexion, "INSERT INTO detallefacturaV (nofacturav, 
							nomproducto, cantidad, valorkilo,  subtotal)
							VALUES ('$numerofacturav','$descripcionA3', 1 , '$valorA3','$valorA3')");
		}
	}



    
//para mostrar con punto
$total=number_format($total, 0, ",", ".");

?>



<!DOCTYPE html>
<html lang="es">
<head>
	<meta charset="UTF-8">
	<?php
		include "include/scripts.php";
	?>
	<title>Vender</title>
	
</head>
<body>
	<?php
		include "include/header.php";
		include "include/nav.php";
	?>
	
	<section class="contenido">
        	
	<div class="datos_cliente">	
		<div class="title_page">
			<h1><i class="fas fa-cube"></i>Recibo de Venta</h1>
		</div>
				
			<form name="form_new_cliente_venta" id="form_new_cliente_venta" class="datos" action="Vender.php" method="POST">
					

					<div class="wd100">
						<h4>Nombre del Cliente</h4>
					</div>

					<tr>
						<th colspan="1"><input type="hidden" name="idcliente" id="idcliente" value="<?php echo $idcliente; ?>"></th>
						<td colspan="2"><input type="text" name="nomcliente" id="nomcliente" readonly="readonly" value="<?php echo $nomcliente; ?>"></td>
					
						<?php
						if($remision!=""){?>
						<div class="wd50">
							<h4>Remisión</h4>
						</div>
						<td colspan="1"><input type="text" name="remision" id="remision" readonly="readonly" value="<?php echo $remision; ?>"></td>
						<?php
						}
						?>	

					</tr>
					
					
					
					

					<div class="wd100">
						<h4>Detalle de la Venta</h4>
					</div>




			<table class="tbl_venta">
			<thead>
				
				<tr>
					<th colspan="1">Descripción</th>
					<th colspan="1">Total Peso</th>
					<th colspan="2">Valor Venta</th>
					<th colspan="2">Subtotal</th>
				</tr>
			</thead>
			<tbody id="detalle_venta">


				
				<?php

                if($peso0 >0)
					{
					?>
					<tr>
						<input type="hidden" name="idproducto0" id="idproducto0" value="<?php echo $idproducto0; ?>">
						<td colspan="1">
							<input type="text" name="descripcion0" id="descripcion0" readonly="readonly" value="<?php echo $descripcion0; ?>">
						</td>
						
						<td colspan="1">
							<input type="number" name="peso0" id="peso0" readonly="readonly" value="<?php echo $peso0; ?>">
						</td>
						<td colspan="2">
							<input type="number" name="valor0" id="valor0"  readonly="readonly" value="<?php echo $valor0; ?>">
						</td>
						<td colspan="2">
							<input type="number" name="subtotal0" id="subtotal0" value="<?php echo $subtotal0; ?>">
						</td>
					</tr>
					<?php
					}
					
				if($peso1 >0)
					{
					?>
					<tr>
                        <input type="hidden" name="idproducto1" id="idproducto1" value="<?php echo $idproducto1; ?>">
                        <td colspan="1">
                            <input type="text" name="descripcion1" id="descripcion1" readonly="readonly" value="<?php echo $descripcion1; ?>">
                        </td>
                        
                        <td colspan="1">
                            <input type="number" name="peso1" id="peso1" readonly="readonly" value="<?php echo $peso1; ?>">
                        </td>
                        <td colspan="2">
                            <input type="number" name="valor1" id="valor1"  readonly="readonly" value="<?php echo $valor1; ?>">
                        </td>
                        <td colspan="2">
                            <input type="number" name="subtotal1" id="subtotal1" value="<?php echo $subtotal1; ?>">
                        </td>
                    </tr>

					<?php
					}
					if($peso2 >0 )
					{
					
						?>
						<tr>
							
							<input type="hidden" name="idproducto2" id="idproducto2" value="<?php echo $idproducto2; ?>">
							
							<td colspan="1">
								<input type="text" name="descripcion2" id="descripcion2" readonly="readonly" value="<?php echo $descripcion2; ?>">
							</td>
							
							<td colspan="1">
								<input type="number" name="peso2" id="peso2" readonly="readonly" value="<?php echo $peso2; ?>">
							</td>
							<td colspan="2">
								<input type="number" name="valor2" id="valor2" readonly="readonly" value="<?php echo $valor2; ?>">
							</td>
							<td colspan="2">
								<input type="number" name="subtotal2" id="subtotal2"  value="<?php echo $subtotal2; ?>">
							</td>
						</tr>
						<?php
						
					}
					if($peso3>0)
					{
					?>
					<tr>
						<input type="hidden" name="idproducto3" id="idproducto3" value="<?php echo $idproducto3; ?>">
						<td colspan="1">
							<input type="text" name="descripcion3" id="descripcion3" readonly="readonly" value="<?php echo $descripcion3; ?>">
						</td>
						
						<td colspan="1">
							<input type="number" name="peso3" id="peso3" readonly="readonly" value="<?php echo $peso3; ?>">
						</td>
						<td colspan="2">
							<input type="number" name="valor3" id="valor3"  readonly="readonly" value="<?php echo $valor3; ?>">
						</td>
						<td colspan="2">
							<input type="number" name="subtotal3" id="subtotal3"  value="<?php echo $subtotal3; ?>">
						</td>
					</tr>
					<?php
                    }
					if($peso4>0)
					{
					?>
					<tr>
						<input type="hidden" name="idproducto4" id="idproducto4" value="<?php echo $idproducto4; ?>">
						<td colspan="1">
							<input type="text" name="descripcion4" id="descripcion4" readonly="readonly" value="<?php echo $descripcion4; ?>">
						</td>
						
						<td colspan="1">
							<input type="number" name="peso4" id="peso4" readonly="readonly" value="<?php echo $peso4; ?>">
						</td>
						<td colspan="2">
							<input type="number" name="valor4" id="valor4"  readonly="readonly" value="<?php echo $valor4; ?>">
						</td>
						<td colspan="2">
							<input type="number" name="subtotal4" id="subtotal4"  value="<?php echo $subtotal4; ?>">
						</td>
					</tr>
                    <?php
                    }
					if($peso5>0)
					{
					?>
					<tr>
						<input type="hidden" name="idproducto5" id="idproducto5" value="<?php echo $idproducto5; ?>">
						<td colspan="1">
							<input type="text" name="descripcion5" id="descripcion5" readonly="readonly" value="<?php echo $descripcion5; ?>">
						</td>
						
						<td colspan="1">
							<input type="number" name="peso5" id="peso5" readonly="readonly" value="<?php echo $peso5; ?>">
						</td>
						<td colspan="2">
							<input type="number" name="valor5" id="valor5"  readonly="readonly" value="<?php echo $valor5; ?>">
						</td>
						<td colspan="2">
							<input type="number" name="subtotal5" id="subtotal5"  value="<?php echo $subtotal5; ?>">
						</td>
					</tr>
                    <?php
                    }
					if($peso6>0)
					{
					?>
					<tr>
						<input type="hidden" name="idproducto6" id="idproducto6" value="<?php echo $idproducto6; ?>">
						<td colspan="1">
							<input type="text" name="descripcion6" id="descripcion6" readonly="readonly" value="<?php echo $descripcion6; ?>">
						</td>
						
						<td colspan="1">
							<input type="number" name="peso6" id="peso6" readonly="readonly" value="<?php echo $peso6; ?>">
						</td>
						<td colspan="2">
							<input type="number" name="valor6" id="valor6"  readonly="readonly" value="<?php echo $valor6; ?>">
						</td>
						<td colspan="2">
							<input type="number" name="subtotal6" id="subtotal6"  value="<?php echo $subtotal6; ?>">
						</td>
					</tr>
                    <?php                    
                     }
                    if($peso7>0)
					{
					?>
					<tr>
                        <input type="hidden" name="idproducto7" id="idproducto7" value="<?php echo $idproducto7; ?>">
                        <td colspan="1">
                            <input type="text" name="descripcion7" id="descripcion7" readonly="readonly" value="<?php echo $descripcion7; ?>">
                        </td>
                        
                        <td colspan="1">
                            <input type="number" name="peso7" id="peso7" readonly="readonly" value="<?php echo $peso7; ?>">
                        </td>
                        <td colspan="2">
                            <input type="number" name="valor7" id="valor7"  readonly="readonly" value="<?php echo $valor7; ?>">
                        </td>
                        <td colspan="2">
                            <input type="number" name="subtotal7" id="subtotal7"  value="<?php echo $subtotal7; ?>">
                        </td>
                    </tr>

                    <?php
                    }

                    if($peso8>0)
					{
					?>
					<tr>
						<input type="hidden" name="idproducto8" id="idproducto8" value="<?php echo $idproducto8; ?>">
						<td colspan="1">
							<input type="text" name="descripcion8" id="descripcion8" readonly="readonly" value="<?php echo $descripcion8; ?>">
						</td>
						
						<td colspan="1">
							<input type="number" name="peso8" id="peso8" readonly="readonly" value="<?php echo $peso8; ?>">
						</td>
						<td colspan="2">
							<input type="number" name="valor8" id="valor8"  readonly="readonly" value="<?php echo $valor8; ?>">
						</td>
						<td colspan="2">
							<input type="number" name="subtotal8" id="subtotal8"  value="<?php echo $subtotal8; ?>">
						</td>
					</tr>
                    <?php
                    }
                    if($peso9>0)
					{
					?>
					<tr>
                        <input type="hidden" name="idproducto9" id="idproducto9" value="<?php echo $idproducto9; ?>">
                        <td colspan="1">
                            <input type="text" name="descripcion9" id="descripcion9" readonly="readonly" value="<?php echo $descripcion9; ?>">
                        </td>
                        
                        <td colspan="1">
                            <input type="number" name="peso9" id="peso9" readonly="readonly" value="<?php echo $peso9; ?>">
                        </td>
                        <td colspan="2">
                            <input type="number" name="valor9" id="valor9"  readonly="readonly" value="<?php echo $valor9; ?>">
                        </td>
                        <td colspan="2">
                            <input type="number" name="subtotal9" id="subtotal9"  value="<?php echo $subtotal9; ?>">
                        </td>
                    </tr>

                    <?php
                    }
                    if($pesoA>0)
					{
					?>
					<tr>
						<input type="hidden" name="idproductoA" id="idproductoA" value="<?php echo $idproductoA; ?>">
						<td colspan="1">
							<input type="text" name="descripcionA" id="descripcionA" readonly="readonly" value="<?php echo $descripcionA; ?>">
						</td>
						
						<td colspan="1">
							<input type="number" name="pesoA" id="pesoA" readonly="readonly" value="<?php echo $pesoA; ?>">
						</td>
						<td colspan="2">
							<input type="number" name="valorA" id="valorA"  readonly="readonly" value="<?php echo $valorA; ?>">
						</td>
						<td colspan="2">
							<input type="number" name="subtotalA" id="subtotalA"  value="<?php echo $subtotalA; ?>">
						</td>
					</tr>
                    <?php
                    }
                     if($pesoB>0)
					{
					?>
					<tr>
						<input type="hidden" name="idproductoB" id="idproductoB" value="<?php echo $idproductoB; ?>">
						<td colspan="1">
							<input type="text" name="descripcionB" id="descripcionB" readonly="readonly" value="<?php echo $descripcionB; ?>">
						</td>
						
						<td colspan="1">
							<input type="number" name="pesoB" id="pesoB" readonly="readonly" value="<?php echo $pesoB; ?>">
						</td>
						<td colspan="2">
							<input type="number" name="valorB" id="valorB"  readonly="readonly" value="<?php echo $valorB; ?>">
						</td>
						<td colspan="2">
							<input type="number" name="subtotalB" id="subtotalB"  value="<?php echo $subtotalB; ?>">
						</td>
					</tr>
                    <?php
                    }
                    
					//subproductos
					if($pesoS1>0)
					{
					?>
					<tr>
						<input type="hidden" name="idS1" id="idS1" value="<?php echo $idS1; ?>">
						<td colspan="1">
							<input type="text" name="descripcionS1" id="descripcionS1" readonly="readonly" value="<?php echo $descripcionS1; ?>">
						</td>
						
						<td colspan="1">
							<input type="number" name="pesoS1" id="pesoS1" readonly="readonly" value="<?php echo $pesoS1; ?>">
						</td>
						<td colspan="2">
							<input type="number" name="valorS1" id="valorS1"  readonly="readonly" value="<?php echo $valorS1; ?>">
						</td>
						<td colspan="2">
							<input type="number" name="subtotalS1" id="subtotalS1"  value="<?php echo $subtotalS1; ?>">
						</td>
					</tr>
                    <?php
                    }
                    if($pesoS2>0)
					{
					?>
					<tr>
						<input type="hidden" name="idS2" id="idS2" value="<?php echo $idS2; ?>">
						<td colspan="1">
							<input type="text" name="descripcionS2" id="descripcionS2" readonly="readonly" value="<?php echo $descripcionS2; ?>">
						</td>
						
						<td colspan="1">
							<input type="number" name="pesoS2" id="pesoS2" readonly="readonly" value="<?php echo $pesoS2; ?>">
						</td>
						<td colspan="2">
							<input type="number" name="valorS2" id="valorS2"  readonly="readonly" value="<?php echo $valorS2; ?>">
						</td>
						<td colspan="2">
							<input type="number" name="subtotalS2" id="subtotalS2"  value="<?php echo $subtotalS2; ?>">
						</td>
					</tr>
                    <?php
                    }
					if($pesoS3>0)
					{
					?>
					<tr>
						<input type="hidden" name="idS3" id="idS3" value="<?php echo $idS3; ?>">
						<td colspan="1">
							<input type="text" name="descripcionS3" id="descripcionS3" readonly="readonly" value="<?php echo $descripcionS3; ?>">
						</td>
						
						<td colspan="1">
							<input type="number" name="pesoS3" id="pesoS3" readonly="readonly" value="<?php echo $pesoS3; ?>">
						</td>
						<td colspan="2">
							<input type="number" name="valorS3" id="valorS3"  readonly="readonly" value="<?php echo $valorS3; ?>">
						</td>
						<td colspan="2">
							<input type="number" name="subtotalS3" id="subtotalS3"  value="<?php echo $subtotalS3; ?>">
						</td>
					</tr>
                    <?php
                    }
                    if($pesoS4>0)
                    {
                    ?>
                    <tr>
                        <input type="hidden" name="idS4" id="idS4" value="<?php echo $idS4; ?>">
                        <td colspan="1">
                            <input type="text" name="descripcionS4" id="descripcionS4" readonly="readonly" value="<?php echo $descripcionS4; ?>">
                        </td>
                        
                        <td colspan="1">
                            <input type="number" name="pesoS4" id="pesoS4" readonly="readonly" value="<?php echo $pesoS4; ?>">
                        </td>
                        <td colspan="2">
                            <input type="number" name="valorS4" id="valorS4"  readonly="readonly" value="<?php echo $valorS4; ?>">
                        </td>
                        <td colspan="2">
                            <input type="number" name="subtotalS4" id="subtotalS4"  value="<?php echo $subtotalS4; ?>">
                        </td>
                    </tr>
                    <?php
                    }
                    if($pesoS5>0)
                    {
                    ?>
                    <tr>
                        <input type="hidden" name="idS5" id="idS5" value="<?php echo $idS5; ?>">
                        <td colspan="1">
                            <input type="text" name="descripcionS5" id="descripcionS5" readonly="readonly" value="<?php echo $descripcionS5; ?>">
                        </td>
                        
                        <td colspan="1">
                            <input type="number" name="pesoS5" id="pesoS5" readonly="readonly" value="<?php echo $pesoS5; ?>">
                        </td>
                        <td colspan="2">
                            <input type="number" name="valorS5" id="valorS5"  readonly="readonly" value="<?php echo $valorS5; ?>">
                        </td>
                        <td colspan="2">
                            <input type="number" name="subtotalS5" id="subtotalS5"  value="<?php echo $subtotalS5; ?>">
                        </td>
                    </tr>
                    <?php
                    }
                    if($pesoS6>0)
                    {
                    ?>
                    <tr>
                        <input type="hidden" name="idS6" id="idS6" value="<?php echo $idS6; ?>">
                        <td colspan="1">
                            <input type="text" name="descripcionS6" id="descripcionS6" readonly="readonly" value="<?php echo $descripcionS6; ?>">
                        </td>
                        
                        <td colspan="1">
                            <input type="number" name="pesoS6" id="pesoS6" readonly="readonly" value="<?php echo $pesoS6; ?>">
                        </td>
                        <td colspan="2">
                            <input type="number" name="valorS6" id="valorS6"  readonly="readonly" value="<?php echo $valorS6; ?>">
                        </td>
                        <td colspan="2">
                            <input type="number" name="subtotalS6" id="subtotalS6"  value="<?php echo $subtotalS6; ?>">
                        </td>
                    </tr>
                    <?php
                    }
					if($pesoS7>0)
                    {
                    ?>
                    <tr>
                        <input type="hidden" name="idS7" id="idS7" value="<?php echo $idS7; ?>">
                        <td colspan="1">
                            <input type="text" name="descripcionS7" id="descripcionS7" readonly="readonly" value="<?php echo $descripcionS7; ?>">
                        </td>
                        
                        <td colspan="1">
                            <input type="number" name="pesoS7" id="pesoS7" readonly="readonly" value="<?php echo $pesoS7; ?>">
                        </td>
                        <td colspan="2">
                            <input type="number" name="valorS7" id="valorS7"  readonly="readonly" value="<?php echo $valorS7; ?>">
                        </td>
                        <td colspan="2">
                            <input type="number" name="subtotalS7" id="subtotalS7"  value="<?php echo $subtotalS7; ?>">
                        </td>
                    </tr>
                    <?php
                    }
                    if($art1>0 )
                    {
						

						//echo $art1;
                    ?>
                    <tr>
                        <input type="hidden" name="art1" id="art1" value="<?php echo $art1; ?>">
                        <td colspan="2">
                            <input type="text" name="descripcionA1" id="descripcionA1" readonly="readonly" value="<?php echo $descripcionA1; ?>">
                        </td>
                        
                        
                        <td colspan="2">
                            <input type="number" name="valorA1" id="valorA1"  readonly="readonly" value="<?php echo $valorA1; ?>">
                        </td>
                        <td colspan="2">
                            <input type="number" name="subtotalA1" id="subtotalA1" readonly="readonly"  value="<?php echo $subtotalA1; ?>">
                        </td>
                    </tr>
                    <?php
                    }
                    if($art2>0 )
                    {
                    ?>
                    <tr>
                        <input type="hidden" name="art2" id="art2" value="<?php echo $art2; ?>">
                        <td colspan="2">
                            <input type="text" name="descripcionA2" id="descripcionA2" readonly="readonly" value="<?php echo $descripcionA2; ?>">
                        </td>
                        
                        
                        <td colspan="2">
                            <input type="number" name="valorA2" id="valorA2"  readonly="readonly" value="<?php echo $valorA2; ?>">
                        </td>
                        <td colspan="2">
                            <input type="number" name="subtotalA2" id="subtotalA2" readonly="readonly"  value="<?php echo $subtotalA2; ?>">
                        </td>
                    </tr>
                    <?php
                    }
					if($art3>0 )
                    {
                    ?>
                    <tr>
                        <input type="hidden" name="art3" id="art3" value="<?php echo $art3; ?>">
                        <td colspan="2">
                            <input type="text" name="descripcionA3" id="descripcionA3" readonly="readonly" value="<?php echo $descripcionA3; ?>">
                        </td>
                        
                        
                        <td colspan="2">
                            <input type="number" name="valorA3" id="valorA3"  readonly="readonly" value="<?php echo $valorA3; ?>">
                        </td>
                        <td colspan="2">
                            <input type="number" name="subtotalA3" id="subtotalA3" readonly="readonly"  value="<?php echo $subtotalA3; ?>">
                        </td>
                    </tr>
                    <?php
                    }
                    ?>


				<tr>
					<td colspan="1">
						<h1><input type="hidden" name="total" id="total" readonly="readonly" value="<?php echo $total; ?>"></h1>
					</td>
					<td colspan="1">
						<h1><input type="hidden" name="ajuste" id="ajuste" readonly="readonly" value="<?php echo $ajuste; ?>"></h1>
					</td>
				</tr>
				<tr>
					<td colspan="3">
							<label><h1><?php echo "Ajuste   $".$ajuste; ?></h1></label>
					</td>				
					<td colspan="3">
							<label><h1><?php echo "Total a Cobrar   $".$total; ?></h1></label>
					</td>
				</tr>



				


				

				
			</tbody>
		</table>	

		<div class="wd30"><a href="facturaV_pdf.php" target="_blank">
		<input type="button" class="btn_imp" value="Imprimir POS" />
		</a></div>

		<div class="wd30"><a href="facturaV2_pdf.php" target="_blank">
		<input type="button" class="btn_imp2" value="Imprimir Recibo" />
		</a></div>

					<div class="wd30"><input type="button" onclick=" location.href='nueva_venta.php'" target="_blank" 
					                value="Realizar Otra Venta" name="boton" class="btn_procesar"  /></div>


					
					
					
			</form>
		</div>
			<

		
	</section>
		
</body>
</html>
