<?php

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
dol_include_once('/controldeinventario/class/entradas.class.php');
dol_include_once('/controldeinventario/lib/controldeinventario_entradas.lib.php');
dol_include_once('/controldeinventario/class/unidadmedida.class.php');

// Load translation files required by the page
$langs->loadLangs(array("controldeinventario@controldeinventario", "other"));

// Get parameters
$target = GETPOST('req','alpha');
$database = GETPOST('data','alpha');
$isstock = $_SERVER['HTTP_REFERER'];
if ($database != "inventariogeneral"){
$query = "SELECT * FROM ".MAIN_DB_PREFIX."controldeinventario_".$database." WHERE ref ='".$target."'";
}
else{
    $query = "SELECT * FROM ".MAIN_DB_PREFIX."controldeinventario_".$database." WHERE rowid ='".$target."'";
}
$datalist = $db->query($query);
$resultado="";
if ($datalist){
    foreach ($datalist as $line)
    {
        $resultado="";
        if($database=='emisionderequisiciones'){
            $check = stripos($isstock,"&isstock=");
            $lestock = $isstock[$check+9];//solo sirve si tiporeq es MENOR a 10, asi que AGUAS!
            //logica para entender detectar de donde calo la entrada
            if($lestock == $line["tiporeq"])
                $resultado = $line["description"].";".$line["udm"].";".$line["qty"].";".$line["solicitante"].";".$line["codificacion"];
            else
                $resultado = "notFound";

        }
        if($database=='entradas')
        $resultado = $line["description"].";".$line["udm"].";".$line["get_qty"].";".$line["usuario"];
        if($database=='inventariogeneral'){
            if($line["ask_qty"]==0)
            $resultado = $line["description"].";".$line["udm"].";0;Almacén;".$line["cost"];
            else
            $resultado = $line["description"].";".$line["udm"].";".$line["ask_qty"].";Almacén;".$line["cost"].';'.$line["location"];
        }
    }
}
if ($datalist->num_rows<=0) {
    $resultado="notFound";
}


print $resultado;