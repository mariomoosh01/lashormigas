<?php
/* Copyright (C) 2001-2005 Rodolphe Quiedeville <rodolphe@quiedeville.org>
 * Copyright (C) 2004-2015 Laurent Destailleur  <eldy@users.sourceforge.net>
 * Copyright (C) 2005-2012 Regis Houssin        <regis.houssin@inodbox.com>
 * Copyright (C) 2015      Jean-François Ferry	<jfefe@aternatik.fr>
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
 */

/**
 *	\file       controldeinventario/controldeinventarioindex.php
 *	\ingroup    controldeinventario
 *	\brief      Home page of controldeinventario top menu
 */

// Load Dolibarr environment
$res = 0;
// Try main.inc.php into web root known defined into CONTEXT_DOCUMENT_ROOT (not always defined)
if (!$res && !empty($_SERVER["CONTEXT_DOCUMENT_ROOT"])) {
	$res = @include $_SERVER["CONTEXT_DOCUMENT_ROOT"]."/main.inc.php";
}
// Try main.inc.php into web root detected using web root calculated from SCRIPT_FILENAME
$tmp = empty($_SERVER['SCRIPT_FILENAME']) ? '' : $_SERVER['SCRIPT_FILENAME']; $tmp2 = realpath(__FILE__); $i = strlen($tmp) - 1; $j = strlen($tmp2) - 1;
while ($i > 0 && $j > 0 && isset($tmp[$i]) && isset($tmp2[$j]) && $tmp[$i] == $tmp2[$j]) {
	$i--; $j--;
}
if (!$res && $i > 0 && file_exists(substr($tmp, 0, ($i + 1))."/main.inc.php")) {
	$res = @include substr($tmp, 0, ($i + 1))."/main.inc.php";
}
if (!$res && $i > 0 && file_exists(dirname(substr($tmp, 0, ($i + 1)))."/main.inc.php")) {
	$res = @include dirname(substr($tmp, 0, ($i + 1)))."/main.inc.php";
}
// Try main.inc.php using relative path
if (!$res && file_exists("../main.inc.php")) {
	$res = @include "../main.inc.php";
}
if (!$res && file_exists("../../main.inc.php")) {
	$res = @include "../../main.inc.php";
}
if (!$res && file_exists("../../../main.inc.php")) {
	$res = @include "../../../main.inc.php";
}
if (!$res) {
	die("Include of main fails");
}

require_once DOL_DOCUMENT_ROOT.'/core/class/html.formfile.class.php';

// Load translation files required by the page
$langs->loadLangs(array("controldeinventario@controldeinventario"));

$action = GETPOST('action', 'aZ09');
$backto = GETPOST('backto', 'aZ09');
$ac2=GETPOST('ac2','aZ09');


// Security check
// if (! $user->rights->controldeinventario->myobject->read) {
// 	accessforbidden();
// }
$socid = GETPOST('socid', 'int');
if (isset($user->socid) && $user->socid > 0) {
	$action = '';
	$socid = $user->socid;
}

$max = 5;
$now = dol_now();


/*
 * Actions
 */

// None


/*
 * View
 */

$form = new Form($db);
$formfile = new FormFile($db);

llxHeader("", $langs->trans("Sistema de Control De Inventario"));

print load_fiche_titre($langs->trans("Las Hormigas Vallereal, Chihuahua"), '', 'controldeinventario.png@controldeinventario');
print '<div class="fichecenter">';
    if ($action){	
		if($action=='requisicion'){
			print '<h2>Emisión de requicisiones</h2>';
		}
		if($action=='entradas'){
			print '<h2>Sistema de Entradas de Almacén.</h2>';
		}
		if($action=='salidas'){
			print '<h2>Sistema de Salidas de Almacén.</h2>';
		}
		if($action=='reportes'){
			print'<h2>Menú de reportes.</h2>';
			
		}
		if($action=='reportes2'){
			print'<h2>Reportes de inventario.</h2>';
			
		}
		if($action=="inventario"){
			print'<h2>Sistema de inventario.</h2>';
		}
		if($action=="reporte_nosurtida"){
			print '<h2>Reportes de requisiciones no surtidas.</h2>';
		}
		print '
		<div class="quick_access"> 
			<a href="/custom/controldeinventario/controldeinventarioindex.php">		
				<span class="quickButton quarter backButton">Menú principal</span>		
			</a>
		</div>';
		if($backto){
			print '
		<div class="quick_access"> 
			<a href="/custom/controldeinventario/controldeinventarioindex.php?action='.$backto.'&idmenu=35234&mainmenu=controldeinventario&leftmenu=">		
				<span class="quickButton quarter backButton">Atrás</span>		
			</a>
		</div>';
		}
	}
print '
</div>
	<div class="fichethirdleft firstcolumn">';
if(!$action){
	print '<h2>Menú principal</h2>';
	if($user->rights->controldeinventario->emisionderequisiciones->read){
		print '<a class="mainMenuButton" 
		href="/custom/controldeinventario/controldeinventarioindex.php?action=requisicion">
		<img src="/custom/controldeinventario/img/emisionderequisiciones.png" alt="" class="paddingright pictofixedwidth valignmiddle">
		Emisión de requisiciones</a>';
		print '<br>';
	}
	if($user->rights->controldeinventario->entradas->read){
		print '<a class="mainMenuButton" 
		href="/custom/controldeinventario/controldeinventarioindex.php?action=entradas">
		<img src="/custom/controldeinventario/img/entradas.png" alt="" class="paddingright pictofixedwidth valignmiddle">
		Entradas de almacén</a>';
		print '<br>';
	}
	if($user->rights->controldeinventario->salidas->read){
		print '<a class="mainMenuButton" 
		href="/custom/controldeinventario/controldeinventarioindex.php?action=salidas">
		<img src="/custom/controldeinventario/img/salidas.png" alt="" class="paddingright pictofixedwidth valignmiddle">
		Salidas de almacén</a>';
		print '<br>';
	}

	print '<a class ="mainMenuButton" 
	href="/custom/controldeinventario/controldeinventarioindex.php?action=inventario">
	<img src="/custom/controldeinventario/img/inventariogeneral.png" alt="" class="paddingright pictofixedwidth valignmiddle">
	Sistema de control de inventarios Stock</a>';
	print '<br>';

	print '<a class ="mainMenuButton" 
	href="/custom/controldeinventario/inventarions_list.php?search_tiporeq=1">
	<img src="/custom/controldeinventario/img/inventariogeneral.png" alt="" class="paddingright pictofixedwidth valignmiddle">
	Sistema de control de inventarios (No Stock)</a>';
	print '<br>';

	print '<a class ="mainMenuButton" 
	href="/custom/controldeinventario/inventarions_list.php?search_tiporeq=4">
	<img src="/custom/controldeinventario/img/inventariogeneral.png" alt="" class="paddingright pictofixedwidth valignmiddle">
	Sistema de control de inventarios (OS)</a>';
	print '<br>';

	print '<a class ="mainMenuButton" 
	href="/custom/controldeinventario/inventarioans_list.php">
	<img src="/custom/controldeinventario/img/inventariogeneral.png" alt="" class="paddingright pictofixedwidth valignmiddle">
	Sistema de control de inventarios (Agroquímicos)</a>';
	print '<br>';
	if($user->rights->controldeinventario->report->read){
		print '<a class ="mainMenuButton" 
		href="/custom/controldeinventario/controldeinventarioindex.php?action=reportes">
		<img src="/custom/controldeinventario/img/emisionderequisiciones.png" alt="" class="paddingright pictofixedwidth valignmiddle">
		Reportes</a>';
		print '<br>';
	}
	
}
if($action=='requisicion'){
	if($user->rights->controldeinventario->emisionderequisiciones->read){
	print '<a class ="mainMenuButton" href="/custom/controldeinventario/emisionderequisiciones_card.php?action=create&isstock=1&backtopageforcancel=/custom/controldeinventario/controldeinventarioindex.php?action=requisicion">Nueva Requisición (No Stock)</a>';
	print '<br>';
	print '<a class ="mainMenuButton" href="/custom/controldeinventario/emisionderequisiciones_card.php?action=create&isstock=4&backtopageforcancel=/custom/controldeinventario/controldeinventarioindex.php?action=requisicion">Nueva Requisición (Órden de Servicio)</a>';
	print '<br>';
	print '<a class ="mainMenuButton" href="/custom/controldeinventario/emisionderequisiciones_card.php?action=create&isstock=6&backtopageforcancel=/custom/controldeinventario/controldeinventarioindex.php?action=requisicion">Nueva Requisición (ANS)</a>';
	print '<br>';
	print '<a class ="mainMenuButton" href="/custom/controldeinventario/emisionderequisiciones_card.php?action=create&isstock=0&backtopageforcancel=/custom/controldeinventario/controldeinventarioindex.php?action=requisicion">Nueva Requisición (Stock)</a>';
	print '<br>';
	print '<a class ="mainMenuButton" href="/custom/controldeinventario/emisionderequisiciones_list.php?idmenu=35411&mainmenu=controldeinventario&leftmenu=">Lista de requisiciones</a>';
	print '<br>';
	}

	

}
if($action=='entradas'){
	if($user->rights->controldeinventario->entradas->read){
	print '<a class ="mainMenuButton" href="/custom/controldeinventario/entradas_card.php?action=create&isstock=1&backtopageforcancel=/custom/controldeinventario/controldeinventarioindex.php?action=entradas">Nueva Entrada (No Stock)</a>';
	print '<br>';
	print '<a class ="mainMenuButton" href="/custom/controldeinventario/entradas_card.php?action=create&isstock=4&backtopageforcancel=/custom/controldeinventario/controldeinventarioindex.php?action=entradas">Nueva Entrada (Servicio)</a>';
	print '<br>';
	print '<a class ="mainMenuButton" href="/custom/controldeinventario/entradas_card.php?action=create&isstock=6&backtopageforcancel=/custom/controldeinventario/controldeinventarioindex.php?action=entradas">Nueva Entrada (ANS)</a>';
	print '<br>';
	print '<a class ="mainMenuButton" href="/custom/controldeinventario/entradas_card.php?action=create&isstock=0&backtopageforcancel=/custom/controldeinventario/controldeinventarioindex.php?action=entradas">Nueva Entrada (Stock)</a>';
	print '<br>';
	}
}
if($action=='salidas'){	
	if($user->rights->controldeinventario->salidas->read){
	print '<a class ="mainMenuButton" href="/custom/controldeinventario/salidas_card.php?action=create&isstock=1&backtopageforcancel=/custom/controldeinventario/controldeinventarioindex.php?action=salidas">Nueva salida (No Stock)</a>';
	print '<br>';
	print '<a class ="mainMenuButton" href="/custom/controldeinventario/salidas_card.php?action=create&isstock=4&backtopageforcancel=/custom/controldeinventario/controldeinventarioindex.php?action=salidas">Nueva salida (Servicio)</a>';
	print '<br>';
	print '<a class ="mainMenuButton" href="/custom/controldeinventario/salidas_card.php?action=create&isstock=6&backtopageforcancel=/custom/controldeinventario/controldeinventarioindex.php?action=salidas">Nueva salida (ANS)</a>';
	print '<br>';
	print '<a class ="mainMenuButton" href="/custom/controldeinventario/salidas_card.php?action=create&isstock=0&backtopageforcancel=/custom/controldeinventario/controldeinventarioindex.php?action=salidas">Nueva salida (Stock)</a>';
	print '<br>';
	}

}
if($action == 'inventario'){
	
	print '<a class ="mainMenuButton" 
	href="/custom/controldeinventario/inventariogeneral_list.php?search_tiporeq=0&sortfield=t.ref">Inventario Stock</a>';
	print '<br>';

	print '<a class ="mainMenuButton" 
	href="/custom/controldeinventario/inventariogeneral_card.php?action=create&stock=0&idmenu=35435&mainmenu=controldeinventario&leftmenu=">
	Nueva parte Stock
	</a>';
	print '<br>';


	print '<a class ="mainMenuButton" href="/custom/controldeinventario/familias_list.php?idmenu=35154&mainmenu=controldeinventario&leftmenu=">
	Familias
	</a>';
	print '<br>';

	print '<a class ="mainMenuButton" 
	href="/custom/controldeinventario/familias_card.php?action=create&idmenu=35442&mainmenu=controldeinventario&leftmenu=">
	Nueva Familia
	</a>';
	print '<br>';


}
if ($action == 'reportes'){
	if($user->rights->controldeinventario->report->read){
		if($user->rights->controldeinventario->reporte_afectadas->read){
			print '<a class ="mainMenuButton" target="_blank"
			href="/custom/controldeinventario/pdf_generator.php?report=inventariogeneral&filter=10">
			Reporte de partes afectadas.</a>';
			print '<br>';
		}
		if($user->rights->controldeinventario->reporte_familia->read){
			print '<a class ="mainMenuButton" 
			href="/custom/controldeinventario/controldeinventarioindex.php?action=reporte_stock_familia&backto='.$action.'">
			Reportes de inventario Stock por familias.</a>';
			print '<br>';
		}
		if($user->rights->controldeinventario->reporte_ubicacion->read){
			print '<a class ="mainMenuButton" 
			href="/custom/controldeinventario/controldeinventarioindex.php?action=reporte_stock_ubiqacion&backto='.$action.'">
			Reportes de inventario Stock por ubicación.</a>';
			print '<br>';
		}
		if($user->rights->controldeinventario->reporte_surtido->read){
			print '<a class ="mainMenuButton" 
			href="/custom/controldeinventario/controldeinventarioindex.php?action=reporte_nosurtida&backto='.$action.'">
			Reportes de Requisiciones no surtidas.</a>';
			print '<br>';
		}
		if($user->rights->controldeinventario->reporte_surtido->read){
			print '<a class ="mainMenuButton" 
			href="/custom/controldeinventario/controldeinventarioindex.php?action=reporte_requisicion&backto='.$action.'">
			Reportes de Requisiciones (por fecha).</a>';
			print '<br>';
		}
		if($user->rights->controldeinventario->reporte_diario->read){
			print '<a class ="mainMenuButton" 
			href="/custom/controldeinventario/pdf_generator.php?report=emisionderequisiciones&filter=7">
			Reportes de requisiciones Stock diarias (día anterior)</a>';
			print '<br>';
		}
			
			print '<a class ="mainMenuButton" 
			href="/custom/controldeinventario/controldeinventarioindex.php?action=reporte_salidas_fecha&backto='.$action.'">
			Reportes de Salidas (por fecha).</a>';
			print '<br>';

			print '<a class ="mainMenuButton" 
			href="/custom/controldeinventario/controldeinventarioindex.php?action=reporte_stock_fecha&backto='.$action.'">
			Reportes de Inventario con existencias.</a>';
			print '<br>';

	}

	
	

}
if($action=='reporte_nosurtida'){
		print '<br>';
		if($user->rights->controldeinventario->report->read){			
		print '<a class ="mainMenuButton" 
		href="/custom/controldeinventario/pdf_generator.php?report=emisionderequisiciones&filter=40">
		Reportes de requisiciones Stock, no surtidas.</a>';
		print '<br>';
		print '<a class ="mainMenuButton" 
		href="/custom/controldeinventario/pdf_generator.php?report=emisionderequisiciones&filter=41">
		Reportes de requisiciones No Stock, no surtidas.</a>';
		print '<br>';
		print '<a class ="mainMenuButton" 
		href="/custom/controldeinventario/pdf_generator.php?report=emisionderequisiciones&filter=44">
		Reportes de requisiciones de Servicio, no surtidas.</a>';
		print '<br>';
		print '<a class ="mainMenuButton" 
		href="/custom/controldeinventario/pdf_generator.php?report=emisionderequisiciones&filter=46">
		Reportes de requisiciones Agroquímicas, no surtidas.</a>';
		print '<br>';}
}
if($action=='reporte_requisicion'){
	print '<br>';
	
		if($user->rights->controldeinventario->report->read){
			print '<h2>Reporte de requisiciones (por fecha)</h2>';
			print '
			<form action="/custom/controldeinventario/pdf_generator.php" class="half " style="
		margin: 30px auto;
	">
	<div class="cabezeraTabla datebox"><h3>Formulario para hacer reporte</h3></div>
	<div class="normalTable">
		<br></br>
		<div style="margin: 0 auto;"class="datebox">
			<label>Fecha Inicio: </label>	
			<input type="date" name="startDate"> 
		</div>
		<div style="margin: 0 auto;"class="datebox">
			<label>Fecha Fin: </label>	
			<input type="date" name="endinDate"> 
			
		</div>
		<div style="margin: 0 auto;"class="datebox">
			<div class="tooltip">(?)
				<span class="tooltiptext">Solo elija <b>Fecha inicio</b> para iniciar desde esa fecha hasta el día de hoy.<p>Solo elija la <b>fecha fin</b> para SOLO ese día en particular.<p>Dejar vacio para ver la <b>TODA</b> la información completa.</span>
			</div>
		</div>
		';
		// <div style="margin: 0 auto;"class="datebox">
		// 	<label>Tipo de requisiciones</label>
		//  	<select id="tiporeq" name="tiporeq">
		// 	 	<option id="0" value="9">TODOS</option>
		// 		<option id="1" value="0">Stock</option>
		// 		<option id="2" value="1">NS y OS</option>
		// 		<option id="3" value="6">Agroquímicos</option>
			 
		//  	</select>
		//  </div>
		print'
		<input hidden id="report" name="report" value="emisionderequisiciones">';
		print '
		<input hidden id="report" name="filter" value="100">
		<br><br>
		
		<input style="margin:auto;width:30%;display: block;" type="submit" value="Generar Reporte">
		
	</div>
	</form>';

			 
		}
}

if ($action=='reporte_stock_ubiqacion'){

	print '<h2>Reporte de inventario Stock por ubicaciones.</h2>';
		print '
		<form action="/custom/controldeinventario/pdf_generator.php" class="half " style="
    margin: 30px auto;
">
<div class="cabezeraTabla datebox"><h3>Formulario para hacer reporte</h3></div>
<div class="normalTable">
	<br></br>
    <div style="margin: 0 auto;" class="datebox"><label>Ubicación a buscar: </label>
    <input type="search" id="target" name="target">
	</div>';
    // <select id="target">
    //     <option id="1"name="target" value="Almacén">En construcción...
    //     </option>
    // </select>
	print '
    <input hidden id="report" name="report" value="inventariogeneral">
	<input hidden id="report" name="filter" value="11">
	<br><br>
    

	
    <input style="margin:auto;width:30%;display: block;" type="submit" value="Generar Reporte">
    
</div>
</form>
		';
}
if ($action=='reporte_stock_diario'){

	print '<h2>Reporte de inventario Stock por ubicaciones.</h2>';
		print '
		<form action="/custom/controldeinventario/pdf_generator.php" class="half " style="
    margin: 30px auto;
">
<div class="cabezeraTabla datebox"><h3>Formulario para hacer reporte</h3></div>
<div class="normalTable">
	<br></br>
    <div style="margin: 0 auto;" class="datebox"><label>Ubicación a buscar: </label>
    <input type="date" id="target" name="target">
	</div>';
    // <select id="target">
    //     <option id="1"name="target" value="Almacén">En construcción...
    //     </option>
    // </select>
	print '
    <input hidden id="report" name="report" value="inventariogeneral">
	<input hidden id="report" name="filter" value="11">
	<br><br>
    
    <input style="margin:auto;width:30%;display: block;" type="submit" value="Generar Reporte">
    
</div>
</form>
		';
}

if ($action=='reporte_stock_familia'){
	print '<h2>Reporte de inventario Stock por Familia.</h2>';
		print '
		<script>
		// Get the input field
var input = document.getElementById("family");
window.onload = function() {
	
// Execute a function when the user releases a key on the keyboard
input.addEventListener("keyup", function(event) {
  // Number 13 is the "Enter" key on the keyboard
  if (event.keyCode === 13) {
    // Cancel the default action, if needed
    event.preventDefault();
    // Trigger the button element with a click
    document.getElementById("reportar").click();
  }
}
});
</script>
		<form action="/custom/controldeinventario/pdf_generator.php" class="half " style="
    margin: 30px auto;
">
<div class="cabezeraTabla datebox"><h3>Formulario para hacer reporte</h3></div>
<div class="normalTable">
	<br></br>
    <div style="margin: 0 auto;" class="datebox"><label>familia: </label>';
    //<input type="search" id="target" name="target">
	
	$sqlquery = "SELECT * FROM ".MAIN_DB_PREFIX."controldeinventario_familias";
	$sqlList = $db->query($sqlquery);
	print '<select id="family" name="family" onchange="document.getElementById('."'reportar'".').click()">';
	foreach ($sqlList as $member)
	{
		print'<option value = "'.(int)$member['ref'].'">'.$member['ref'].': '.$member['label'].' </option>';
	}
	
	

	print '</select>
	</div>';
    // <select id="target">
    //     <option id="1"name="target" value="Almacén">En construcción...
    //     </option>
    // </select>
	print '
    <input hidden id="report" name="report" value="inventariogeneral">
	<input hidden id="report" name="filter" value="12">
	<br><br>
    
    <input id="reportar" name="reportar" style="margin:auto;width:30%;display: block;" type="submit" value="Generar Reporte">
    
</div>
</form>
		';
}
if($action=='reporte_salidas_fecha'){
	print '<h2>Reporte de Salidas (con margen de fecha).</h2>';
	print'<form action="/custom/controldeinventario/pdf_generator.php" class="half " style="
    margin: 30px auto;
"><div class="cabezeraTabla datebox"><h3>Formulario para hacer reporte</h3></div>
<div style="margin: 0 auto;" class="datebox normalTable">
	<label>Fecha de inicio: </label><input type="date" name="startDate"> <br>
	<label>Fecha de fin: </label> <input type="date" name="endinDate"><br>
	<input hidden id="report" name="report" value="salidas">
	<input hidden id="filter" name="filter" value="100">
	<div style="margin: 0 auto;"class="datebox">
	<div class="tooltip">(?)
	<span class="tooltiptext">Solo elija <b>Fecha inicio</b> para iniciar desde esa fecha hasta el día de hoy.<p>Solo elija la <b>fecha fin</b> para SOLO ese día en particular.<p>Dejar vacio para ver la <b>TODA</b> la información completa.</span>
	</div>
</div>

	<br>
	<input id="reportar" name="reportar" style="margin:auto;width:30%;display: block;" type="submit" value="Generar Reporte">
</div>';
}
if($action=='reporte_stock_fecha'){
	print '<h2>Reportes con Existencia (por fecha).</h2>';
	print'<form action="/custom/controldeinventario/pdf_generator.php" class="half " style="
    margin: 30px auto;
"><div class="cabezeraTabla datebox"><h3>Formulario para hacer reporte</h3></div>
<div style="margin: 0 auto;" class="datebox normalTable">
	<label>Tipo de inventario: </label>
	<select name="report">
		<option value="inventariogeneral">Inventario Stock</option> 
		<option value="inventarions">Inventario NS, OS</option>
		<option value="inventarioans">Agroquímicos</option> 
	</select> <br>
	<label>Fecha de inicio: </label><input type="date" name="startDate"> <br>
	<label>Fecha de fin: </label> <input type="date" name="endinDate"><br>
	<div style="margin: 0 auto;"class="datebox">
		<div class="tooltip">(?)
		<span class="tooltiptext">Solo elija <b>Fecha inicio</b> para iniciar desde esa fecha hasta el día de hoy.<p>Solo elija la <b>fecha fin</b> para SOLO ese día en particular.<p>Dejar vacio para ver la <b>TODA</b> la información completa.</span>
		</div>
	</div>

	<input hidden id="filter" name="filter" value="110">
	<br>
	<input id="reportar" name="reportar" style="margin:auto;width:30%;display: block;" type="submit" value="Generar Reporte">
</div>';
}

print '</div><div class="fichetwothirdright firstcolumn"><div class="ficheaddleft">';


$NBMAX = $conf->global->MAIN_SIZE_SHORTLIST_LIMIT;
$max = $conf->global->MAIN_SIZE_SHORTLIST_LIMIT;


print '</div>
	</div>	
	<div></div>
</div>';

// End of page
llxFooter();
$db->close();
