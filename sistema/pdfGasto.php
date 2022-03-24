<?php

session_start();
$iduser=$_SESSION['idUser'];

$razon= ""; $nitempre= ""; $telefono= ""; $direccion=""; $ciudad= "";

include "../conexion.php";

$nomgasto="Sin Tipo";
$tipo=0; $tercero=0;



$totalgasto=0;
if($_POST['tipo']){
    $tipo=$_POST['tipo'];
    $query_tipo=mysqli_query($conexion, "select nombregasto from tipo_gasto WHERE idtipogasto=$tipo");
    $query_tipo1= mysqli_fetch_array($query_tipo);
    $nomgasto=$query_tipo1[0];
}else{  
    $nomgasto="TODOS LOS GASTOS";
}
if($_POST['tercero']){
    $tercero=$_POST['tercero'];
    $query_tercero=mysqli_query($conexion, "select nombrec from cliente WHERE idcliente=$tercero");
    $query_tercero1= mysqli_fetch_array($query_tercero);
    $nomtercero=$query_tercero1[0];

}else   
    $nomtercero="TODOS LOS TERCEROS";
if($_POST['desde']){
    $desdef=$_POST['desde'];
}else   
    $desdef="Sin Fecha";
if($_POST['hasta']){
    $hasta=$_POST['hasta'];
}else{  
    $hasta="Sin Fecha";
}

    





                    $dia=substr( $desdef, 3, 2 );
					$mes=substr( $desdef, 0, 2 );
					$ano=substr( $desdef, 6, 4 );
                    $desdef=$ano."-".$mes."-".$dia;
                    $desdef2=$dia."-".$mes."-".$ano;

                    if(!$_POST['desde']){
                        $desdef2="No selecciono fecha Inicial";
                    }
                   

                   
					$hasta=$_POST['hasta'];

					$dia=substr( $hasta, 3, 2 );
					$mes=substr( $hasta, 0, 2 );
					$ano=substr( $hasta, 6, 4 );

					$hasta=$ano."-".$mes."-".$dia;
                    $hasta2=$dia."-".$mes."-".$ano;

                    if(!$_POST['hasta']){
                        $hasta2="No selecciono fecha Final";
                    }


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
    $gastomay=0;
    $gastocon=0;



    
    
      
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
        $pdf->Cell(200,4,"INFORME DE GASTOS",0,1,'C');
        $pdf->Ln(1);

        $pdf->SetFont('Helvetica', 'B',14);
        $pdf->Cell(200,4,utf8_decode($razon),0,1,'C');
        $pdf->SetFont('Helvetica','',9);
        $pdf->Cell(200,4,"NIT ".$nitempre,0,1,'C');
        $pdf->Cell(100,4,$direccion,0,0,'R');
        $pdf->Cell(100,4,$telefono,0,1,'L');
        $pdf->Cell(200,4,utf8_decode($ciudad),0,1,'C');
        $pdf->Ln(6);
        
 
 
        $qtotal=mysqli_query($conexion,"SELECT SUM(valorgasto) as totalgasto
                                    FROM gasto WHERE DATE(fechagasto)>='$desdef' 
                                    and DATE(fechagasto)<='$hasta'" );
    
        $totalg=mysqli_fetch_array($qtotal);
        $valortgasto=$totalg["totalgasto"];

        $qtotalrec=mysqli_query($conexion,"SELECT SUM(valorgasto) as totalgasto
                                    FROM gasto WHERE DATE(fechagasto)>='$desdef' 
                                    and DATE(fechagasto)<='$hasta' and procedencia=1" );
    
        $totalgrec=mysqli_fetch_array($qtotalrec);
        $gastorec=$totalgrec["totalgasto"];

        $qtotalmay=mysqli_query($conexion,"SELECT SUM(valorgasto) as totalgasto
        FROM gasto WHERE DATE(fechagasto)>='$desdef' 
        and DATE(fechagasto)<='$hasta' and procedencia=2" );

        $totalgmay=mysqli_fetch_array($qtotalmay);
        $gastomay=$totalgmay["totalgasto"];

        if(!$gastomay)
            $gastomay=0;

        $qtotalcon=mysqli_query($conexion,"SELECT SUM(valorgasto) as totalgasto
        FROM gasto WHERE DATE(fechagasto)>='$desdef' 
        and DATE(fechagasto)<='$hasta' and procedencia=3" );

        
        $totalgcon=mysqli_fetch_array($qtotalcon);
        $gastocon=$totalgcon["totalgasto"];

        if(!$gastocon)
            $gastocon=0;
 
// DATOS DE CONSULTA
$pdf->SetFont('Helvetica', 'B',12);

date_default_timezone_set('America/Bogota');
$fechaactual2 = Date('Y-m-d H:i:s', time());
$pdf->SetFont('Helvetica', 'B',12);
$pdf->Cell(60,10, "Consultado por: ", 0 , 0 , 'L', 0 );
$pdf->SetFont('Helvetica', '', 12);
$pdf->Cell(50,10, $nomuser, 0 , 1 , 'L', 0 );
$pdf->SetFont('Helvetica', 'B',12);
    $pdf->Cell(60,10, "Tercero: ", 0 , 0 , 'L', 0 );
    $pdf->SetFont('Helvetica', '', 12);
    $pdf->Cell(50,10, $nomtercero, 0 , 1 , 'L', 0 );


$pdf->SetFont('Helvetica', 'B',12);
$pdf->Cell(60,10, "Fecha Y Hora de Consulta: ", 0 , 0 , 'L', 0 );
$pdf->SetFont('Helvetica', '', 12);
$pdf->Cell(50,10, $fechaactual2, 0 , 1 , 'L', 0 );

if ($tipo==0 && $tercero==0){

    $pdf->SetFont('Helvetica', 'B',12);
    $pdf->Cell(60,10, "Tipo de Gasto: ", 0 , 0 , 'L', 0 );
    $pdf->SetFont('Helvetica', '', 12);
    $pdf->Cell(50,10, $nomgasto, 0 , 1 , 'L', 0 );
    $pdf->SetFont('Helvetica', 'B',12);
    $pdf->Cell(60,10, "Total Gastos: ", 0 , 0 , 'L', 0 );
    $pdf->SetFont('Helvetica', '', 12);
    $valortgasto=number_format($valortgasto, 0, ",", ".");
    $pdf->Cell(50,10, "$ ".$valortgasto, 0 , 1 , 'L', 0 );
    $pdf->SetFont('Helvetica', 'B',12);
    $pdf->Cell(60,10, "Efectivo Caja Menor: ", 0 , 0 , 'L', 0 );
    $pdf->SetFont('Helvetica', '', 12);
    $gr=number_format($gastorec, 0, ",", ".");
    $pdf->Cell(50,10, "$ ".$gr, 0 , 1 , 'L', 0 );

    $pdf->SetFont('Helvetica', 'B',12);
    $pdf->Cell(60,10, "Efectivo Caja Mayor: ", 0 , 0 , 'L', 0 );
    $pdf->SetFont('Helvetica', '', 12);
    $gm=number_format($gastomay, 0, ",", ".");
    $pdf->Cell(50,10, "$ ".$gm, 0 , 1 , 'L', 0 );
    $pdf->SetFont('Helvetica', 'B',12);
    $pdf->Cell(60,10, "Consignaciones: ", 0 , 0 , 'L', 0 );
    $pdf->SetFont('Helvetica', '', 12);
    $gc=number_format($gastocon, 0, ",", ".");
    $pdf->Cell(50,10, "$ ".$gc, 0 , 1 , 'L', 0 );
    
}
   




$pdf->SetFont('Helvetica', 'B',12);
$pdf->Cell(60,10, "Periodo Consultado: ", 0 , 0 , 'L', 0 );
$pdf->SetFont('Helvetica', '', 12);
$pdf->Cell(50,10, "Del ". $desdef2. " Hasta el ". $hasta2, 0 , 1 , 'L', 0 );
$pdf->Cell(50,10, "", 0 , 1 , 'L', 0 );



//si se selcciono tipo de gasto y tercero
if ($tipo>0 && $tercero>0){

    $qg=mysqli_query($conexion,"SELECT SUM(g.valorgasto) as tgasto, t.nombregasto 
                                    FROM gasto g INNER JOIN tipo_gasto t 
                                    ON t.idtipogasto=g.idtipogasto
                                    WHERE DATE(fechagasto)>='$desdef' 
                                    and DATE(fechagasto)<='$hasta' 
                                    and g.idtipogasto=$tipo
                                    and idcliente=$tercero " );
    
    $dg=mysqli_num_rows($qg);
    

   

    $pdf->SetFont('Helvetica', 'B',11);
    //$pdf->Cell(35,10, "GASTO", 1 , 0 , 'C', 0 );
    $pdf->Cell(100,10, "TIPO DE GASTO", 1 , 0 , 'C', 0 );
    $pdf->Cell(70,10, "VALOR TOTAL", 1 , 1 , 'C', 0 );



					
	if($dg > 0){
        while($dacu=mysqli_fetch_array($qg)){

            $pdf->Cell(100, 7, $dacu["nombregasto"], 1,0,'L');
            

            $vk=number_format($dacu["tgasto"], 0, ",", ".");

            $pdf->Cell(70, 7, "$ ".$vk, 1,1,'L');
        }
    }
   
   $qtotalrec=mysqli_query($conexion,"SELECT SUM(valorgasto) as totalgasto
                                    FROM gasto WHERE DATE(fechagasto)>='$desdef' 
                                    and DATE(fechagasto)<='$hasta' and procedencia=1
                                    and idtipogasto=$tipo and idcliente=$tercero " );
    
        $totalgrec=mysqli_fetch_array($qtotalrec);
        $gastorec=$totalgrec["totalgasto"];

        $qtotalmay=mysqli_query($conexion,"SELECT SUM(valorgasto) as totalgasto
                                    FROM gasto WHERE DATE(fechagasto)>='$desdef' 
                                    and DATE(fechagasto)<='$hasta' and procedencia=2
                                    and idtipogasto=$tipo and idcliente=$tercero " );
    
        $totalgmay=mysqli_fetch_array($qtotalmay);
        $gastomay=$totalgmay["totalgasto"];

        $qtotalcon=mysqli_query($conexion,"SELECT SUM(valorgasto) as totalgasto
        FROM gasto WHERE DATE(fechagasto)>='$desdef' 
        and DATE(fechagasto)<='$hasta' and procedencia=3
        and idtipogasto=$tipo and idcliente=$tercero " );

        $totalgcon=mysqli_fetch_array($qtotalcon);
        $gastocon=$totalgcon["totalgasto"];

  
       

    $pdf->SetFont('Helvetica', 'B',12);
    $pdf->Cell(60,10, "Efectivo Caja Menor: ", 0 , 0 , 'L', 0 );
    $pdf->SetFont('Helvetica', '', 12);
    $gr=number_format($gastorec, 0, ",", ".");
    $pdf->Cell(50,10, "$ ".$gr, 0 , 1 , 'L', 0 );
    $pdf->SetFont('Helvetica', 'B',12);
    $pdf->Cell(60,10, "Efectivo Caja Mayor: ", 0 , 0 , 'L', 0 );
    $pdf->SetFont('Helvetica', '', 12);
    $gm=number_format($gastomay, 0, ",", ".");
    $pdf->Cell(50,10, "$ ".$gm, 0 , 1 , 'L', 0 );
    $pdf->SetFont('Helvetica', 'B',12);
    $pdf->Cell(60,10, "Consignaciones: ", 0 , 0 , 'L', 0 );
    $pdf->SetFont('Helvetica', '', 12);
    $gc=number_format($gastocon, 0, ",", ".");
    $pdf->Cell(50,10, "$ ".$gc, 0 , 1 , 'L', 0 );


   //discriminado por terceros y por tipo
    
    $qg=mysqli_query($conexion,"SELECT g.valorgasto, g.fechagasto, g.nota, c.nombrec 
                                    FROM gasto g INNER JOIN cliente c 
                                    ON c.idcliente=g.idcliente
                                    WHERE DATE(fechagasto)>='$desdef' 
                                    and DATE(fechagasto)<='$hasta' 
                                    and g.idtipogasto=$tipo
                                    and g.idcliente=$tercero and procedencia=1" );
    
    $dg=mysqli_num_rows($qg);

    $pdf->Cell(190, 7, "",0 ,1,'C');
    $pdf->SetFont('Helvetica', 'B',12 );
    $pdf->Cell(190, 7, "DISCRIMINADO POR FECHA - CAJA MENOR",0 ,1,'C');
    

   

    $pdf->SetFont('Helvetica', 'B',11);
    //$pdf->Cell(35,10, "GASTO", 1 , 0 , 'C', 0 );
    $pdf->Cell(40,10, "FECHA", 1 , 0 , 'C', 0 );
     $pdf->Cell(100,10, "NOTA", 1 , 0 , 'C', 0 );
    $pdf->Cell(30,10, "VALOR ", 1 , 1 , 'C', 0 );



    $pdf->SetFont('Helvetica', '',11);			
	if($dg > 0){
        while($dacu=mysqli_fetch_array($qg)){

            $pdf->Cell(40, 7, $dacu["fechagasto"], 1,0,'L');
             $pdf->Cell(100, 7, $dacu["nota"], 1,0,'L');
            

            $vk=number_format($dacu["valorgasto"], 0, ",", ".");

            $pdf->Cell(30, 7, "$ ".$vk, 1,1,'L');
        }
    }


    //discriminado por terceros y por tipo
    
    $qg=mysqli_query($conexion,"SELECT g.valorgasto, g.fechagasto, g.nota, c.nombrec 
                                    FROM gasto g INNER JOIN cliente c 
                                    ON c.idcliente=g.idcliente
                                    WHERE DATE(fechagasto)>='$desdef' 
                                    and DATE(fechagasto)<='$hasta' 
                                    and g.idtipogasto=$tipo
                                    and g.idcliente=$tercero and procedencia=2 OR procedencia=3" );
    
    $dg=mysqli_num_rows($qg);

    if ($dg>0){

        $pdf->Cell(190, 7, "",0 ,1,'C');
        $pdf->SetFont('Helvetica', 'B',12 );
        $pdf->Cell(190, 7, "DISCRIMINADO POR FECHA - CAJA MAYOR Y CONSIGNACIONES",0 ,1,'C');
        

    

        $pdf->SetFont('Helvetica', 'B',11);
        //$pdf->Cell(35,10, "GASTO", 1 , 0 , 'C', 0 );
        $pdf->Cell(40,10, "FECHA", 1 , 0 , 'C', 0 );
        $pdf->Cell(100,10, "NOTA", 1 , 0 , 'C', 0 );
        $pdf->Cell(30,10, "VALOR ", 1 , 1 , 'C', 0 );



        $pdf->SetFont('Helvetica', '',11);			
        if($dg > 0){
            while($dacu=mysqli_fetch_array($qg)){

                $pdf->Cell(40, 7, $dacu["fechagasto"], 1,0,'L');
                $pdf->Cell(100, 7, $dacu["nota"], 1,0,'L');
                

                $vk=number_format($dacu["valorgasto"], 0, ",", ".");

                $pdf->Cell(30, 7, "$ ".$vk, 1,1,'L');
            }
        }
    }


}elseif($tipo>0){
    //si selecciona gasto------------------------------***********************************

    $qg=mysqli_query($conexion,"SELECT SUM(g.valorgasto) as tgasto, t.nombregasto 
                                    FROM gasto g INNER JOIN tipo_gasto t 
                                    ON t.idtipogasto=g.idtipogasto
                                    WHERE DATE(fechagasto)>='$desdef' 
                                    and DATE(fechagasto)<='$hasta' 
                                    and g.idtipogasto=$tipo" );
    
    $dg=mysqli_num_rows($qg);
    

   

    $pdf->SetFont('Helvetica', 'B',11);
    //$pdf->Cell(35,10, "GASTO", 1 , 0 , 'C', 0 );
    $pdf->Cell(100,10, "TIPO DE GASTO", 1 , 0 , 'C', 0 );
    $pdf->Cell(70,10, "VALOR TOTAL", 1 , 1 , 'C', 0 );



					
	if($dg > 0){
        while($dacu=mysqli_fetch_array($qg)){

            $pdf->Cell(100, 7, $dacu["nombregasto"], 1,0,'L');
            

            $vk=number_format($dacu["tgasto"], 0, ",", ".");

            $pdf->Cell(70, 7, "$ ".$vk, 1,1,'L');
        }
    }

    //-----------------ojooooooooooooooooooooo no da


    $qtotalrec=mysqli_query($conexion,"SELECT SUM(valorgasto) as totalgasto
    FROM gasto WHERE DATE(fechagasto)>='$desdef' 
    and DATE(fechagasto)<='$hasta' and procedencia=1
    and idtipogasto=$tipo  " );

        $totalgrec=mysqli_fetch_array($qtotalrec);
        $gastorec=$totalgrec["totalgasto"];



        $pdf->SetFont('Helvetica', 'B',12);
        $pdf->Cell(60,10, "Efectivo Caja Menor: ", 0 , 0 , 'L', 0 );
        $pdf->SetFont('Helvetica', '', 12);
        $gr=number_format($gastorec, 0, ",", ".");
        $pdf->Cell(50,10, "$ ".$gr, 0 , 1 , 'L', 0 );

        $pdf->SetFont('Helvetica', 'B',12);
        $pdf->Cell(60,10, "Efectivo Caja Mayor: ", 0 , 0 , 'L', 0 );
        $pdf->SetFont('Helvetica', '', 12);
        $gm=number_format($gastomay, 0, ",", ".");
        $pdf->Cell(50,10, "$ ".$gm, 0 , 1 , 'L', 0 );
        $pdf->SetFont('Helvetica', 'B',12);
        $pdf->Cell(60,10, "Consignaciones: ", 0 , 0 , 'L', 0 );
        $pdf->SetFont('Helvetica', '', 12);
        $gc=number_format($gastocon, 0, ",", ".");
        $pdf->Cell(50,10, "$ ".$gc, 0 , 1 , 'L', 0 );


    $pdf->SetFont('Helvetica', 'B',12);
    $pdf->Cell(190, 7, "",0 ,1,'C');
    $pdf->Cell(190, 7, "DISCRIMINADO POR TERCERO - CAJA MENOR",0 ,1,'C');

    //discriminado por terceros***************************
    
    $qg=mysqli_query($conexion,"SELECT SUM(g.valorgasto) as tgasto, c.nombrec 
                                    FROM gasto g INNER JOIN cliente c 
                                    ON c.idcliente=g.idcliente
                                    WHERE DATE(fechagasto)>='$desdef' 
                                    and DATE(fechagasto)<='$hasta' 
                                    and g.idtipogasto=$tipo
                                    GROUP BY g.idcliente" );
    
    $dg=mysqli_num_rows($qg);
    

   

    $pdf->SetFont('Helvetica', 'B',11);
    //$pdf->Cell(35,10, "GASTO", 1 , 0 , 'C', 0 );
   $pdf->Cell(100,10, "TERCERO", 1 , 0 , 'C', 0 );
   $pdf->Cell(70,10, "VALOR ", 1 , 1 , 'C', 0 );



    $pdf->SetFont('Helvetica', '',11);			
	if($dg > 0){
        while($dacu=mysqli_fetch_array($qg)){

           $pdf->Cell(100, 7, $dacu["nombrec"], 1,0,'L');
            

            $vk=number_format($dacu["tgasto"], 0, ",", ".");

            $pdf->Cell(70, 7, "$ ".$vk, 1,1,'L');
        }
    }


    $pdf->SetFont('Helvetica', 'B',12);
    $pdf->Cell(190, 7, "",0 ,1,'C');
    $pdf->Cell(190, 7, "DISCRIMINADO POR TERCERO - CAJA MAYOR",0 ,1,'C');

    //discriminado por terceros***************************
    
    $qg=mysqli_query($conexion,"SELECT SUM(g.valorgasto) as tgasto, c.nombrec 
                                    FROM gasto g INNER JOIN cliente c 
                                    ON c.idcliente=g.idcliente
                                    WHERE DATE(fechagasto)>='$desdef' 
                                    and DATE(fechagasto)<='$hasta' 
                                    and g.idtipogasto=$tipo
                                    AND (procedencia=2 OR PROCEDENCIA=3)
                                    GROUP BY g.idcliente" );
    
    $dg=mysqli_num_rows($qg);
    

   

    $pdf->SetFont('Helvetica', 'B',11);
    //$pdf->Cell(35,10, "GASTO", 1 , 0 , 'C', 0 );
   $pdf->Cell(100,10, "TERCERO", 1 , 0 , 'C', 0 );
   $pdf->Cell(70,10, "VALOR ", 1 , 1 , 'C', 0 );



    $pdf->SetFont('Helvetica', '',11);			
	if($dg > 0){
        while($dacu=mysqli_fetch_array($qg)){

           $pdf->Cell(100, 7, $dacu["nombrec"], 1,0,'L');
            

            $vk=number_format($dacu["tgasto"], 0, ",", ".");

            $pdf->Cell(70, 7, "$ ".$vk, 1,1,'L');
        }
    }


}else{
    //si no se selecciona ni tipo ni tercero


    $qg=mysqli_query($conexion,"SELECT SUM(g.valorgasto) as tgasto, t.nombregasto 
                                    FROM gasto g INNER JOIN tipo_gasto t 
                                    ON t.idtipogasto=g.idtipogasto
                                    WHERE DATE(fechagasto)>='$desdef' 
                                    and DATE(fechagasto)<='$hasta' and procedencia=1
                                    GROUP BY g.idtipogasto ORDER BY nombregasto  " );
    
    $dg=mysqli_num_rows($qg);
    



$pdf->SetFont('Helvetica', 'B',13);
//$pdf->Cell(35,10, "GASTO", 1 , 0 , 'C', 0 );
$pdf->Cell(170,10, "GASTOS PAGADOS CAJA MENOR", 0 , 1 , 'C', 0 );
$pdf->Cell(100,10, "TIPO DE GASTO", 1 , 0 , 'C', 0 );
$pdf->Cell(70,10, "VALOR TOTAL", 1 , 1 , 'C', 0 );
$pdf->SetFont('Helvetica', '',11);


					
	if($dg > 0){
        while($dacu=mysqli_fetch_array($qg)){

            $pdf->Cell(100, 7, $dacu["nombregasto"], 1,0,'L');
            

            $vk=number_format($dacu["tgasto"], 0, ",", ".");

            $pdf->Cell(70, 7, "$ ".$vk, 1,1,'L');
        }
    }


    $qg=mysqli_query($conexion,"SELECT SUM(g.valorgasto) as tgasto, t.nombregasto 
                                    FROM gasto g INNER JOIN tipo_gasto t 
                                    ON t.idtipogasto=g.idtipogasto
                                    WHERE DATE(fechagasto)>='$desdef' 
                                    and DATE(fechagasto)<='$hasta'
                                    and (procedencia=2 OR procedencia=3) 
                                    GROUP BY g.idtipogasto
                                    ORDER BY nombregasto  " );
    
    $dg=mysqli_num_rows($qg);
    



$pdf->SetFont('Helvetica', 'B',13);
$pdf->Cell(170,10, "", 0 , 1 , 'C', 0 );
$pdf->Cell(170,10, "GASTOS PAGADOS EFECTIVO CAJA MAYOR O CONSIGNACIÓN", 0 , 1 , 'C', 0 );
$pdf->Cell(100,10, "TIPO DE GASTO", 1 , 0 , 'C', 0 );
$pdf->Cell(70,10, "VALOR TOTAL", 1 , 1 , 'C', 0 );
$pdf->SetFont('Helvetica', '',11);


					
	if($dg > 0){
        while($dacu=mysqli_fetch_array($qg)){

            $pdf->Cell(100, 7, $dacu["nombregasto"], 1,0,'L');
            

            $vk=number_format($dacu["tgasto"], 0, ",", ".");

            $pdf->Cell(70, 7, "$ ".$vk, 1,1,'L');
        }
    }


}//fin sin tipo ni tercero


    



$pdf->Output('Informe Gastos.pdf','i');
    
?>