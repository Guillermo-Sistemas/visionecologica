<link rel="stylesheet" href="css/style.css" type="text/css" media="screen">
<link rel="stylesheet" href="css/all.css" type="text/css" media="screen">
<link rel=”stylesheet” href=”css/font-awesome.min.css“>


    <ul id="nav">
        <li ><a href="index.php"><i class="fas fa-home"></i> Inicio</a></li>
        <li><a href=""><i class="fas fa-file-invoice-dollar"></i> Caja</a>
            <ul>
                <li><a href="abrir_cuadre.php">Iniciar Caja</a></li>
		<li><a href="">Bases</a>
			<ul>
                		<li><a href="bases.php">Agregar Base</a></li>
				<li><a href="editar_base.php">Modificar Base</a></li>
				<li><a href="listar_base.php">Consultar Bases</a></li>
           		</ul>
		
                <li><a href="">Gastos</a>
					<ul>
                		<li><a href="registro_gasto.php">Registrar</a></li>
                		<li><a href="listar_gasto.php">Consultar</a></li>
						<li><a href="buscar_gasto.php">Buscar</a>
							
						</li>
            		</ul>

					<li><a href="">Prestamos</a>
					<ul>
                		<li><a href="listar_prestamo.php">Consultar</a></li>
						<li><a href="buscar_prestamo.php">Buscar</a>
							
						</li>
            		</ul>
					
					
                <li><a href="cerrar_cuadre.php">Cerrar Caja</a></li>
		<li><a href="listar_cuadre.php">Consultar Cuadres de Caja</a></li>
            </ul>
        </li>
        <li><a href=""><i class="fab fa-product-hunt"></i> Productos</a>
            <ul>
                <li><a href="registro_producto.php">Nuevo</a></li>
                <li><a href="listar_producto1.php">Consultar</a></li>
		<li><a href="">Subproducto</a>
			<ul>
                                <li><a href="registro_subproducto.php">Nuevo</a></li>
                                <li><a href="listar_subproducto.php" >Consultar</a></li>
                    	</ul> 
		</li>
		<li><a href="">Artículos Recuperados</a>
			<ul>
                                <li><a href="registro_recuperado.php">Nuevo</a></li>
                                <li><a href="listar_recuperado.php" >Consultar</a></li>
				<li><a href="articulos_vendidos.php" >Vendidos</a></li>
				<li><a href="articulos_eliminados.php" >Eliminados</a></li>
                    	</ul> 
		</li>
		<li><a href="recuperar_material.php">Recuperar Material</a>
		</li>
            </ul>
        </li>
        <li><a href=""><i class="fas fa-people-carry"></i> Compras</a>
            <ul>
                <li><a href="nueva_compra.php">Registrar Compra</a></li>
                <li><a href="nueva_compra.php" target="_blank">Registrar Otra Compra</a></li>
                <li><a href="factura_pdf.php" target="_blank">Ultima Compra</a>

				<li><a href="index.php">Devolución Compras</a>
					<ul>
                		<li><a href="registro_devolucionc.php">Registrar</a></li>
                		<li><a href="listar_devolucionc.php">Consultar</a></li>
            		</ul>
				</li>

                <li><a href="listar_compra.php">Consultar Compras</a></li>
		<li><a href="">Compras a Crédito</a>
			<ul>
                		<li><a href="listar_compra_credito1.php">Por Pagar</a></li>
						<li><a href="listar_compra_creditoabo1.php">Abonadas</a>
                		<li><a href="listar_compra_creditopag1.php">Pagadas</a>
            		</ul>
		</li>
		<li><a href="listar_compra_anulada.php">Compras Anuladas</a></li>
		<li><a href="imprimir_compras.php" target="_blank">Informe de Compras Diario</a></li>
            </ul>
        </li>
        <li><a href=""><i class="fas fa-shopping-cart"></i> Ventas</a>
            <ul>
                <li><a href="nueva_venta.php">Registrar Venta</a></li>
                <li><a href="nueva_venta.php" target="_blank">Registrar Otra Venta</a></li>
                <li><a href="facturaV_pdf.php" target="_blank">Ultima Venta</a>

				<li><a href="">Devolución Ventas</a>
					<ul>
                		<li><a href="registro_devolucionv.php">Registrar</a></li>
                		<li><a href="listar_devolucionv.php">Consultar</a></li>
            		</ul>
				</li>

                <li><a href="listar_venta.php">Consultar Venta</a></li>
		<li><a href="">Ventas a Crédito</a>
			<ul>
                		<li><a href="listar_venta_credito1.php">Por Cobrar</a></li>
                		<li><a href="listar_venta_creditoco.php">Cobradas</a>
            		</ul>
		</li>
		<li><a href="listar_venta_anulada.php">Ventas Anuladas</a></li>
		<li><a href="imprimir_ventas.php" target="_blank">Informe Diario de Ventas de Contado</a></li>
		<li><a href="imprimir_ventascre.php" target="_blank">Informe Diario de Ventas a Crédito</a></li>
            </ul>
        </li>
	<li><a href=""><i class="fas fa-users"></i> Terceros</a>
            <ul>
                <li><a href="registro_tercero.php">Nuevo</a></li>
                <li><a href="listar_tercero.php">Consultar</a>
            </ul>
        </li>
        <li><a href=""><i class="fas fa-user-lock"></i> Administrar</a>
		<ul>
                <li><a href="">Inventario</a>
					<ul>
									<li><a href="listar_inventario.php">Consultar Inventario</a></li>
									<li><a href="imprimir_inventario.php" target="_blank">Imprimir Inventario Total</a></li>
									
					</ul>    
                </li>

				<li><a href="">Compras a Crédito</a>
					<ul>
							<li><a href="listar_compra_credito.php">Por Pagar</a></li>
							<li><a href="listar_compra_creditoabo.php">Abonadas</a></li>
							<li><a href="listar_compra_creditopag.php">Pagadas</a></li>
							<li><a href="compras_proveedor_porpagar.php">Por Proveedor</a></li>
					</ul>
				</li>

				<li><a href="">Compras de Contado</a>
					<ul>
					<li><a href="compras_producto.php" >Compras por Producto</a>
									<ul>
										<li><a href="informe_compras_producto.php">Generar Informe</a></li>
									</ul>
									<li><a href="compras_proveedor.php" >Compras por Proveedor</a>
									<ul>
										<li><a href="informe_compras_proveedor.php">Generar Informe</a></li>
									</ul>
								</li>
					</ul>
				</li>

				<li><a href="">Compras Generales</a>
					<ul>
					<li><a href="compras_producto.php" >Compras por Producto</a>
									<ul>
										<li><a href="informe_compras_producto.php">Generar Informe</a></li>
									</ul>
									<li><a href="compras_proveedor.php" >Compras por Proveedor</a>
									<ul>
										<li><a href="informe_compras_proveedor.php">Generar Informe</a></li>
									</ul>
								</li>
					</ul>
				</li>

		<li><a href="">Ventas a Crédito</a>
			<ul>
                		<li><a href="listar_venta_credito.php">Por Cobrar</a></li>
						<!--<li><a href="listar_venta_credito.php">Abonadas</a></li>-->
                		<li><a href="listar_venta_creditoco.php">Cobradas</a>
            		</ul>
		</li>

				<li><a href="informe_gasto.php">Informe de Gastos</a>

				
					  
                </li>





                <li><a href="">Caja Mayor</a>
			<ul>
				<li><a href="abrir_mayor.php">Abrir Caja</a></li>
                                
				<li><a href="">Gastos</a>
					<ul>
					    <li><a href="registro_gastomayor.php">Registrar</a></li>
                        <li><a href="listar_gastomayor.php">Consultar</a></li>
						
					</ul>
                   		</li>
						   <li><a href="movimientos.php">Movimientos</a></li>    
						   <li><a href="cerrar_caja.php">Cerrar Caja</a></li> 
						   <li><a href="listar_cuadreMayor.php">Consultar Cajas</a></li>          
                   	</ul>
		</li>
			<li><a href="">Usuarios</a>
                    <ul>
                                <li><a href="registro_usuario.php">Crear</a></li>
                                <li><a href="listar_usuario.php">Consultar</a></li>
                    </ul>
			<li><a href="configuracion.php">Configuración</a></li>
            </ul>
		
        </li>

	
        <li><a href="../salir.php">Salir <i class="fas fa-power-off"></i></a></li>
    </ul>
