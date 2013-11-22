<?php
function generar_tabla_abm($titulo,$resultados,$urlabm)
{
        //echo $resultados;
	    echo "<table border='1'>";
		echo "<thead>";
		echo "<tr>";
		$canttitulo = count($titulo);
		for($i=0;$i<$canttitulo;$i++)
		{
		   echo "<th>$titulo[$i]</th>";
		}
		echo "</tr>";
        echo "</thead>";
		
		echo "<tbody>";
		
		if(isset($resultados))
		{	
			$nrofila=1;
			$cambiarColor = false;
			while($fila =  mysql_fetch_array($resultados,MYSQL_ASSOC))
			{ 
			   $claseFila = "tableFilaPar";
			   if($cambiarColor==true)
			   {
			       $claseFila = "tableFilaImPar"; 				     
			   }
			   $cambiarColor = !$cambiarColor;
			   
			   echo "<tr class='$claseFila'>";
			   echo "<td>$nrofila</td>";
				  
				   foreach ($fila as $indice => $valor)
				   {
                         echo "<td>$valor</td>";
				
                   }
				   	$codigo = $fila["codigo"];
					echo "<td><a href='$urlabm?op=2&codigo=$codigo'>Modificar</a></td>";
					echo "<td><a href='$urlabm?op=3&codigo=$codigo'>Eliminar</a></td>";
			   echo "</tr>";
			   
			   $nrofila++;
			   				
			}
			
		}
		else
		{
		  echo "<tr><td colspan='$canttitulo'> NO HAY RESULTADOS CON EL CRITERIO DE BUSQUEDA</td></tr>";
		}
		echo "</tbody>";
		echo "</table>";
}

function obtener_tabla_abm_paginacion($titulo,$resultados,$urlabm)
{
        //echo $resultados;
		$resultado_html = "";
		
	    $resultado_html =  "<table border='1'>";
		$resultado_html .=  "<thead>";
		$resultado_html .="<tr>";
		$canttitulo = count($titulo);
		for($i=0;$i<$canttitulo;$i++)
		{
		   $resultado_html .= "<th>$titulo[$i]</th>";
		}
		$resultado_html .= "</tr>";
        $resultado_html .= "</thead>";
		
		$resultado_html .= "<tbody>";
		
		if(isset($resultados))
		{	
			$nrofila=1;
			$cambiarColor = false;
			while($fila =  mysql_fetch_array($resultados,MYSQL_ASSOC))
			{ 
			   $claseFila = "tableFilaPar";
			   if($cambiarColor==true)
			   {
			       $claseFila = "tableFilaImPar"; 				     
			   }
			   $cambiarColor = !$cambiarColor;
			   
			   $resultado_html .= "<tr class='$claseFila'>";
			   $resultado_html .= "<td>$nrofila</td>";
				  
				   foreach ($fila as $indice => $valor)
				   {
                         $resultado_html .= "<td>$valor</td>";
				
                   }
				   	$codigo = $fila["codigo"];
					$resultado_html .= "<td><a href='$urlabm?op=2&codigo=$codigo'>Modificar</a></td>";
					$resultado_html .= "<td><a href='$urlabm?op=3&codigo=$codigo'>Eliminar</a></td>";
			  $resultado_html .= "</tr>";
			   
			   $nrofila++;
			   				
			}
			
		}
		else
		{
		  $resultado_html .= "<tr><td colspan='$canttitulo'> NO HAY RESULTADOS CON EL CRITERIO DE BUSQUEDA</td></tr>";
		}
		$resultado_html .= "</tbody>";
		$resultado_html .= "</table>";
		return $resultado_html;
}

function obtener_tabla_abm_paginacion_seleccion($titulo,$resultados,$nombrebtnsel)
{
        //echo $resultados;
		$resultado_html = "";
		$canttitulo = count($titulo);
	    $resultado_html =  "<table border='1'>";
		$resultado_html .=  "<thead>";
				
		$resultado_html .="<tr>";
		for($i=0;$i<$canttitulo;$i++)
		{
		   $resultado_html .= "<th>$titulo[$i]</th>";
		}
		$resultado_html .= "</tr>";
        $resultado_html .= "</thead>";
		
		$resultado_html .= "<tbody>";
		
		if(isset($resultados))
		{	
			$nrofila=1;
			$cambiarColor = false;
			while($fila =  mysql_fetch_array($resultados,MYSQL_ASSOC))
			{ 
			   $claseFila = "tableFilaPar";
			   if($cambiarColor==true)
			   {
			       $claseFila = "tableFilaImPar"; 				     
			   }
			   $cambiarColor = !$cambiarColor;
			   
			   $resultado_html .= "<tr class='$claseFila'>";
			   $resultado_html .= "<td>$nrofila</td>";
				  
				   foreach ($fila as $indice => $valor)
				   {
                         $resultado_html .= "<td>$valor</td>";
				
                   }
				   	$codigo = $fila["codigo"];
					$descripcion= $fila["descripcion"];
					$resultado_html .= "<td><input type='button' name='$nombrebtnsel' id='$nombrebtnsel' value='Seleccionar'
					codigo='$codigo' descripcion='$descripcion' class='btnsel'></input></td>";
			  $resultado_html .= "</tr>";
			   
			   $nrofila++;			   				
			}
			
		}
		else
		{
		  $resultado_html .= "<tr><td colspan='$canttitulo'> NO HAY RESULTADOS CON EL CRITERIO DE BUSQUEDA</td></tr>";
		}
		$resultado_html .= "</tbody>";
		$resultado_html .= "</table>";
		return $resultado_html;
}

function paginar($page,$criterio,$objEntidad,$url)
{ 
		if(isset($page))
		{
			$cur_page = $page;
			$page -= 1;
			$per_page = 5;
			$previous_btn = true;
			$next_btn = true;
			$first_btn = true;
			$last_btn = true;
			$start = $page * $per_page;
					
			//$query_pag_data = "SELECT msg_id,message from messages LIMIT $start, $per_page";
		    //$result_pag_data = mysql_query($query_pag_data) or die('MySql Error' . mysql_error());
			$msg = $objEntidad->generar_paginacion($criterio,$start,$per_page,$url,&$count);					
			$msg = "<div class='data'>" . $msg . "</div>"; // Content for Data		
			$no_of_paginations = ceil($count / $per_page);
		
		/* ---------------Calculating the starting and endign values for the loop----------------------------------- */
			if ($cur_page >= 7) {
				$start_loop = $cur_page - 3;
				if ($no_of_paginations > $cur_page + 3)
					$end_loop = $cur_page + 3;
				else if ($cur_page <= $no_of_paginations && $cur_page > $no_of_paginations - 6) {
					$start_loop = $no_of_paginations - 6;
					$end_loop = $no_of_paginations;
				} else {
					$end_loop = $no_of_paginations;
				}
			} else {
				$start_loop = 1;
				if ($no_of_paginations > 7)
					$end_loop = 7;
				else
					$end_loop = $no_of_paginations;
			}
		/* ----------------------------------------------------------------------------------------------------------- */
			$msg .= "<div class='pagination'><ul>";
		
			// FOR ENABLING THE FIRST BUTTON
			if ($first_btn && $cur_page > 1)
			{
				$msg .= "<li p='1' class='active'>Primero</li>";
			}
			else if ($first_btn)
			{
				$msg .= "<li p='1' class='inactive'>Primero</li>";
			}
		
			// FOR ENABLING THE PREVIOUS BUTTON
			if ($previous_btn && $cur_page > 1)
			{
				$pre = $cur_page - 1;
				$msg .= "<li p='$pre' class='active'>Anterior</li>";
			}
			else if ($previous_btn)
			{
				$msg .= "<li class='inactive'>Anterior</li>";
			}
			for ($i = $start_loop; $i <= $end_loop; $i++)
			{
			
				if ($cur_page == $i)
					$msg .= "<li p='$i' style='color:#fff;background-color:#006699;' class='active'>{$i}</li>";
				else
					$msg .= "<li p='$i' class='active'>{$i}</li>";
			}
		
			// TO ENABLE THE NEXT BUTTON
			if ($next_btn && $cur_page < $no_of_paginations)
			{
				$nex = $cur_page + 1;
				$msg .= "<li p='$nex' class='active'>Siguiente</li>";
			} else if ($next_btn)
			{
				$msg .= "<li class='inactive'>Siguiente</li>";
			}
			
			// TO ENABLE THE END BUTTON
			if ($last_btn && $cur_page < $no_of_paginations)
			{
				$msg .= "<li p='$no_of_paginations' class='active'>Ultimo</li>";
			}
			else if ($last_btn)
			{
				$msg .= "<li p='$no_of_paginations' class='inactive'>Ultimo</li>";
			}
			$goto = "<input type='text' class='goto' size='1' style='margin-top:-1px;margin-left:60px;'/>
					<input type='button' id='go_btn'
			 		class='go_button' value='Ir.'/>";
			$total_string = "<span class='total' a='$no_of_paginations'>Pagina<b>" .
						    $cur_page . "</b> de <b>$no_of_paginations</b></span>";
			$msg = $msg . "</ul>" . $goto . $total_string .
			"</div>";  // Content for pagination
			echo $msg;
		}
}


function paginar_seleccion($page,$criterio,$objEntidad,$nombrebtnsel)
{ 
		if(isset($page))
		{
			$cur_page = $page;
			$page -= 1;
			$per_page = 5;
			$previous_btn = true;
			$next_btn = true;
			$first_btn = true;
			$last_btn = true;
			$start = $page * $per_page;
					
			//$query_pag_data = "SELECT msg_id,message from messages LIMIT $start, $per_page";
		    //$result_pag_data = mysql_query($query_pag_data) or die('MySql Error' . mysql_error());
			$msg = $objEntidad->generar_paginacion_seleccion($criterio,$start,$per_page,$nombrebtnsel,&$count);					
			$msg = "<div class='data'>" . $msg . "</div>"; // Content for Data		
			$no_of_paginations = ceil($count / $per_page);
		
		/* ---------------Calculating the starting and endign values for the loop----------------------------------- */
			if ($cur_page >= 7) {
				$start_loop = $cur_page - 3;
				if ($no_of_paginations > $cur_page + 3)
					$end_loop = $cur_page + 3;
				else if ($cur_page <= $no_of_paginations && $cur_page > $no_of_paginations - 6) {
					$start_loop = $no_of_paginations - 6;
					$end_loop = $no_of_paginations;
				} else {
					$end_loop = $no_of_paginations;
				}
			} else {
				$start_loop = 1;
				if ($no_of_paginations > 7)
					$end_loop = 7;
				else
					$end_loop = $no_of_paginations;
			}
		/* ----------------------------------------------------------------------------------------------------------- */
			$msg .= "<div class='pagination'><ul>";
		
			// FOR ENABLING THE FIRST BUTTON
			if ($first_btn && $cur_page > 1)
			{
				$msg .= "<li p='1' class='active'>Primero</li>";
			}
			else if ($first_btn)
			{
				$msg .= "<li p='1' class='inactive'>Primero</li>";
			}
		
			// FOR ENABLING THE PREVIOUS BUTTON
			if ($previous_btn && $cur_page > 1)
			{
				$pre = $cur_page - 1;
				$msg .= "<li p='$pre' class='active'>Anterior</li>";
			}
			else if ($previous_btn)
			{
				$msg .= "<li class='inactive'>Anterior</li>";
			}
			for ($i = $start_loop; $i <= $end_loop; $i++)
			{
			
				if ($cur_page == $i)
					$msg .= "<li p='$i' style='color:#fff;background-color:#006699;' class='active'>{$i}</li>";
				else
					$msg .= "<li p='$i' class='active'>{$i}</li>";
			}
		
			// TO ENABLE THE NEXT BUTTON
			if ($next_btn && $cur_page < $no_of_paginations)
			{
				$nex = $cur_page + 1;
				$msg .= "<li p='$nex' class='active'>Siguiente</li>";
			} else if ($next_btn)
			{
				$msg .= "<li class='inactive'>Siguiente</li>";
			}
			
			// TO ENABLE THE END BUTTON
			if ($last_btn && $cur_page < $no_of_paginations)
			{
				$msg .= "<li p='$no_of_paginations' class='active'>Ultimo</li>";
			}
			else if ($last_btn)
			{
				$msg .= "<li p='$no_of_paginations' class='inactive'>Ultimo</li>";
			}
			$goto = "<input type='text' class='goto' size='1' style='margin-top:-1px;margin-left:60px;'/>
					<input type='button' id='go_btn'
			 		class='go_button' value='Ir.'/>";
			$total_string = "<span class='total' a='$no_of_paginations'>Pagina<b>" .
						    $cur_page . "</b> de <b>$no_of_paginations</b></span>";
			$msg = $msg . "</ul>" . $goto . $total_string .
			"</div>";  // Content for pagination
			echo $msg;
		}
}
?>