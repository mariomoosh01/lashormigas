<?php
// Move fields of totalizable into the common array pos and val
// if (!empty($totalarray['totalizable']) && is_array($totalarray['totalizable'])) {
// 	foreach ($totalarray['totalizable'] as $keytotalizable => $valtotalizable) {
// 		$totalarray['pos'][$valtotalizable['pos']] = $keytotalizable;
// 		$totalarray['val'][$keytotalizable] = $valtotalizable['total'];
// 	}
// }
//modificado del original de arriba
$sumaArticulosMNX=0;
$sumaPrecioTotalMNX = 0.0;
if($tablaobjetivo == "hor_controldeinventario_entradas"||$tablaobjetivo == "hor_controldeinventario_inventariogeneral"){
	$allCost_pesos = "SELECT t_cost FROM ".$tablaobjetivo;
	$list_articulo = $db->query($allCost_pesos);
	if($list_articulo > 0){
		foreach($list_articulo as $key=>$target)
		{		
			$sumaPrecioTotalMNX += $target["t_cost"];
		}
	}
}else{
	$allCost_pesos = "SELECT qty,cost FROM ".$tablaobjetivo;
	$list_articulo = $db->query($allCost_pesos);
	if($list_articulo > 0){
		foreach($list_articulo as $key=>$target)
		{		
			$sumaPrecioTotalMNX += $target["cost"]*$target["qty"];
		}
	}

}


$allCost_pesos = "SELECT qty,cost FROM ".$tablaobjetivo;




// Show total line
$printer ="";
if (isset($totalarray['pos'])) {
	print '<tr class="liste_total">';
	$i = 0;
	while ($i < $totalarray['nbfield']) {
		$i++;
		if (!empty($totalarray['pos'][$i])) {
			if($totalarray['pos'][$i]=="t.t_cost"){
				($tablaobjetivo == "hor_controldeinventario_inventariogeneral")? print '<td></td><td class="center">$ '.number_format($sumaPrecioTotalMNX,2).'</td>' : print '<td class="center">$ '.number_format($sumaPrecioTotalMNX,2).'</td>';
			}else{
				
				print '<td class="center">'.price($totalarray['val'][$totalarray['pos'][$i]]).'</td>';
			
			}
		} else {
			if ($i == 1) {
				print '<td>'.$list_articulo->num_rows.'</td>';
			}else if ($i == 2){
				print '<td>Suma Total: </td>';
			}
			 else {
				print '<td></td>';
			}
		}
	}
	print $printer;
	print '</tr>';
}
