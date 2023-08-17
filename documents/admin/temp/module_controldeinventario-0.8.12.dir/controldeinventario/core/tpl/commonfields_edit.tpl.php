<script>
	function enlargeTextBoxes(){
		
	}
</script>
<?php
/* Copyright (C) 2017-2019  Laurent Destailleur  <eldy@users.sourceforge.net>
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
 */

// Protection to avoid direct call of template
if (empty($conf) || !is_object($conf)) {
	print "Error, template page can't be called as URL";
	exit;
}
if (!is_object($form)) {
	$form = new Form($db);
}

?>
<!-- BEGIN PHP TEMPLATE commonfields_edit.tpl.php -->
<?php

$object->fields = dol_sort_array($object->fields, 'position');
foreach ($object->fields as $key => $val) {
	// Discard if extrafield is a hidden field on form
	if (abs($val['visible']) != 1 && abs($val['visible']) != 3 && abs($val['visible']) != 4) {
		continue;
	}

	if (array_key_exists('enabled', $val) && isset($val['enabled']) && !verifCond($val['enabled'])) {
		continue; // We don't want this field
	}

	$tableActual.= '<th class="field_'.$key.' normalTable">';
	
		$tableActual.= $langs->trans($val['label']);
	
	$tableActual.= '</th>';
	
}
$tableActual.= '<tr>';
foreach ($object->fields as $key => $val) {
	// Discard if extrafield is a hidden field on form
	if (abs($val['visible']) != 1 && abs($val['visible']) != 3 && abs($val['visible']) != 4) {
		continue;
	}

	if (array_key_exists('enabled', $val) && isset($val['enabled']) && !verifCond($val['enabled'])) {
		continue; // We don't want this field
	}
	$tableActual.= '<td class="valuefieldcreate tablaAbajoCelda">';
	if (!empty($val['picto'])) {
		$tableActual.= img_picto('', $val['picto'], '', false, 0, 0, '', 'pictofixedwidth');
	}
	if (in_array($val['type'], array('int', 'integer'))) {
		$value = GETPOSTISSET($key) ?GETPOST($key, 'int') : $object->$key;
	} elseif ($val['type'] == 'double') {
		$value = GETPOSTISSET($key) ? price2num(GETPOST($key, 'alphanohtml')) : $object->$key;
	} elseif (preg_match('/^(text|html)/', $val['type'])) {
		$tmparray = explode(':', $val['type']);
		if (!empty($tmparray[1])) {
			$check = $tmparray[1];
		} else {
			$check = 'restricthtml';
		}
		$value = GETPOSTISSET($key) ? GETPOST($key, $check) : $object->$key;
	} elseif ($val['type'] == 'price') {
		$value = GETPOSTISSET($key) ? price2num(GETPOST($key)) : price2num($object->$key);
	} else {
		$value = GETPOSTISSET($key) ? GETPOST($key, 'alpha') : $object->$key;
	}
	//var_dump($val.' '.$key.' '.$value);
	if ($val['noteditable']) {
		$tableActual.= $object->showOutputField($val, $key, $value, '', '', '', 0);
	} else {
		$tableActual.= $object->showInputField($val, $key, $value, '', '', '', 0);
	}	
	$tableActual.= '</td>';
}
$tableActual.= '</tr>';

if($isstock>0){
	if($entrada){
		$tableActual = str_replace('id="ref" ','id="ref" onload="showYellow(this.id)" onblur="leerDatoE(this.value,'."'emisionderequisiciones'".')"',$tableActual);
		$tableActual = str_replace('id="qty" ','id="qty" onkeyup="autoExistencia()"',$tableActual);
		$tableActual = str_replace('id="cost" ','id="cost" onkeyup="autoCalc_cost()"',$tableActual);
		$tableActual = str_replace('id="t_cost" ','id="t_cost" onkeyup="autoCalc_t_cost()"',$tableActual);
		$tableActual.= '<img id="lockAutoTargets" onload="lockEntradas()" ></img>';
	}
	if($salida)
	$tableActual = str_replace('id="ref" ','id="ref" onload="showYellow(this.id)" onblur="leerDatoE(this.value,'."'entradas'".')"',$tableActual);
}
print $tableActual;
/*
foreach ($object->fields as $key => $val) {
	// Discard if extrafield is a hidden field on form
	if (abs($val['visible']) != 1 && abs($val['visible']) != 3 && abs($val['visible']) != 4) {
		continue;
	}

	if (array_key_exists('enabled', $val) && isset($val['enabled']) && !verifCond($val['enabled'])) {
		continue; // We don't want this field
	}

	print '<tr class="field_'.$key.'"><td';
	print ' class="titlefieldcreate';
	if (isset($val['notnull']) && $val['notnull'] > 0) {
		print ' fieldrequired';
	}
	if (preg_match('/^(text|html)/', $val['type'])) {
		print ' tdtop';
	}
	print '">';
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
		$value = GETPOSTISSET($key) ?GETPOST($key, 'int') : $object->$key;
	} elseif ($val['type'] == 'double') {
		$value = GETPOSTISSET($key) ? price2num(GETPOST($key, 'alphanohtml')) : $object->$key;
	} elseif (preg_match('/^(text|html)/', $val['type'])) {
		$tmparray = explode(':', $val['type']);
		if (!empty($tmparray[1])) {
			$check = $tmparray[1];
		} else {
			$check = 'restricthtml';
		}
		$value = GETPOSTISSET($key) ? GETPOST($key, $check) : $object->$key;
	} elseif ($val['type'] == 'price') {
		$value = GETPOSTISSET($key) ? price2num(GETPOST($key)) : price2num($object->$key);
	} else {
		$value = GETPOSTISSET($key) ? GETPOST($key, 'alpha') : $object->$key;
	}
	//var_dump($val.' '.$key.' '.$value);
	if ($val['noteditable']) {
		print $object->showOutputField($val, $key, $value, '', '', '', 0);
	} else {
		print $object->showInputField($val, $key, $value, '', '', '', 0);
	}
	print '</td>';
	print '</tr>';
}
*/

?>
<!-- END PHP TEMPLATE commonfields_edit.tpl.php -->
