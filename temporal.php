
                    
    
        if($result > 0){
                        while($data=mysqli_fetch_array($query)){
				?>
						<tr>
                            <td>1</tdh>
                            <td>Jorge</td>
                            <td>jorge@gmail.com</td>
                            <td>Administrador</td>
                            <td>
                                <a class="link_edit" href="#">Editar</a>
                                |
                                <a class="link_delete" href="#">Eliminar</a>
                            </td>
                        </tr>
				<?php
						}
					}
				?>

'