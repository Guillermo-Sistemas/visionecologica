<?php

session_start();
$iduser=$_SESSION['idUser'];
$cuadreanterior=0;
$saldoanterior=0;
$tipo="Efectivo";

$enef=0;
$enco=0;
$saef=0;
$saco=0;


include "../conexion.php";

if(!empty($_GET['id'])){
    $idcuadre=$_GET['id'];
    //$cuadreanterior=$idcuadre-1;
}else{ 
    //se recupera el id del ultimo cuadre
    $inicio=mysqli_query($conexion, "select MAX(idcaja) from cajamayor");
    $inicio1= mysqli_fetch_array($inicio);
    $idcuadre=$inicio1[0];
    //$cuadreanterior=$idcuadre-1;

}




$razon= ""; $nitempre= ""; $telefono= ""; $direccion=""; $ciudad= "";
$fecha=""; $totalventas=-1; $totalventascre=0; $fechai=""; $fechaf="";

$totalegr=0; $totalcompras=0;   $totalgastos=0;




$query_usuario=mysqli_query($conexion, "select nombre from usuario WHERE idusuario='$iduser'");
    $query_usuario1= mysqli_fetch_array($query_usuario);
    $iduser=$query_usuario1[0];

$base=0;

$alert="";

//Saldo cuadre anterior
/*if ($idcuadre>1){
$inicio2=mysqli_query($conexion, "select * from cajamayor WHERE idcaja='$cuadreanterior'");
$datoinicio=mysqli_fetch_array($inicio2);

    $saldoanterior= $datoinicio["saldo"];
}*/

//datos del cuadre
$inicio2=mysqli_query($conexion, "select * from cajamayor WHERE idcaja='$idcuadre'");
$datoinicio=mysqli_fetch_array($inicio2);

    $controlinicio= $datoinicio["estatus"];
    $fechaopen= $datoinicio["fechaini"];
    $ingresos= $datoinicio["ingresos"];
    $egresos= $datoinicio["egresos"];
    $banco= $datoinicio["banco"];
    $bancosale= $datoinicio["bancosale"];
    $fechaclosed= $datoinicio["fechafin"];

/*//solo la fecha del cuadre
$queryfecha=mysqli_query($conexion, "select DATE(fechaini), DATE(fechafin) from cajamayor WHERE idcaja='$idcuadre'");
$queryfecha1=mysqli_fetch_array($queryfecha);
$fechai= $queryfecha1["DATE(fechaini)"];
$fechaf= $queryfecha1["DATE(fechaini)"];*/
        
//consulta los datos de la empresa
$empresa=mysqli_query($conexion, "select * from configuracion");
$empresa2=mysqli_fetch_array($empresa);

    $razon= $empresa2["razon_social"];
    $nitempre= $empresa2["nit"];
    $telefono= $empresa2["telefono"];
    $direccion= $empresa2["direccion"];
    $ciudad= $empresa2["ciudad"];

    

//query total gastos
$querygastos=mysqli_query($conexion, "select g.fechagastom, sum(g.valorgastom) as totalgastos, u.rol FROM gastomayor g
                                    INNER JOIN usuario u ON u.idusuario=g.idusuario
                                    WHERE g.idcuadre=$idcuadre and g.estatus!=0  ");
$querygastos1= mysqli_fetch_array($querygastos);
$totalgastos= $querygastos1[1];


    

    
    /*
    $final=$saldoanterior+$totalbase+$totalventas-($totalcompras+$totalgastos)-$saldo;

    $final=$final*-1;

    $fin=number_format($final, 0, ",", ".");
    
    

    $cierre="Cuadre Cerrado con Faltante ".($fin);

    if($final==0){
        $cierre="Cuadre Cerrado OK"; 
    }elseif($final>0){
        $cierre="Cuadre Cerrado con Sobrante  ".($fin); 
    }*/





    


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
            $pdf->Cell(80,8,utf8_decode('CUADRE DE CAJA MAYOR'),0,1,'C');
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
        $pdf->Cell(70,7, "Fecha y Hora de Cierre:", 0 , 0 , 'L', 0 );
        $pdf->SetFont('Arial','',14);
        $pdf->Cell(110,7, $fechaclosed, 0 , 1 , 'L', 0 );
        
        
        

       


         //mostrar VALOR ventas a credito

        

       

 

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
        $pdf->Cell(50, 10, 'TERCERO',0,0,'L');
        $pdf->Cell(65, 10, 'NOTA',0,0,'L');
        $pdf->Cell(35, 10, 'VALOR',0,0,'L');
        $pdf->Ln(10);

            $query=mysqli_query($conexion,"SELECT g.idtipogastom, g.idcliente, g.valorgastom, g.notam, u.nombre FROM gastomayor g INNER JOIN
                                            usuario u ON g.idusuario=u.idusuario  WHERE idcuadre='$idcuadre' and g.estatus!=0");
            $result =mysqli_num_rows($query);
                            
            if($result > 0){
                while($data=mysqli_fetch_array($query)){

                    $gasto=$data["idtipogastom"];
                    $querygasto=mysqli_query($conexion, "select nombregasto from tipo_gasto WHERE idtipogasto='$gasto'");
                    $datogasto=mysqli_fetch_array($querygasto);
                    $gasto= $datogasto["nombregasto"];

                    $idcliente=$data["idcliente"];
                    $queryidcliente=mysqli_query($conexion, "select nombrec from cliente WHERE idcliente='$idcliente'");
                    $datocliente=mysqli_fetch_array($queryidcliente);
                    $idcliente= $datocliente["nombrec"];
                    $gasto=substr($gasto,0,18);
                    $pdf->Cell(50, 8, $gasto, 1,0,'L');
                    $idcliente=substr($idcliente,0,22);
                    $pdf->Cell(50, 8, $idcliente, 1,0,'L');
                    $pdf->Cell(65, 8, $data["notam"], 1,0,'L');

                    $gt=number_format($data["valorgastom"], 0, ",", ".");

                    $pdf->Cell(35, 8, $gt, 1,1,'L');
                   
                }
            }
    }

        $pdf->SetFont('Arial','B',14);
        $pdf->Cell(70,7, "TOTAL GASTOS:", 0 , 0 , 'L', 0 );
        $pdf->SetFont('Arial','',14);
        $pdf->Cell(110,7, $totalgastos, 0 , 1 , 'L', 0 );
        

    

            $pdf->Ln(10);

            $pdf->SetFont('Arial','B',16);
        $pdf->Cell(180,4,utf8_decode('ENTRADAS'),0,1,'C');
        // Salto de línea
        $pdf->Ln(3);

             // COLUMNAS

 $pdf->SetFont('Helvetica', 'B', 14);
 $pdf->Cell(50, 10, 'FECHA', 0);
 $pdf->Cell(100, 10, 'NOTA',0,0,'C');
 $pdf->Cell(30, 10, 'VALOR',0,0,'L');
 $pdf->Cell(12, 10, 'TIPO',0,0,'C');
 $pdf->Ln(10);

 $query1=mysqli_query($conexion,"SELECT * FROM entrada WHERE estatus=1 and  
        idcaja=$idcuadre" );

$result1 =mysqli_num_rows($query1);
                            
            if($result1 > 0){
                while($data=mysqli_fetch_array($query1)){

                    $pdf->Cell(50, 8, $data["fecha"], 1,0,'L');
                    //$idcliente=substr($idcliente,0,22);
                    $pdf->Cell(95, 8, $data["descripcion"], 1,0,'L');
                    $vlen2=$data["valorentrada"];
                    $vlen=number_format($data["valorentrada"], 0, ",", ".");

                    $pdf->Cell(30, 8, $vlen, 1,0,'L');
                    $tipo="Efectivo";
                    if ($data["tipoentrada"]==2){
                        $tipo="Consigna";
                        $enco=$enco+$vlen2;
						}else{
								$enef=$enef+$vlen2;
						}
                    
                        
                    $pdf->Cell(25, 8, $tipo, 1,1,'L');
                }
            }

            $pdf->SetFont('Arial','B',14);
        $pdf->Cell(70,7, "ENTRADAS EFECTIVO:", 0 , 0 , 'L', 0 );
        $pdf->SetFont('Arial','',14);
        $enef=number_format($enef, 0, ",", ".");
        $pdf->Cell(110,7, "$".$enef, 0 , 1 , 'L', 0 );
        $pdf->SetFont('Arial','B',14);
        $pdf->Cell(70,7, utf8_decode("ENTRADAS CONSIGNACIÓN:"), 0 , 0 , 'L', 0 );
        $pdf->SetFont('Arial','',14);
        $enco=number_format($enco, 0, ",", ".");
        $pdf->Cell(110,7, "$".$enco, 0 , 1 , 'L', 0 );


        //salidas

        $pdf->Ln(10);

            $pdf->SetFont('Arial','B',16);
        $pdf->Cell(180,4,utf8_decode('SALIDAS'),0,1,'C');
        // Salto de línea
        $pdf->Ln(3);

             // COLUMNAS

 $pdf->SetFont('Helvetica', 'B', 14);
 $pdf->Cell(50, 10, 'FECHA', 0);
 $pdf->Cell(100, 10, 'NOTA',0,0,'C');
 $pdf->Cell(30, 10, 'VALOR',0,0,'L');
 $pdf->Cell(12, 10, 'TIPO',0,0,'C');
 $pdf->Ln(10);

 $query2=mysqli_query($conexion,"SELECT * FROM salida WHERE estatus_s=1 and  
        idcaja=$idcuadre" );

$result2 =mysqli_num_rows($query2);
                            
            if($result2 > 0){
                while($data2=mysqli_fetch_array($query2)){

                    $pdf->Cell(50, 8, $data2["fecha"], 1,0,'L');
                    //$idcliente=substr($idcliente,0,22);
                    $pdf->Cell(95, 8, $data2["descripcion_s"], 1,0,'L');
                    $vlsa2=$data2["valorsalida"];
                    $vlsa=number_format($data2["valorsalida"], 0, ",", ".");

                    $pdf->Cell(30, 8, $vlsa, 1,0,'L');
                    $tipo="Efectivo";
                    if ($data2["tiposalida"]==2){
                        $tipo="Consigna";
                        $saco=$saco+$vlsa2;
						}else{
								$saef=$saef+$vlsa2;
						}
                    
                        
                    $pdf->Cell(25, 8, $tipo, 1,1,'L');
                }
            }

            $pdf->SetFont('Arial','B',14);
        $pdf->Cell(70,7, "SALIDAS EFECTIVO:", 0 , 0 , 'L', 0 );
        $pdf->SetFont('Arial','',14);
        $saef=number_format($saef, 0, ",", ".");
        $pdf->Cell(110,7, "$".$saef, 0 , 1 , 'L', 0 );
        $pdf->SetFont('Arial','B',14);
        $pdf->Cell(72,7, utf8_decode("SALIDAS CONSIGNACIÓN:"), 0 , 0 , 'L', 0 );
        $pdf->SetFont('Arial','',14);
        $saco=number_format($saco, 0, ",", ".");
        $pdf->Cell(110,7, "$".$saco, 0 , 1 , 'L', 0 );









   

        

        $pdf->Output();
    }
?>