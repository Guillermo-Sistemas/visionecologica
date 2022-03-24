<?php


session_start();
$iduser=$_SESSION['idUser'];

$razon= ""; $nitempre= ""; $telefono= ""; $direccion=""; $ciudad= "";
$ajuste=0; $estado="Pendiente por Cobrar"; $motivo="";  $remision="";

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

 $empresa=mysqli_query($conexion, "select * from configuracion");
 $empresa2=mysqli_fetch_array($empresa);

 $razon= $empresa2["razon_social"];
 $nitempre= $empresa2["nit"];
 $telefono= $empresa2["telefono"];
 $direccion= $empresa2["direccion"];
 $ciudad= $empresa2["ciudad"];



 if(!empty($_GET['id'])){
     $numfactura=$_GET['id'];
 }else{ 
     //se recupera el id de la ultima factura
     $inicio=mysqli_query($conexion, "select MAX(nofacturav) from facturaV");
     $inicio1= mysqli_fetch_array($inicio);
     $numfactura=$inicio1[0];
 }

//se recuperan los datos de la fatura
$factura=mysqli_query($conexion, "select * from facturav WHERE nofacturav='$numfactura'");
$factura2=mysqli_fetch_array($factura);

$fecha=$factura2["fecha"];
$cajero= $factura2["usuario"];
$codcliente= $factura2["codcliente"];
$totalfactura= $factura2["totalfactura"];
$abono= $factura2["abono"];
$tipo= $factura2["tipofactura"];
$remision= $factura2["remision"];
$motivo= $factura2["motivo"];
$estatus= $factura2["estatus"];

$abono= $factura2["abono"];

if($tipo!=1){
    $tipo="Crédito";
}else{
    $tipo="Efectivo";    
}

if($abono==$totalfactura){
    $estado="Factura Cobrada";
}else{
    $saldo=$totalfactura-$abono;
    $saldo=number_format($saldo, 0, ",", ".");
    $estado=$estado." $".$saldo;
}



    $query_usuario=mysqli_query($conexion, "select nombre from usuario WHERE idusuario='$iduser'");
    $query_usuario1= mysqli_fetch_array($query_usuario);
    $nomuser=$query_usuario1[0];

    //nombre de cajero
    $query_usuario=mysqli_query($conexion, "select nombre from usuario WHERE idusuario='$cajero'");
    $query_usuario1= mysqli_fetch_array($query_usuario);
    $cajero=$query_usuario1[0];
    

    //nombre y nit del cliente
    $query_cliente=mysqli_query($conexion, "SELECT nit, nombrec from cliente WHERE idcliente='$codcliente'");
    $query_cliente1= mysqli_fetch_array($query_cliente);

    $nitcliente= $query_cliente1["nit"];
    $nombrecliente= $query_cliente1["nombrec"];


     //generar PDF
     require('fpdf/fpdf.php');

     define('EURO',chr(128)); // Constante con el símbolo Euro.
     $pdf = new FPDF('P','mm',array(82,200)); // Tamaño tickt 80mm x 150 mm (largo aprox)
     $pdf->AddPage();

      // CABECERA
      $pdf->SetFont('Helvetica', 'B',10);
      $pdf->Cell(60,4,utf8_decode($razon),0,1,'C');
      $pdf->SetFont('Helvetica','',9);
      $pdf->Cell(60,4,"NIT. ".$nitempre,0,1,'C');
      $pdf->Cell(60,4,$direccion,0,1,'C');
      $pdf->Cell(60,4,$telefono,0,1,'C');
      $pdf->Cell(60,4,utf8_decode($ciudad),0,1,'C');
      $pdf->SetFont('Helvetica', 'B',10);

      // DATOS FACTURA     
      
         
      $pdf->Ln(3);
      
      if($estatus==0){ 
        $pdf->Cell(35,4,'RECIBO ANULADO:',0,0,'');
        }else{ 
            $pdf->Cell(30,4,'Recibo de Venta:',0,0,'');    
        }

      $pdf->Cell(40,4,$numfactura,0,1,'');
      $pdf->Cell(15,4,'Fecha: ',0,0,'');
      $pdf->Cell(50,4,$fecha,0,1,'');
      $pdf->Cell(15,4,'Cliente: ',0,0,'');
      $pdf->Cell(50,4,utf8_decode($nombrecliente),0,1,'');
      $pdf->Cell(25,4,utf8_decode('Identificación: '),0,0,'');
      $pdf->Cell(35,4,$nitcliente,0,1,'');
      $pdf->Ln(2);
      $pdf->Cell(15,4,'Cajero:',0,0,'');
      $pdf->Cell(50,4,$cajero,0,1,'');

      if ($remision!=""){
        $pdf->Cell(35,4,utf8_decode('Remisión:'),0,0,'');
        $pdf->Cell(35,4,utf8_decode($remision),0,1,'');
        }else
            $pdf->Ln(4);

      //$pdf->Cell(60,4,'Metodo de pago: Tarjeta',0,1,'');

      // COLUMNAS
      $pdf->SetFont('Helvetica', 'B', 10);
      $pdf->Cell(22, 10, 'Producto', 0);
      $pdf->Cell(14, 10, 'Peso',0,0,'L');
      $pdf->Cell(13, 10, 'Valor',0,0,'L');
      $pdf->Cell(15, 10, 'SubTotal',0,0,'L');
      $pdf->Ln(8);
      $pdf->Cell(120,0,'','T');
      $pdf->Ln(0);

// PRODUCTOS
$pdf->SetFont('Helvetica', '', 8);

$query=mysqli_query($conexion,"SELECT * FROM detallefacturav WHERE nofacturav='$numfactura'");
$result =mysqli_num_rows($query);
                
if($result > 0){
    while($data=mysqli_fetch_array($query)){

        $nompro=substr($data["nomproducto"], 0, 13);

        $pdf->Cell(22, 10, $nompro , 0);
        $pdf->Cell(14, 10, $data["cantidad"], 0);
        $pdf->Cell(13, 10, "$".$data["valorkilo"], 0);
        $subt=number_format($data["subtotal"], 0, ",", ".");
        $pdf->Cell(15, 10, "$".$subt, 0);
        $pdf->Ln(4);
    }
    
}

// SUMATORIO DE LOS PRODUCTOS Y EL IVA
$pdf->Ln(4);
$pdf->Cell(120,0,'', 'B');
$pdf->Ln(2);
$pdf->SetFont('Helvetica', 'B', 10);    
$pdf->Cell(28, 5, 'TOTAL VENTA $', 0,0);
$totalfactura=number_format($totalfactura, 0, ",", ".");   
$pdf->Cell(20, 5,$totalfactura,0,1,'L');
if($ajuste!=0){
    $pdf->Cell(12, 5, 'AJUSTE $', 0,0);   
    $pdf->Cell(15, 5,$ajuste,0,0,'C');
}

$pdf->Cell(30, 5, 'Forma de Pago:', 0,0,'R'); 
$pdf->Cell(30, 5, utf8_decode($tipo), 0,1,'L'); 






//este va a quedarrrrrrrrrrr

if($abono>0){

    $pdf->Ln(3);
    $pdf->Cell(70,0,'','T');
    $pdf->Ln(1);
    $pdf->SetFont('Helvetica', 'B', 10);  
    $pdf->Cell(55, 5,$estado,0,1,'C');  
    $pdf->Cell(70, 5, utf8_decode('Detalle del Crédito '), 0,0, 'C');   
    
    $pdf->Ln(3);
   
    
     // COLUMNAS
     $pdf->SetFont('Helvetica', 'B', 9);
     $pdf->Cell(31, 10, 'Fecha', 0);
     $pdf->Cell(13, 10, 'Valor',0,0,'L');
     $pdf->Cell(13, 10, 'Pago',0,0,'L');
     $pdf->Cell(15, 10, 'Cajero',0,0,'L');
     $pdf->Ln(8);
     $pdf->Cell(70,0,'','T');
     $pdf->Ln(0);

        // PRODUCTOS
        $pdf->SetFont('Helvetica', '', 8);

        $queryabono=mysqli_query($conexion,"SELECT a.idabono, a.fecha, a.valor, a.tipo_abv, u.nombre  FROM
                                abonov a  INNER JOIN usuario u ON a.usuario_abv=u.idusuario  
                                WHERE facturav='$numfactura'" );
					$result1 =mysqli_num_rows($queryabono);
                    
        if($result > 0){
            while($data=mysqli_fetch_array($queryabono)){

                $pdf->Cell(30, 10, $data["fecha"], 0);
                $pdf->Cell(15, 10, "$".$data["valor"], 0);

                if ($data["tipo_abv"]==1){
                    $tipo="Efect";
                  }else{
                      $tipo="Consig";
                  }
                $nomb=substr($data["nombre"],0,11);
                $pdf->Cell(9, 10, utf8_decode($tipo), 0);
                $pdf->Cell(13, 10, $nomb, 0);
                $pdf->Ln(4);
            }
        }
    }



$pdf->Cell(20, 10, '', 0);
$pdf->Ln(3);
$pdf->Cell(120,0,'','T');
$pdf->Ln(3);

if($motivo!=""){
    //$pdf->Cell(37, 5, 'Recibo Anulado ', 0,1);   
    $pdf->Cell(50, 5,$motivo,0,1,'C');
    $pdf->Ln(3);
}
$pdf->Ln(1);

// PIE DE PAGINA
$pdf->Ln(2);
$pdf->SetFont('Helvetica', 'B', 7);
$pdf->Cell(20,0,'Impreso por:',0,0,'R');
$pdf->Cell(20,0,$nomuser,0,0,'C');
$pdf->Cell(50,0,$actual,0,1,'L');
$pdf->Ln(1);
$pdf->SetFont('Arial','I',8);
$pdf->Cell(0,9,utf8_decode(' Generado por TIS@ - Desarrollo de Software '),0,1,'C');
 
$pdf->Output('ticket.pdf','i');





















    
?>
