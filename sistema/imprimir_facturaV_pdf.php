<?php

$numfactura=$_GET['id'];

session_start();
$iduser=$_SESSION['idUser'];

include "../conexion.php";


$nitcliente= 0;
$nombrecliente= "";
$totalfactura=0;
$cajero= "";



    
    //nombre de usuario que va a imprimir la factura
    $query_usuario=mysqli_query($conexion, "select nombre from usuario WHERE idusuario='$iduser'");
    $query_usuario1= mysqli_fetch_array($query_usuario);
    $nomuser=$query_usuario1[0];

    
    //se recuperan los datos de la factura con el POST enviado
    $factura=mysqli_query($conexion, "select fecha, usuario, codcliente, totalfactura from facturaV WHERE nofacturav='$numfactura'");
    $factura2=mysqli_fetch_array($factura);

    $fecha=$factura2["fecha"];
    $cajero= $factura2["usuario"];
    $codcliente= $factura2["codcliente"];
    $totalfactura= $factura2["totalfactura"];

    //nombre de cajero
    $query_usuario=mysqli_query($conexion, "select nombre from usuario WHERE idusuario='$cajero'");
    $query_usuario1= mysqli_fetch_array($query_usuario);
    $cajero=$query_usuario1[0];
    

    //nombre y nit del cliente
    $query_cliente=mysqli_query($conexion, "SELECT nit, nombre from cliente WHERE idcliente='$codcliente'");
    $query_cliente1= mysqli_fetch_array($query_cliente);

    $nitcliente= $query_cliente1["nit"];
    $nombrecliente= $query_cliente1["nombre"];
    
   
        //generar PDF
        require('fpdf/fpdf.php');

        define('EURO',chr(128)); // Constante con el símbolo Euro.
        $pdf = new FPDF('P','mm',array(80,150)); // Tamaño tickt 80mm x 150 mm (largo aprox)
        $pdf->AddPage();

        // CABECERA
        $pdf->SetFont('Helvetica', 'B',14);
        $pdf->Cell(60,4,utf8_decode('RECUPERADORA SHADDAI'),0,1,'C');
        $pdf->SetFont('Helvetica','',9);
        $pdf->Cell(60,4,'NIT ',0,1,'C');
        $pdf->Cell(60,4,utf8_decode('CR 7 CL 7 ESQUINA'),0,1,'C');
        $pdf->Cell(60,4,utf8_decode('Chinchiná - Caldas'),0,1,'C');
        
 
        // DATOS FACTURA        
        $pdf->Ln(5);
        $pdf->Cell(30,4,'Recibo de Venta',0,0,'');
        $pdf->Cell(30,4,$numfactura,0,1,'');
        $pdf->Cell(30,4,'Fecha: ',0,0,'');
        $pdf->Cell(30,4,$fecha,0,1,'');
        $pdf->Cell(30,4,'Cliente: ',0,0,'');
        $pdf->Cell(30,4,utf8_decode($nombrecliente),0,1,'');
        $pdf->Cell(30,4,utf8_decode('Identificación: '),0,0,'');
        $pdf->Cell(30,4,$nitcliente,0,1,'');
        $pdf->Ln(2);
        $pdf->Cell(30,4,'Cajero',0,0,'');
        $pdf->Cell(30,4,$cajero,0,1,'');
        //$pdf->Cell(60,4,'Metodo de pago: Tarjeta',0,1,'');
 
        // COLUMNAS
        $pdf->SetFont('Helvetica', 'B', 8);
        $pdf->Cell(22, 10, 'Producto', 0);
        
        $pdf->Cell(10, 10, 'Peso',0,0,'L');
        $pdf->Cell(14, 10, 'Valor',0,0,'L');
        $pdf->Cell(10, 10, 'SubTot',0,0,'L');
        $pdf->Ln(8);
        $pdf->Cell(60,0,'','T');
        $pdf->Ln(0);
 
// PRODUCTOS
$pdf->SetFont('Helvetica', '', 8);


    $query=mysqli_query($conexion,"SELECT * FROM detallefacturaV WHERE nofacturav='$numfactura'");
    $result =mysqli_num_rows($query);
					
	if($result > 0){
        while($data=mysqli_fetch_array($query)){

            $pdf->Cell(22, 10, $data["nomproducto"], 0);
             $pdf->Cell(10, 10, $data["cantidad"], 0);
            $pdf->Cell(14, 10, "$".$data["valorkilo"], 0);
            $pdf->Cell(11, 10, "$".$data["subtotal"], 0);
            $pdf->Ln(3);
        }
        
    }



 
// SUMATORIO DE LOS PRODUCTOS Y EL IVA
$pdf->Ln(6);
$pdf->Cell(60,0,'', 'B');
$pdf->Ln(2);
$pdf->SetFont('Helvetica', 'B', 10);    
$pdf->Cell(30, 10, 'TOTAL A COBRAR  $', 0,0);   
$pdf->Cell(25, 10,$totalfactura,0,1,'C'); 
$pdf->Cell(20, 10, '', 0);

 
// PIE DE PAGINA
$pdf->Ln(5);
$pdf->SetFont('Helvetica', 'B', 7);
$pdf->Cell(30,0,'IMPRESO POR',0,0,'C');
$pdf->Cell(5,0,$nomuser,0,1,'C');
$pdf->Ln(5);
$pdf->SetFont('Arial','I',8);
$pdf->Cell(0,9,utf8_decode(' Generado por TIS@ - Desarrollo de Software '),0,1,'C');
 
$pdf->Output('ticket.pdf','i');
    
?>