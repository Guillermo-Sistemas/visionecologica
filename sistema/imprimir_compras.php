<?php

session_start();
$iduser=$_SESSION['idUser'];

include "../conexion.php";

date_default_timezone_set('America/Bogota');
$actual = Date("Y-m-d");
$total=0; $total2=0; $total3=0;


if(!empty($_GET['id'])){
    $idcuadre=$_GET['id'];
}else{ 
    //se recupera el id del ultimo cuadre
    $inicio=mysqli_query($conexion, "select MAX(idcuadre) from cuadre");
    $inicio1= mysqli_fetch_array($inicio);
    $idcuadre=$inicio1[0];

}




$razon= ""; $nitempre= ""; $telefono= ""; $direccion=""; $ciudad= "";
$fecha=""; $totalventas=-1;

$totalegr=0; $totalcompras=0;   $totalgastos=0;




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
            $pdf->SetFont('Arial','B',18);
            $pdf->Cell(80,4,utf8_decode('COMPRAS DIARIAS   ').$actual,0,1,'C');
            // Salto de línea
            $pdf->Ln(10);





        
        $pdf->Ln(3);
        
        


       
 // COLUMNAS

 $pdf->SetFont('Helvetica', 'B', 12);
 $pdf->Cell(30, 10, utf8_decode('No. RECIBO'), 0);
 $pdf->Cell(30, 10, 'HORA', 0);
 $pdf->Cell(50, 10, 'VALOR',0,0,'L');
 $pdf->Cell(60, 10, 'CAJERO',0,0,'L');
 $pdf->Ln(8);

  //query compras
  $querycompras=mysqli_query($conexion, "select f.nofactura, time(f.fecha) as hour, f.totalfactura, u.nombre FROM factura f INNER JOIN 
                                usuario u ON u.idusuario=f.usuario WHERE DATE(fecha)='$actual' and f.estatus!=0 
                                    and tipofactura=1 ORDER BY nofactura DESC ");
 $result =mysqli_num_rows($querycompras);

 $pdf->SetFont('Helvetica', '', 12);
    				
	if($result > 0){
        while($data=mysqli_fetch_array($querycompras)){

            $pdf->Cell(30, 6, $data["nofactura"], 1,0,'L');
            $pdf->Cell(30, 6, $data["hour"], 1,0,'L');
            $pdf->Cell(50, 6, "$ ".$data["totalfactura"], 1,0,'L');
            $pdf->Cell(60, 6, $data["nombre"], 1,1,'L');
            $total=$total+$data["totalfactura"];
        }
    }
    $pdf->Ln(10);
    $pdf->SetFont('Helvetica', 'B', 16);
    $pdf->Cell(92, 6, "TOTAL COMPRAS EN EFECTIVO", 0,0,'L');
    $pdf->Cell(60, 6, "$ ".$total, 0,1,'L');

    $pdf->Ln(10);
    //query compras por usuario

    
  $comprasusuario=mysqli_query($conexion, "select SUM(totalfactura) as subtotales, u.nombre FROM factura f INNER JOIN 
                                usuario u ON u.idusuario=f.usuario WHERE DATE(fecha)='$actual' and f.estatus!=0 
                                and tipofactura=1 GROUP BY f.usuario ");
            $resultusuario =mysqli_num_rows($comprasusuario);

            $pdf->SetFont('Helvetica', '', 12);

            if($resultusuario > 0){
                while($data=mysqli_fetch_array($comprasusuario)){

                    $pdf->Cell(80, 6, "TOTAL COMPRAS REALIZADAS POR", 1,0,'L');
                    $pdf->Cell(60, 6, $data["nombre"], 1,0,'L');
                    $pdf->Cell(50, 6, "$ ".$data["subtotales"], 1,1,'L');
                
                }
            }


    //COMPRAS A CREDITO

    $pdf->Ln(10);
    $pdf->SetFont('Helvetica', 'B', 16);
    $pdf->Cell(92, 6, utf8_decode("*******************************************************************************"), 0,1,'L');

    $pdf->Cell(92, 6, utf8_decode("COMPRAS A CRÉDITO"), 0,1,'L');

    $pdf->Ln(3);
        
        


       
 // COLUMNAS

 $pdf->SetFont('Helvetica', 'B', 12);
 $pdf->Cell(35, 10, utf8_decode('No. RECIBO'), 0);
 $pdf->Cell(20, 10, 'HORA', 0);
 $pdf->Cell(30, 10, 'VALOR',0,0,'L');
 $pdf->Cell(50, 10, 'CLIENTE',0,0,'L');
 $pdf->Cell(55, 10, 'CAJERO',0,0,'L');
 $pdf->Ln(8);

    //query compras A CREDITO
  $querycompras=mysqli_query($conexion, "select f.nofactura, TIME(f.fecha) as fech, f.totalfactura, u.nombre, c.nombrec FROM factura f INNER JOIN 
  usuario u ON u.idusuario=f.usuario INNER JOIN cliente c ON c.idcliente=f.codcliente WHERE DATE(fecha)='$actual' and f.estatus!=0 
      and tipofactura=2 ORDER BY nofactura DESC ");
$result =mysqli_num_rows($querycompras);

$pdf->SetFont('Helvetica', '', 12);

if($result > 0){
while($data=mysqli_fetch_array($querycompras)){

    $hora=$data["fech"];
   

$pdf->Cell(25, 6, $data["nofactura"], 1,0,'L');
$pdf->Cell(30, 6, $hora, 1,0,'L');
$pdf->Cell(30, 6, "$ ".$data["totalfactura"], 1,0,'L');
$pdf->Cell(50, 6, $data["nombrec"], 1,0,'L');
$pdf->Cell(55, 6, $data["nombre"], 1,1,'L');
$total2=$total2+$data["totalfactura"];
}
}
$pdf->Ln(10);
$pdf->SetFont('Helvetica', 'B', 16);
$pdf->Cell(92, 6, utf8_decode("TOTAL COMPRAS A CRÉDITO"), 0,0,'L');
$pdf->Cell(60, 6, "$ ".$total2, 0,1,'L');




//COMPRAS A CREDITO

$pdf->Ln(10);
$pdf->SetFont('Helvetica', 'B', 16);
$pdf->Cell(92, 6, utf8_decode("*******************************************************************************"), 0,1,'L');
$pdf->Cell(92, 6, utf8_decode("COMPRAS ANULADAS"), 0,1,'L');

$pdf->Ln(3);
    
    


   
// COLUMNAS

$pdf->SetFont('Helvetica', 'B', 12);
$pdf->Cell(35, 10, utf8_decode('No. RECIBO'), 0);
$pdf->Cell(30, 10, 'HORA', 0);
$pdf->Cell(30, 10, 'VALOR',0,0,'L');
$pdf->Cell(50, 10, 'CLIENTE',0,0,'L');
$pdf->Cell(55, 10, 'CAJERO',0,0,'L');
$pdf->Ln(8);

//query compras Anuladas
$querycompras=mysqli_query($conexion, "select f.nofactura, time(f.fecha) as hora, f.totalfactura, u.nombre, c.nombrec FROM factura f INNER JOIN 
usuario u ON u.idusuario=f.usuario INNER JOIN cliente c ON c.idcliente=f.codcliente WHERE DATE(fecha)='$actual' and f.estatus=0 
   ");
$result =mysqli_num_rows($querycompras);

$pdf->SetFont('Helvetica', '', 12);

if($result > 0){
while($data=mysqli_fetch_array($querycompras)){

$pdf->Cell(25, 6, $data["nofactura"], 1,0,'L');
$pdf->Cell(30, 6, $data["hora"], 1,0,'L');
$pdf->Cell(30, 6, "$ ".$data["totalfactura"], 1,0,'L');
$pdf->Cell(50, 6, $data["nombrec"], 1,0,'L');
$pdf->Cell(55, 6, $data["nombre"], 1,1,'L');
$total3=$total3+$data["totalfactura"];
}
}
$pdf->Ln(10);
$pdf->SetFont('Helvetica', 'B', 16);
$pdf->Cell(92, 6, utf8_decode("TOTAL COMPRAS ANULADAS"), 0,0,'L');
$pdf->Cell(60, 6, "$ ".$total3, 0,1,'L');
            











   

        

        $pdf->Output();
    
?>