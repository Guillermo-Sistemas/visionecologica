<?php
    date_default_timezone_set('America/Bogota');

    function fechaC(){
        $meses = array("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");

            return date('d') . ' de '  . $meses[date('n')-1] . ' de ' . date('Y');
        }
?> 