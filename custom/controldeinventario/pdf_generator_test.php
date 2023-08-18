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
//cargandgo variables
$title = "";
$dataToLoad = GETPOST('report','alpha');
$filterToSee = GETPOSTINT('filter');
$orientacion = GETPOST('orient','alpha');
$objetivo = GETPOST('target','alpha');
$familiaL = GETPOST('family','alpha');
$startDate = GETPOST('startDate','alpha');
$endinDate = GETPOST('endinDate','alpha');
$cajaCount = 0;
$parrafCount = true;
//cargando librerias Dolibar
require_once TCPDF_PATH.'tcpdf.php';
$consultasql = '';
$objeto = '';
//dol_include_once('/controldeinventario/core/modules/controldeinventario/doc/pdf_standard_inventariogeneral.modules.php');
if($dataToLoad!=NULL){
    dol_include_once('/controldeinventario/class/entradas.class.php');
    dol_include_once('/controldeinventario/class/emisionderequisiciones.class.php');
    dol_include_once('/controldeinventario/class/salidas.class.php');
    dol_include_once('/controldeinventario/class/inventariogeneral.class.php');
    dol_include_once('/controldeinventario/class/inventarions.class.php');
    dol_include_once('/controldeinventario/class/inventarioans.class.php');
    dol_include_once('/controldeinventario/class/unidadmedida.class.php');
    dol_include_once('/controldeinventario/class/almacenes.class.php');
    dol_include_once('/controldeinventario/class/familias.class.php');
    if($orientacion==NULL) $orientacion = "L";
    $unidadmedida = new unidadmedida($db);
    $almacen = new almacenes($db);
    $familia = new familias($db);
    $consultasql = 'SELECT * FROM '.MAIN_DB_PREFIX.'controldeinventario_'.$dataToLoad;
    if($filterToSee)
        switch($filterToSee)
        {
            case 0:
            case 1:
            case 4:
            case 6:
                $consultasql.=' WHERE "tiporeq" = '.$filterToSee;
                break;
            case 7:
                $consultasql.=" WHERE DATE(date_creation) = CURRENT_DATE()-1 AND tiporeq = 0;";
                break;
            case 8:
                $consultasql.=" WHERE qty > 0;";
                break;
            case 9:
                $consultasql.= ' WHERE tiporeq=0 AND status = 1;';
                break;
            case 10:
                $consultasql.= " WHERE ask_qty > 0 AND tiporeq = 0";
                break;
            case 11:
                $consultasql.= " WHERE location LIKE '".$objetivo."%'";
                break;
            case 12:
                $consultasql.= " WHERE family = ".$familiaL;
                break;
            case 13:
                $consultasql.= " WHERE DATE(date_creation) >= ".$sendDate." AND tiporeq = 0";
                break;
            case 20:
            case 21:               
            case 24:               
            case 26:
                $consultasql.= " WHERE tiporeq=".($filterToSee - 20)." AND status = 1";
                $hidereq = true;
                break;
            case 30:
            case 31:               
            case 34:               
            case 36:
                $consultasql.=" WHERE qty > 0 AND tiporeq = ".($filterToSee-30).";";
               
                break;
            case 40:
            case 41:
            case 44:
            case 46:
                $consultasql.= ' WHERE tiporeq='.($filterToSee-40).' AND status = 1;';
                break;
            case 100:
                if($endinDate=='')
                $consultasql.= " WHERE date_creation >= '".$startDate."' AND date_creation <= '".$startDate." 23:59:59'";
                else if ($startDate=='')
                $consultasql.= " WHERE date_creation >= '".$endinDate."' AND date_creation <= '".$endinDate." 23:59:59'";
                else if($startDate && $endinDate)
                $consultasql.= " WHERE date_creation >= '".$startDate." ' AND date_creation <= '".$endinDate." 23:59:59'";
                break;
            case 110:
                if (!$startDate && !$endinDate)
                $consultasql.= " WHERE tms >= '1990-01-01' AND tms <= '".date("Y-m-d")." 23:59:59' AND status = 1";
                else if($endinDate=='')
                $consultasql.= " WHERE tms >= '".$startDate."' AND tms <= '".$startDate." 23:59:59' AND status = 1";
                else if ($startDate=='')
                $consultasql.= " WHERE tms >= '".$endinDate."' AND tms <= '".$endinDate." 23:59:59' AND status = 1";
                else if($startDate && $endinDate)
                $consultasql.= " WHERE tms >= '".$startDate." ' AND tms <= '".$endinDate." 23:59:59' AND status = 1";
                

                break;              
            case 111:
            case 114:
                if($endinDate=='')
                $consultasql.= " WHERE date_creation >= '".$startDate."' AND date_creation <= '".$startDate." 23:59:59' AND status = 1";
                else if ($startDate=='')
                $consultasql.= " WHERE date_creation >= '".$endinDate."' AND date_creation <= '".$endinDate." 23:59:59' AND status = 1";
                else if($startDate && $endinDate)
                $consultasql.= " WHERE date_creation >= '".$startDate." ' AND date_creation <= '".$endinDate." 23:59:59' AND status = 1";
                else if (!$startDate && !$endinDate)
                $consultasql.= " WHERE date_creation >= '1990-01-01' AND date_creation <= '".date("Y-m-d")." 23:59:59' AND status = 1";
                break;
            case 116:
                if($endinDate=='')
                $consultasql.= " WHERE date_creation >= '".$startDate."' AND date_creation <= '".$startDate." 23:59:59' ";
                else if ($startDate=='')
                $consultasql.= " WHERE date_creation >= '".$endinDate."' AND date_creation <= '".$endinDate." 23:59:59' ";
                else if($startDate && $endinDate)
                $consultasql.= " WHERE date_creation >= '".$startDate." ' AND date_creation <= '".$endinDate." 23:59:59' ";
                else if (!$startDate && !$endinDate)
                $consultasql.= " WHERE date_creation >= '1990-01-01' AND date_creation <= '".date("Y-m-d")." 23:59:59' ";
                break;
        }
}

class MYPDF extends TCPDF {

    // Load table data from file
    public function LoadData($query,$db,$truTable=NULL) {
        // Leemos los datos de la consulta SQL
        $lines = $db->query($query);;

        $data = array();
        foreach($lines as $line) {
            $cleanline = array_values($line);
            $newline = array();
            //si tenemos una tabla de visión de datos de dolibar, 
            //seleccionamos los datos que marcamos como 'visibles' en Dolibarr.
            if($truTable){
               for($x=0;$x<count($cleanline);$x++){
                   if(in_array($truTable[$x],[1,2,4,5],true)){
                       $newline[]=$cleanline[$x];
                   }
               }
                $data[]=$newline;
            }else{
                //pero si no, simplemente metemos TODA la fila.
                $data[] = $line;
            }
        }
        return $data;
    }
    
    // Colored table
    public function ColoredTable($header,$data,$w = array(40, 35, 40, 45)) {
        // Colors, line width and bold font
        $this->SetFillColor(0, 0, 128);
        $this->SetTextColor(255);
        $this->SetDrawColor(32, 32, 192);
        $this->SetLineWidth(0.5);
        $this->SetFont('', 'B' ,7);
        // Header
        ;
        $num_headers = count($header);
        for($i = 0; $i < $num_headers; ++$i) {
            $this->Cell($w[$i], 7, $header[$i], 1, 0, 'C', 1);
        }
        $this->Ln();
        // Color and font restoration
        $this->SetFillColor(224, 235, 255);
        $this->SetTextColor(0);
        $this->SetFont('');
        // Data
        $fill = 0;
        foreach($data as $row) {
            $x=0;
            $cosa = array_values($row);
            do {                
                $text=$this->Cell($w[$x], 4, $cosa[$x] , 'LR', 0, 'L', $fill);                           
                $x++;
            } while($x < count($w));
            
            $this->Ln();
            $fill=!$fill;
        }
        $this->Cell(array_sum($w), 0, '', 'T');
    }
}
//$documentoPDF = new pdf_standard_inventariogeneral($db);
$pdf = new MYPDF($orientacion,PDF_UNIT,PDF_PAGE_FORMAT,true,'UTF-8',false);
//datos de fecha para los reportes. PHP no me quiere. pero bueno, mejor que nada.
$diassemana = array("Domingo","Lunes","Martes","Miercoles","Jueves","Viernes","Sábado");
$meses = array("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");
$fecha = $diassemana[date('w')]." ".date('d')." de ".$meses[date('n')-1]. " del ".date('Y') ;

//creando titulo
if($dataToLoad == 'inventariogeneral')
{
   
    $title = "Inventario";
    if($filterToSee==9 || $filterToSee==10)
        $title = "partes afectadas";
    if($filterToSee==11){
        $title = "Inventario por ubicacion (stock).";
    }
    if($filterToSee==12){
        $title = "Inventario por Familia (stock).";
    }
    if($filterToSee==110){
        $title = "Inventario con existencia por fecha (stock)";
    }
           
}
   
//fue un dolor de muelas descubrir, pero lo haremos manual por lo pronto.

else if($dataToLoad == 'entradas')
{
   
    $title = "Entradas";
    switch($filterToSee){
        case 6:
        case 16:
        case 26:
        case 36:
        $title.=' (Agroquímicos)';
        break;
        case 4:
        case 14:
        case 24:
        case 34:
        $title.=' (Orden de servicio)';
        break;
        case 1:
        case 11:
        case 21:
        case 31:
        $title.=' (No Stock)';
        break;
            
    }

    

    //simplemente dividimos equitativamente entre las cabezeras, son pocos los campos de todos modos.
}
else if($dataToLoad == 'salidas')
{
    $title = "Salidas";
   
    
}
else if($dataToLoad == 'emisionderequisiciones')
{
   
    if($filterToSee==7){
        $title = "de requisición diario";

    }
    else if($filterToSee==9||$filterToSee==40){
        $title = "de requisiciones Stock no surtidas.";
    }
    else if($filterToSee==41){
        $title = "de requisiciones No Stock no surtidas.";
    }
    else if($filterToSee==44){
        $title = "de requisiciones de Orden de Servicio no surtidas.";
    }
    else if($filterToSee==46){
        $title = "de requisiciones de Agroquímicos no surtidas.";
    }
    else if($filterToSee==10){
        $title = "partes afectadas";

    }
    else{
        $title = "requisiciones";
    }
}
else if ($dataToLoad == 'inventarions'|| $dataToLoad=='inventarioans')
{
    $title = "Entradas de almacén";
    switch($filterToSee){
        case 6:
        case 16:
        case 26:
        case 36:
        case 46:
        $title.=' (Agroquímicos)';
        break;
        case 4:
        case 14:
        case 24:
        case 34:
        case 44:
        $title.=' (Orden de servicio)';
        break;
        case 1:
        case 11:
        case 21:
        case 31:
        case 41:
            $title.=' (No Stock)';
            break;
        case 110:
                $title = "Inventario con existencia por fecha";
            break;
        case 111:
        case 114:
            $title = "Inventario con existencia por fecha (NS, OS)";
            break;
        case 116:
            $title = "Inventario con existencia por fecha (ANS)";
            break;
    }
    

}


//cabezera y pies de página
if($dataToLoad!=NULL)$tituloDoc='Reporte de '.$title;
else $tituloDoc='REPORTE DE PRUEBA';
$pdf->SetHeaderData('', 0, $tituloDoc.' ', $fecha, array(0,64,255), array(0,64,128));
$pdf->setFooterData(array(0,64,0), array(0,64,128));

// set header and footer fonts
$pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', 15));
$pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));

// set default monospaced font
$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

// set margins
$pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
$pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
$pdf->SetFooterMargin(PDF_MARGIN_FOOTER);

// set auto page breaks
$pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);

// set image scale factor
$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);
//aqui empieza el relleno de datos.
$pdf->AddPage();
//$pdf->writeHTML($estilos.$contenido,true,false,true,false,'');
$resql = $db->query($consultasql);

if ($resql) {
    $widts = array();
    $header = array();
    $showTable = array();
    $nameTable = array();
    //arreglamos los anchos de cada columna, los títulos de las táblas, y 
    //un array que nos dirá dependiendo de QUE lee dolibar como "visible"
    //para agarrar SOLO los datos que necesitamos.
    if($dataToLoad == 'inventariogeneral')
    {
        $listatablas = new inventariogeneral($db);
        $title = "Inventario";

        if($filterToSee==10||$filterToSee==11||$filterToSee==12){
            $title = "Reporte de partes afectadas";
            $listatablas->fields['date_creation']['visible']=0;
            $listatablas->fields['auditoria']['visible']=1;
        }else if($filterToSee >= 110 && $filterToSee<120){
            $title = "Reporte de inventario con existencia.";
            $listatablas->fields['date_creation']['visible']=0;
            $listatablas->fields['tms']['visible']=1;
            $listatablas->fields['tiporeq']['visible']=0;
        }
       
        //fue un dolor de muelas descubrir, pero lo haremos manual por lo pronto.
    }
    else if($dataToLoad == 'entradas')
    {
        $listatablas = new entradas($db);
        $title = "Entradas";
        $listatablas->fields['status']['visible']=0;
        $listatablas->fields['udm']['comment']='U.D.M';
        $listatablas->fields['cost']['comment']='P.U';
        $listatablas->fields['t_cost']['comment']='C.T';
        $listatablas->fields['get_qty']['comment']='Pedido';
        $listatablas->fields['qty']['comment']='Recibido';
        $listatablas->fields['usuario']['visible']=0;
        $listatablas->fields['ubicacion']['visible']=0;
        $listatablas->fields['tiporeq']['visible']=0;
        $listatablas->fields['date_creation']['visible']=0;
        $listatablas->fields['tms']['visible']=0;

        
   
        //simplemente dividimos equitativamente entre las cabezeras, son pocos los campos de todos modos.
    }
    else if($dataToLoad == 'salidas')
    {
        $title = "Salidas";

        $listatablas = new salidas($db);
        
    }
    else if($dataToLoad == 'emisionderequisiciones')
    {
        $listatablas = new emisionderequisiciones($db);
         if($filterToSee==9||$filterToSee==7){
            //$title = "Reporte de partes afectadas";
            $listatablas->fields['solicitante']['visible']=0;
            $listatablas->fields['tiporeq']['visible']=0;
            $listatablas->fields['date_creation']['visible']=0;
            $listatablas->fields['codificacion']['visible']=1;
            $listatablas->fields['codificacion']['position']=41;
            $listatablas->fields['tms']['visible']=1;
            $listatablas->fields['tms']['comment']="Fecha de requisición";
            
            //$listatablas->fields = dol_sort_array($listatablas->fields, 'position');
            
        
        }
        else if ($filterToSee>=20 && $filterToSee<30){
            $listatablas->fields['tiporeq']['visible']=0;
            $title = "requisiciones ";
        
            switch ($filterToSee)
                {
                    case 20:
                        $title.= "(Stock)";
                        break;
                    case 21:
                        $title.= "(No Stock)";
                        break;
                    case 24:
                        $title.= "(Servicios)";
                        break;
                    case 26:
                        $title.= "(Agroquímicos)";
                        break;
                }
        }
        else if ($filterToSee>=40 && $filterToSee<50){
            $listatablas->fields['tiporeq']['visible']=0;
        }
        
        else{
            $title = "requisiciones";
        }
    }
    else if ($dataToLoad=="inventarions"){
        $listatablas = new inventarions($db);
        $title = "Inventario  ";
        
        switch ($filterToSee)
            {
                case 31:
                    $title.= "(No Stock)";
                    break;
                case 34:
                    $title.= "(Servicios)";
                    break;
                case 36:
                    $title.= "(Agroquímicos)";
                    break;
                case 110:
                case 111:
                case 114:
                case 116:                    
                    $title = "Reporte de inventario con existencia.";
                    $listatablas->fields['date_creation']['visible']=0;
                    $listatablas->fields['tms']['visible']=0;
                    $listatablas->fields['tiporeq']['visible']=0;
                    $listatablas->fields['solicitante']['visible']=1;
                    break;
    
            }

    }
    else if ($dataToLoad=="inventarioans"){
        $listatablas = new inventarioans($db);
        $title = "Inventario  ";
        
        switch ($filterToSee)
            {
                case 31:
                    $title.= "(No Stock)";
                    break;
                case 34:
                    $title.= "(Servicios)";
                    break;
                case 36:
                    $title.= "(Agroquímicos)";
                    break;
                case 110:
                case 111:
                case 114:
                case 116:                    
                    $title = "Reporte de inventario con existencia.";
                    $listatablas->fields['date_creation']['visible']=0;
                    $listatablas->fields['tms']['visible']=0;
                    $listatablas->fields['tiporeq']['visible']=0;
                    $listatablas->fields['solicitante']['visible']=1;
                    break;
                    
            }

    }

    else{
        $title = "pruebas";
        $pdf->Cell(0,12,'Lo siento, pero no se ha proporcionado información correcta, fin del documento. ',0,1,'C',0);
        $pdf->Cell(0,12,'sin embargo, esto comprueba que el sistema automático de creación de reportes está ',0,1,'C',0);
        $pdf->Cell(0,12,'funcionando correctamente.',0,1,'C',0);
        //solo en caso de sentirnos bravos, aun metiendo parámetros que no existen.
    }
    //creamos la cabezera con info de la clase. 
    //AGARRMOS del comment, por que la etiqueta 'label' puede salir muy larga.
    $nameTable = array_keys($listatablas->fields);
    $reduTable = array(); 
    $g=0;
    //limpiamos campos indeseados
    //vemos que campos son 
    foreach ($listatablas->fields as $cosa)
    {       
        $showTable[] = $cosa['visible'];                
        if(in_array($cosa['visible'],[1,2,4,5],true)){            
            $header[] = $cosa['comment']; 
            $reduTable[] = $nameTable[$g];            
        }
        $g++;
    }
    //por que el array? por que esos son los valores que dolibarr usar 
    //para mostrar datos en las listas. así que hacemos lo mismo, básicamente.
    if($dataToLoad == 'inventariogeneral'){
    //$widts = array_pad($widts, count($header), (int)(270/count($header)));
    
        if($filterToSee >= 110 && $filterToSee<=120){
                if($orientacion=="L")
            $widts = [24,117,12,12,12,12,12,12,12,12,15,15];//landscape tiene 270 caracteres de largo
            else 
            $widts = [20,60,10,10,10,10,10,10,10,10,15,15];//portrait tiene 180 caracteres de largo            
        }
        else{    
            if($orientacion=="L")
                
                $widts = [24,117,12,12,12,12,12,12,12,12,30];//landscape tiene 270 caracteres de largo
                else 
                $widts = [20,60,10,10,10,10,10,10,10,10,30];//portrait tiene 180 caracteres de largo
        }
    }
    else if($dataToLoad == 'emisionderequisiciones' && ($filterToSee == 9||$filterToSee == 7)){
        if($orientacion=="L")
        $widts = [30,30,130,22,22,30];//landscape tiene 270 caracteres de largo
        else 
        $widts = [20,20,88,16,16,22];//portrait tiene 180 caracteres de largo
    }
    else if($dataToLoad == 'emisionderequisiciones' && ($filterToSee>=20 && $filterToSee<30)){
        if($orientacion=="L")
        $widts = [27,162,27,27,27];//landscape tiene 270 caracteres de largo
        else 
        $widts = [21,96,21,21,21];//portrait tiene 180 caracteres de largo
    }
    else if ($dataToLoad == 'emisionderequisiciones' && ($filterToSee>=40 && $filterToSee<50))
    {
        if($orientacion=="L")
        $widts = [27,162,27,27,27];//landscape tiene 270 caracteres de largo
        else 
        $widts = [21,96,21,21,21];//portrait tiene 180 caracteres de largo
    }
    else if($dataToLoad == 'inventarions'||$dataToLoad == 'inventarioans'){
        if($filterToSee >= 110 && $filterToSee<=120){
            if($orientacion=="L")
            $widts = [24,72,14,14,14,14,14,14,24,34,36];//landscape tiene 270 caracteres de largo
            else 
            $widts = [16,48,9,9,9,9,9,9,16,36,14];//portrait tiene 180 caracteres de largo
        }else{
            if($orientacion=="L")
            $widts = [24,72,14,14,14,14,14,14,24,54,18];//landscape tiene 270 caracteres de largo
            else 
            $widts = [16,48,9,9,9,9,9,9,16,36,14];//portrait tiene 180 caracteres de largo
        }

    }
    else if ($dataToLoad == 'entradas' && ($filterToSee>=30 && $filterToSee<40)){
        
        if($orientacion=='L'){
            //$widts = array_pad($widts, count($header), (int)(270/count($header)));
            $widts=[15,90,10,10,10,10,10,10,10,9,23,60];
        }
        else{

        }
    }
    else if ($dataToLoad == 'salidas'){
        if($orientacion=='L'){
            //$widts = array_pad($widts, count($header), (int)(270/count($header)));
            $widts=[114,20,20,25,45,20,20];
        }
        else{

        }
    }
    else{
        if($orientacion=="L")$widts = array_pad($widts, count($header), (int)(270/count($header)));//por defecto, espaciado igual
        else $widts = array_pad($widts, count($header), (int)(180/count($header)));
    }
    //intentamos rellenar y limpiar los datos para una impresión más correcta y limpia. ANTES de imprimirla
    //es decir, no todos los valores son texto: algunos son referencias a OTRAS tablas, 
    //hay que reemplazar dicho valor con su respectiva referencia.

    //vamos a filtrar los datos, para cargar los que realmente són.
    //si son datos referentes a OTROS objetos del módulo, los reemplazaremos por su valor en vista
    // y si son fechas, las formateamos.
    $informacion = $pdf->LoadData($consultasql,$db,$showTable) ;   
    for ($j=0;$j<count($informacion);$j++){
        for($h=0;$h<count($reduTable);$h++){
            if ($reduTable[$h]=='udm')
            {
                $temp = $unidadmedida->fetch($informacion[$j][$h]);
                if($temp>0) $informacion[$j][$h] = $unidadmedida->ref;
            }
            if ($reduTable[$h]=='tiporeq'){

                $temp = $informacion[$j][$h];
                
                switch($temp){
                    case 1:
                        $informacion[$j][$h]= "No Stock";
                    break;
                    case 4:
                        $informacion[$j][$h]= "Servicio";
                    break;
                    case 6:
                        $informacion[$j][$h]= "Agroquímicos";
                    break;
                    default:
                        $informacion[$j][$h]= "Stock";
                }
                

            }
            if ($reduTable[$h]=='location'){
                $temp = $almacen->fetch($informacion[$j][$h]);
                if($temp>0) $informacion[$j][$h] = $almacen->ref;
            }
            if($reduTable[$h]=='family'){
                $temp = $familia->fetch($informacion[$j][$h]);
                if($temp>0) $informacion[$j][$h] = $familia->label;
                else $informacion[$j][$h]="ninguna";
            }
            if($reduTable[$h]=='t_cost'||$reduTable[$h]=='cost'){
                if(in_array('iva',$reduTable)){
                    $temp1 = array_keys($reduTable,'iva');
                    if($informacion[$temp1[0][$h]==1])
                        $informacion[$j][$h]= round($informacion[$j][$h]*1.16,2);
                }
            }
            if($reduTable[$h]=='date_creation'||$reduTable[$h]=='tms')
            {
                $informacion[$j][$h]= date("d-m-Y",strtotime($informacion[$j][$h]));
            }
        }
    }
    //POR FIN imprimimos los datos.
    $pdf->ColoredTable($header, $informacion,$widts);
} else {
    //en caso de cargar la página pelona. Osease, sin parámetro alguno.
    $pdf->Cell(0,12,'Lo siento, pero no se ha proporcionado información correcta, fin del documento. ',0,1,'C',0);
    $pdf->Cell(0,12,'sin embargo, esto comprueba que el sistema automático de creación de reportes está ',0,1,'C',0);
    $pdf->Cell(0,12,'funcionando correctamente.',0,1,'C',0);
}
$pdf->lastPage();
//cerramos el PDF, y por FIN, lo imprimimos al usuario
$pdf->output('Reporte_'.$dataToLoad.'.pdf','I');
?>
