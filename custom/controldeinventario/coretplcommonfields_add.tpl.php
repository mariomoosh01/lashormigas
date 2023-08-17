<?php
/* Copyright (C) 2017  Laurent Destailleur  <eldy@users.sourceforge.net>
 *
 * This program is free software; you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation; either version 3 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program. If not, see <https://www.gnu.org/licenses/>.
 *
 * Need to have following variables defined:
 * $object (invoice, order, ...)
 * $action
 * $conf
 * $langs
 * $form
 */

// Protection to avoid direct call of template
if (empty($conf) || !is_object($conf)) {
	print "Error, template page can't be called as URL";
	exit;
}
//interrumpimos aqui el PHP para introducir algo de JavaScript..o boy.
?>
<!-- BEGIN PHP TEMPLATE commonfields_add.tpl.php -->
<script>
function cleanEntradas(){
	document.getElementById("description").value = "";
	document.getElementById("udm").value = "";
	document.getElementById("get_qty").value = "";
	document.getElementById("usuario").value = "";
  }
  function cleanSalidas(){
	
	document.getElementById("description").value = "";
	document.getElementById("udm").value = "";
	document.getElementById("give_qty").value = "";
	
  }
function setAlmacen(){
	var cosa = document.getElementById("usuario");
	cosa.value = "Almacén";
	var att = document.createAttribute("disabled");
	cosa.setAttributeNode(att);
}
 function leerDatoE(str,str2,where = "entrada",req = 0){
	if (str.length == 0) { 
    document.getElementById("description").value = "";
    return;
  }
  const xhttp = new XMLHttpRequest();
  document.getElementById("test").innerHTML = "comunicando con servidor...";
  xhttp.onload = function() {
	var resultado = this.responseText;
	var matriz = resultado.split(";");
	if(resultado != "notFound"){
		document.getElementById("description").value = matriz[0];
		document.getElementById("udm").value = matriz[1];
		
		
		if(str2 == "emisionderequisiciones")
		{
			
			document.getElementById("get_qty").value = matriz[2];
			
			document.getElementById("usuario").value = matriz[3];
			if(where=="stock")
			document.getElementById("codificacion").value = matriz[4];
		}
		if(str2 == "entradas")
		{
			//document.getElementById("codific").value = document.getElementById("ref").value;
			document.getElementById("give_qty").value = matriz[2];
			//document.getElementById("usuario").value = matriz[3];
		}
		if(str2 == "inventariogeneral"){
			if(where=="requisicion"){

			}else if (where=="entrada"){
				document.getElementById("get_qty").value = matriz[2];
				setAlmacen();
				//document.getElementById("cost").value = matriz[4];
				document.getElementById("ubicacion").value = matriz[5];
			}
			else if (where=="salida"){

			}

		}
		document.getElementById("test").innerHTML = "listo";
	}
	else
	{
		
		if(str2 == "emisionderequisiciones"){
			document.getElementById("test").innerHTML = "requicisión no encontrada";
			cleanEntradas();
		}		
		else if (str2 == "entradas"){
			document.getElementById("test").innerHTML = "entrada no encontrada";
			cleanSalidas();
		}
		else if (str2 == "inventariogeneral"){
			document.getElementById("test").innerHTML = "Parte no encontrada";
			
		}
		
	}
  }
  xhttp.open("GET", "../controldeinventario/scripts/loadReq.php?req="+str+"&data="+str2+"&ifnostock="+req);
  xhttp.send();  
 }
 function showYellow(z){
	var x = document.getElementById(z);
	x.addEventListener(z, myFocusFunction(x), true);
	x.addEventListener(z, myBlurFunction(x), true);
}
function myFocusFunction(y) {
  document.getElementById(y).style.backgroundColor = "yellow";
}

function myBlurFunction(y) {
  document.getElementById(y).style.backgroundColor = "";
}
</script>
<?php
//interrumpimos aqui el PHP para introducir algo de JavaScript..o boy.
if($isstock)
$udm = new unidadmedida($db);
	
$tableData= $db->query($tableQuery);
$tableFields = array_values($object->fields);
$tableActual = '<br><br><span></span><table class="tablaAbajo"><tr class="normalTableHeaderRow">';
for ($x=0;$x<count($tableFields);$x++)
{
	$temp = array_values($object->fields);
	$temp2= array_keys($object->fields);
	$temp = ($temp[$x]);
	if(in_array($temp['visible'],[1,2,3,5],true)&&$temp2[$x]!='tiporeq')
	$tableActual.='<th class="normalTable">'.$temp['comment'].'</th>';
}
// y si somos los admin, damos chance de BORRAR los datos aqui mesmo.
if($permissiontodelete&&$tableData){
	$tableActual.='<th class="normalTable">Borrar?</th>';
}
$tableActual.= '</tr>';

//aqui hacemos la consulta de datos, para mostrar los últimos del mes.
if($tableData){
	foreach($tableData as $line)
	{	
		$tableActual.='<tr>';
		$temp2 = array_values($line);
			for ($x=0;$x<$tableData->field_count;$x++)
		{		
			$temp3 = array_keys($object->fields); //nombre de campos
			$temp = array_values($object->fields);//contenido de campos
			$temp = ($temp[$x]);		
			if(in_array($temp['visible'],[1,2,3,5],true)&&$temp3[$x]!='tiporeq'){
				$tableActual.='<td class="tablaAbajoCelda center ';
				$temp4 = strpos($temp3[$x],'fk_');
				if($temp3[$x]=='ref' && $requisicion){
					//indicamos si la requsicion 
					if($line['status']==9)
						$tableActual.= '"
						style="
						color: white;
						background: darkgreen;"';
					else if($line['status']==1)
						$tableActual.= '"
						style="
						color: white;
						background: darkred;"';
					$tableActual.= '">'.$temp2[$x].'</td>';
				}
				else if($temp3[$x]=='date_creation'||$temp3[$x]=='tms'){
					//$tableActual.= strftime("%d %B %y", $temp2[$x]).'</td>';
					$reformatDatetoMexican = substr($temp2[$x],2,8);
					$temp4 = explode('-',$reformatDatetoMexican,3);
					$reformatDatetoMexican = $temp4[2]."-".$temp4[1]."-".$temp4[0];
					$tableActual.=  ' minwidth75 width75 datebox">'.$reformatDatetoMexican.'</td>';
					$temp4 = false;
				}
				else if($temp3[$x]=='fk_codific'){				
						$tableActual.= '">'.$line["codificacion"].'</td>';								
				}
				else if($temp3[$x]=='fk_ref'){
					$tableActual.= '">'.$line["ref"].'</td>';								
				}
				else if($temp3[$x]=='t_cost'||$temp3[$x]=='cost'){
					if($line['iva']==1){
						$tableActual.= '">'.($temp2[$x]*1.16).'</td>';
					}else{
						$tableActual.= '">'.$temp2[$x].'</td>';
					}
				}else if($temp3[$x]=='iva'){
					if($line['iva']==1){
						$tableActual.= '">Incluido</td>';
					}else{
						$tableActual.= '">No</td>';
					}
				}
				else{
					$tableActual.= '">'.$temp2[$x].'</td>';
				}
			}
		}
		//print $temp;
		// y si somos los admin, damos chance de BORRAR los datos aqui mesmo.
		if($permissiontodelete&&$tableData){
			// '.$temp2[0].' Id a borrar
			// $langs->trans('Delete') palabra para borrar en cualquier idioma
			// $_SERVER['PHP_SELF'].'?id='.$temp2[0].'&action=delete&token='.newToken()
			$tableActual.='<td class="tablaAbajoCelda center ">'.
			'<a href ="'.$_SERVER['PHP_SELF'].'?id='.$temp2[0].'&action=delete&token='.newToken().'&isstock='.$isstock.'">
			[Borrar]
			</a>
			</td>';
		}
		$tableActual.='</tr>';
	}
}
//aqui ponemos los campos de captura de datos...asumiendo que TIENES PERMISO!!!
if($permissiontoadd){
	for ($x=0;$x<count($tableFields);$x++)
	{
		$temp = array_values($object->fields);
		$temp2= array_keys($object->fields);
		$temp = ($temp[$x]);
		if(in_array($temp['visible'],[1,2,3,5],true)&&$temp2[$x]!='tiporeq'){
			$tableActual.='<td class="tablaAbajoCelda center">';
			if($temp2[$x]=='ref' && $requisicion)
			$tableActual.= $object->showInputField($temp[$x], $temp2[$x], $object->getNextNumRef($prfx,$isstock), '', '', '', $temp["css"]." center");
			else
			$tableActual.= $object->showInputField($temp[$x], $temp2[$x], '', '', '', '',$temp["css"]." center");
			$tableActual.='</td>';
		}	
	}
}
if($permissiontodelete&&$tableData){
	$tableActual.='<td class="tablaAbajoCelda center "></td>';
}
$tableActual.= '</tr>';
//calcular total de entradas de cierto tipo
if($entrada){
	//$tableActual.= '<tr><td class="tablaAbajoCelda center">Suma Artículos</td><td></td><td></td><td></td><td></td><td></td><td></td><td>';
	$tableActual.= '<tr>';
	for ($x=0;$x<count($tableFields);$x++)
	{	
		if($x==0){
			$tableActual.='<td class="tablaAbajoCelda center">Suma Artículos</td>';
		}else if($x==7){
			$allCost_pesos = "SELECT t_cost FROM hor_controldeinventario_entradas WHERE tiporeq =".$isstock;
			$sumaArticulosMNX=0;
			$sumaPrecioTotalMNX = 0.0;

			$list_articulo = $db->query($allCost_pesos);
			if($list_articulo > 0){
				foreach($list_articulo as $key=>$target)
				{		
					$sumaPrecioTotalMNX += $target["t_cost"];
				}
			}
			$sumaResultado = sprintf("<td>%s </td>",number_format($sumaPrecioTotalMNX,2));
			$tableActual.= $sumaResultado;
		}
		else{
			$tableActual.='<td></td>';
		}		
		
	}
	$tableActual.= '</tr>';
}
//aqui termina el calculo de totales

$tableActual.='</table>'."\n";
$tableActual.='<br><span id="test" ></span>';
if($isstock===0){
	if($entrada)
	$tableActual = str_replace('id="ref" ','id="ref" onchange="leerDatoE(this.value,'."'emisionderequisiciones'".','."'stock'".')"',$tableActual);
	if($salida)	
	$tableActual = str_replace('id="fk_codific" ','id="fk_codific" onchange="leerDatoE(this.value,'."'inventariogeneral'".','."'salida'".')"',$tableActual);
	if($requisicion)
	$tableActual = str_replace('id="fk_codific" ','id="fk_codific" onchange="leerDatoE(this.value,'."'inventariogeneral'".','."'requisicion'".')"',$tableActual);
}
	//$tableActual.='<span id="forceAlmacen" onload="setAlmacen()"></span>';
//antes de imprimir la tabla (y exclusivamente en entradas y salidas), 
//le agregamos un pequeño script al boton de seleccion de cosas, si la tiene.

	if($entrada){
		if($isstock>0)
		$tableActual = str_replace('id="ref" ','id="ref" onload="showYellow(this.id)" onblur="leerDatoE(this.value,'."'emisionderequisiciones'".')"',$tableActual);
				
		$tableActual = str_replace('id="qty" ','id="qty" onkeyup="autoExistencia()"',$tableActual);
		$tableActual = str_replace('id="cost" ','id="cost" onkeyup="autoCalc_cost()"',$tableActual);
		$tableActual = str_replace('id="t_cost" ','id="t_cost" onkeyup="autoCalc_t_cost()"',$tableActual);
		$tableActual.= '<img id="lockAutoTargets" onload="lockEntradas()" ></img>';
	}
	if($salida)
	$tableActual = str_replace('id="ref" ','id="ref" onload="showYellow(this.id)" onblur="leerDatoE(this.value,'."'entradas'".')"',$tableActual);




print $tableActual;
//aqui terminamos de insertar una tabla "mágica"


// $object->fields = dol_sort_array($object->fields, 'position');

// foreach ($object->fields as $key => $val) {
// 	// Discard if extrafield is a hidden field on form
// 	if (abs($val['visible']) != 1 && abs($val['visible']) != 3) {
// 		continue;
// 	}

// 	if (array_key_exists('enabled', $val) && isset($val['enabled']) && !verifCond($val['enabled'])) {
// 		continue; // We don't want this field
// 	}

// 	print '<th class="field_'.$key.' cabezeraTabla">';
	
// 		print $langs->trans($val['label']);
	
// 	print '</th>';
	
// }
// print '<tr>';
// foreach ($object->fields as $key => $val) {
// 	// Discard if extrafield is a hidden field on form
// 	if (abs($val['visible']) != 1 && abs($val['visible']) != 3) {
// 		continue;
// 	}

// 	if (array_key_exists('enabled', $val) && isset($val['enabled']) && !verifCond($val['enabled'])) {
// 		continue; // We don't want this field
// 	}
// 	print '<td class="valuefieldcreate fieldbox">';
// 	if (!empty($val['picto'])) {
// 		print img_picto('', $val['picto'], '', false, 0, 0, '', 'pictofixedwidth');
// 	}
// 	if (in_array($val['type'], array('int', 'integer'))) {
// 		$value = GETPOST($key, 'int');
// 	} elseif ($val['type'] == 'double') {
// 		$value = price2num(GETPOST($key, 'alphanohtml'));
// 	} elseif ($val['type'] == 'text' || $val['type'] == 'html') {
// 		$value = GETPOST($key, 'restricthtml');
// 	} elseif ($val['type'] == 'date') {
// 		$value = dol_mktime(12, 0, 0, GETPOST($key.'month', 'int'), GETPOST($key.'day', 'int'), GETPOST($key.'year', 'int'));
// 	} elseif ($val['type'] == 'datetime') {
// 		$value = dol_mktime(GETPOST($key.'hour', 'int'), GETPOST($key.'min', 'int'), 0, GETPOST($key.'month', 'int'), GETPOST($key.'day', 'int'), GETPOST($key.'year', 'int'));
// 	} elseif ($val['type'] == 'boolean') {
// 		$value = (GETPOST($key) == 'on' ? 1 : 0);
// 	} elseif ($val['type'] == 'price') {
// 		$value = price2num(GETPOST($key));
// 	} else {
// 		$value = GETPOST($key, 'alphanohtml');
// 	}
// 	if (!empty($val['noteditable'])) {
// 		print $object->showOutputField($val, $key, $value, '', '', '', 0);
// 	} else {
// 		print $object->showInputField($val, $key, $value, '', '', '', 0);
// 	}
// 	print '</td>';
// }
// print '</tr>';
/*
	// Discard if extrafield is a hidden field on form
	if (abs($val['visible']) != 1 && abs($val['visible']) != 3) {
		continue;
	}

	if (array_key_exists('enabled', $val) && isset($val['enabled']) && !verifCond($val['enabled'])) {
		continue; // We don't want this field
	}

	print '<tr class="field_'.$key.'">';
	print '<td';
	print ' class="titlefieldcreate';
	if (isset($val['notnull']) && $val['notnull'] > 0) {
		print ' fieldrequired';
	}
	if ($val['type'] == 'text' || $val['type'] == 'html') {
		print ' tdtop';
	}
	print '"';
	print '>';
	if (!empty($val['help'])) {
		print $form->textwithpicto($langs->trans($val['label']), $langs->trans($val['help']));
	} else {
		print $langs->trans($val['label']);
	}
	print '</td>';
	print '<td class="valuefieldcreate">';
	if (!empty($val['picto'])) {
		print img_picto('', $val['picto'], '', false, 0, 0, '', 'pictofixedwidth');
	}
	if (in_array($val['type'], array('int', 'integer'))) {
		$value = GETPOST($key, 'int');
	} elseif ($val['type'] == 'double') {
		$value = price2num(GETPOST($key, 'alphanohtml'));
	} elseif ($val['type'] == 'text' || $val['type'] == 'html') {
		$value = GETPOST($key, 'restricthtml');
	} elseif ($val['type'] == 'date') {
		$value = dol_mktime(12, 0, 0, GETPOST($key.'month', 'int'), GETPOST($key.'day', 'int'), GETPOST($key.'year', 'int'));
	} elseif ($val['type'] == 'datetime') {
		$value = dol_mktime(GETPOST($key.'hour', 'int'), GETPOST($key.'min', 'int'), 0, GETPOST($key.'month', 'int'), GETPOST($key.'day', 'int'), GETPOST($key.'year', 'int'));
	} elseif ($val['type'] == 'boolean') {
		$value = (GETPOST($key) == 'on' ? 1 : 0);
	} elseif ($val['type'] == 'price') {
		$value = price2num(GETPOST($key));
	} else {
		$value = GETPOST($key, 'alphanohtml');
	}
	if (!empty($val['noteditable'])) {
		print $object->showOutputField($val, $key, $value, '', '', '', 0);
	} else {
		print $object->showInputField($val, $key, $value, '', '', '', 0);
	}
	print '</td>';
	print '</tr>';
}*/

?>
<!-- END PHP TEMPLATE commonfields_add.tpl.php -->
