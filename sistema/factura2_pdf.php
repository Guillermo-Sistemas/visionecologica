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
$estado="Pendiente de Pago"; $motivo="";
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
        $inicio=mysqli_query($conexion, "select MAX(nofactura) from factura");
        $inicio1= mysqli_fetch_array($inicio);
        $numfactura=$inicio1[0];
    }

    
    //se recuperan los datos de la fatura
    $factura=mysqli_query($conexion, "select * from factura WHERE nofactura='$numfactura'");
    $factura2=mysqli_fetch_array($factura);

    $fecha=$factura2["fecha"];
    $cajero= $factura2["usuario"];
    $codcliente= $factura2["codcliente"];
    $ajuste= $factura2["ajuste"];
    $totalfactura= $factura2["totalfactura"];
    $tipo= $factura2["tipofactura"];
    $remision= $factura2["remision"];
    $abono= $factura2["abono"];
    $estatus= $factura2["estatus"];
    $motivo= $factura2["motivo"];


    if($tipo!=1){
        $tipo="Crédito";
    }else{
        $tipo="Efectivo";    
    }

    if($abono==$totalfactura){
        $estado="Pagado en su Totalidad";
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
    $nombrecliente = substr($nombrecliente, 0,22);
    
   
        //generar PDF
        require('fpdf/fpdf.php');

        define('EURO',chr(128)); // Constante con el símbolo Euro.
        $pdf = new FPDF('P','mm',array(215,140)); // Tamaño MEDIA CARTA
        $pdf->AddPage();

        // CABECERA
        $pdf->SetFont('Helvetica', 'B',14);
        $pdf->Cell(115,4,$razon,0,1,'C');
        $pdf->SetFont('Helvetica','',9);
        $pdf->Cell(115,4,"NIT. ".$nitempre,0,1,'C');
        $pdf->Cell(50,4,$direccion,0,0,'R');
        $pdf->Cell(50,4,$telefono,0,1,'L');
        $pdf->Cell(115,4,$ciudad,0,1,'C');
        
 
        // DATOS FACTURA        
        $pdf->Ln(3);

        if($estatus==0){ 
            $pdf->Cell(30,4,'RECIBO ANULADO:',0,0,'');
        }else{ 
            $pdf->Cell(30,4,'Recibo de Compra:',0,0,'');    
        }

        
        $pdf->Cell(40,4,$numfactura,0,0,'');
        $pdf->Cell(22,4,'Fecha: ',0,0,'');
        $pdf->Cell(20,4,$fecha,0,1,'');
        $pdf->Cell(30,4,'Cliente: ',0,0,'');
        $pdf->Cell(40,4,utf8_decode($nombrecliente),0,0,'');
        $pdf->Cell(22,4,utf8_decode('Identificación: '),0,0,'');
        $pdf->Cell(20,4,$nitcliente,0,1,'');
        $pdf->Cell(30,4,'Cajero:',0,0,'');
        $pdf->Cell(40,4,$cajero,0,0,'');
        if ($remision!=""){
        $pdf->Cell(22,4,utf8_decode('Remisión:'),0,0,'');
        $pdf->Cell(20,4,utf8_decode($remision),0,1,'');
        }else
            $pdf->Ln(2);
        //$pdf->Cell(60,4,'Metodo de pago: Tarjeta',0,1,'');
 
        // COLUMNAS
        $pdf->SetFont('Helvetica', 'B', 10);
        $pdf->Cell(38, 10, 'Producto', 0);
        $pdf->Cell(20, 10, 'Peso',0,0,'L');
        $pdf->Cell(17, 10, 'Total',0,0,'L');
        $pdf->Cell(25, 10, 'Valor/kilo',0,0,'L');
        $pdf->Cell(15, 10, 'SubTotal',0,0,'L');
        $pdf->Ln(8);
        $pdf->Cell(120,0,'','T');
        $pdf->Ln(0);
 
// PRODUCTOS
$pdf->SetFont('Helvetica', '', 10);


    $query=mysqli_query($conexion,"SELECT * FROM detallefactura WHERE nofactura='$numfactura'");
    $result =mysqli_num_rows($query);
					
	if($result > 0){
        while($data=mysqli_fetch_array($query)){

            $pdf->Cell(40, 10, $data["nomproducto"], 0);
            $pdf->Cell(20, 10, $data["cantidades"], 0,0,'L');
            $pdf->Cell(20, 10, $data["cantidad"], 0);
            $pdf->Cell(20, 10, "$".$data["valorkilo"], 0);
            $subt=number_format($data["subtotal"], 0, ",", ".");
            $pdf->Cell(25, 10, "$".$subt, 0);
            $pdf->Ln(4);
        }
        
    }



 
// SUMATORIO DE LOS PRODUCTOS Y EL IVA
$pdf->Ln(4);
$pdf->Cell(120,0,'', 'B');
$pdf->Ln(2);
$pdf->SetFont('Helvetica', 'B', 10);    
$pdf->Cell(30, 5, 'TOTAL PAGADO $', 0,0);
$totalfactura=number_format($totalfactura, 0, ",", ".");   
$pdf->Cell(20, 5,$totalfactura,0,0,'C');
if($ajuste!=0){
    $pdf->Cell(12, 5, 'AJUSTE $', 0,0);   
    $pdf->Cell(15, 5,$ajuste,0,0,'C');
}

$pdf->Cell(30, 5, 'Forma de Pago:', 0,0,'R'); 
$pdf->Cell(15, 5, utf8_decode($tipo), 0,1,'L'); 



if($abono>0){

    $pdf->Ln(3);
    $pdf->Cell(120,0,'','T');
    $pdf->Ln(3);
    $pdf->SetFont('Helvetica', 'B', 12);    
    $pdf->Cell(64, 5, utf8_decode('Detalle del Pago Crédito - '), 0,0);   
    $pdf->Cell(30, 5,$estado,0,0,'C');
    $pdf->Ln(8);
   
    
     // COLUMNAS
     $pdf->SetFont('Helvetica', 'B', 10);
     $pdf->Cell(38, 10, 'Fecha', 0);
     $pdf->Cell(25, 10, 'Valor',0,0,'L');
     $pdf->Cell(30, 10, 'Forma de Pago',0,0,'L');
     $pdf->Cell(20, 10, 'Cajero',0,0,'L');
     $pdf->Ln(8);
     $pdf->Cell(120,0,'','T');
     $pdf->Ln(0);

        // PRODUCTOS
        $pdf->SetFont('Helvetica', '', 10);

        $queryabono=mysqli_query($conexion,"SELECT a.idabonoc, a.fecha, a.valor, a.tipo_abc, u.nombre  FROM
                    								abonoc a  INNER JOIN usuario u ON a.usuario_abc=u.idusuario  
													WHERE factura='$numfactura'" );
					$result1 =mysqli_num_rows($queryabono);
                    
        if($result > 0){
            while($data=mysqli_fetch_array($queryabono)){

                $pdf->Cell(40, 10, $data["fecha"], 0);
                $pdf->Cell(25, 10, "$".$data["valor"], 0);

                if ($data["tipo_abc"]==1){
                    $tipo="Efectivo";
                  }else{
                      $tipo="Consignación";
                  }

                $pdf->Cell(30, 10, utf8_decode($tipo), 0);
                $pdf->Cell(20, 10, $data["nombre"], 0);
                $pdf->Ln(4);
            }
        }
    }

$pdf->Cell(20, 10, '', 0);
$pdf->Ln(3);
$pdf->Cell(120,0,'','T');
$pdf->Ln(3);














$pdf->Ln(3);

if($motivo!=""){
    $pdf->Cell(37, 5, 'Recibo Anulado por', 0,0);   
    $pdf->Cell(50, 5,$motivo,0,0,'C');
}
$pdf->Ln(3);
// PIE DE PAGINA
$pdf->Ln(5);
$pdf->SetFont('Helvetica', 'B', 7);
$pdf->Cell(45,0,'Impreso por:',0,0,'R');
$pdf->Cell(25,0,$nomuser,0,0,'C');
$pdf->Cell(60,0,$actual,0,1,'L');
$pdf->Ln(1);
$pdf->SetFont('Arial','I',8);
$pdf->Cell(0,9,utf8_decode(' Generado por TIS@ - Desarrollo de Software '),0,1,'C');
 
$pdf->Output('ticket.pdf','i');
    
?>
