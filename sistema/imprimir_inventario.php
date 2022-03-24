<?php

session_start();
$iduser=$_SESSION['idUser'];

$razon= ""; $nitempre= ""; $telefono= ""; $direccion=""; $ciudad= "";

include "../conexion.php";

$numfactura=0;
$nitcliente= 0;
$nombrecliente= "";
$totalfactura=0;
$cajero= "";
$usuarioqpaga="";
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
        $pdf->Cell(200,4,"INVENTARIO GENERAL",0,1,'C');
        $pdf->Ln(1);

        $pdf->SetFont('Helvetica', 'B',14);
        $pdf->Cell(200,4,utf8_decode($razon),0,1,'C');
        $pdf->SetFont('Helvetica','',9);
        $pdf->Cell(200,4,"NIT ".$nitempre,0,1,'C');
        $pdf->Cell(100,4,$direccion,0,0,'R');
        $pdf->Cell(100,4,$telefono,0,1,'L');
        $pdf->Cell(200,4,utf8_decode($ciudad),0,1,'C');
        $pdf->Ln(5);
        
 
       
 
// PRODUCTOS
$pdf->SetFont('Helvetica', '', 10);


$query=mysqli_query($conexion,"SELECT p.descripcion, p.precio_compra, p.existencia FROM
producto p WHERE p.existencia>0 ORDER BY p.existencia DESC" );

$total=0;

date_default_timezone_set('America/Bogota');
$fechaactual2 = Date('Y-m-d H:i:s', time());
$pdf->SetFont('Helvetica', 'B',13);
$pdf->Cell(70,10, "Consultado por: ", 0 , 0 , 'L', 0 );
$pdf->Cell(50,10, $nomuser, 0 , 1 , 'L', 0 );
$pdf->Cell(70,10, "Fecha Y Hora de Consulta: ", 0 , 0 , 'L', 0 );
$pdf->Cell(50,10, $fechaactual2, 0 , 1 , 'L', 0 );
$pdf->Cell(50,10, "", 0 , 1 , 'L', 0 );




$pdf->Cell(60,10, "PRODUCTO", 1 , 0 , 'C', 0 );
$pdf->Cell(40,10, "VALOR COMPRA", 1 , 0 , 'C', 0 );
$pdf->Cell(40,10, "CANTIDAD", 1 , 0 , 'C', 0 );
$pdf->Cell(40,10, "SUBTOTAL", 1 , 1 , 'C', 0 );
$pdf->SetFont('Helvetica', '',12);
$result =mysqli_num_rows($query);

if($result > 0){
    while($data=mysqli_fetch_array($query)){
        $pdf->Cell(60,10, $data["descripcion"], 1 , 0 , 'L', 0 );
        $pdf->Cell(40,10, "$ ".number_format($data["precio_compra"], 0, ",", "."), 1 , 0 , 'C', 0 );
        $pdf->Cell(40,10, number_format($data["existencia"], 2, ",", "."), 1 , 0 , 'C', 0 );
        $pdf->Cell(40,10, "$ ". number_format($data["precio_compra"]*$data["existencia"], 0, ",", "."), 1 , 1 , 'R', 0 );

        $total=$total+$data["precio_compra"]*$data["existencia"];
    }

}
$pdf->SetFont('Helvetica', 'B',14);
$pdf->Cell(100,10, "VALOR TOTAL INVENTARIO", 1 , 0 , 'C', 0 );
$pdf->Cell(80,10, "$ ".number_format($total, 2, ",", "."), 1 , 0 , 'C', 0 );



 


 
$pdf->Output('inventario.pdf','i');
    
?>
