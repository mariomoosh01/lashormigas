<script>
	//funciones javascript para manejo sencillo de la página de entradas(versión No stock)
	function autoExistencia(){
		 document.getElementById("ext_qty").value = document.getElementById("qty").value;
		// var cosa = document.getElementById("ext_qty");	
		// var att = document.createAttribute("disabled");
		// cosa.setAttributeNode(att);
	}
	function lockEntradas(){
		var cosa = document.getElementById("codificacion");	
		var att = document.createAttribute("disabled");
		cosa.setAttributeNode(att);
		cosa = document.getElementById("description");	
		cosa.setAttributeNode(att);
		cosa = document.getElementById("umd");	
		cosa.setAttributeNode(att);
		cosa = document.getElementById("get_qty");	
		cosa.setAttributeNode(att);
		cosa = document.getElementById("usuario");	
		cosa.setAttributeNode(att);

	}
	function autoCalc_cost(){
		var cantidad = document.getElementById("qty").value;
		var precio = document.getElementById("cost").value;
		var total = precio * cantidad;
		document.getElementById("t_cost").value = total;

	}
	function autoCalc_t_cost(){
		var cantidad = document.getElementById("qty").value;
		var precio = document.getElementById("t_cost").value;
		var total = precio / cantidad;
		document.getElementById("cost").value = total;
	}
	function PreventDoubles(){			
			document.getElementById("execute").style.display = "none";
			document.getElementById("loadingGraph").style.display = "inline-block";
			document.getElementById("FormatoEnvio").style.display = "none";
			document.getElementById("Procesando").style.display = ""
		}
</script>
<?php
/* Copyright (C) 2017 Laurent Destailleur  <eldy@users.sourceforge.net>
 * Copyright (C) ---Put here your own copyright and developer email---
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
 *   	\file       entradas_card.php
 *		\ingroup    controldeinventario
 *		\brief      Page to create/edit/view entradas
 */

//if (! defined('NOREQUIREDB'))              define('NOREQUIREDB', '1');				// Do not create database handler $db
//if (! defined('NOREQUIREUSER'))            define('NOREQUIREUSER', '1');				// Do not load object $user
//if (! defined('NOREQUIRESOC'))             define('NOREQUIRESOC', '1');				// Do not load object $mysoc
//if (! defined('NOREQUIRETRAN'))            define('NOREQUIRETRAN', '1');				// Do not load object $langs
//if (! defined('NOSCANGETFORINJECTION'))    define('NOSCANGETFORINJECTION', '1');		// Do not check injection attack on GET parameters
//if (! defined('NOSCANPOSTFORINJECTION'))   define('NOSCANPOSTFORINJECTION', '1');		// Do not check injection attack on POST parameters
//if (! defined('NOCSRFCHECK'))              define('NOCSRFCHECK', '1');				// Do not check CSRF attack (test on referer + on token if option MAIN_SECURITY_CSRF_WITH_TOKEN is on).
//if (! defined('NOTOKENRENEWAL'))           define('NOTOKENRENEWAL', '1');				// Do not roll the Anti CSRF token (used if MAIN_SECURITY_CSRF_WITH_TOKEN is on)
//if (! defined('NOSTYLECHECK'))             define('NOSTYLECHECK', '1');				// Do not check style html tag into posted data
//if (! defined('NOREQUIREMENU'))            define('NOREQUIREMENU', '1');				// If there is no need to load and show top and left menu
//if (! defined('NOREQUIREHTML'))            define('NOREQUIREHTML', '1');				// If we don't need to load the html.form.class.php
//if (! defined('NOREQUIREAJAX'))            define('NOREQUIREAJAX', '1');       	  	// Do not load ajax.lib.php library
//if (! defined("NOLOGIN"))                  define("NOLOGIN", '1');					// If this page is public (can be called outside logged session). This include the NOIPCHECK too.
//if (! defined('NOIPCHECK'))                define('NOIPCHECK', '1');					// Do not check IP defined into conf $dolibarr_main_restrict_ip
//if (! defined("MAIN_LANG_DEFAULT"))        define('MAIN_LANG_DEFAULT', 'auto');					// Force lang to a particular value
//if (! defined("MAIN_AUTHENTICATION_MODE")) define('MAIN_AUTHENTICATION_MODE', 'aloginmodule');	// Force authentication handler
//if (! defined("NOREDIRECTBYMAINTOLOGIN"))  define('NOREDIRECTBYMAINTOLOGIN', 1);		// The main.inc.php does not make a redirect if not logged, instead show simple error message
//if (! defined("FORCECSP"))                 define('FORCECSP', 'none');				// Disable all Content Security Policies
//if (! defined('CSRFCHECK_WITH_TOKEN'))     define('CSRFCHECK_WITH_TOKEN', '1');		// Force use of CSRF protection with tokens even for GET
//if (! defined('NOBROWSERNOTIF'))     		 define('NOBROWSERNOTIF', '1');				// Disable browser notification

//it's JAVASCRIPT time

//


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

require_once DOL_DOCUMENT_ROOT.'/core/class/html.formcompany.class.php';
require_once DOL_DOCUMENT_ROOT.'/core/class/html.formfile.class.php';
require_once DOL_DOCUMENT_ROOT.'/core/class/html.formprojet.class.php';
require_once DOL_DOCUMENT_ROOT.'/custom/controldeinventario/core/modules/validarCampos.php';

dol_include_once('/controldeinventario/class/inventariogeneral.class.php');
dol_include_once('/controldeinventario/class/inventarions.class.php');
dol_include_once('/controldeinventario/class/inventarioans.class.php');
dol_include_once('/controldeinventario/class/entradas.class.php');
dol_include_once('/controldeinventario/lib/controldeinventario_entradas.lib.php');
dol_include_once('/controldeinventario/class/unidadmedida.class.php');
dol_include_once('/controldeinventario/class/emisionderequisiciones.class.php');

// Load translation files required by the page
$langs->loadLangs(array("controldeinventario@controldeinventario", "other"));

// Get parameters
$id = (int) GETPOST('id', 'int');
$ref = GETPOST('ref', 'alpha');
$action = GETPOST('action', 'aZ09');
$ogaction = GETPOST('action', 'aZ09');
$confirm = GETPOST('confirm', 'alpha');
$cancel = GETPOST('cancel', 'aZ09');
$contextpage = GETPOST('contextpage', 'aZ') ? GETPOST('contextpage', 'aZ') : 'entradascard'; // To manage different context of search
$backtopage = GETPOST('backtopage', 'alpha');
$backtopageforcancel = GETPOST('backtopageforcancel', 'alpha');

//$lineid   = GETPOST('lineid', 'int');

// Initialize technical objects
$object = new Entradas($db);
$extrafields = new ExtraFields($db);
//cargando parámetros dependientes del objeto
if($id<=0) $isstock = GETPOSTINT('isstock');
else{
	$object->fetch($id);
	$isstock = $object->tiporeq ;
}
$prfx="ST";
switch ($isstock){
	case
		1: $prfx = "NS";
	break;
	case
		4: $prfx = "OS";
	break;
	case
		6 :$prfx = "ANS";
	break;
}
$title = $langs->trans("Entrada_".$prfx);
//objetos pendientes del objecto cargados!
$diroutputmassaction = $conf->controldeinventario->dir_output.'/temp/massgeneration/'.$user->id;
$hookmanager->initHooks(array('entradascard', 'globalcard')); // Note that conf->hooks_modules contains array

// Fetch optionals attributes and labels
$extrafields->fetch_name_optionals_label($object->table_element);

$search_array_options = $extrafields->getOptionalsFromPost($object->table_element, '', 'search_');

// Initialize array of search criterias
$search_all = GETPOST("search_all", 'alpha');
$search = array();
foreach ($object->fields as $key => $val) {
	if (GETPOST('search_'.$key, 'alpha')) {
		$search[$key] = GETPOST('search_'.$key, 'alpha');
	}
}

if (empty($action) && empty($id) && empty($ref)) {
	$action = 'view';
}

// Load object
include DOL_DOCUMENT_ROOT.'/core/actions_fetchobject.inc.php'; // Must be include, not include_once.


$permissiontoread = $user->rights->controldeinventario->entradas->read;
$permissiontoadd = $user->rights->controldeinventario->entradas->write; // Used by the include of actions_addupdatedelete.inc.php and actions_lineupdown.inc.php
$permissiontodelete = $user->rights->controldeinventario->entradas->delete || ($permissiontoadd && isset($object->status) && $object->status == $object::STATUS_DRAFT);
$permissionnote = $user->rights->controldeinventario->entradas->write; // Used by the include of actions_setnotes.inc.php
$permissiondellink = $user->rights->controldeinventario->entradas->write; // Used by the include of actions_dellink.inc.php
$upload_dir = $conf->controldeinventario->multidir_output[isset($object->entity) ? $object->entity : 1].'/entradas';

// Security check (enable the most restrictive one)
//if ($user->socid > 0) accessforbidden();
//if ($user->socid > 0) $socid = $user->socid;
//$isdraft = (($object->status == $object::STATUS_DRAFT) ? 1 : 0);
//restrictedArea($user, $object->element, $object->id, $object->table_element, '', 'fk_soc', 'rowid', $isdraft);
//if (empty($conf->controldeinventario->enabled)) accessforbidden();
//if (!$permissiontoread) accessforbidden();


/*
 * Actions
 */

$parameters = array();
$reshook = $hookmanager->executeHooks('doActions', $parameters, $object, $action); // Note that $action and $object may have been modified by some hooks
if ($reshook < 0) {
	setEventMessages($hookmanager->error, $hookmanager->errors, 'errors');
}

if (empty($reshook)) {
	$error = 0;

//	$backurlforlist = dol_buildpath('/controldeinventario/entradas_list.php', 1);
	$backurlforlist = dol_buildpath('/controldeinventario/controldeinventarioindex.php?action=entradas', 1);

	if (empty($backtopage) || ($cancel && empty($id))) {
		if (empty($backtopage) || ($cancel && strpos($backtopage, '__ID__'))) {
			if (empty($id) && (($action != 'add' && $action != 'create') || $cancel)) {
				$backtopage = $backurlforlist;
			} else {
				//$backtopage = dol_buildpath('/controldeinventario/entradas_card.php', 1).'?id='.($id > 0 ? $id : '__ID__');
				$backtopage = dol_buildpath('/controldeinventario/entradas_card.php', 1).'?action=create&isstock='.$isstock.'&backtopageforcancel=/custom/controldeinventario/controldeinventarioindex.php?action=entradas';
			}
		}
	}

	$triggermodname = 'CONTROLDEINVENTARIO_ENTRADAS_MODIFY'; // Name of trigger action code to execute when we modify record
	//ingerto por que no se usar ni Triggers ni Hooks, y de aquì a que aprenda, mejor le hago manual. a ver si no explota el código

		
	//si la requisición es STOCK, hacemos lo siguiente.
	if($cancel!="Cancelar"){
		if($isstock==0)
		{
			//if($action=='create' || $action=='edit' || ($id > 0 && ($object->tiporeq=="0")))
			//$object->fields['fk_codific']['type']='integer:inventariogeneral:controldeinventario/class/inventariogeneral.class.php:0:tiporeq=0';
			//if($action=='add'||$action=='update')
			if($action=='add')
			{			
				require_once DOL_DOCUMENT_ROOT."\custom\controldeinventario\class\inventariogeneral.class.php";
				$stockproduct = new inventariogeneral($db);
				$currententrd = new entradas($db);	
				$requisicion = new emisionderequisiciones($db);
				$idobject = $stockproduct->fetch(0,GETPOST('codificacion'));
				$ref = $object->getNextNumRef($prfx,$isstock);
				$object->ref = $ref;
				if($idobject>0)
				{				
					$object->udm = $stockproduct->udm;
					$current_qty = $stockproduct->qty;
					$maxqt = $stockproduct->max_qty;
					$add_qty = (double)GETPOST('qty','int');
					$object->ext_qty += $add_qty;
					if($add_qty < 0) goto nocalcula;				
					$object->codificacion = $stockproduct->ref;
					$object->fk_codific = $idobject;
					if(($current_qty+$add_qty)>($maxqt*1.1))goto nocomputa;
					$stockproduct->qty = $current_qty+$add_qty;
					$stockproduct->cost = GETPOST('cost','int');
					//si el stock sigue siendo afectado, hay que indicarlo, de lo contrario, decimos que no
					//pedirémos mas stock.
					if($current_qty <= $stockproduct->ask_qty)
					$stockproduct->ask_qty = $maxqt - $stockproduct->qty;
					else
					$stockproduct->ask_qty = 0;
					//multiplicamos automáticamente el costo por la cantidad de partes que tendrémos
					$stockproduct->t_cost = $stockproduct->cost*$stockproduct->qty;
					//$object->t_cost = $object->ask_qty * $object->cost ;
					$object->usuario = 'Almacén';
					//aqui actualizamos el producto...si no hubiera error.
					//ahora, cancelamos la requisicion para que no nos cause borlote en el reporte
					//asumiendo no actualizemos NADA.

					
						$object->ref=GETPOST('ref','alpha');
						$idreq = $requisicion->fetch(0,$object->ref);
						if($idreq>0){
							
							if($object->ext_qty>=$requisicion->qty){
								if($requisicion->status==1||$requisicion->status==2)						
									$requisicion->status = 9;															
							}
							else{
								$requisicion->status=2;
							}						
						}
						else{
							goto nocheca;
						}
					
					
					
					goto salida;
	nocomputa:		
					$error++;
					setEventMessages('Cantidad supera máximo del producto, pida '.($maxqt-$current_qty).' o menos del producto seleccionado',null,'errors');
					goto salida;
	nocalcula:
					$error++;
					setEventMessages('Cantidad puesta resultó en un número negativo. Intente con otra cantidad.',null,'errors');
					goto salida;
				
	nocheca:		
					$error++;
					setEventMessages('Requisición no existe, favor de verificar.',null,'errors');
					goto salida;
	repetido:
					$error++;
					setEventMessages('Requisición ya fue cancelada. Intente con otra requisición',null,'errors');
	salida:				
				}
				else {
					$error++;
					//dol_print_error($db, $stockproduct->error);
					setEventMessages('Parte a sido borrada mientras se hacia la entrada, favor de verificar.',null,'errors');
				}
				//código para validar campos requeridos ANTES de modificar la base de datos...
				//para no hacer entradas de productos deokis.
			
				$areKeyFieldEmpty = isRequiredValsEmtpy($action,$permissiontoadd,$object);
				if($areKeyFieldEmpty==0){
					$productOK=true;
					//si no uhubo horrores a la hora de calcular, proceder a actualizar el stock.
				}else{
					setEventMessages('Faltan campos clave.',null,'errors');
					$error++;
				}
				//evitar repetidas en entradas y salidas va  a ser MUY diferente de requisiciónes.
				if (! $error) {
					$object->tms=time();
					if($idreq>0 ) {
						$requisicion->tms = time();
						$requisicion->update($user);
						if($requisicion->status==9)
						setEventMessages('Requisición '.$requisicion->ref.' Completada correctamente.',null);
						else
						setEventMessages('Requisición '.$requisicion->ref.' Parcial aceptada.',null);
					}
					if($productOK){
						setEventMessages('Producto de inventario '.$stockproduct->ref.' actualizado correctamente.',null);
						$stockproduct->tms=time();
						$stockproduct->update($user);
					}					
					$db->commit();
					//print '--- end ok'."\n";
				} else {
					//print '--- end error code='.$error."\n";
					$db->rollback();
				}							
			}
		}
		else //Si la requisicion es NO STOCK(NS), SERVICIO, ETC.
		{
			//if($action=='add'||$action=='update')
			if($action=='add')
			{
				$object->fields['ref']['visible']='1';
				//$object->ref = GETPOST('codificacion','alpha');
				$object->fields['ref']['default']='';			
				$object->fields['fk_ref']['type']='integer:emisionderequisiciones:controldeinventario/class/emisionderequisiciones.class.php:0:tiporeq='.$isstock;
				//primero cambiamos los campos para revelar lo que necesitamos y sobreescribimos los permisos de dolibarr.
				$requisicion = new emisionderequisiciones($db);
				if($isstock==6)$nostockproduct = new inventarioans($db);
				else $nostockproduct = new inventarions($db);
				$parte_objetivo = GETPOST('ref','alpha');
				$idobject = $requisicion->fetch(0,GETPOST('ref'));
				$idproduct = $nostockproduct->fetch(0,$parte_objetivo);
				$object->codificacion = $parte_objetivo;
				$object->tiporeq = $isstock;
				$object->qty = GETPOST('qty','int');
				$object->ext_qty = GETPOST('ext_qty','int');
				if($action=='add'){
					$object->cost = GETPOST('cost','int');
					$object->t_cost = GETPOST('t_cost','int');
				}			
			
				//checando si no borran la requisición mientras editan los datos.
				if($idobject>0)
				{
					$object->ext_qty = GETPOST('ext_qty','int');
					$object->fk_ref=$idobject;				
				}
				else{
					$error++;
					setEventMessages('Error cargando requisición, se borró en lo que se agregaba la entrada, favor de verificar.',null,'errors');
					goto salto;
					
				}
				if($idproduct > 0)
				{
					//actualizamos los datos del producto
					
					if($action=='add')
					{
						$object->ext_qty = $nostockproduct->qty;
						if($nostockproduct->max_qty >= ($object->qty + $nostockproduct->rec_qty))
						{
							$nostockproduct->qty += $object->qty;
							$nostockproduct->rec_qty += $object->qty;
							$nostockproduct->cost = $object->cost;	
							if($nostockproduct->iva==1) {
								$nostockproduct->t_cost = ($nostockproduct->qty * $object->cost)*16;
								$nostockproduct->cost *= 1.16;
								
							}
							else {
								$nostockproduct->t_cost = $nostockproduct->qty * $object->cost;
							}
							$nostockproduct->cost = round($nostockproduct->cost,2);
							$nostockproduct->t_cost = round($nostockproduct->t_cost,2);
							$object->fields['ext_qty']['visible']='0';
							//si terminamos de rellenar la requisición, decimos que ya podemos cerrar la requicisión
							//de otro modo, no cerramos la requicisión, dando a entender que es una entrada parcial.
							if($nostockproduct->max_qty == $nostockproduct->rec_qty){
								$cerrar_req=true;
							}
						}
						else{
							$error++;
							setEventMessages('La cantidad supera a la esperada por la requisición. Verifique.',null,'errors');
							goto salto;
						}
					}else{
						$current_qty=GETPOST('qty','int');
						$current_rec_qty=GETPOST('qty','int');
						$current_cost=GETPOST('cost','int');
						$current_t_cost=GETPOST('t_cost','int');
						$nostockproduct->iva = GETPOS('iva');
						$nostockproduct->qty -= ($current_qty-$object->qty);
						$nostockproduct->rec_qty -= ($current_rec_qty - $object->qty);
						$nostockproduct->cost = round($current_cost,2);	
						$nostockproduct->t_cost = round($current_t_cost,2);	
						$object->cost = round($object->cost,2);
						$object->t_cost = round($object->t_cost,2);


					}
				}else{
					$object->ext_qty=$object->qty;
					//agregamos un producto no stock nuevo, Si este no existe.
					$nostockproduct->ref = $object->codificacion;
					$nostockproduct->description = GETPOST('description','alpha');
					$nostockproduct->udm = GETPOST('udm','alpha');
					$nostockproduct->qty = GETPOST('qty','int');
					$nostockproduct->rec_qty = GETPOST('qty','int');
					$nostockproduct->cost = GETPOST('cost','int');
					$nostockproduct->t_cost = GETPOST('t_cost','int');
					$nostockproduct->iva = GETPOSTINT('iva');
					if($object->iva==1) {
						$nostockproduct->t_cost *= 1.16;
						$nostockproduct->cost *= 1.16;
						$nostockproduct->iva = 1;
					}					
					$nostockproduct->max_qty = $requisicion->qty;
					$nostockproduct->ubicacion = GETPOST('ubicacion','alpha');
					$nostockproduct->tiporeq = $isstock;
					$nostockproduct->solicitante = GETPOST('usuario','alpha');
					$nostockproduct->udm = GETPOST('udm','alpha');
					$nostockproduct->date_creation = time();
					$nostockproduct->tms = time();
					$nostockproduct->fk_user_creat = $user->id;
					$nostockproduct->status = 1;
					$newpart = true;
					if($nostockproduct->max_qty == $nostockproduct->rec_qty){
						$cerrar_req=true;
					}

				}
				//ver costos y actualizarlos automáticamente si se omite alguno.
				if($object->t_cost==0  && $object->cost==0){
					if($action=='add'){
						$error++;
						setEventMessages('Debe poner costo individual de la parte, o en su defecto, la cantidad total de la factura.',null,'errors');						
					}
				}
				if($object->qty > $requisicion->qty ){
					if($isstock==1){
					$error++;
					setEventMessages('La cantidad a recibir supera la cantidad estimada. Vuelva a intentarlo.',null,'errors');
					}else{
						setEventMessages('La cantidad supera la petición, pero se permitió exceder la requisición.',null,'warnings');
					}
					
				}
				//aqui verificamos si cumplimos con las cantidades en inventario.
				if($idproduct>0) {
					if($action=='add'){
						if($requisicion->status == 1 || $requisicion->status==0 )
						{
							
						}
						else{
							$error++;
							setEventMessages('Requisición ya cumplida. intente con otra.',null,'errors');
							goto salto;						
						}
					}
				}
				//aquí verificamos que la entrada tenga parte asignada, si no se le asigna uno nuevo.
				
				salto:
				if (! $error) {
					$object->tms = time();
					if($action=='add'){
						$object->date_creation = time();
						
						if($cerrar_req){
							
							$requisicion->status = 9;						
							$requisicion->update($user);
							$nostockpart->tms = time();
							$nostockproduct->update($user);
							
							setEventMessages('Requisición cerrada correctamente',null);
						}
						
						if($newpart){														
							$nostockproduct->create($user);
							setEventMessages('Nueva parte agregada al Inventario NS: '.$nostockproduct->ref,null);														
						}else{
							$nostockproduct->tms = time();
							$nostockproduct->update($user);
							setEventMessages('Parte actualizada en Inventario NS: '.$nostockproduct->ref,null);
						}
					}if($action=='update'){
						$object->tms = time();
						if($newpart){														
							$nostockproduct->create($user);
							setEventMessages('Nueva parte agregada al Inventario NS: '.$nostockproduct->ref,null);														
						}else{
							$nostockproduct->tms = time();
							$nostockproduct->update($user);
							setEventMessages('Parte actualizada en Inventario NS: '.$nostockproduct->ref,null);
						}
					}
					
					$db->commit();
					//print '--- end ok'."\n";
					//setEventMessages('entrada '.$object->ref.' actualizada correctamente.',null);
				} else {
					//print '--- end error code='.$error."\n";
					$db->rollback();
				}	
				
			}
		}

		if($action=="confirm_delete"){
			$requisicion = new emisionderequisiciones($db);
			$stockproduct = new inventariogeneral($db);
			$nostockpart = new inventarions($db);
			$anspart = new inventarioans($db);
			$object->fetch($id);
			$idobject = $requisicion->fetch(0,$object->ref);
			$idparte = $stockproduct->fetch($object->fk_codific);
			

			if($idobject>0){
				$requisicion->status = 1;
				$requisicion->update($user);
			}
			if($isstock!=0){//ANS, OS, NS
				$idns = $nostockpart->fetch(0,$object->ref);
				$idan = $anspart->fetch(0,$object->ref);
				if($idns > 0){
					$nostockpart->qty -= $object->qty;
					if($nostockpart->qty>0){
						$nostockpart->tms = time();
						$nostockpart->update($user);						
					}
					else{$nostockpart->delete($user);}
				}
				if($idan > 0){
					$anspart->qty -= $object->qty;
					if($anspart->qty>0){
						$anspart->tms = time();
						$anspart->update($user);
					}
					else{$anspart->delete($user);}
				}
			}else//si es parte stock, simplemente bajar partes de la codificación correspondiente
			{
				if($idparte>0){
					$stockproduct->qty -= $object->qty;
					if($stockproduct->qty <0)$stockproduct->qty=0;
					$stockproduct->tms = time();
					$stockproduct->update($user);
				}
			}
		}
	}
	//termina ingerto

	// Actions cancel, add, update, update_extras, confirm_validate, confirm_delete, confirm_deleteline, confirm_clone, confirm_close, confirm_setdraft, confirm_reopen
	include DOL_DOCUMENT_ROOT.'/core/actions_addupdatedelete.inc.php';

	// Actions when linking object each other
	include DOL_DOCUMENT_ROOT.'/core/actions_dellink.inc.php';

	// Actions when printing a doc from card
	include DOL_DOCUMENT_ROOT.'/core/actions_printing.inc.php';

	// Action to move up and down lines of object
	//include DOL_DOCUMENT_ROOT.'/core/actions_lineupdown.inc.php';

	// Action to build doc
	include DOL_DOCUMENT_ROOT.'/core/actions_builddoc.inc.php';

	if ($action == 'set_thirdparty' && $permissiontoadd) {
		$object->setValueFrom('fk_soc', GETPOST('fk_soc', 'int'), '', '', 'date', '', $user, $triggermodname);
	}
	if ($action == 'classin' && $permissiontoadd) {
		$object->setProject(GETPOST('projectid', 'int'));
	}

	// Actions to send emails
	$triggersendname = 'CONTROLDEINVENTARIO_ENTRADAS_SENTBYMAIL';
	$autocopy = 'MAIN_MAIL_AUTOCOPY_ENTRADAS_TO';
	$trackid = 'entradas'.$object->id;
	include DOL_DOCUMENT_ROOT.'/core/actions_sendmails.inc.php';
}




/*
 * View
 *
 * Put here all code to build page
 */

$form = new Form($db);
$formfile = new FormFile($db);
$formproject = new FormProjets($db);


$help_url = '';
llxHeader('', $title, $help_url);

// Example : Adding jquery code
// print '<script type="text/javascript" language="javascript">
// jQuery(document).ready(function() {
// 	function init_myfunc()
// 	{
// 		jQuery("#myid").removeAttr(\'disabled\');
// 		jQuery("#myid").attr(\'disabled\',\'disabled\');
// 	}
// 	init_myfunc();
// 	jQuery("#mybutton").click(function() {
// 		init_myfunc();
// 	});
// });
// </script>';


// Part to create
if ($action == 'create') {
	print load_fiche_titre($langs->trans($title), '', 'object_'.$object->picto);
	print '<div id="Procesando" class="quickButton full" style="display:none">Procesando datos, por favor, espere...</div>';
	print '<form method="POST" id="FormatoEnvio" action="'.$_SERVER["PHP_SELF"].'?isstock='.$isstock.'">';
	print '<input type="hidden" name="token" value="'.newToken().'">';
	print '<input type="hidden" name="action" value="add">';
	print '<input type="hidden" name="isstock" value="'.$isstock.'">';
	if ($backtopage) {
		print '<input type="hidden" name="backtopage" value="'.$backtopage.'">';
	}
	if ($backtopageforcancel) {
		print '<input type="hidden" name="backtopageforcancel" value="'.$backtopageforcancel.'">';
	}

	print dol_get_fiche_head(array(), '');

	// Set some default values
	//if (! GETPOSTISSET('fieldname')) $_POST['fieldname'] = 'myvalue';

	print '<table class="border centpercent tableforfieldcreate">'."\n";


	//aqui tuneamos algunas cosillas.
	
	
	if($isstock==0)
	{
		//if($action=='create' || $action=='edit' || ($id > 0 && ($object->tiporeq=="0")))		
		//$object->fields['fk_ref']['visible']=0;
		$object->fields['fk_codific']['visible']=0;
		$object->fields['codificacion']['visible']=1;
		$object->fields['ref']['visible']=1;
		$object->fields['qty']['visible']=1;
		$object->fields['ext_qty']['visible']=0;


	}else{
		//$object->fields['fk_ref']['type']='integer:emisionderequisiciones:controldeinventario/class/emisionderequisiciones.class.php:0:tiporeq='.$isstock;
		$object->fields['fk_ref']['visible']=0;
		//$object->fields['fk_codific']['visible']=0;
		$object->fields['codificacion']['visible']=0;	
		$object->fields['ref']['visible']=1;

	}
	//$tableQuery="SELECT * FROM hor_controldeinventario_entradas WHERE MONTH(date_creation)=MONTH(now())and YEAR(date_creation)=YEAR(now()) AND tiporeq = ".$isstock." ORDER by 'ref'";		
	$tableQuery='SELECT * FROM hor_controldeinventario_entradas WHERE tiporeq = '.$isstock.' ORDER by ref ASC';
	// Common attributes
	//include DOL_DOCUMENT_ROOT.'/core/tpl/commonfields_add.tpl.php';
	$entrada = true;
	include DOL_DOCUMENT_ROOT.'/custom/controldeinventario/core/tpl/commonfields_add.tpl.php';
	//modificar variable a otra cosa?
	// Other attributes
	//include DOL_DOCUMENT_ROOT.'/custom/controldeinventario/core/tpl/extrafields_add.tpl.php';
	
	print '<div class="center">';
	if($permissiontoadd)
	print '<input type="submit" class="button" name="add" value="Ejecutar" id="execute" onclick="PreventDoubles()">';
	print '<input type="label" class="button" name"load" id="loadingGraph" value="Procesando..." style="display:none">';
	print '&nbsp; ';
	print '<input type="'.($backtopage ? "submit" : "button").'" class="button button-cancel" name="cancel" value="'.dol_escape_htmltag($langs->trans("Cancel")).'"'.($backtopage ? '' : ' onclick="javascript:history.go(-1)"').'>'; // Cancel for create does not post form if we don't know the backtopage
	print '</div>';

	print '</table>'."\n";

	print dol_get_fiche_end();


	print '</form>';

	dol_set_focus('input[name="ref"]');
}

// Part to edit record
if (($id || $ref) && $action == 'edit') {
	print load_fiche_titre($langs->trans("Editando entrada"), '', 'object_'.$object->picto);

	print '<div id="Procesando" class="quickButton full" style="display:none">Procesando datos, por favor, espere...</div>';
	print '<form method="POST" id="FormatoEnvio" action="'.$_SERVER["PHP_SELF"].'?isstock='.$isstock.'">';
	print '<input type="hidden" name="token" value="'.newToken().'">';
	print '<input type="hidden" name="action" value="update">';
	$isstock = (int)GETPOST("isstock","int");
	print '<input type="hidden" name="isstock" value="'.$isstock.'">';
	

	print '<input type="hidden" name="id" value="'.$object->id.'">';
	if ($backtopage) {
		print '<input type="hidden" name="backtopage" value="'.$backtopage.'">';
	}
	if ($backtopageforcancel) {
		print '<input type="hidden" name="backtopageforcancel" value="'.$backtopageforcancel.'">';
	}

	print dol_get_fiche_head();

	print '<table class="border centpercent tableforfieldedit">'."\n";

	// Common attributes
	// include DOL_DOCUMENT_ROOT.'/core/tpl/commonfields_edit.tpl.php';
	$entrada = true;
	include DOL_DOCUMENT_ROOT.'/custom/controldeinventario/core/tpl/commonfields_edit.tpl.php';

	// Other attributes
	include DOL_DOCUMENT_ROOT.'/core/tpl/extrafields_edit.tpl.php';

	print '</table>';

	print dol_get_fiche_end();

	print '<div class="center"><input type="submit" class="button button-save" name="save" value="'.$langs->trans("Save").'">';
	print ' &nbsp; <input type="submit" class="button button-cancel" name="cancel" value="'.$langs->trans("Cancel").'">';
	print '</div>';

	print '</form>';
}


// Part to show record
if ($object->id > 0 && (empty($action) || ($action != 'edit' && $action != 'create'))) {
	$res = $object->fetch_optionals();

	$head = entradasPrepareHead($object);
	print dol_get_fiche_head($head, 'card', $langs->trans("Workstation"), -1, $object->picto);

	$formconfirm = '';

	// Confirmation to delete
	if ($action == 'delete') {
		$formconfirm = $form->formconfirm($_SERVER["PHP_SELF"].'?id='.$object->id, $langs->trans('DeleteEntradas'), $langs->trans('ConfirmDeleteObject'), 'confirm_delete', '', 0, 1);
	}
	// Confirmation to delete line
	if ($action == 'deleteline') {
		$formconfirm = $form->formconfirm($_SERVER["PHP_SELF"].'?id='.$object->id.'&lineid='.$lineid, $langs->trans('DeleteLine'), $langs->trans('ConfirmDeleteLine'), 'confirm_deleteline', '', 0, 1);
	}
	// Clone confirmation
	if ($action == 'clone') {
		// Create an array for form
		$formquestion = array();
		$formconfirm = $form->formconfirm($_SERVER["PHP_SELF"].'?id='.$object->id, $langs->trans('ToClone'), $langs->trans('ConfirmCloneAsk', $object->ref), 'confirm_clone', $formquestion, 'yes', 1);
	}

	// Confirmation of action xxxx
	if ($action == 'xxx') {
		$formquestion = array();
		/*
		$forcecombo=0;
		if ($conf->browser->name == 'ie') $forcecombo = 1;	// There is a bug in IE10 that make combo inside popup crazy
		$formquestion = array(
			// 'text' => $langs->trans("ConfirmClone"),
			// array('type' => 'checkbox', 'name' => 'clone_content', 'label' => $langs->trans("CloneMainAttributes"), 'value' => 1),
			// array('type' => 'checkbox', 'name' => 'update_prices', 'label' => $langs->trans("PuttingPricesUpToDate"), 'value' => 1),
			// array('type' => 'other',    'name' => 'idwarehouse',   'label' => $langs->trans("SelectWarehouseForStockDecrease"), 'value' => $formproduct->selectWarehouses(GETPOST('idwarehouse')?GETPOST('idwarehouse'):'ifone', 'idwarehouse', '', 1, 0, 0, '', 0, $forcecombo))
		);
		*/
		$formconfirm = $form->formconfirm($_SERVER["PHP_SELF"].'?id='.$object->id, $langs->trans('XXX'), $text, 'confirm_xxx', $formquestion, 0, 1, 220);
	}

	// Call Hook formConfirm
	$parameters = array('formConfirm' => $formconfirm, 'lineid' => $lineid);
	$reshook = $hookmanager->executeHooks('formConfirm', $parameters, $object, $action); // Note that $action and $object may have been modified by hook
	if (empty($reshook)) {
		$formconfirm .= $hookmanager->resPrint;
	} elseif ($reshook > 0) {
		$formconfirm = $hookmanager->resPrint;
	}

	// Print form confirm
	print $formconfirm;


	// Object card
	// ------------------------------------------------------------
	//$linkback = '<a href="'.dol_buildpath('/controldeinventario/entradas_list.php', 1).'?restore_lastsearch_values=1'.(!empty($socid) ? '&socid='.$socid : '').'">'.$langs->trans("BackToList").'</a>';
	$linkback = '<a href="/custom/controldeinventario/controldeinventarioindex.php?action=entradas"> Menú de Entradas</a>';

	$morehtmlref = '<div class="refidno">';
	/*
	 // Ref customer
	 $morehtmlref.=$form->editfieldkey("RefCustomer", 'ref_client', $object->ref_client, $object, 0, 'string', '', 0, 1);
	 $morehtmlref.=$form->editfieldval("RefCustomer", 'ref_client', $object->ref_client, $object, 0, 'string', '', null, null, '', 1);
	 // Thirdparty
	 $morehtmlref.='<br>'.$langs->trans('ThirdParty') . ' : ' . (is_object($object->thirdparty) ? $object->thirdparty->getNomUrl(1) : '');
	 // Project
	 if (! empty($conf->projet->enabled)) {
	 $langs->load("projects");
	 $morehtmlref .= '<br>'.$langs->trans('Project') . ' ';
	 if ($permissiontoadd) {
	 //if ($action != 'classify') $morehtmlref.='<a class="editfielda" href="' . $_SERVER['PHP_SELF'] . '?action=classify&amp;id=' . $object->id . '">' . img_edit($langs->transnoentitiesnoconv('SetProject')) . '</a> ';
	 $morehtmlref .= ' : ';
	 if ($action == 'classify') {
	 //$morehtmlref .= $form->form_project($_SERVER['PHP_SELF'] . '?id=' . $object->id, $object->socid, $object->fk_project, 'projectid', 0, 0, 1, 1);
	 $morehtmlref .= '<form method="post" action="'.$_SERVER['PHP_SELF'].'?id='.$object->id.'">';
	 $morehtmlref .= '<input type="hidden" name="action" value="classin">';
	 $morehtmlref .= '<input type="hidden" name="token" value="'.newToken().'">';
	 $morehtmlref .= $formproject->select_projects($object->socid, $object->fk_project, 'projectid', $maxlength, 0, 1, 0, 1, 0, 0, '', 1);
	 $morehtmlref .= '<input type="submit" class="button valignmiddle" value="'.$langs->trans("Modify").'">';
	 $morehtmlref .= '</form>';
	 } else {
	 $morehtmlref.=$form->form_project($_SERVER['PHP_SELF'] . '?id=' . $object->id, $object->socid, $object->fk_project, 'none', 0, 0, 0, 1);
	 }
	 } else {
	 if (! empty($object->fk_project)) {
	 $proj = new Project($db);
	 $proj->fetch($object->fk_project);
	 $morehtmlref .= ': '.$proj->getNomUrl();
	 } else {
	 $morehtmlref .= '';
	 }
	 }
	 }*/
	$morehtmlref .= '</div>';


	dol_banner_tab($object, 'ref', $linkback, 1, 'ref', 'ref', $morehtmlref);


	print '<div class="fichecenter">';
	print '<div class="fichehalfleft">';
	print '<div class="underbanner clearboth"></div>';
	print '<table class="border centpercent tableforfield">'."\n";

	// Common attributes
	//$keyforbreak='fieldkeytoswitchonsecondcolumn';	// We change column just before this field
	//unset($object->fields['fk_project']);				// Hide field already shown in banner
	//unset($object->fields['fk_soc']);					// Hide field already shown in banner
	//include DOL_DOCUMENT_ROOT.'/core/tpl/commonfields_view.tpl.php';
	include DOL_DOCUMENT_ROOT.'/custom/controldeinventario/core/tpl/commonfields_view.tpl.php';

	// Other attributes. Fields from hook formObjectOptions and Extrafields.
	include DOL_DOCUMENT_ROOT.'/core/tpl/extrafields_view.tpl.php';

	print '</table>';
	print '</div>';
	print '</div>';

	print '<div class="clearboth"></div>';

	print dol_get_fiche_end();


	/*
	 * Lines
	 */

	if (!empty($object->table_element_line)) {
		// Show object lines
		$result = $object->getLinesArray();

		print '	<form name="addproduct" id="addproduct" action="'.$_SERVER["PHP_SELF"].'?id='.$object->id.(($action != 'editline') ? '' : '#line_'.GETPOST('lineid', 'int')).'" method="POST">
		<input type="hidden" name="token" value="' . newToken().'">
		<input type="hidden" name="action" value="' . (($action != 'editline') ? 'addline' : 'updateline').'">
		<input type="hidden" name="mode" value="">
		<input type="hidden" name="page_y" value="">
		<input type="hidden" name="id" value="' . $object->id.'">
		';

		if (!empty($conf->use_javascript_ajax) && $object->status == 0) {
			include DOL_DOCUMENT_ROOT.'/core/tpl/ajaxrow.tpl.php';
		}

		print '<div class="div-table-responsive-no-min">';
		if (!empty($object->lines) || ($object->status == $object::STATUS_DRAFT && $permissiontoadd && $action != 'selectlines' && $action != 'editline')) {
			print '<table id="tablelines" class="noborder noshadow" width="100%">';
		}

		if (!empty($object->lines)) {
			$object->printObjectLines($action, $mysoc, null, GETPOST('lineid', 'int'), 1);
		}

		// Form to add new line
		if ($object->status == 0 && $permissiontoadd && $action != 'selectlines') {
			if ($action != 'editline') {
				// Add products/services form

				$parameters = array();
				$reshook = $hookmanager->executeHooks('formAddObjectLine', $parameters, $object, $action); // Note that $action and $object may have been modified by hook
				if ($reshook < 0) setEventMessages($hookmanager->error, $hookmanager->errors, 'errors');
				if (empty($reshook))
					$object->formAddObjectLine(1, $mysoc, $soc);
			}
		}

		if (!empty($object->lines) || ($object->status == $object::STATUS_DRAFT && $permissiontoadd && $action != 'selectlines' && $action != 'editline')) {
			print '</table>';
		}
		print '</div>';

		print "</form>\n";
	}


	// Buttons for actions

	if ($action != 'presend' && $action != 'editline') {
		print '<div class="tabsAction">'."\n";
		$parameters = array();
		$reshook = $hookmanager->executeHooks('addMoreActionsButtons', $parameters, $object, $action); // Note that $action and $object may have been modified by hook
		if ($reshook < 0) {
			setEventMessages($hookmanager->error, $hookmanager->errors, 'errors');
		}

		if (empty($reshook)) {
			// Send
			if (empty($user->socid)) {
				print dolGetButtonAction($langs->trans('SendMail'), '', 'default', $_SERVER["PHP_SELF"].'?id='.$object->id.'&action=presend&mode=init&isstock='.$isstock.'&token='.newToken().'#formmailbeforetitle');
			}

			// Back to draft
			// if ($object->status == $object::STATUS_VALIDATED) {
			// 	print dolGetButtonAction($langs->trans('SetToDraft'), '', 'default', $_SERVER["PHP_SELF"].'?id='.$object->id.'&action=confirm_setdraft&confirm=yes&isstock='.$isstock.'&token='.newToken(), '', $permissiontoadd);
			// }

			print dolGetButtonAction($langs->trans('Modify'), '', 'default', $_SERVER["PHP_SELF"].'?id='.$object->id.'&action=edit&isstock='.$isstock.'&token='.newToken(), '', $permissiontoadd);

			// Validate
			if ($object->status == $object::STATUS_DRAFT) {
				if (empty($object->table_element_line) || (is_array($object->lines) && count($object->lines) > 0)) {
					print dolGetButtonAction($langs->trans('Validate'), '', 'default', $_SERVER['PHP_SELF'].'?id='.$object->id.'&action=confirm_validate&confirm=yes&isstock='.$isstock.'&token='.newToken(), '', $permissiontoadd);
				} else {
					$langs->load("errors");
					print dolGetButtonAction($langs->trans("ErrorAddAtLeastOneLineFirst"), $langs->trans("Validate"), 'default', '#', '', 0);
				}
			}

			// Clone
			print dolGetButtonAction($langs->trans('ToClone'), '', 'default', $_SERVER['PHP_SELF'].'?id='.$object->id.'&socid='.$object->socid.'&action=clone&isstock='.$isstock.'&token='.newToken(), '', $permissiontoadd);

			/*
			if ($permissiontoadd) {
				if ($object->status == $object::STATUS_ENABLED) {
					print dolGetButtonAction($langs->trans('Disable'), '', 'default', $_SERVER['PHP_SELF'].'?id='.$object->id.'&action=disable&isstock='.$isstock.'&token='.newToken(), '', $permissiontoadd);
				} else {
					print dolGetButtonAction($langs->trans('Enable'), '', 'default', $_SERVER['PHP_SELF'].'?id='.$object->id.'&action=enable&isstock='.$isstock.'&token='.newToken(), '', $permissiontoadd);
				}
			}
			
			if ($permissiontoadd) {
				if ($object->status == $object::STATUS_VALIDATED) {
					print dolGetButtonAction($langs->trans('Cancel'), '', 'default', $_SERVER['PHP_SELF'].'?id='.$object->id.'&action=close&isstock='.$isstock.'&token='.newToken(), '', $permissiontoadd);
				} else {
					print dolGetButtonAction($langs->trans('Re-Open'), '', 'default', $_SERVER['PHP_SELF'].'?id='.$object->id.'&action=reopen&isstock='.$isstock.'&token='.newToken(), '', $permissiontoadd);
				}
			}
			*/

			// Delete (need delete permission, or if draft, just need create/modify permission)
			print dolGetButtonAction($langs->trans('Delete'), '', 'delete', $_SERVER['PHP_SELF'].'?id='.$object->id.'&action=delete&isstock='.$isstock.'&token='.newToken(), '', $permissiontodelete || ($object->status == $object::STATUS_DRAFT && $permissiontoadd));
		}
		print '</div>'."\n";
	}


	// Select mail models is same action as presend
	if (GETPOST('modelselected')) {
		$action = 'presend';
	}

	if ($action != 'presend') {
		print '<div class="fichecenter"><div class="fichehalfleft">';
		print '<a name="builddoc"></a>'; // ancre

		$includedocgeneration = 0;

		// Documents
		if ($includedocgeneration) {
			$objref = dol_sanitizeFileName($object->ref);
			$relativepath = $objref.'/'.$objref.'.pdf';
			$filedir = $conf->controldeinventario->dir_output.'/'.$object->element.'/'.$objref;
			$urlsource = $_SERVER["PHP_SELF"]."?id=".$object->id;
			$genallowed = $user->rights->controldeinventario->entradas->read; // If you can read, you can build the PDF to read content
			$delallowed = $user->rights->controldeinventario->entradas->write; // If you can create/edit, you can remove a file on card
			print $formfile->showdocuments('controldeinventario:Entradas', $object->element.'/'.$objref, $filedir, $urlsource, $genallowed, $delallowed, $object->model_pdf, 1, 0, 0, 28, 0, '', '', '', $langs->defaultlang);
		}

		// Show links to link elements
		$linktoelem = $form->showLinkToObjectBlock($object, null, array('entradas'));
		$somethingshown = $form->showLinkedObjectBlock($object, $linktoelem);


		print '</div><div class="fichehalfright"><div class="ficheaddleft">';

		$MAXEVENT = 10;

		$morehtmlright = '<a href="'.dol_buildpath('/controldeinventario/entradas_agenda.php', 1).'?id='.$object->id.'">';
		$morehtmlright .= $langs->trans("SeeAll");
		$morehtmlright .= '</a>';

		// List of actions on element
		include_once DOL_DOCUMENT_ROOT.'/core/class/html.formactions.class.php';
		$formactions = new FormActions($db);
		$somethingshown = $formactions->showactions($object, $object->element.'@'.$object->module, (is_object($object->thirdparty) ? $object->thirdparty->id : 0), 1, '', $MAXEVENT, '', $morehtmlright);

		print '</div></div></div>';
	}

	//Select mail models is same action as presend
	if (GETPOST('modelselected')) {
		$action = 'presend';
	}

	// Presend form
	$modelmail = 'entradas';
	$defaulttopic = 'InformationMessage';
	$diroutput = $conf->controldeinventario->dir_output;
	$trackid = 'entradas'.$object->id;

	include DOL_DOCUMENT_ROOT.'/core/tpl/card_presend.tpl.php';
}


// End of page


// End of page
llxFooter();
$db->close();
