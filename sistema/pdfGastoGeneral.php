<?php

session_start();
$iduser=$_SESSION['idUser'];

$razon= ""; $nitempre= ""; $telefono= ""; $direccion=""; $ciudad= "";

include "../conexion.php";

$tipo=$_POST['tipo'];
$salida="";

if($_POST['tercero']){
    $tercero=$_POST['tercero'];
}else{
    $tercero="SIN TERCERO";
}

$totalgasto=0;

$desdef=$_POST['desde'];
$hasta=$_POST['hasta'];


                    $dia=substr( $desdef, 3, 2 );
					$mes=substr( $desdef, 0, 2 );
					$ano=substr( $desdef, 6, 4 );

					$desdef=$ano."-".$mes."-".$dia;
                    $desdef2=$dia."-".$mes."-".$ano;

                   
					$hasta=$_POST['hasta'];

					$dia=substr( $hasta, 3, 2 );
					$mes=substr( $hasta, 0, 2 );
					$ano=substr( $hasta, 6, 4 );

					$hasta=$ano."-".$mes."-".$dia;
                    $hasta2=$dia."-".$mes."-".$ano;


date_default_timezone_set('America/Bogota');
$actual = Date('Y-m-d H:i:s', time());



    //nombre de usuario que va a imprimir la factura
    $query_usuario=mysqli_query($conexion, "select nombre from usuario WHERE idusuario='$iduser'");
    $query_usuario1= mysqli_fetch_array($query_usuario);
    $nomuser=$query_usuario1[0];


    //datos de la Empresa
    $empresa=mysqli_query($conexion, "select * from configuracion");
    $empresa2=mysqli_fetch_array($empresa);

    $razon= $empresa2["razon_social"];
    $nitempre= $empresa2["nit"];
    $telefono= $empresa2["telefono"];
    $direccion= $empresa2["direccion"];
    $ciudad= $empresa2["ciudad"];



    
    
      
        $query_usuario=mysqli_query($conexion, "select nombre from usuario WHERE idusuario='$iduser'");
        $query_usuario1= mysqli_fetch_array($query_usuario);
        $nomuser=$query_usuario1[0];

    
    
   
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
            $this->SetFont('Arial','I',8);
            $this->Cell(0,6,utf8_decode(' Generado por TIS@ - Desarrollo de Software '),0,1,'C');
            // Número de página
            $this->Cell(0,6,utf8_decode(' Página ').$this->PageNo().'/{nb}',0,0,'C');
        }
        }


        $pdf = new PDF();
        $pdf -> AliasNbPages();
        $pdf->AddPage();

        // CABECERA

        $pdf->SetFont('Helvetica', 'B',16);
        $pdf->Cell(200,4,"INFORME GENERAL DE GASTOS",0,1,'C');
        $pdf->Ln(1);

        $pdf->SetFont('Helvetica', 'B',14);
        $pdf->Cell(200,4,utf8_decode($razon),0,1,'C');
        $pdf->SetFont('Helvetica','',9);
        $pdf->Cell(200,4,"NIT ".$nitempre,0,1,'C');
        $pdf->Cell(100,4,$direccion,0,0,'R');
        $pdf->Cell(100,4,$telefono,0,1,'L');
        $pdf->Cell(200,4,utf8_decode($ciudad),0,1,'C');
        
 
       
 
// PRODUCTOS
$pdf->SetFont('Helvetica', 'B',12);

date_default_timezone_set('America/Bogota');
$fechaactual2 = Date('Y-m-d H:i:s', time());

$pdf->Cell(60,10, "Consultado por: ", 0 , 0 , 'L', 0 );
$pdf->SetFont('Helvetica', '', 12);
$pdf->Cell(50,10, $nomuser, 0 , 1 , 'L', 0 );
$pdf->SetFont('Helvetica', 'B',12);
$pdf->Cell(60,10, "Fecha Y Hora de Consulta: ", 0 , 0 , 'L', 0 );
$pdf->SetFont('Helvetica', '', 12);
$pdf->Cell(50,10, $fechaactual2, 0 , 1 , 'L', 0 );



 //consultar el nombvre del gasto
 $consultatipo2=mysqli_query($conexion, "SELECT idtipogasto, nombregasto FROM tipo_gasto WHERE idtipogasto=$tipo");
 $datotipo2=mysqli_fetch_array($consultatipo2);
 $tipo2= $datotipo2["nombregasto"];
 
 

 $pdf->SetFont('Helvetica', 'B',12);
$pdf->Cell(60,10, "Tipo de Gasto: ", 0 , 0 , 'L', 0 );
$pdf->SetFont('Helvetica', '', 12);
$pdf->Cell(50,10, $tipo2, 0 , 1 , 'L', 0 );


//consultar el nombre del tercero
if($tercero!="SIN TERCERO"){
    $tercero2=mysqli_query($conexion, "SELECT idcliente, nombrec FROM cliente WHERE idcliente=$tercero");
    $datotercero2=mysqli_fetch_array($tercero2);

    $pdf->SetFont('Helvetica', 'B',12);
    $pdf->Cell(60,10, "Tercero: ", 0 , 0 , 'L', 0 );
    $pdf->SetFont('Helvetica', '', 12);
    $pdf->Cell(50,10, $datotercero2["nombrec"], 0 , 1 , 'L', 0 );

    $querytotal=mysqli_query($conexion,"SELECT SUM(valorgasto) as tgasto FROM gasto
                                    WHERE estatus=1 and DATE(fechagasto)>='$desdef' 
                                    and DATE(fechagasto)<='$hasta' and idcliente='$tercero' 
                                    and idtipogasto='$tipo' " );
    
    $datototal=mysqli_fetch_array($querytotal);
    $tgasto=$datototal["tgasto"];


    $pdf->SetFont('Helvetica', 'B',12);
    $pdf->Cell(60,10, "Total Gasto: ", 0 , 0 , 'L', 0 );
    $pdf->SetFont('Helvetica', '', 12);
    $tgasto=number_format($tgasto, 0, ",", ".");
    $pdf->Cell(50,10, "$ ".$tgasto, 0 , 1 , 'L', 0 );
}else{
    $pdf->SetFont('Helvetica', 'B',12);
    $pdf->Cell(60,10, "Tercero: ", 0 , 0 , 'L', 0 );
    $pdf->SetFont('Helvetica', '', 12);
    $pdf->Cell(50,10, "Todos los Terceros", 0 , 1 , 'L', 0 );

    $querytotal=mysqli_query($conexion,"SELECT SUM(valorgasto) as tgasto FROM gasto
                                    WHERE estatus=1 and DATE(fechagasto)>='$desdef' 
                                    and DATE(fechagasto)<='$hasta' 
                                    and idtipogasto='$tipo' " );
    
    $datototal=mysqli_fetch_array($querytotal);
    $tgasto=$datototal["tgasto"];


    $pdf->SetFont('Helvetica', 'B',12);
    $pdf->Cell(60,10, "Total Gasto: ", 0 , 0 , 'L', 0 );
    $pdf->SetFont('Helvetica', '', 12);
    $tgasto=number_format($tgasto, 0, ",", ".");
    $pdf->Cell(50,10, "$ ".$tgasto, 0 , 1 , 'L', 0 );
}


$pdf->SetFont('Helvetica', 'B',12);
$pdf->Cell(60,10, "Periodo Consultado: ", 0 , 0 , 'L', 0 );
$pdf->SetFont('Helvetica', '', 12);
$pdf->Cell(50,10, "Del ". $desdef2. " Hasta el ". $hasta2, 0 , 1 , 'L', 0 );
$pdf->Cell(50,10, "", 0 , 1 , 'L', 0 );

$pdf->SetFont('Helvetica', 'B',11);
//$pdf->Cell(35,10, "GASTO", 1 , 0 , 'C', 0 );
$pdf->Cell(45,10, "TERCERO", 1 , 0 , 'C', 0 );
$pdf->Cell(25,10, "VALOR", 1 , 0 , 'C', 0 );
$pdf->Cell(40,10, "FECHA", 1 , 0 , 'C', 0 );
$pdf->Cell(60,10, "NOTA", 1 , 0 , 'C', 0 );
$pdf->Cell(21,10, "REALIZO", 1 , 1 , 'C', 0 );
$pdf->SetFont('Helvetica', '', 10);

if($tercero!="SIN TERCERO"){

					
    $query=mysqli_query($conexion,"SELECT t.nombregasto, c.nombrec, g.valorgasto, g.fechagasto, g.nota, u.nombre 
                                    FROM gasto g INNER JOIN tipo_gasto t ON g.idtipogasto=t.idtipogasto 
                                    INNER JOIN cliente c ON g.idcliente=c.idcliente 
                                    INNER JOIN usuario u ON u.idusuario=g.idusuario 
                                    WHERE g.estatus=1 and DATE(fechagasto)>='$desdef' 
                                    and DATE(fechagasto)<='$hasta' and g.idcliente='$tercero' 
                                    and g.idtipogasto='$tipo' ORDER BY fechagasto" );
    
   



    
    $result =mysqli_num_rows($query);
    
    if($result > 0){
        while($data=mysqli_fetch_array($query)){
                //$pdf->Cell(35,10, substr($data["nombregasto"],0,20), 1 , 0 , 'L', 0 );
                $pdf->Cell(45,10, substr($data["nombrec"],0,15), 1 , 0 , 'L', 0 );
                $vg=number_format($data["valorgasto"], 0, ",", ".");
                $pdf->Cell(25,10, "$ ".$vg, 1 , 0 , 'L', 0 );
                $pdf->Cell(40,10, $data["fechagasto"], 1 , 0 , 'L', 0 );
                $pdf->Cell(60,10, substr($data["nota"],0,19), 1 , 0 , 'L', 0 );
                
                $pdf->Cell(21,10, substr($data["nombre"],0,11), 1 , 1 , 'L', 0 );

                $totalgasto=$totalgasto+$data["valorgasto"];
        
               
        }
                /*$pdf->SetFont('Helvetica', 'B',14);
                $tvg=number_format($totalgasto, 0, ",", ".");
                $pdf->Cell(190,10, "TOTAL GASTO $ ".$tvg, 1 , 0 , 'C', 0 );*/
    
    }
}//fin si sin tercero
else{

					
    $query=mysqli_query($conexion,"SELECT t.nombregasto, c.nombrec, g.valorgasto, g.fechagasto, g.nota, u.nombre 
                                    FROM gasto g INNER JOIN tipo_gasto t ON g.idtipogasto=t.idtipogasto 
                                    INNER JOIN cliente c ON g.idcliente=c.idcliente 
                                    INNER JOIN usuario u ON u.idusuario=g.idusuario 
                                    WHERE g.estatus=1 and DATE(fechagasto)>='$desdef' 
                                    and DATE(fechagasto)<='$hasta' 
                                    and g.idtipogasto='$tipo' ORDER BY fechagasto" );
    
   



    
    $result =mysqli_num_rows($query);
    
    if($result > 0){
        while($data=mysqli_fetch_array($query)){
                //$pdf->Cell(35,10, substr($data["nombregasto"],0,20), 1 , 0 , 'L', 0 );
                $pdf->Cell(45,10, substr($data["nombrec"],0,22), 1 , 0 , 'L', 0 );
                $vg=number_format($data["valorgasto"], 0, ",", ".");
                $pdf->Cell(25,10, "$ ".$vg, 1 , 0 , 'L', 0 );
                $pdf->Cell(40,10, $data["fechagasto"], 1 , 0 , 'L', 0 );
                $pdf->Cell(60,10, substr($data["nota"],0,32), 1 , 0 , 'L', 0 );
                
                $pdf->Cell(21,10, substr($data["nombre"],0,11), 1 , 1 , 'L', 0 );

                $totalgasto=$totalgasto+$data["valorgasto"];
        
               
        }
                /*$pdf->SetFont('Helvetica', 'B',14);
                $tvg=number_format($totalgasto, 0, ",", ".");
                $pdf->Cell(190,10, "TOTAL GASTO $ ".$tvg, 1 , 0 , 'C', 0 );*/
    
    }
}//fin else sin tercero
       
        
 
 
$pdf->Output('Informe Gastos.pdf','i');
    
?>