<?php

session_start();
$iduser=$_SESSION['idUser'];
$cuadreanterior=0;
$saldoanterior=0;
$productos="";


include "../conexion.php";

if(!empty($_GET['id'])){
    $idcuadre=$_GET['id'];
    $cuadreanterior=$idcuadre-1;
}else{ 
    //se recupera el id del ultimo cuadre
    $inicio=mysqli_query($conexion, "select MAX(idcuadre) from cuadre");
    $inicio1= mysqli_fetch_array($inicio);
    $idcuadre=$inicio1[0];
    $cuadreanterior=$idcuadre-1;

}




$razon= ""; $nitempre= ""; $telefono= ""; $direccion=""; $ciudad= "";
$fecha=""; $totalventas=-1; $totalventascre=0;

$totalegr=0; $totalcompras=0;   $totalgastos=0; $cobro=0; $pago=0;




$query_usuario=mysqli_query($conexion, "select nombre from usuario WHERE idusuario='$iduser'");
    $query_usuario1= mysqli_fetch_array($query_usuario);
    $iduser=$query_usuario1[0];

$base=0;

$alert="";

//Saldo cuadre anterior
if ($idcuadre>1){
$inicio2=mysqli_query($conexion, "select * from cuadre WHERE idcuadre='$cuadreanterior'");
$datoinicio=mysqli_fetch_array($inicio2);

    $saldoanterior= $datoinicio["saldo"];
}

//datos del cuadre
$inicio2=mysqli_query($conexion, "select * from cuadre WHERE idcuadre='$idcuadre'");
$datoinicio=mysqli_fetch_array($inicio2);

    $controlinicio= $datoinicio["estatus"];
    $fechaopen= $datoinicio["fechaInicial"];
    $ingresos= $datoinicio["ingresos"];
    $egresos= $datoinicio["egresos"];
    $cobro= $datoinicio["cobro"];
    $pago= $datoinicio["pago"];
    
    $saldo= $datoinicio["saldo"];
    $idusuario_open= $datoinicio["idusuario_abre"];
    $idusuario_close= $datoinicio["idusuario_cierra"];
    $fechaclosed= $datoinicio["fechaFinal"];

//solo la fecha del cuadre
$queryfecha=mysqli_query($conexion, "select DATE(fechaInicial) from cuadre WHERE idcuadre='$idcuadre'");
$queryfecha1=mysqli_fetch_array($queryfecha);
$fecha= $queryfecha1["DATE(fechaInicial)"];
        
//consulta los datos de la empresa
$empresa=mysqli_query($conexion, "select * from configuracion");
$empresa2=mysqli_fetch_array($empresa);

    $razon= $empresa2["razon_social"];
    $nitempre= $empresa2["nit"];
    $telefono= $empresa2["telefono"];
    $direccion= $empresa2["direccion"];
    $ciudad= $empresa2["ciudad"];


    //query total bases

    $querytotalbase=mysqli_query($conexion, "select sum(valorbase) as totalbases FROM base WHERE idcuadre='$idcuadre'");
    $querytotalbase1= mysqli_fetch_array($querytotalbase);
    $totalbase= $querytotalbase1[0];

    //query total ventas contado
     $queryventas=mysqli_query($conexion, "select fecha, sum(totalfactura) as totalventas FROM facturav 
                                           WHERE DATE(fecha)='$fecha' and estatus!=0 and tipofactura=1");
    $queryventas1= mysqli_fetch_array($queryventas);
    if ($queryventas1> 0){ 
        $totalventas= $queryventas1["totalventas"];
     }

     //query total ventas credito
     $queryventascre=mysqli_query($conexion, "select fecha, sum(totalfactura) as totalventas FROM facturav 
                                           WHERE DATE(fecha)='$fecha' and estatus!=0 and tipofactura=2");
    $queryventascre1= mysqli_fetch_array($queryventascre);
    if ($queryventascre1> 0){ 
        $totalventascre= $queryventascre1["totalventas"];
     }
        

    //query total compras
    $querycompras=mysqli_query($conexion, "select fecha, sum(totalfactura) as totalcompras FROM factura 
                    WHERE DATE(fecha)='$fecha' and estatus=1 and tipofactura=1");
    $querycompras1= mysqli_fetch_array($querycompras);
    $totalcompras= $querycompras1[1];

     //query total compras credito
     $querycomprascred=mysqli_query($conexion, "select fecha, sum(totalfactura) as totalcompras FROM factura 
     WHERE DATE(fecha)='$fecha' and estatus=1 and tipofactura=2");
        $querycomprascred1= mysqli_fetch_array($querycomprascred);
        $totalcomprascred= $querycomprascred1[1];


    //query total gastos
    $querygastos=mysqli_query($conexion, "select fechagasto, sum(valorgasto) as totalgastos FROM gasto 
                    WHERE DATE(fechagasto)='$fecha' and estatus!=0 ");
    $querygastos1= mysqli_fetch_array($querygastos);
    $totalgastos= $querygastos1[1];
    


    $query_open=mysqli_query($conexion, "select nombre from usuario WHERE idusuario='$idusuario_open'");
    $query_open1= mysqli_fetch_array($query_open);
    $idusuario_open=$query_open1[0];

    $query_close=mysqli_query($conexion, "select nombre from usuario WHERE idusuario='$idusuario_close'");
    $query_close1= mysqli_fetch_array($query_close);
    $idusuario_close=$query_close1[0];

    $final=$saldoanterior+$totalbase+$totalventas-($totalcompras+$totalgastos)-$saldo-$pago+$cobro;

    $final=$final*-1;

    $fin=number_format($final, 0, ",", ".");
    
    

    $cierre="Cuadre Cerrado con Faltante ".($fin);

    if($final==0){
        $cierre="Cuadre Cerrado OK"; 
    }elseif($final>0){
        $cierre="Cuadre Cerrado con Sobrante  ".($fin); 
    }





    


    if($controlinicio==1)
    {
        echo "<script>alert('El Cuadre no se ha Cerrado ')</script>";
        echo "<script>window.close();</script>";
    }

    else{

        require('fpdf/fpdf.php');

        class PDF extends FPDF
        {
        // Cabecera de página
        

        // Pie de página
        function Footer()
        {
            // Posición: a 1,5 cm del final
            $this->SetY(-20);
            // Arial italic 8
            $this->SetFont('Arial','I',10);
            $this->Cell(0,6,utf8_decode(' Generado por TIS@ - Desarrollo de Software '),0,1,'C');
            // Número de página
            $this->Cell(0,6,utf8_decode(' Página ').$this->PageNo().'/{nb}',0,0,'C');
        }
        }


        //('P','mm',array(215,280)); // Tamaño tickt 80mm x 150 mm (largo aprox)
        $pdf = new PDF('P','mm',array(215,280));
        $pdf -> AliasNbPages();
        $pdf->AddPage();


            $pdf->SetFont('Arial','B',20);
            // Movernos a la derecha
            $pdf->Cell(60);
            // Título
           $pdf->Cell(80,8,utf8_decode($razon),0,1,'C');
            $pdf->SetFont('Helvetica','',16);
            $pdf->Cell(50);
            $pdf->Cell(95,8,"NIT ".$nitempre,0,1,'C');
            $pdf->Cell(50);
            $pdf->Cell(50,8,$direccion,0,0,'R');
            $pdf->Cell(50,8,$telefono,0,1,'L');
            $pdf->Cell(50);
            $pdf->Cell(95,8,utf8_decode($ciudad),0,1,'C');
            $pdf->Ln(5);
            $pdf->Cell(60);
            $pdf->SetFont('Arial','B',22);
            $pdf->Cell(80,8,utf8_decode('CUADRE DE CAJA'),0,1,'C');
            // Salto de línea
            $pdf->Ln(10);





        $pdf->SetFont('Arial','B',14);
        $pdf->Cell(70,7, "Impreso por:", 0 , 0 , 'L', 0 );
        $pdf->SetFont('Arial','',14);
        $pdf->Cell(110,7, $iduser, 0 , 1 , 'L', 0 );
        $pdf->SetFont('Arial','B',14);
        $pdf->Cell(70,7, "Fecha y Hora de Apertura:", 0 , 0 , 'L', 0 );
        $pdf->SetFont('Arial','',14);
        $pdf->Cell(110,7, $fechaopen, 0 , 1 , 'L', 0 );
        $pdf->SetFont('Arial','B',14);
        $pdf->Cell(70,7, "Abierto por:", 0 , 0 , 'L', 0 );
        $pdf->SetFont('Arial','',14);
        $pdf->Cell(110,7, $idusuario_open, 0 , 1 , 'L', 0 );
        $pdf->SetFont('Arial','B',14);
        $pdf->Cell(70,7, "Fecha y Hora de Cierre:", 0 , 0 , 'L', 0 );
        $pdf->SetFont('Arial','',14);
        $pdf->Cell(110,7, $fechaclosed, 0 , 1 , 'L', 0 );
        $pdf->SetFont('Arial','B',14);
        $pdf->Cell(70,7, "Cerrado por:", 0 , 0 , 'L', 0 );
        $pdf->SetFont('Arial','',14);
        $pdf->Cell(110,7, $idusuario_close, 0 , 1 , 'L', 0 );
        $pdf->SetFont('Arial','B',14);
        $pdf->Cell(70,7, "Saldo Reportado:", 0 , 0 , 'L', 0 );
        $sr=number_format($saldo, 0, ",", ".");
        $pdf->Cell(110,7, "$ " .$sr, 0 , 1 , 'L', 0 );
        $pdf->SetFont('Arial','B',16);
        $pdf->Cell(70,7, "Cuadre Cerrado:", 0 , 0 , 'L', 0 );
        $pdf->Cell(110,7, $cierre, 0 , 1 , 'L', 0 );

        $pdf->Cell(170,0,'','T');
        $pdf->Ln(3);
        $pdf->SetFont('Arial','B',14);
        $pdf->Cell(70,7, "Saldo Anterior:", 0 , 0 , 'L', 0 );
        $pdf->SetFont('Arial','',14);
        $san=number_format($saldoanterior, 0, ",", ".");
        $pdf->Cell(130,7, "$ " .$san, 0 , 1 , 'L', 0 );
        $pdf->SetFont('Arial','B',14);


        
        $pdf->Cell(70,7, "Bases:", 0 , 0 , 'L', 0 );
        $pdf->SetFont('Arial','',14);
        $tbs=number_format($totalbase, 0, ",", ".");
        $pdf->Cell(110,7, "$ " .$tbs, 0 , 1 , 'L', 0 );
        $pdf->SetFont('Arial','B',14);

        if ($totalventas>0){ 
            $pdf->Cell(70,7, "Ventas de Contado:", 0 , 0 , 'L', 0 );
            $tvs=number_format($totalventas, 0, ",", ".");
            $pdf->Cell(110,7, "$ " .$tvs, 0 , 1 , 'L', 0 );
        }else{ 
            $pdf->Cell(70,7, "Ventas de Contado:", 0 , 0 , 'L', 0 );
            $pdf->Cell(110,7, "$ 0 " , 0 , 1 , 'L', 0 );
         }


        $pdf->Cell(170,0,'','T');
        $pdf->Ln(3);

        $totaling=$saldoanterior+$totalbase+$totalventas;
        $pdf->SetFont('Arial','B',18);
        $pdf->Cell(70,7, "TOTAL INGRESOS:", 0 , 0 , 'L', 0 );
        $tig=number_format($totaling, 0, ",", ".");
        $pdf->Cell(110,7, "$ ". $tig, 0 , 1 , 'L', 0 );

        

        
        
        $pdf->Cell(170,0,'','T');
        $pdf->Ln(3);


         //mostrar VALOR ventas a credito

         if ($totalventascre>0){ 
            $pdf->Cell(70,7, utf8_decode( "Ventas a Crédito:"), 0 , 0 , 'L', 0 );
            $tvc=number_format($totalventascre, 0, ",", ".");
            $pdf->Cell(110,7, "$ " .$tvc, 0 , 1 , 'L', 0 );
        }else{ 
            $pdf->Cell(70,7, utf8_decode( "Ventas a Crédito:"), 0 , 0 , 'L', 0 );
            $pdf->Cell(110,7, "$ 0 " , 0 , 1 , 'L', 0 );
         }

        $pdf->Cell(170,0,'','T');
        $pdf->Ln(3);

        if ($cobro>0){ 
            $pdf->Cell(90,7, utf8_decode( "Ventas a Crédito Cobradas:"), 0 , 0 , 'L', 0 );
            $cobro=number_format($cobro, 0, ",", ".");
            $pdf->Cell(90,7, "$ " .$cobro, 0 , 1 , 'L', 0 );
        }else{ 
            $pdf->Cell(90,7, utf8_decode( "Ventas a Crédito  Cobradas:"), 0 , 0 , 'L', 0 );
            $pdf->Cell(90,7, "$ 0 " , 0 , 1 , 'L', 0 );
         }

         $pdf->Ln(3);

         if ($pago>0){ 
            $pdf->Cell(90,7, utf8_decode( "Compras a Crédito Pagadas:"), 0 , 0 , 'L', 0 );
            $pago=number_format($pago, 0, ",", ".");
            $pdf->Cell(90,7, "$ " .$pago, 0 , 1 , 'L', 0 );
        }else{ 
            $pdf->Cell(90,7, utf8_decode( "Compras a Crédito Pagadas:"), 0 , 0 , 'L', 0 );
            $pdf->Cell(90,7, "0"  , 0 , 1 , 'L', 0 );
         }

        $pdf->Cell(170,0,'','T');
        $pdf->Ln(3);


        $pdf->SetFont('Arial','B',14);
        
        $pdf->Cell(70,7, "Compras:", 0 , 0 , 'L', 0 );
        $pdf->SetFont('Arial','',14);
        $tco=number_format($totalcompras, 0, ",", ".");
        $pdf->Cell(110,7, "$ ".$tco, 0 , 1 , 'L', 0 );
        $pdf->SetFont('Arial','B',14);

        if ($totalgastos>0){

            $pdf->Cell(70,7, "Gastos:", 0 , 0 , 'L', 0 );
            $pdf->SetFont('Arial','',14);
            $tga=number_format($totalgastos, 0, ",", ".");
            $pdf->Cell(110,7, "$ ".$tga, 0 , 1 , 'L', 0 );
        }else{
            $pdf->Cell(70,7, "Gastos:", 0 , 0 , 'L', 0 );
            $pdf->SetFont('Arial','',14);
            $pdf->Cell(110,7, "$ 0 ", 0 , 1 , 'L', 0 );
        }


        $pdf->Cell(170,0,'','T');
        $pdf->Ln(3);

        $totalegr=$totalcompras+$totalgastos;
        $pdf->SetFont('Arial','B',18);
        $pdf->Cell(70,7, "TOTAL EGRESOS:", 0 , 0 , 'L', 0 );
        $teg=number_format($totalegr, 0, ",", ".");
        $pdf->Cell(110,7, "$ ". $teg, 0 , 1 , 'L', 0 );

        

        $pdf->Cell(170,0,'','T');
        $pdf->Ln(6);



        

        if ($totalcomprascred>0){

            $pdf->Cell(70,7, utf8_decode("Compras a Crédito :"), 0 , 0 , 'L', 0 );
            $tcc=number_format($totalcomprascred, 0, ",", ".");
            $pdf->Cell(110,7, "$ ".$tcc, 0 , 1 , 'L', 0 );
        }

        $pdf->Cell(170,0,'','T');
        $pdf->Ln(6);

 
//BASES

$pdf->SetFont('Arial','B',16);
$pdf->Cell(180,4,utf8_decode('BASES INGRESADAS'),0,1,'C');
// Salto de línea
$pdf->Ln(3);

 // COLUMNAS

 $pdf->SetFont('Helvetica', 'B', 14);
 $pdf->Cell(20, 10, 'HORA', 0);
 $pdf->Cell(130, 10, 'NOTA',0,0,'C');
 $pdf->Cell(35, 10, 'VALOR',0,0,'L');
 
 $pdf->Ln(10);

  $query=mysqli_query($conexion,"SELECT time(b.fechabase) as hour, b.valorbase, b.notabase, u.nombre FROM base b 
                        INNER JOIN usuario u ON b.idusuario=u.idusuario WHERE idcuadre='$idcuadre'");
    $result =mysqli_num_rows($query);
					
	if($result > 0){
        while($data=mysqli_fetch_array($query)){

            $pdf->Cell(30, 8, $data["hour"], 1,0,'L');
            
            $pdf->Cell(125, 8, substr($data["notabase"],0,50), 1,0,'L');

            $bs=number_format($data["valorbase"], 0, ",", ".");
            $pdf->Cell(35, 8, "$ ".$bs, 1,1,'L');
           
        }
    }

//GASTOS
if ($totalgastos>0){
        $pdf->Ln(6);
        $pdf->SetFont('Arial','B',16);
        $pdf->Cell(180,4,utf8_decode('GASTOS'),0,1,'C');
        // Salto de línea
        $pdf->Ln(3);

        // COLUMNAS

        $pdf->SetFont('Helvetica', 'B', 14);
        $pdf->Cell(50, 10, 'TIPO', 0);
        $pdf->Cell(60, 10, 'TERCERO',0,0,'L');
        $pdf->Cell(35, 10, 'VALOR',0,0,'L');
        $pdf->Cell(55, 10, 'RESPONSABLE',0,0,'L');
        $pdf->Ln(10);

            $query=mysqli_query($conexion,"SELECT g.idtipogasto, g.idcliente, g.valorgasto, u.nombre FROM gasto g INNER JOIN
                                            usuario u ON g.idusuario=u.idusuario  WHERE idcuadre='$idcuadre' ");
            $result =mysqli_num_rows($query);
                            
            if($result > 0){
                while($data=mysqli_fetch_array($query)){

                    $gasto=$data["idtipogasto"];
                    $querygasto=mysqli_query($conexion, "select nombregasto from tipo_gasto WHERE idtipogasto='$gasto'");
                    $datogasto=mysqli_fetch_array($querygasto);
                    $gasto= $datogasto["nombregasto"];

                    $idcliente=$data["idcliente"];
                    $queryidcliente=mysqli_query($conexion, "select nombrec from cliente WHERE idcliente='$idcliente'");
                    $datocliente=mysqli_fetch_array($queryidcliente);
                    $idcliente= $datocliente["nombrec"];
                    $gasto=substr($gasto,0,18);
                    $pdf->Cell(50, 8, $gasto, 1,0,'L');
                    $idcliente=substr($idcliente,0,18);
                    $pdf->Cell(60, 8, $idcliente, 1,0,'L');

                    $gt=number_format($data["valorgasto"], 0, ",", ".");

                    $pdf->Cell(35, 8, $gt, 1,0,'L');
                    $pdf->Cell(55, 8, substr($data["nombre"],0,18), 1,1,'L');
                }
            }
    }

    //COMPRAS
$pdf->Ln(8);
$pdf->SetFont('Arial','B',16);
$pdf->Cell(180,4,utf8_decode('COMPRAS DE CONTADO'),0,1,'C');
// Salto de línea
$pdf->Ln(3);

 // COLUMNAS

 $pdf->SetFont('Helvetica', 'B', 14);
 $pdf->Cell(65, 10, 'PRODUCTO', 0);
 $pdf->Cell(35, 10, 'CANTIDAD',0,0,'L');
 $pdf->Cell(45, 10, 'VALOR KILO',0,0,'L');
 $pdf->Cell(55, 10, 'VALOR TOTAL',0,0,'L');
 $pdf->Ln(10);

  $query=mysqli_query($conexion,"SELECT d.nomproducto, f.nofactura, SUM(d.cantidad) as subtotales, SUM(d.subtotal) as totales  , 
                        d.valorkilo FROM detallefactura d INNER JOIN factura f ON d.nofactura=f.nofactura 
                        WHERE DATE(f.fecha)='$fecha' and tipofactura=1 and estatus=1 GROUP BY d.nomproducto ORDER BY totales DESC ");
    $result =mysqli_num_rows($query);
					
	if($result > 0){
        while($data=mysqli_fetch_array($query)){

            $pdf->Cell(65, 7, $data["nomproducto"], 1,0,'L');
            $pdf->Cell(35, 7, $data["subtotales"], 1,0,'L');

            $vk=number_format($data["valorkilo"], 0, ",", ".");

            $pdf->Cell(45, 7, "$ ".$vk, 1,0,'L');

            $modulo=$data["totales"]%10;

            if ($modulo>0 && $modulo<5){ 
                $data["totales"]=$data["totales"]-$modulo;   
             }else{ 
                if($modulo!=0){ 
                    $data["totales"]=$data["totales"]-$modulo+10;
                 }
            }


            $tt=number_format($data["totales"], 0, ",", ".");
            $pdf->Cell(55, 7, "$ ".$tt, 1,1,'L');
        }
    }




    //COMPRAS POR VALOR
$pdf->Ln(8);
$pdf->SetFont('Arial','B',16);
$pdf->Cell(180,4,utf8_decode('DISCRIMINADO COMPRAS POR VALOR'),0,1,'C');
// Salto de línea
$pdf->Ln(3);

 // COLUMNAS

 $pdf->SetFont('Helvetica', 'B', 14);
 $pdf->Cell(65, 10, 'PRODUCTO', 0);
 $pdf->Cell(35, 10, 'CANTIDAD',0,0,'L');
 $pdf->Cell(45, 10, 'VALOR KILO',0,0,'L');
 $pdf->Cell(55, 10, 'VALOR TOTAL',0,0,'L');
 $pdf->Ln(10);


 $queryacu=mysqli_query($conexion,"SELECT f.nofactura, f.fecha, f.tipofactura, c.nit, c.nombrec, 
												d.nomproducto, d.cantidad, d.valorkilo, d.subtotal, 
												SUM(d.cantidad) as cantidades FROM factura f INNER JOIN cliente c 
												ON f.codcliente=c.idcliente INNER JOIN detallefactura d 
												ON d.nofactura=f.nofactura WHERE DATE(f.fecha)='$fecha' and tipofactura=1 
                                                and f.estatus=1 GROUP BY d.valorkilo, d.nomproducto ORDER BY d.nomproducto" );

 
    $resultacu =mysqli_num_rows($queryacu);
					
	if($resultacu > 0){
        while($dataacu=mysqli_fetch_array($queryacu)){

            $pdf->Cell(65, 7, $dataacu["nomproducto"], 1,0,'L');
            $pdf->Cell(35, 7, $dataacu["cantidades"], 1,0,'L');

            $vk=number_format($dataacu["valorkilo"], 0, ",", ".");

            $pdf->Cell(45, 7, "$ ".$vk, 1,0,'L');

            $subacumulado=$dataacu["cantidades"]*$dataacu["valorkilo"]; 
            $subacumulado=number_format($subacumulado, 0, ",", ".");
            $pdf->Cell(45, 7, "$ ".$subacumulado, 1,1,'L');

           


            
           
        }
    }






















    /*COMPRAS A CREDITO POR PRODUCTO

    $query=mysqli_query($conexion,"SELECT d.nomproducto, f.nofactura, SUM(d.cantidad) as subtotales, SUM(d.subtotal) as totales  , 
    d.valorkilo FROM detallefactura d INNER JOIN factura f ON d.nofactura=f.nofactura 
    WHERE DATE(f.fecha)='$fecha' and tipofactura=2 and estatus=1  GROUP BY d.nomproducto ORDER BY totales DESC ");
    $result =mysqli_num_rows($query);

        if ($result){


            $pdf->Ln(8);
            $pdf->SetFont('Arial','B',16);
            $pdf->Cell(180,4,utf8_decode('COMPRAS A CRÉDITO POR PRODUCTO'),0,1,'C');
            // Salto de línea
            $pdf->Ln(3);

            // COLUMNAS

            $pdf->SetFont('Helvetica', 'B', 14);
            $pdf->Cell(65, 10, 'PRODUCTO', 0);
            $pdf->Cell(35, 10, 'CANTIDAD',0,0,'L');
            $pdf->Cell(45, 10, 'VALOR KILO',0,0,'L');
            $pdf->Cell(55, 10, 'VALOR TOTAL',0,0,'L');
            $pdf->Ln(10);

            
                                
                if($result > 0){
                    while($data=mysqli_fetch_array($query)){

                        $pdf->Cell(65, 7, utf8_decode($data["nomproducto"]), 1,0,'L');
                        $pdf->Cell(35, 7, $data["subtotales"], 1,0,'L');

                        $vk=number_format($data["valorkilo"], 0, ",", ".");
                        $pdf->Cell(45, 7, "$ ".$vk, 1,0,'L');

                        $modulo=$data["totales"]%10;

                        if ($modulo>0 && $modulo<5){ 
                            $data["totales"]=$data["totales"]-$modulo;   
                        }else{ 
                            if($modulo!=0){ 
                                $data["totales"]=$data["totales"]-$modulo+10;
                            }
                        }


                        $tf3=number_format($data["totales"], 0, ",", ".");
                        $pdf->Cell(55, 7, "$ ".$tf3, 1,1,'L');
                    }
                }
        }

        ---------------------------COMPRAS A CREDITO POR proveedor

    $query=mysqli_query($conexion,"SELECT f.nofactura, f.totalfactura, c.nombrec FROM factura f INNER JOIN cliente c
                        ON c.idcliente=f.codcliente WHERE DATE(f.fecha)='$fecha' and tipofactura=2 and f.estatus=1 ");
    $result =mysqli_num_rows($query);

        if ($result){

            $pdf->Ln(8);
            $pdf->SetFont('Arial','B',16);
            $pdf->Cell(180,4,utf8_decode('COMPRAS A CRÉDITO POR PROVEEDOR'),0,1,'C');
            // Salto de línea
            $pdf->Ln(3);

            // COLUMNAS

            $pdf->SetFont('Helvetica', 'B', 14);
            $pdf->Cell(40, 10, 'No. RECIBO', 0);
            $pdf->Cell(100, 10, 'PROVEEDOR',0,0,'L');
            $pdf->Cell(60, 10, 'VALOR A PAGAR',0,0,'L');
            
            $pdf->Ln(10);
                    
                if($result > 0){
                    while($data=mysqli_fetch_array($query)){
                        $numfactura=$data["nofactura"];

                        $pdf->Cell(40, 6, utf8_decode($data["nofactura"]), 1,0,'L');

                        $nombrec=substr($data["nombrec"],0,25);

                        $pdf->Cell(100, 6,$nombrec , 1,0,'L');

                        $tfc=number_format($data["totalfactura"], 0, ",", ".");
                        $pdf->Cell(60, 6, "$ ".$tfc, 1,1,'L');


                        //detalle de productos

                        $query5=mysqli_query($conexion,"SELECT * FROM detallefactura WHERE nofactura='$numfactura'");
                        $result5 =mysqli_num_rows($query5);
                                        
                        if($result5 > 0){

                            $pdf->SetFont('Helvetica', 'B', 14);
                            $pdf->Cell(40, 10, 'PRODUCTO', 0);
                            $pdf->Cell(50, 10, 'PESO',0,0,'L');
                            $pdf->Cell(50, 10, 'VALOR KILO',0,0,'L');
                            $pdf->Cell(60, 10, 'SUBTOTAL',0,0,'L');
                            $pdf->Ln(5);
                            while($data5=mysqli_fetch_array($query5)){
                                $pdf->SetFont('Helvetica', '', 14);
                                $prod=substr($data5["nomproducto"],0,11);
                                $pdf->Cell(40, 10, $prod, 0);
                                $pdf->Cell(50, 10, $data5["cantidad"], 0);
                                $pdf->Cell(50, 10, "$".$data5["valorkilo"], 0);
                                $subt=number_format($data5["subtotal"], 0, ",", ".");
                                $pdf->Cell(60, 10, "$".$subt, 0);
                                $pdf->Ln(5);
                            }
                        }
                        $pdf->Ln(6);
     
                    }
                }
        }*/


        //VENTAS de contado

     $queryventascon2=mysqli_query($conexion, "select f.nofacturav, c.nombrec, f.totalfactura FROM facturav f
     INNER JOIN cliente c ON f.codcliente=c.idcliente
    WHERE DATE(fecha)='$fecha' and f.estatus=1 and tipofactura=1");

            $result24 =mysqli_num_rows($queryventascon2);

        if ($result24){


            $pdf->Ln(8);
            $pdf->SetFont('Arial','B',16);
            $pdf->Cell(180,4,utf8_decode('VENTAS DE CONTADO'),0,1,'C');
            // Salto de línea
            $pdf->Ln(3);

            // COLUMNAS

            

            if($result24 > 0){

            $pdf->SetFont('Helvetica', 'B', 14);
            $pdf->Cell(30, 10, 'No. REC', 0);
            $pdf->Cell(50, 10, 'CLIENTE',0,0,'C');
            $pdf->Cell(85, 10, 'PRODUCTOS',0,0,'C');
            $pdf->Cell(35, 10, 'VALOR',0,1,'L');
            $pdf->Ln(2);


            while($data21=mysqli_fetch_array($queryventascon2)){

            $nofv=$data21["nofacturav"];
            $pdf->Cell(30, 7, $nofv, 1,0,'L');
            $pdf->Cell(50, 7,  substr($data21["nombrec"],0,15), 1,0,'L');

            $nomproducto=mysqli_query($conexion, "select nomproducto, cantidad, valorkilo FROM detallefacturav f
                         WHERE nofacturav='$nofv' ");

            $resultnompro =mysqli_num_rows($nomproducto);

            if ($resultnompro){
                $productos="";
                while($datanp=mysqli_fetch_array($nomproducto)){
                    $productos=$datanp["nomproducto"].", ".$datanp["cantidad"]." Kilos, $".$datanp["valorkilo"].", ".$productos;
                }
            }
            

            

            

            $pdf->Cell(85, 7, substr($productos,0,40), 1,0,'L');

            $tf4=number_format($data21["totalfactura"], 0, ",", ".");
            $pdf->Cell(35, 7, "$ ".$tf4, 1,1,'L');
            }
            }
    }


     /*VENTAS A CRÉDITO

     $queryventascre2=mysqli_query($conexion, "select f.nofacturav, c.nombrec, f.totalfactura FROM facturav f
                                            INNER JOIN cliente c ON f.codcliente=c.idcliente
                                           WHERE DATE(fecha)='$fecha' and f.estatus=1 and tipofactura=2");
    
    $result21 =mysqli_num_rows($queryventascre2);

    if ($result21){


        $pdf->Ln(8);
        $pdf->SetFont('Arial','B',16);
        $pdf->Cell(180,4,utf8_decode('VENTAS A CRÉDITO'),0,1,'C');
        // Salto de línea
        $pdf->Ln(3);

        // COLUMNAS

       
                            
            if($result21 > 0){

                $pdf->SetFont('Helvetica', 'B', 14);
                $pdf->Cell(30, 10, 'No. REC', 0);
                $pdf->Cell(70, 10, 'CLIENTE',0,0,'C');
                $pdf->Cell(65, 10, 'PRODUCTOS',0,0,'C');
                $pdf->Cell(35, 10, 'VALOR',0,1,'L');
                $pdf->Ln(2);


                while($data21=mysqli_fetch_array($queryventascre2)){

                    $nofv=$data21["nofacturav"];
            $pdf->Cell(30, 7, $nofv, 1,0,'L');
            $pdf->Cell(70, 7,  substr($data21["nombrec"],0,18), 1,0,'L');

            $nomproducto=mysqli_query($conexion, "select nomproducto FROM detallefacturav f
                         WHERE nofacturav='$nofv' ");

            $resultnompro =mysqli_num_rows($nomproducto);

            if ($resultnompro){
                $productos="";
                while($datanp=mysqli_fetch_array($nomproducto)){
                    $productos=$datanp["nomproducto"].", ".$productos;
                }
            }
            

            

            

            $pdf->Cell(65, 7, substr($productos,0,40), 1,0,'L');

            $tf5=number_format($data21["totalfactura"], 0, ",", ".");
            $pdf->Cell(35, 7, "$ ".$tf5, 1,1,'L');
                }
            }
        }

            $pdf->Ln(4);

            $pdf->Cell(30, 7, $fecha, 1,0,'L');

        */
            //COMPRAS ANULADAS

     $queryventascon11=mysqli_query($conexion, "select f.nodevolucionc, c.nombrec, f.total_devc FROM devolucionc f
     INNER JOIN cliente c ON f.codcliente=c.idcliente
    WHERE DATE(fechadevc)='$fecha' ");

            $result11 =mysqli_num_rows($queryventascon11);

        if ($result11){


            $pdf->Ln(8);
            $pdf->SetFont('Arial','B',16);
            $pdf->Cell(180,4,utf8_decode('COMPRAS ANULADAS'),0,1,'C');
            // Salto de línea
            $pdf->Ln(3);

            // COLUMNAS

            

            if($result11 > 0){

            $pdf->SetFont('Helvetica', 'B', 14);
            $pdf->Cell(30, 10, 'No. REC', 0);
            $pdf->Cell(50, 10, 'CLIENTE',0,0,'C');
            $pdf->Cell(85, 10, 'PRODUCTOS',0,0,'C');
            $pdf->Cell(35, 10, 'VALOR',0,1,'L');
            $pdf->Ln(2);


            while($data11=mysqli_fetch_array($queryventascon11)){

            $nofv=$data11["nodevolucionc"];
            $pdf->Cell(30, 7, $nofv, 1,0,'L');
            $pdf->Cell(50, 7,  substr($data11["nombrec"],0,15), 1,0,'L');

            $nomproducto=mysqli_query($conexion, "select nomproducto, cantidad, valorkilo FROM detalledevc f
                         WHERE nodevolucionc='$nofv' ");

            $resultnompro =mysqli_num_rows($nomproducto);

            if ($resultnompro){
                $productos="";
                while($datanp=mysqli_fetch_array($nomproducto)){
                    $productos=$datanp["nomproducto"].", ".$datanp["cantidad"]." Kilos, $".$datanp["valorkilo"].", ".$productos;
                }
            }
            

            

            

            $pdf->Cell(85, 7, substr($productos,0,40), 1,0,'L');

            $tf4=number_format($data11["total_devc"], 0, ",", ".");
            $pdf->Cell(35, 7, "$ ".$tf4, 1,1,'L');
            }
            }
    }










   

        

        $pdf->Output();
    }
?>