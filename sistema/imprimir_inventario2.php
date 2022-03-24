<?php

session_start();
$iduser=$_SESSION['idUser'];

include "../conexion.php";


$query_usuario=mysqli_query($conexion, "select nombre from usuario WHERE idusuario='$iduser'");
    $query_usuario1= mysqli_fetch_array($query_usuario);
    $iduser=$query_usuario1[0];


    //datos de la empresa
    $empresa=mysqli_query($conexion, "select * from configuracion");
    $empresa2=mysqli_fetch_array($empresa);

    $razon= $empresa2["razon_social"];
    $nitempre= $empresa2["nit"];
    $telefono= $empresa2["telefono"];
    $direccion= $empresa2["direccion"];
    $ciudad= $empresa2["ciudad"];


         //generar PDF
         require('fpdf/fpdf.php');

         define('EURO',chr(128)); // Constante con el símbolo Euro.
         $pdf = new FPDF('P','mm',array(215,140)); // Tamaño MEDIA CARTA
         $pdf->AddPage();

       
          // CABECERA
          $pdf->SetFont('Helvetica', 'B',14);
          $pdf->Cell(115,4,$razon,0,1,'C');
          $pdf->SetFont('Helvetica','',9);
          $pdf->Cell(115,4,$nitempre,0,1,'C');
          $pdf->Cell(50,4,$direccion,0,0,'R');
          $pdf->Cell(50,4,$telefono,0,1,'L');
          $pdf->Cell(115,4,$ciudad,0,1,'C');
       

        // Pie de página
        function Footer()
        {
            // Posición: a 1,5 cm del final
            $this->SetY(-25);
            // Arial italic 8
            $this->SetFont('Arial','I',8);
            $this->Cell(0,9,utf8_decode(' Generado por TIS@ - Desarrollo de Software '),0,1,'C');
            // Número de página
            $this->Cell(0,9,utf8_decode(' Página ').$this->PageNo().'/{nb}',0,0,'C');
        }
        


        $pdf = new PDF();
        $pdf -> AliasNbPages();
        $pdf->AddPage();
        $pdf->SetFont('Arial','B',12);


        $query=mysqli_query($conexion,"SELECT p.descripcion, p.precio_compra, p.existencia FROM
                    producto p WHERE p.existencia>0 ORDER BY p.descripcion" );

        $total=0;

        date_default_timezone_set('America/Bogota');
        $fechaactual2 = Date('Y-m-d H:i:s', time());

        $pdf->Cell(60,10, "Consultado por: ", 0 , 0 , 'L', 0 );
        $pdf->Cell(50,10, $iduser, 0 , 1 , 'L', 0 );
        $pdf->Cell(60,10, "Fecha Y Hora de Consulta: ", 0 , 0 , 'L', 0 );
        $pdf->Cell(50,10, $fechaactual2, 0 , 1 , 'L', 0 );
        $pdf->Cell(50,10, "", 0 , 1 , 'L', 0 );

        


        $pdf->Cell(60,10, "PRODUCTO", 1 , 0 , 'C', 0 );
        $pdf->Cell(40,10, "VALOR COMPRA", 1 , 0 , 'C', 0 );
        $pdf->Cell(40,10, "CANTIDAD", 1 , 0 , 'C', 0 );
        $pdf->Cell(40,10, "SUBTOTAL", 1 , 1 , 'C', 0 );

        $result =mysqli_num_rows($query);
					
					if($result > 0){
                        while($data=mysqli_fetch_array($query)){
                            $pdf->Cell(60,10, $data["descripcion"], 1 , 0 , 'L', 0 );
                            $pdf->Cell(40,10, "$ ".$data["precio_compra"], 1 , 0 , 'C', 0 );
                            $pdf->Cell(40,10, $data["existencia"], 1 , 0 , 'C', 0 );
                            $pdf->Cell(40,10, "$ ".$data["precio_compra"]*$data["existencia"], 1 , 1 , 'C', 0 );

                            $total=$total+$data["precio_compra"]*$data["existencia"];
                        }

                    }

                    $pdf->Cell(100,10, "VALOR TOTAL INVENTARIO", 1 , 0 , 'C', 0 );
                    $pdf->Cell(80,10, "$ ".$total, 1 , 0 , 'C', 0 );

    

        $pdf->Output();
    
?>