<?php

session_start();
$iduser=$_SESSION['idUser'];
$cuadreanterior=0;

include "../conexion.php";

if(!empty($_GET['id'])){
    $idnomina=$_GET['id'];
    
}else{ 
    //se recupera el id del ultimo cuadre
    $inicio=mysqli_query($conexion, "select MAX(idnomina) from nomina");
    $inicio1= mysqli_fetch_array($inicio);
    $idnomina=$inicio1[0];
   

}






//se consulta la nomina
$inicio2=mysqli_query($conexion, "select c.nombrec,fecha, ordinario,dias,
                        extras, valorextras, auxilio, salud, pension, saludem, pensionem, arl, confa FROM nomina
                        INNER JOIN cliente c ON idempleado=idcliente WHERE idnomina='$idnomina' ") ;
    $datoinicio=mysqli_fetch_array($inicio2);

    $controlinicio= $datoinicio["estatus"];
    $nota= $datoinicio["fechaInicial"];
    $ingresos= $datoinicio["ingresos"];
    $egresos= $datoinicio["egresos"];
    $saldo= $datoinicio["saldo"];
    $idusuario_open= $datoinicio["idusuario_abre"];
    $idusuario_close= $datoinicio["idusuario_cierra"];
    $fechaclosed= $datoinicio["fechaFinal"];


        
//consulta los datos de la empresa
$empresa=mysqli_query($conexion, "select * from configuracion");
$empresa2=mysqli_fetch_array($empresa);

    $razon= $empresa2["razon_social"];
    $nitempre= $empresa2["nit"];
    $telefono= $empresa2["telefono"];
    $direccion= $empresa2["direccion"];
    $ciudad= $empresa2["ciudad"];


    
    


    

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


            $pdf->SetFont('Arial','B',18);
            // Movernos a la derecha
            $pdf->Cell(60);
            // Título
           $pdf->Cell(80,5,$razon,0,1,'C');
            $pdf->SetFont('Helvetica','',9);
            $pdf->Cell(50);
            $pdf->Cell(95,5,"NIT ".$nitempre,0,1,'C');
            $pdf->Cell(50);
            $pdf->Cell(50,5,$direccion,0,0,'R');
            $pdf->Cell(50,5,$telefono,0,1,'L');
            $pdf->Cell(50);
            $pdf->Cell(95,4,$ciudad,0,1,'C');
            $pdf->Ln(5);
            $pdf->Cell(60);
            $pdf->SetFont('Arial','B',20);
            $pdf->Cell(80,4,utf8_decode('COMPROBANTE DE PAGO DE NÓMINA'),0,1,'C');
            // Salto de línea
            $pdf->Ln(10);





        $pdf->SetFont('Arial','B',12);
        $pdf->Cell(90,7, "Nomina:", 0 , 0 , 'L', 0 );
        $pdf->SetFont('Arial','',12);
        $pdf->Cell(90,7, $nota, 0 , 1 , 'L', 0 );
        $pdf->SetFont('Arial','B',12);
        $pdf->Cell(90,7, "Fecha y Hora de Apertura:", 0 , 0 , 'L', 0 );
        $pdf->SetFont('Arial','',12);
        $pdf->Cell(90,7, $fechaopen, 0 , 1 , 'L', 0 );
        $pdf->SetFont('Arial','B',12);
        $pdf->Cell(90,7, "Abierto por:", 0 , 0 , 'L', 0 );
        $pdf->SetFont('Arial','',12);
        $pdf->Cell(90,7, $idusuario_open, 0 , 1 , 'L', 0 );
        $pdf->SetFont('Arial','B',12);
        $pdf->Cell(90,7, "Fecha y Hora de Cierre:", 0 , 0 , 'L', 0 );
        $pdf->SetFont('Arial','',12);
        $pdf->Cell(90,7, $fechaclosed, 0 , 1 , 'L', 0 );
        $pdf->SetFont('Arial','B',12);
        $pdf->Cell(90,7, "Cerrado por:", 0 , 0 , 'L', 0 );
        $pdf->SetFont('Arial','',12);
        $pdf->Cell(90,7, $idusuario_close, 0 , 1 , 'L', 0 );
        $pdf->SetFont('Arial','B',12);
        $pdf->Cell(90,7, "Saldo Reportado:", 0 , 0 , 'L', 0 );
        $pdf->Cell(90,7, "$ " .$saldo, 0 , 1 , 'L', 0 );
        $pdf->SetFont('Arial','B',14);
        $pdf->Cell(90,7, "Cuadre Cerrado:", 0 , 0 , 'L', 0 );
        $pdf->Cell(90,7, $cierre, 0 , 1 , 'L', 0 );

        $pdf->Cell(170,0,'','T');
        $pdf->Ln(3);
        $pdf->SetFont('Arial','B',12);
        $pdf->Cell(90,7, "Saldo Anterior:", 0 , 0 , 'L', 0 );
        $pdf->SetFont('Arial','',12);
        $pdf->Cell(90,7, "$ " .$saldoanterior, 0 , 1 , 'L', 0 );
        $pdf->SetFont('Arial','B',12);


        
        $pdf->Cell(90,7, "Bases:", 0 , 0 , 'L', 0 );
        $pdf->SetFont('Arial','',12);
        $pdf->Cell(90,7, "$ " .$totalbase, 0 , 1 , 'L', 0 );
        $pdf->SetFont('Arial','B',12);

        if ($totalventas>0){ 
            $pdf->Cell(90,7, "Ventas de Contado:", 0 , 0 , 'L', 0 );
            $pdf->Cell(90,7, "$ " .$totalventas, 0 , 1 , 'L', 0 );
        }else{ 
            $pdf->Cell(90,7, "Ventas de Contado:", 0 , 0 , 'L', 0 );
            $pdf->Cell(90,7, "$ 0 " , 0 , 1 , 'L', 0 );
         }


        $pdf->Cell(170,0,'','T');
        $pdf->Ln(3);

        $totaling=$saldoanterior+$totalbase+$totalventas;
        $pdf->SetFont('Arial','B',16);
        $pdf->Cell(90,7, "TOTAL INGRESOS:", 0 , 0 , 'L', 0 );
        $pdf->Cell(90,7, "$ ". $totaling, 0 , 1 , 'L', 0 );

        

        
        
        $pdf->Cell(170,0,'','T');
        $pdf->Ln(3);


         //mostrar VALOR ventas a credito

         if ($totalventascre>0){ 
            $pdf->Cell(90,7, utf8_decode( "Ventas a Crédito:"), 0 , 0 , 'L', 0 );
            $pdf->Cell(90,7, "$ " .$totalventascre, 0 , 1 , 'L', 0 );
        }else{ 
            $pdf->Cell(90,7, utf8_decode( "Ventas a Crédito:"), 0 , 0 , 'L', 0 );
            $pdf->Cell(90,7, "$ 0 " , 0 , 1 , 'L', 0 );
         }

        $pdf->Cell(170,0,'','T');
        $pdf->Ln(3);


        $pdf->SetFont('Arial','B',12);
        
        $pdf->Cell(90,7, "Compras:", 0 , 0 , 'L', 0 );
        $pdf->SetFont('Arial','',12);
        $pdf->Cell(90,7, "$ ".$totalcompras, 0 , 1 , 'L', 0 );
        $pdf->SetFont('Arial','B',12);

        if ($totalgastos>0){

            $pdf->Cell(90,7, "Gastos:", 0 , 0 , 'L', 0 );
            $pdf->SetFont('Arial','',12);
            $pdf->Cell(90,7, "$ ".$totalgastos, 0 , 1 , 'L', 0 );
        }else{
            $pdf->Cell(90,7, "Gastos:", 0 , 0 , 'L', 0 );
            $pdf->SetFont('Arial','',12);
            $pdf->Cell(90,7, "$ 0 ", 0 , 1 , 'L', 0 );
        }


        $pdf->Cell(170,0,'','T');
        $pdf->Ln(3);

        $totalegr=$totalcompras+$totalgastos;
        $pdf->SetFont('Arial','B',16);
        $pdf->Cell(90,7, "TOTAL EGRESOS:", 0 , 0 , 'L', 0 );
        $pdf->Cell(90,7, "$ ". $totalegr, 0 , 1 , 'L', 0 );

        

        $pdf->Cell(170,0,'','T');
        $pdf->Ln(6);

 
//BASES

$pdf->SetFont('Arial','B',14);
$pdf->Cell(180,4,utf8_decode('BASES INGRESADAS'),0,1,'C');
// Salto de línea
$pdf->Ln(3);

 // COLUMNAS

 $pdf->SetFont('Helvetica', 'B', 12);
 $pdf->Cell(60, 10, 'FECHA Y HORA', 0);
 $pdf->Cell(60, 10, 'VALOR',0,0,'L');
 $pdf->Cell(60, 10, 'RESPONSABLE',0,0,'L');
 $pdf->Ln(10);

  $query=mysqli_query($conexion,"SELECT b.fechabase, b.valorbase, u.nombre FROM base b 
                        INNER JOIN usuario u ON b.idusuario=u.idusuario WHERE idcuadre='$idcuadre'");
    $result =mysqli_num_rows($query);
					
	if($result > 0){
        while($data=mysqli_fetch_array($query)){

            $pdf->Cell(60, 6, $data["fechabase"], 1,0,'L');
            $pdf->Cell(60, 6, "$ ".$data["valorbase"], 1,0,'L');
            $pdf->Cell(60, 6, $data["nombre"], 1,1,'L');
        }
    }

//GASTOS
if ($totalgastos>0){
        $pdf->Ln(6);
        $pdf->SetFont('Arial','B',14);
        $pdf->Cell(180,4,utf8_decode('GASTOS'),0,1,'C');
        // Salto de línea
        $pdf->Ln(3);

        // COLUMNAS

        $pdf->SetFont('Helvetica', 'B', 12);
        $pdf->Cell(50, 10, 'TIPO', 0);
        $pdf->Cell(55, 10, 'TERCERO',0,0,'L');
        $pdf->Cell(35, 10, 'VALOR',0,0,'L');
        $pdf->Cell(40, 10, 'RESPONSABLE',0,0,'L');
        $pdf->Ln(10);

            $query=mysqli_query($conexion,"SELECT g.idtipogasto, g.idcliente, g.valorgasto, u.nombre FROM gasto g INNER JOIN
                                            usuario u ON g.idusuario=u.idusuario  WHERE idcuadre='$idcuadre' and g.estatus!=0");
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

                    $pdf->Cell(50, 6, $gasto, 1,0,'L');
                    $idcliente=substr($idcliente,0,22);
                    $pdf->Cell(55, 6, $idcliente, 1,0,'L');
                    $pdf->Cell(35, 6, $data["valorgasto"], 1,0,'L');
                    $pdf->Cell(40, 6, $data["nombre"], 1,1,'L');
                }
            }
    }

    //COMPRAS
$pdf->Ln(8);
$pdf->SetFont('Arial','B',14);
$pdf->Cell(180,4,utf8_decode('COMPRAS'),0,1,'C');
// Salto de línea
$pdf->Ln(3);

 // COLUMNAS

 $pdf->SetFont('Helvetica', 'B', 12);
 $pdf->Cell(60, 10, 'PRODUCTO', 0);
 $pdf->Cell(30, 10, 'CANTIDAD',0,0,'L');
 $pdf->Cell(40, 10, 'VALOR KILO',0,0,'L');
 $pdf->Cell(50, 10, 'VALOR TOTAL',0,0,'L');
 $pdf->Ln(10);

  $query=mysqli_query($conexion,"SELECT d.nomproducto, f.nofactura, SUM(d.cantidad) as subtotales, SUM(d.subtotal) as totales  , 
                        d.valorkilo FROM detallefactura d INNER JOIN factura f ON d.nofactura=f.nofactura 
                        WHERE DATE(f.fecha)='$fecha' GROUP BY d.nomproducto ORDER BY totales DESC ");
    $result =mysqli_num_rows($query);
					
	if($result > 0){
        while($data=mysqli_fetch_array($query)){

            $pdf->Cell(60, 6, utf8_decode($data["nomproducto"]), 1,0,'L');
            $pdf->Cell(30, 6, $data["subtotales"], 1,0,'L');
            $pdf->Cell(40, 6, "$ ".$data["valorkilo"], 1,0,'L');

            $modulo=$data["totales"]%10;

            if ($modulo>0 && $modulo<5){ 
                $data["totales"]=$data["totales"]-$modulo;   
             }else{ 
                if($modulo!=0){ 
                    $data["totales"]=$data["totales"]-$modulo+10;
                 }
            }



            $pdf->Cell(50, 6, "$ ".$data["totales"], 1,1,'L');
        }
    }


     //VENTAS A CRÉDITO
$pdf->Ln(8);
$pdf->SetFont('Arial','B',14);
$pdf->Cell(180,4,utf8_decode('VENTAS A CRÉDITO'),0,1,'C');
// Salto de línea
$pdf->Ln(3);

 // COLUMNAS

 $queryventascre2=mysqli_query($conexion, "select f.nofacturav, c.nombrec, f.totalfactura FROM facturav f
                                            INNER JOIN cliente c ON f.codcliente=c.idcliente
                                           WHERE DATE(fecha)='$fecha' and estatus!=0 and tipofactura=2");
    
    $result21 =mysqli_num_rows($queryventascre2);
					
	if($result21 > 0){

        $pdf->SetFont('Helvetica', 'B', 12);
        $pdf->Cell(40, 10, 'No. RECIBO', 0);
        $pdf->Cell(70, 10, 'CLIENTE',0,0,'L');
        $pdf->Cell(50, 10, 'VALOR',0,1,'L');
        $pdf->Ln(4);


        while($data21=mysqli_fetch_array($queryventascre2)){

            $pdf->Cell(40, 6, $data21["nofacturav"], 1,0,'L');
            $pdf->Cell(70, 6, $data21["nombrec"], 1,0,'L');
            $pdf->Cell(50, 6, "$ ".$data21["totalfactura"], 1,1,'L');
        }
    }

    $pdf->Ln(4);









   

        

        $pdf->Output();
    
?>