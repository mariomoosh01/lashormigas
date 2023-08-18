<script>
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
 *   	\file       salidas_card.php
 *		\ingroup    controldeinventario
 *		\brief      Page to create/edit/view salidas
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
dol_include_once('/controldeinventario/class/salidas.class.php');
dol_include_once('/controldeinventario/lib/controldeinventario_salidas.lib.php');
dol_include_once('/controldeinventario/class/unidadmedida.class.php');

// Load translation files required by the page
$langs->loadLangs(array("controldeinventario@controldeinventario", "other"));

// Get parameters
$id = GETPOST('id', 'int');
$ref = GETPOST('ref', 'alpha');
$action = GETPOST('action', 'aZ09');
$ogaction = GETPOST('action', 'aZ09');
$confirm = GETPOST('confirm', 'alpha');
$cancel = GETPOST('cancel', 'aZ09');
$contextpage = GETPOST('contextpage', 'aZ') ? GETPOST('contextpage', 'aZ') : 'salidascard'; // To manage different context of search
$backtopage = GETPOST('backtopage', 'alpha');
$backtopageforcancel = GETPOST('backtopageforcancel', 'alpha');
$isstock = 0;
//$lineid   = GETPOST('lineid', 'int');

// Initialize technical objects
$object = new Salidas($db);
$extrafields = new ExtraFields($db);
//cargando requisicion
if($id<=0) $isstock = GETPOSTINT('isstock');
else{
	$object->fetch($id);
	$isstock = $object->tiporeq ;
}


$diroutputmassaction = $conf->controldeinventario->dir_output.'/temp/massgeneration/'.$user->id;
$hookmanager->initHooks(array('salidascard', 'globalcard')); // Note that conf->hooks_modules contains array

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


$permissiontoread = $user->rights->controldeinventario->salidas->read;
$permissiontoadd = $user->rights->controldeinventario->salidas->write; // Used by the include of actions_addupdatedelete.inc.php and actions_lineupdown.inc.php
$permissiontodelete = $user->rights->controldeinventario->salidas->delete || ($permissiontoadd && isset($object->status) && $object->status == $object::STATUS_DRAFT);
$permissionnote = $user->rights->controldeinventario->salidas->write; // Used by the include of actions_setnotes.inc.php
$permissiondellink = $user->rights->controldeinventario->salidas->write; // Used by the include of actions_dellink.inc.php
$upload_dir = $conf->controldeinventario->multidir_output[isset($object->entity) ? $object->entity : 1].'/salidas';

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

	//	$backurlforlist = dol_buildpath('/controldeinventario/salidas_list.php', 1);
	$backurlforlist = dol_buildpath('/controldeinventario/controldeinventarioindex.php?action=salidas', 1);
	if (empty($backtopage) || ($cancel && empty($id))) {
		if (empty($backtopage) || ($cancel && strpos($backtopage, '__ID__'))) {
			if (empty($id) && (($action != 'add' && $action != 'create') || $cancel)) {
				$backtopage = $backurlforlist;
			} else {
				//$backtopage = dol_buildpath('/controldeinventario/salidas_card.php', 1).'?id='.($id > 0 ? $id : '__ID__');
				$backtopage = dol_buildpath('/controldeinventario/salidas_card.php', 1).'?action=create&isstock='.$isstock.'&backtopageforcancel=/custom/controldeinventario/controldeinventarioindex.php?action=salidas';
			}
		}
	}

	$triggermodname = 'CONTROLDEINVENTARIO_SALIDAS_MODIFY'; // Name of trigger action code to execute when we modify record
	//ingerto por que no se usar ni Triggers ni Hooks, y de aquì a que aprenda, mejor le hago manual. a ver si no explota el código
	//primero checamos si no es salida repetida.
	$object->n_exit = GETPOST('n_exit','nohtml');
	$checkExitNum = "SELECT * FROM hor_controldeinventario_salidas WHERE n_exit =".$object->n_exit;

	$isExitNumberRepeat = $db->query($checkExitNum);
	if($isExitNumberRepeat->num_rows > 0){
		$error++;
		setEventMessages('Nùmero de salida repetido, intente de nuevo.',null,'errors');
	}

	if($isstock==0){
		//if($action=='create' || $action=='edit' || ($id > 0 && ($object->tiporeq=="0")))		
		$object->fields['fk_codific']['visible']='0';
		$object->fields['ref']['visible']='0';
		
		//if($action=='add'||$action=='update')
		if($action=='add')
		{
			$ref = $object->getNextNumRef('ST',$isstock);
			$object->ref = $ref;			
			require_once DOL_DOCUMENT_ROOT."\custom\controldeinventario\class\inventariogeneral.class.php";
			require_once DOL_DOCUMENT_ROOT.'\custom\controldeinventario\class\emisionderequisiciones.class.php';
			$stockproduct = new inventariogeneral($db);
			$currentsalid = new salidas($db);
			$newreq = new emisionderequisiciones($db);
			$idobject = $stockproduct->fetch(GETPOSTINT('fk_codific'));
			$idreq =0;//para checar si hicimos nueva requisición, y actualizarla en caso de que exista una (esperando que sea la más recientemente abierta)
			$id_req = 0; //ID para localizar la requisición a editar, en caso de encontrar 1. :P
			if($idobject>0)
			{
				$object->udm = $stockproduct->udm;//aseguramos de tener una unidad de medida consistente.
				$c_qty = $stockproduct->qty;
				if($action=="update")
				{
					$currentsalid->fetch($id);
					$c_qty-=$currententrd->give_qty;
				}			
				$add_qty = GETPOST('give_qty','int');if($add_qty > $c_qty) goto nocalcula;				
				$object->codific = $stockproduct->ref;
				//se supone que lleva su propio contador, ahora lo forzamos....espero.
				$object->fk_codific = $idobject;				
				$object->codificacion = $stockproduct->ref;
				$stockproduct->qty = $c_qty-$add_qty;
			
				if($stockproduct->rst_qty >= $stockproduct->qty)
				{
					$stockproduct->ask_qty = $stockproduct->max_qty - $stockproduct->qty;
					$temp = 0;
					$q_query = "SELECT * FROM hor_controldeinventario_emisionderequisiciones WHERE tiporeq=0 AND status =1 AND codificacion = '".$stockproduct->ref."'";
					$q_result = $db->query($q_query);
					if($q_result->num_rows<=0)$idreq =1;
					else $idreq = 0;
					if($idreq==1){
						
						$newreq->ref = $newreq->getNextNumRef('ST',0);
						$newreq->fk_codific = $idobject;
						$newreq->codificacion = $stockproduct->ref;
						$newreq->description = $stockproduct->description;
						$newreq->notes = "Requisición generada automáticamente.";
					}else{
						if($q_result->num_rows>=1){
							foreach($q_result as $target){								
								$temp = (int)$target['rowid'];
								$id_req = $newreq->fetch($temp);
							}
						}else{
							$error++;
							setEventMessages('Error cargando requisición, pruebe de nuevo.',null,'errors');
						}
						
	
					}
					//$newreq->date_creation = GETPOSTINT('date_creation'); //wachar que genere la fecha correctamente
					$newreq->tms = GETPOSTINT('tms');
					$newreq->udm = $stockproduct->udm;
					$newreq->solicitante = 'Almacén';
					$newreq->qty = $stockproduct->ask_qty;
					
					
				}
				//$stockproduct->cost = GETPOSTINT('cost');
				$stockproduct->t_cost = $stockproduct->qty * $stockproduct->cost;				
				//aqui actualizamos el producto							
				goto exitoprod;
				//aqui manejamos los mensajes de error, para saber exactamente cual fue el error....espero.
				nocomputa:		
				$error++;
				setEventMessages('Cantidad supera máximo del producto, pida '.($maxqt-$c_qty).' o menos del producto seleccionado',null,'errors');
				goto exitoprod;
				nocalcula:
				$error++;
				setEventMessages('La cantidad a sacar supera la de almacén, intente otra cantidad.',null,'errors');
				//goto exitoprod;
				exitoprod:
			}
			else {
				$error++;
				//setEventMessages("Error de base de datos - Producto no existente o vacio.", null, 'errors');
				//dol_print_error($db, $stockproduct->error);
			}
			if($cancel!="Cancelar")
			{
				$object->n_exit = GETPOST('n_exit','nohtml');
				$object->ref = GETPOST('ref','alpha');
				$testerror = isRequiredValsEmtpy($action,$permissiontoadd,$object);

				$checkDouble = new salidas($db);
				$checkDouble = $checkDouble->fetch(0,$ref);				
				if($checkDouble>0){
					setEventMessages('Entrada repetida, evitando duplicados',null,'errors');					
					$error++;					
				}

				//validamos campos antes de hechar a perder la base de datos.
				if ($testerror >0){
					setEventMessages("Error, campos vaciós detectados.", null, 'errors');
					$error++;
				}
				if (! $error) {
					$object->ref = $ref;				
					if($idreq==1)
					{
						$idobject = $newreq->create($user);
	
						if ($idobject > 0) 
						{
							//$object->codificacion = '';
							//necesitamos actualizar contador si hacemos nueva requecision
							dol_include_once('/controldeinventario/class/contadores.class.php');
							$contador = new contadores($db);
							$rescount = $contador->fetch(0,'01');
							$contador->req_ST +=1;
							$contador->update($user);
	
							setEventMessages("Nueva Requisición ".$newreq->codificacion." creada exitosamente",null);
						} 
					}
						setEventMessages('Producto de inventario '.$stockproduct->ref.' actualizado correctamente.',null);
						$stockproduct->tms = time();
						$stockproduct->update($user);
						// if($idreq==0){
						// 	$newreq->update($user);
						// 	setEventMessages("Requisición actualizada".$newreq->codificacion." con codificación: ".$stockproduct->ref,null);
					$updateStonks ="UPDATE hor_controldeinventario_inventarions SET t_cost = (qty * cost)";
					$stonksResult = $db->query($updateStonks);
					$updateStonks2 ="UPDATE hor_controldeinventario_inventarioans SET t_cost = (qty * cost)";
					$stonksResult2 = $db->query($updateStonks2);
					$db->commit();
					//print '--- end ok'."\n";
				} else {
					//print '--- end error code='.$error."\n";
					$db->rollback();
				}
			}			
		}
		if($action=="update"){	
			
		}
		if($action=="confirm_delete"){	

			
			require_once DOL_DOCUMENT_ROOT.'\custom\controldeinventario\class\inventariogeneral.class.php';
			$parte = new inventariogeneral($db);
			//si la salida a borrar es del inventario stock
			$currentsalid = new salidas($db);
			$idobject = $currentsalid->fetch(GETPOST('id','int'));
			if($idobject<=0){$error=2;goto exit_confirm_delete;}
			$ref_ent = $currentsalid->fk_codific;
			$qty = $currentsalid->give_qty;
			$idpart = $parte->fetch($ref_ent);
			if($idpart<=0){
				$error =3;
				goto exit0_confirm_delete;
			}
			$parte->qty+=$qty;
			if($parte->qty>=$parte->rst_qty){$parte->ask_qty=0;}
			else{$parte->ask_qty = $parte->max_qty - $parte->qty;}
			//recalculamos si necesitamos cantidad a pedir...o no.
			exit0_confirm_delete:			
			if (!$error) {					
				$parte->tms = time();				
				$parte->update($user);
				$db->commit();
				setEventMessages('Objeto '.$idexit.' actualizado correctamente.',null);
				//print '--- end ok'."\n";
			} else {
				switch($error){
					
					case 3:
						setEventMessages('error de datos. Parte no encontrada.',null,'errors');
						break;					
				}
				//print '--- end error code='.$error."\n";
				$db->rollback();
				goto nuthingHappened;
			}

		}
	}
	else //cuando manejamos requisiciones NO STOCK, ORDENES DE SERVICIO o AGROQUÍMICOS (NS, OS o ANS)
	{
		
		//$object->fields['fk_codific']['type']='integer:entradas:controldeinventario/class/entradas.class.php:0:tiporeq='.$isstock.'';
		//if($action=='add'||$action=='update')
		if($action=='add')
		{
			if($isstock==6){
				require_once DOL_DOCUMENT_ROOT.'\custom\controldeinventario\class\inventarioans.class.php';
				$parte = new inventarioans($db);
			}else{
				require_once DOL_DOCUMENT_ROOT.'\custom\controldeinventario\class\inventarions.class.php';
				$parte = new inventarions($db);
			}
			$ref_ent = GETPOST('ref','alpha');
			$idobject =$parte->fetch(0,$ref_ent); 
			$object->fields['fk_codific']['type']="integer:entrada:/custom/controldeinventario/class/entrada.class.php:0:tiporeq=".$isstock;
			$object->codificacion = $parte->ref;

			//$object->fk_codific = $idobject;
			$object->tiporeq = $isstock;
			if($cancel!="Cancelar"){
				//$parte = new entradas($db);
				//$idobject = $parte->fetch(0,$object->ref);
				if($idobject>0)
				{
					$despache =GETPOST('give_qty','int');
					if($despache>$parte->qty){
						$error++;
						setEventMessages('Cantidad despachada supera la en inventario.',null,'errors');
					}else
					{
						$parte->qty-=$despache;
						if($parte->salidas == ''){
							$parte->salidas.= GETPOSTINT('n_exit');
						}
						else{
							$parte->salidas.= ','.GETPOSTINT('n_exit');
						}
						if($parte->qty == 0 && $parte->rec_qty == $parte->max_qty){
							$parte->status = 9;
							setEventMessages('Inventario '.$parte->ref.' concluído correctamente.',null);
						}
					}

				}
				else
				{
					$error++;
					setEventMessages('error de datos. Inventario no encontrado.',null,'errors');
				}
				if (!$error) {
					
					$object->tms=time();
					$object->fk_user_modif=$user->id;
					$parte->tms = time();
					$parte->update($user);
					$updateStonks ="UPDATE hor_controldeinventario_inventarions SET t_cost = (qty * cost)";
					$stonksResult = $db->query($updateStonks);
					$updateStonks2 ="UPDATE hor_controldeinventario_inventarioans SET t_cost = (qty * cost)";
					$stonksResult2 = $db->query($updateStonks2);
					$db->commit();
					setEventMessages('Salida '.$object->ref.' actualizada correctamente.',null);
					//print '--- end ok'."\n";
				} else {
					//print '--- end error code='.$error."\n";
					$db->rollback();
				}
			}
		}
		if($action=="confirm_delete"){
			if($isstock==1||$isstock==4){
				require_once DOL_DOCUMENT_ROOT.'\custom\controldeinventario\class\inventarions.class.php';
				$parte = new inventarions($db);
			}else if($isstock==6){
				require_once DOL_DOCUMENT_ROOT.'\custom\controldeinventario\class\inventarioans.class.php';
				$parte = new inventarioans($db);
			}
			$currentsalid = new salidas($db);
			$idobject = $currentsalid->fetch(GETPOST('id','int'));
			if($idobject<=0){$error=2;goto exit_confirm_delete;}
			$ref_ent = $currentsalid->ref;
			$qty = $currentsalid->give_qty;
			
				//si la salida a borrar es de inventario no stock, servicio o agroquímicos												
				$n_exit =$currentsalid->n_exit;				
				$idpart = $parte->fetch(0,$ref_ent);
				if($idpart<=0){$error=4;goto exit_confirm_delete;}
				$parte->status = 1;
				$parte->qty+=$qty;
				$parte->salidas = str_replace($n_exit,"",$parte->salidas);
				//limpiamos la coma de enmedio.
				$parte->salidas = str_replace(',,',',',$parte->salidas);
				//limpiamos la coma de al principio
				if(strpos($parte->salidas,',')==0){$parte->salidas=substr($parte->salidas,1);}
				//esta parte no hay problema si no encontramos el número de salida...espero.
							
			
			exit_confirm_delete:
			if (!$error) {					
				$parte->tms = time();				
				$parte->update($user);
				$db->commit();
				setEventMessages('Objeto '.$idexit.' actualizado correctamente.',null);
				//print '--- end ok'."\n";
			} else {
				switch($error){
					case 2:
						setEventMessages('error de datos. Salida no encontrada.',null,'errors');
						break;
					case 3:
						setEventMessages('error de datos. Parte no encontrada.',null,'errors');
						break;
					case 4:
						setEventMessages('error de datos. Parte no encontrada.',null,'errors');
						break;
				}
				//print '--- end error code='.$error."\n";
				$db->rollback();
				goto nuthingHappened;
			}
		}
	}

		/*
	}else {
		$object->fields['fk_codific']['type']='integer:entradas:controldeinventario/class/entradas.class.php:0:tiporeq='.$isstock.'';
	}
	*/
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

	// Action if delete result in error?
	nuthingHappened:
	if ($action == 'set_thirdparty' && $permissiontoadd) {
		$object->setValueFrom('fk_soc', GETPOST('fk_soc', 'int'), '', '', 'date', '', $user, $triggermodname);
	}
	if ($action == 'classin' && $permissiontoadd) {
		$object->setProject(GETPOST('projectid', 'int'));
	}

	// Actions to send emails
	$triggersendname = 'CONTROLDEINVENTARIO_SALIDAS_SENTBYMAIL';
	$autocopy = 'MAIN_MAIL_AUTOCOPY_SALIDAS_TO';
	$trackid = 'salidas'.$object->id;
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

$prfx="ST";

$title = $langs->trans("Sistema de Salidas de Almacén ");
switch($isstock){
	case 0:
		$title.="(Stock)";		
		break;
	case 1:
		$title.="(No Stock)";
		$prfx="NS";
		break;
	case 4:
		$title.="(Orden de servicio)";
		$prfx="OS";
		break;
	case 6:
		$title.="(Agroquímicos)";
		$prfx="ANS";
		break;
		
}

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
	print load_fiche_titre($title, '', 'object_'.$object->picto);

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
	if($isstock==0){
		$object->fields['fk_codific']['visible']=1;
		$object->fields['codific']['visible']=0;
		
	}
	else{
		$object->fields['ref']['visible']=1;
		
	}
	print '<table class="border centpercent tableforfieldcreate">'."\n";
	//$tableQuery='SELECT * FROM hor_controldeinventario_salidas WHERE MONTH(date_creation)=MONTH(now())and YEAR(date_creation)=YEAR(now()) AND tiporeq = '.$isstock.' ORDER by date_creation ASC';		
	 ($isstock==0)
	 ?$tableQuery='SELECT * FROM hor_controldeinventario_salidas WHERE tiporeq = '.$isstock.' ORDER by rowid ASC'
	 :$tableQuery='SELECT * FROM hor_controldeinventario_salidas WHERE tiporeq = '.$isstock.' ORDER by ref ASC';
	//$tableQuery='SELECT * FROM hor_controldeinventario_salidas WHERE tiporeq = '.$isstock.' ORDER by ref ASC';
	// Common attributes
	$salida=1;
	//include DOL_DOCUMENT_ROOT.'/core/tpl/commonfields_add.tpl.php';
	include DOL_DOCUMENT_ROOT.'/custom/controldeinventario/core/tpl/commonfields_add.tpl.php';
	//modificar variable a otra cosa?
	// Other attributes
	include DOL_DOCUMENT_ROOT.'/custom/controldeinventario/core/tpl/extrafields_add.tpl.php';

	print '</table>'."\n";

	print dol_get_fiche_end();

	print '<div class="center">';
	if($permissiontoadd)
	print '<input type="submit" class="button" name="add" value="Ejecutar" id="execute" onclick="PreventDoubles()">';
	print '<input type="label" class="button" name"load" id="loadingGraph" value="Procesando..." style="display:none">';
	print '&nbsp; ';
	print '<input type="'.($backtopage ? "submit" : "button").'" class="button button-cancel" name="cancel" value="'.dol_escape_htmltag($langs->trans("Cancel")).'"'.($backtopage ? '' : ' onclick="javascript:history.go(-1)"').'>'; // Cancel for create does not post form if we don't know the backtopage
	print '</div>';

	print '</form>';

	dol_set_focus('input[name="ref"]');
}

// Part to edit record
if (($id || $ref) && $action == 'edit') {
	print load_fiche_titre($langs->trans("Editando salida."), '', 'object_'.$object->picto);

	print '<div id="Procesando" class="quickButton full" style="display:none">Procesando datos, por favor, espere...</div>';
	print '<form method="POST" id="FormatoEnvio" action="'.$_SERVER["PHP_SELF"].'?isstock='.$isstock.'">';
	print '<input type="hidden" name="token" value="'.newToken().'">';
	print '<input type="hidden" name="action" value="update">';
	print '<input type="hidden" name="id" value="'.$object->id.'">';	
	print '<input type="hidden" name="isstock" value="'.$isstock.'">';
	
	if ($backtopage) {
		print '<input type="hidden" name="backtopage" value="'.$backtopage.'">';
	}
	if ($backtopageforcancel) {
		print '<input type="hidden" name="backtopageforcancel" value="'.$backtopageforcancel.'">';
	}

	print dol_get_fiche_head();

	print '<table class="border centpercent tableforfieldedit">'."\n";

	// Common attributes
	//include DOL_DOCUMENT_ROOT.'/core/tpl/commonfields_edit.tpl.php';
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

	$head = salidasPrepareHead($object);
	print dol_get_fiche_head($head, 'card', $langs->trans("Workstation"), -1, $object->picto);

	$formconfirm = '';

	// Confirmation to delete
	if ($action == 'delete') {
		$formconfirm = $form->formconfirm($_SERVER["PHP_SELF"].'?id='.$object->id, $langs->trans('DeleteSalidas'), $langs->trans('ConfirmDeleteObject'), 'confirm_delete', '', 0, 1);
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
	$linkback = '<a href="'.dol_buildpath('/controldeinventario/salidas_list.php', 1).'?restore_lastsearch_values=1'.(!empty($socid) ? '&socid='.$socid : '').'">'.$langs->trans("BackToList").'</a>';

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
			if ($object->status == $object::STATUS_VALIDATED) {
				print dolGetButtonAction($langs->trans('SetToDraft'), '', 'default', $_SERVER["PHP_SELF"].'?id='.$object->id.'&action=confirm_setdraft&confirm=yes&isstock='.$isstock.'&token='.newToken(), '', $permissiontoadd);
			}

			print dolGetButtonAction($langs->trans('Modify'), '', 'default', $_SERVER["PHP_SELF"].'?id='.$object->id.'&action=edit&isstock='.$isstock.'&token='.newToken(), '', $permissiontodelete);

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
			$genallowed = $user->rights->controldeinventario->salidas->read; // If you can read, you can build the PDF to read content
			$delallowed = $user->rights->controldeinventario->salidas->write; // If you can create/edit, you can remove a file on card
			print $formfile->showdocuments('controldeinventario:Salidas', $object->element.'/'.$objref, $filedir, $urlsource, $genallowed, $delallowed, $object->model_pdf, 1, 0, 0, 28, 0, '', '', '', $langs->defaultlang);
		}

		// Show links to link elements
		$linktoelem = $form->showLinkToObjectBlock($object, null, array('salidas'));
		$somethingshown = $form->showLinkedObjectBlock($object, $linktoelem);


		print '</div><div class="fichehalfright"><div class="ficheaddleft">';

		$MAXEVENT = 10;

		$morehtmlright = '<a href="'.dol_buildpath('/controldeinventario/salidas_agenda.php', 1).'?id='.$object->id.'">';
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
	$modelmail = 'salidas';
	$defaulttopic = 'InformationMessage';
	$diroutput = $conf->controldeinventario->dir_output;
	$trackid = 'salidas'.$object->id;

	include DOL_DOCUMENT_ROOT.'/core/tpl/card_presend.tpl.php';
}


// End of page
llxFooter();
$db->close();
