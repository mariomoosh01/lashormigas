<?php
/* Copyright (C) 2004-2018  Laurent Destailleur     <eldy@users.sourceforge.net>
 * Copyright (C) 2018-2019  Nicolas ZABOURI         <info@inovea-conseil.com>
 * Copyright (C) 2019-2020  Frédéric France         <frederic.france@netlogic.fr>
 * Copyright (C) 2021 SuperAdmin
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
 * 	\defgroup   controldeinventario     Module ControlDeInventario
 *  \brief      ControlDeInventario module descriptor.
 *
 *  \file       htdocs/controldeinventario/core/modules/modControlDeInventario.class.php
 *  \ingroup    controldeinventario
 *  \brief      Description and activation file for module ControlDeInventario
 */
include_once DOL_DOCUMENT_ROOT.'/core/modules/DolibarrModules.class.php';

/**
 *  Description and activation class for module ControlDeInventario
 */
class modControlDeInventario extends DolibarrModules
{
	/**
	 * Constructor. Define names, constants, directories, boxes, permissions
	 *
	 * @param DoliDB $db Database handler
	 */
	public function __construct($db)
	{
		global $langs, $conf;
		$this->db = $db;

		// Id for module (must be unique).
		// Use here a free id (See in Home -> System information -> Dolibarr for list of used modules id).
		$this->numero = 564000; // TODO Go on page https://wiki.dolibarr.org/index.php/List_of_modules_id to reserve an id number for your module

		// Key text used to identify module (for permissions, menus, etc...)
		$this->rights_class = 'controldeinventario';

		// Family can be 'base' (core modules),'crm','financial','hr','projects','products','ecm','technic' (transverse modules),'interface' (link with external tools),'other','...'
		// It is used to group modules by family in module setup page
		$this->family = "products";

		// Module position in the family on 2 digits ('01', '10', '20', ...)
		$this->module_position = '91';

		// Gives the possibility for the module, to provide his own family info and position of this family (Overwrite $this->family and $this->module_position. Avoid this)
		//$this->familyinfo = array('myownfamily' => array('position' => '01', 'label' => $langs->trans("MyOwnFamily")));
		// Module label (no space allowed), used if translation string 'ModuleControlDeInventarioName' not found (ControlDeInventario is name of module).
		$this->name = preg_replace('/^mod/i', '', get_class($this));

		// Module description, used if translation string 'ModuleControlDeInventarioDesc' not found (ControlDeInventario is name of module).
		$this->description = "Sistemas de control de inventario para -Huerta Las Hormigas-";
		// Used only if file README.md and README-LL.md not found.
		$this->descriptionlong = "Sistemas de control de inventario para -Huerta Las Hormigas-";

		// Author
		$this->editor_name = 'Gibrán Majalca';
		$this->editor_url = '#';

		// Possible values for version are: 'development', 'experimental', 'dolibarr', 'dolibarr_deprecated' or a version string like 'x.y.z'
		$this->version = '0.9.4';
		// Url to the file with your last numberversion of this module
		//$this->url_last_version = 'http://www.example.com/versionmodule.txt';

		// Key used in llx_const table to save module status enabled/disabled (where CONTROLDEINVENTARIO is value of property name of module in uppercase)
		$this->const_name = 'MAIN_MODULE_'.strtoupper($this->name);

		// Name of image file used for this module.
		// If file is in theme/yourtheme/img directory under name object_pictovalue.png, use this->picto='pictovalue'
		// If file is in module/img directory under name object_pictovalue.png, use this->picto='pictovalue@module'
		// To use a supported fa-xxx css style of font awesome, use this->picto='xxx'
		$this->picto = 'controldeinventario@ControldeInventario';

		// Define some features supported by module (triggers, login, substitutions, menus, css, etc...)
		$this->module_parts = array(
			// Set this to 1 if module has its own trigger directory (core/triggers)
			'triggers' => 1,
			// Set this to 1 if module has its own login method file (core/login)
			'login' => 0,
			// Set this to 1 if module has its own substitution function file (core/substitutions)
			'substitutions' => 0,
			// Set this to 1 if module has its own menus handler directory (core/menus)
			'menus' => 0,
			// Set this to 1 if module overwrite template dir (core/tpl)
			'tpl' => 0,
			// Set this to 1 if module has its own barcode directory (core/modules/barcode)
			'barcode' => 0,
			// Set this to 1 if module has its own models directory (core/modules/xxx)
			'models' => 1,
			// Set this to 1 if module has its own printing directory (core/modules/printing)
			'printing' => 0,
			// Set this to 1 if module has its own theme directory (theme)
			'theme' => 0,
			// Set this to relative path of css file if module has its own css file
			'css' => array(
				'/controldeinventario/css/controldeinventario.css.php','/controldeinventario/css/botonMain.css'
			),
			// Set this to relative path of js file if module must load a js on all pages
			'js' => array(
				//   '/controldeinventario/js/controldeinventario.js.php',
			),
			// Set here all hooks context managed by module. To find available hook context, make a "grep -r '>initHooks(' *" on source code. You can also set hook context to 'all'
			'hooks' => array(
				   'data' => array(
				       'nada',
				   ),
				   'entity' => '0',
			),
			// Set this to 1 if features of module are opened to external users
			'moduleforexternal' => 0,
		);

		// Data directories to create when module is enabled.
		// Example: this->dirs = array("/controldeinventario/temp","/controldeinventario/subdir");
		$this->dirs = array("/controldeinventario/temp");

		// Config pages. Put here list of php page, stored into controldeinventario/admin directory, to use to setup module.
		$this->config_page_url = array("setup.php@controldeinventario");

		// Dependencies
		// A condition to hide module
		$this->hidden = false;
		// List of module class names as string that must be enabled if this module is enabled. Example: array('always1'=>'modModuleToEnable1','always2'=>'modModuleToEnable2', 'FR1'=>'modModuleToEnableFR'...)
		$this->depends = array();
		$this->requiredby = array(); // List of module class names as string to disable if this one is disabled. Example: array('modModuleToDisable1', ...)
		$this->conflictwith = array(); // List of module class names as string this module is in conflict with. Example: array('modModuleToDisable1', ...)

		// The language file dedicated to your module
		$this->langfiles = array("controldeinventario@controldeinventario");

		// Prerequisites
		$this->phpmin = array(5, 6); // Minimum version of PHP required by module
		$this->need_dolibarr_version = array(11, -3); // Minimum version of Dolibarr required by module

		// Messages at activation
		$this->warnings_activation = array(); // Warning to show when we activate module. array('always'='text') or array('FR'='textfr','ES'='textes'...)
		$this->warnings_activation_ext = array(); // Warning to show when we activate an external module. array('always'='text') or array('FR'='textfr','ES'='textes'...)
		//$this->automatic_activation = array('FR'=>'ControlDeInventarioWasAutomaticallyActivatedBecauseOfYourCountryChoice');
		//$this->always_enabled = true;								// If true, can't be disabled

		// Constants
		// List of particular constants to add when module is enabled (key, 'chaine', value, desc, visible, 'current' or 'allentities', deleteonunactive)
		// Example: $this->const=array(1 => array('CONTROLDEINVENTARIO_MYNEWCONST1', 'chaine', 'myvalue', 'This is a constant to add', 1),
		//                             2 => array('CONTROLDEINVENTARIO_MYNEWCONST2', 'chaine', 'myvalue', 'This is another constant to add', 0, 'current', 1)
		// );
		$this->const = array();

		// Some keys to add into the overwriting translation tables
		/*$this->overwrite_translation = array(
			'en_US:ParentCompany'=>'Parent company or reseller',
			'fr_FR:ParentCompany'=>'Maison mère ou revendeur'
		)*/

		if (!isset($conf->controldeinventario) || !isset($conf->controldeinventario->enabled)) {
			$conf->controldeinventario = new stdClass();
			$conf->controldeinventario->enabled = 0;
		}

		// Array to add new pages in new tabs
		$this->tabs = array();
		// Example:
		// $this->tabs[] = array('data'=>'objecttype:+tabname1:Title1:mylangfile@controldeinventario:$user->rights->controldeinventario->read:/controldeinventario/mynewtab1.php?id=__ID__');  					// To add a new tab identified by code tabname1
		// $this->tabs[] = array('data'=>'objecttype:+tabname2:SUBSTITUTION_Title2:mylangfile@controldeinventario:$user->rights->othermodule->read:/controldeinventario/mynewtab2.php?id=__ID__',  	// To add another new tab identified by code tabname2. Label will be result of calling all substitution functions on 'Title2' key.
		// $this->tabs[] = array('data'=>'objecttype:-tabname:NU:conditiontoremove');                                                     										// To remove an existing tab identified by code tabname
		//
		// Where objecttype can be
		// 'categories_x'	  to add a tab in category view (replace 'x' by type of category (0=product, 1=supplier, 2=customer, 3=member)
		// 'contact'          to add a tab in contact view
		// 'contract'         to add a tab in contract view
		// 'group'            to add a tab in group view
		// 'intervention'     to add a tab in intervention view
		// 'invoice'          to add a tab in customer invoice view
		// 'invoice_supplier' to add a tab in supplier invoice view
		// 'member'           to add a tab in fundation member view
		// 'opensurveypoll'	  to add a tab in opensurvey poll view
		// 'order'            to add a tab in customer order view
		// 'order_supplier'   to add a tab in supplier order view
		// 'payment'		  to add a tab in payment view
		// 'payment_supplier' to add a tab in supplier payment view
		// 'product'          to add a tab in product view
		// 'propal'           to add a tab in propal view
		// 'project'          to add a tab in project view
		// 'stock'            to add a tab in stock view
		// 'thirdparty'       to add a tab in third party view
		// 'user'             to add a tab in user view

		// Dictionaries
		$this->dictionaries = array();
		/* Example:
		$this->dictionaries=array(
			'langs'=>'controldeinventario@controldeinventario',
			// List of tables we want to see into dictonnary editor
			'tabname'=>array(MAIN_DB_PREFIX."table1", MAIN_DB_PREFIX."table2", MAIN_DB_PREFIX."table3"),
			// Label of tables
			'tablib'=>array("Table1", "Table2", "Table3"),
			// Request to select fields
			'tabsql'=>array('SELECT f.rowid as rowid, f.code, f.label, f.active FROM '.MAIN_DB_PREFIX.'table1 as f', 'SELECT f.rowid as rowid, f.code, f.label, f.active FROM '.MAIN_DB_PREFIX.'table2 as f', 'SELECT f.rowid as rowid, f.code, f.label, f.active FROM '.MAIN_DB_PREFIX.'table3 as f'),
			// Sort order
			'tabsqlsort'=>array("label ASC", "label ASC", "label ASC"),
			// List of fields (result of select to show dictionary)
			'tabfield'=>array("code,label", "code,label", "code,label"),
			// List of fields (list of fields to edit a record)
			'tabfieldvalue'=>array("code,label", "code,label", "code,label"),
			// List of fields (list of fields for insert)
			'tabfieldinsert'=>array("code,label", "code,label", "code,label"),
			// Name of columns with primary key (try to always name it 'rowid')
			'tabrowid'=>array("rowid", "rowid", "rowid"),
			// Condition to show each dictionary
			'tabcond'=>array($conf->controldeinventario->enabled, $conf->controldeinventario->enabled, $conf->controldeinventario->enabled)
		);
		*/

		// Boxes/Widgets
		// Add here list of php file(s) stored in controldeinventario/core/boxes that contains a class to show a widget.
		$this->boxes = array(
			 0 => array(
			     'file' => 'controldeinventariowidget1.php@controldeinventario',
			     'note' => 'Widget Hecho por Gibrán Majalca',
			     'enabledbydefaulton' => 'Home',
			 ),
			//  1 => array(
			// 	'file' => 'randomHormiga.php@controldeinventario',
			// 	'note' => 'Widget Hecho por Gibrán Majalca',
			// 	'enabledbydefaulton' => 'Home',
			// ),
			//  ...
		);

		// Cronjobs (List of cron jobs entries to add when module is enabled)
		// unit_frequency must be 60 for minute, 3600 for hour, 86400 for day, 604800 for week
		$this->cronjobs = array(
			//  0 => array(
			//      'label' => 'MyJob label',
			//      'jobtype' => 'method',
			//      'class' => '/controldeinventario/class/emisionderequisiciones.class.php',
			//      'objectname' => 'EmisionDeRequisiciones',
			//      'method' => 'doScheduledJob',
			//      'parameters' => '',
			//      'comment' => 'Comment',
			//      'frequency' => 2,
			//      'unitfrequency' => 3600,
			//      'status' => 0,
			//      'test' => '$conf->controldeinventario->enabled',
			//      'priority' => 50,
			//  ),
		);
		// Example: $this->cronjobs=array(
		//    0=>array('label'=>'My label', 'jobtype'=>'method', 'class'=>'/dir/class/file.class.php', 'objectname'=>'MyClass', 'method'=>'myMethod', 'parameters'=>'param1, param2', 'comment'=>'Comment', 'frequency'=>2, 'unitfrequency'=>3600, 'status'=>0, 'test'=>'$conf->controldeinventario->enabled', 'priority'=>50),
		//    1=>array('label'=>'My label', 'jobtype'=>'command', 'command'=>'', 'parameters'=>'param1, param2', 'comment'=>'Comment', 'frequency'=>1, 'unitfrequency'=>3600*24, 'status'=>0, 'test'=>'$conf->controldeinventario->enabled', 'priority'=>50)
		// );

		// Permissions provided by this module
		$this->rights = array();
		$r = 0;
		// Add here entries to declare new permissions
		/* BEGIN MODULEBUILDER PERMISSIONS */
		$this->rights[$r][0] = $this->numero . sprintf("%02d", $r + 1); // Permission id (must not be already used)
		$this->rights[$r][1] = 'Leer datos del control de inventarios'; // Permission label
		$this->rights[$r][4] = 'emisionderequisiciones';
		$this->rights[$r][5] = 'read'; // In php code, permission will be checked by test if ($user->rights->controldeinventario->emisionderequisiciones->read)
		$r++;
		$this->rights[$r][0] = $this->numero . sprintf("%02d", $r + 1); // Permission id (must not be already used)
		$this->rights[$r][1] = 'Crear/Editar datos del control de inventarios'; // Permission label
		$this->rights[$r][4] = 'emisionderequisiciones';
		$this->rights[$r][5] = 'write'; // In php code, permission will be checked by test if ($user->rights->controldeinventario->emisionderequisiciones->write)
		$r++;
		$this->rights[$r][0] = $this->numero . sprintf("%02d", $r + 1); // Permission id (must not be already used)
		$this->rights[$r][1] = 'borrar datos del control de inventarios'; // Permission label
		$this->rights[$r][4] = 'emisionderequisiciones';
		$this->rights[$r][5] = 'delete'; // In php code, permission will be checked by test if ($user->rights->controldeinventario->emisionderequisiciones->delete)
		$r++;
		//entradas
		$this->rights[$r][0] = $this->numero . sprintf("%02d", $r + 1); // Permission id (must not be already used)
		$this->rights[$r][1] = 'Ver entradas'; // Permission label
		$this->rights[$r][4] = 'entradas';
		$this->rights[$r][5] = 'read'; // In php code, permission will be checked by test if ($user->rights->controldeinventario->emisionderequisiciones->read)
		$r++;
		$this->rights[$r][0] = $this->numero . sprintf("%02d", $r + 1); // Permission id (must not be already used)
		$this->rights[$r][1] = 'Crear/Editar entradas'; // Permission label
		$this->rights[$r][4] = 'entradas';
		$this->rights[$r][5] = 'write'; // In php code, permission will be checked by test if ($user->rights->controldeinventario->emisionderequisiciones->write)
		$r++;
		$this->rights[$r][0] = $this->numero . sprintf("%02d", $r + 1); // Permission id (must not be already used)
		$this->rights[$r][1] = 'borrar entradas de productos'; // Permission label
		$this->rights[$r][4] = 'entradas';
		$this->rights[$r][5] = 'delete'; // In php code, permission will be checked by test if ($user->rights->controldeinventario->emisionderequisiciones->delete)
		$r++;
		//salidas
		$this->rights[$r][0] = $this->numero . sprintf("%02d", $r + 1); // Permission id (must not be already used)
		$this->rights[$r][1] = 'Ver salidas'; // Permission label
		$this->rights[$r][4] = 'salidas';
		$this->rights[$r][5] = 'read'; // In php code, permission will be checked by test if ($user->rights->controldeinventario->emisionderequisiciones->read)
		$r++;
		$this->rights[$r][0] = $this->numero . sprintf("%02d", $r + 1); // Permission id (must not be already used)
		$this->rights[$r][1] = 'Crear/Editar salidas'; // Permission label
		$this->rights[$r][4] = 'salidas';
		$this->rights[$r][5] = 'write'; // In php code, permission will be checked by test if ($user->rights->controldeinventario->emisionderequisiciones->write)
		$r++;
		$this->rights[$r][0] = $this->numero . sprintf("%02d", $r + 1); // Permission id (must not be already used)
		$this->rights[$r][1] = 'borrar salidas de productos'; // Permission label
		$this->rights[$r][4] = 'salidas';
		$this->rights[$r][5] = 'delete'; // In php code, permission will be checked by test if ($user->rights->controldeinventario->emisionderequisiciones->delete)
		$r++;
		//familias
		$this->rights[$r][0] = $this->numero . sprintf("%02d", $r + 1); // Permission id (must not be already used)
		$this->rights[$r][1] = 'Ver Familias'; // Permission label
		$this->rights[$r][4] = 'familias';
		$this->rights[$r][5] = 'read'; // In php code, permission will be checked by test if ($user->rights->controldeinventario->emisionderequisiciones->read)
		$r++;
		$this->rights[$r][0] = $this->numero . sprintf("%02d", $r + 1); // Permission id (must not be already used)
		$this->rights[$r][1] = 'Crear/Editar familias'; // Permission label
		$this->rights[$r][4] = 'familias';
		$this->rights[$r][5] = 'write'; // In php code, permission will be checked by test if ($user->rights->controldeinventario->emisionderequisiciones->write)
		$r++;
		$this->rights[$r][0] = $this->numero . sprintf("%02d", $r + 1); // Permission id (must not be already used)
		$this->rights[$r][1] = 'borrar familias de productos'; // Permission label
		$this->rights[$r][4] = 'familias';
		$this->rights[$r][5] = 'delete'; // In php code, permission will be checked by test if ($user->rights->controldeinventario->emisionderequisiciones->delete)
		$r++;
		$this->rights[$r][0] = $this->numero . sprintf("%02d", $r + 1); // Permission id (must not be already used)
		$this->rights[$r][1] = 'Ver grupos'; // Permission label
		$this->rights[$r][4] = 'grupos';
		$this->rights[$r][5] = 'read'; // In php code, permission will be checked by test if ($user->rights->controldeinventario->emisionderequisiciones->read)
		$r++;
		$this->rights[$r][0] = $this->numero . sprintf("%02d", $r + 1); // Permission id (must not be already used)
		$this->rights[$r][1] = 'Crear/Editar grupos'; // Permission label
		$this->rights[$r][4] = 'grupos';
		$this->rights[$r][5] = 'write'; // In php code, permission will be checked by test if ($user->rights->controldeinventario->emisionderequisiciones->write)
		$r++;
		$this->rights[$r][0] = $this->numero . sprintf("%02d", $r + 1); // Permission id (must not be already used)
		$this->rights[$r][1] = 'borrar grupos de productos'; // Permission label
		$this->rights[$r][4] = 'grupos';
		$this->rights[$r][5] = 'delete'; // In php code, permission will be checked by test if ($user->rights->controldeinventario->emisionderequisiciones->delete)

		//grupos
		// inventario general
		$this->rights[$r][0] = $this->numero . sprintf("%02d", $r + 1); // Permission id (must not be already used)
		$this->rights[$r][1] = 'Ver Productos'; // Permission label
		$this->rights[$r][4] = 'inventariogeneral';
		$this->rights[$r][5] = 'read'; // In php code, permission will be checked by test if ($user->rights->controldeinventario->emisionderequisiciones->read)
		$r++;
		$this->rights[$r][0] = $this->numero . sprintf("%02d", $r + 1); // Permission id (must not be already used)
		$this->rights[$r][1] = 'Crear/Editar productos'; // Permission label
		$this->rights[$r][4] = 'inventariogeneral';
		$this->rights[$r][5] = 'write'; // In php code, permission will be checked by test if ($user->rights->controldeinventario->emisionderequisiciones->write)
		$r++;
		$this->rights[$r][0] = $this->numero . sprintf("%02d", $r + 1); // Permission id (must not be already used)
		$this->rights[$r][1] = 'borrar productos'; // Permission label
		$this->rights[$r][4] = 'inventariogeneral';
		$this->rights[$r][5] = 'delete'; // In php code, permission will be checked by test if ($user->rights->controldeinventario->emisionderequisiciones->delete)
		$r++;
		//Permisos para medidas?
		$this->rights[$r][0] = $this->numero . sprintf("%02d", $r + 1); // Permission id (must not be already used)
		$this->rights[$r][1] = 'Ver Unidades de medida'; // Permission label
		$this->rights[$r][4] = 'unidadmedida';
		$this->rights[$r][5] = 'read'; // In php code, permission will be checked by test if ($user->rights->controldeinventario->emisionderequisiciones->read)
		$r++;
		$this->rights[$r][0] = $this->numero . sprintf("%02d", $r + 1); // Permission id (must not be already used)
		$this->rights[$r][1] = 'Crear/Editar Unidades de medida'; // Permission label
		$this->rights[$r][4] = 'unidadmedida';
		$this->rights[$r][5] = 'write'; // In php code, permission will be checked by test if ($user->rights->controldeinventario->emisionderequisiciones->write)
		$r++;
		$this->rights[$r][0] = $this->numero . sprintf("%02d", $r + 1); // Permission id (must not be already used)
		$this->rights[$r][1] = 'borrar Unidades de medida'; // Permission label
		$this->rights[$r][4] = 'unidadmedida';
		$this->rights[$r][5] = 'delete'; // In php code, permission will be checked by test if ($user->rights->controldeinventario->emisionderequisiciones->delete)
		$r++;
		//Permiso Almacenes
		$this->rights[$r][0] = $this->numero . sprintf("%02d", $r + 1); // Permission id (must not be already used)
		$this->rights[$r][1] = 'Ver Almacenes'; // Permission label
		$this->rights[$r][4] = 'almacenes';
		$this->rights[$r][5] = 'read'; // In php code, permission will be checked by test if ($user->rights->controldeinventario->emisionderequisiciones->read)
		$r++;
		$this->rights[$r][0] = $this->numero . sprintf("%02d", $r + 1); // Permission id (must not be already used)
		$this->rights[$r][1] = 'Crear/Editar Almacenes'; // Permission label
		$this->rights[$r][4] = 'almacenes';
		$this->rights[$r][5] = 'write'; // In php code, permission will be checked by test if ($user->rights->controldeinventario->emisionderequisiciones->write)
		$r++;
		$this->rights[$r][0] = $this->numero . sprintf("%02d", $r + 1); // Permission id (must not be already used)
		$this->rights[$r][1] = 'borrar Unidades Almacenes'; // Permission label
		$this->rights[$r][4] = 'almacenes';
		$this->rights[$r][5] = 'delete'; // In php code, permission will be checked by test if ($user->rights->controldeinventario->emisionderequisiciones->delete)
		$r++;
		// Inventario No Stock
		$this->rights[$r][0] = $this->numero . sprintf("%02d", $r + 1); // Permission id (must not be already used)
		$this->rights[$r][1] = 'Ver inventario no stock'; // Permission label
		$this->rights[$r][4] = 'inventarions';
		$this->rights[$r][5] = 'read'; // In php code, permission will be checked by test if ($user->rights->controldeinventario->emisionderequisiciones->read)
		$r++;
		$this->rights[$r][0] = $this->numero . sprintf("%02d", $r + 1); // Permission id (must not be already used)
		$this->rights[$r][1] = 'Crear/Editar inventario no stock'; // Permission label
		$this->rights[$r][4] = 'inventarions';
		$this->rights[$r][5] = 'write'; // In php code, permission will be checked by test if ($user->rights->controldeinventario->emisionderequisiciones->write)
		$r++;
		$this->rights[$r][0] = $this->numero . sprintf("%02d", $r + 1); // Permission id (must not be already used)
		$this->rights[$r][1] = 'borrar inventario no stock'; // Permission label
		$this->rights[$r][4] = 'inventarions';
		$this->rights[$r][5] = 'delete'; // In php code, permission will be checked by test if ($user->rights->controldeinventario->emisionderequisiciones->delete)
		$r++;
		// Inventario ANS
		$this->rights[$r][0] = $this->numero . sprintf("%02d", $r + 1); // Permission id (must not be already used)
		$this->rights[$r][1] = 'Ver inventario Agroquímicos'; // Permission label
		$this->rights[$r][4] = 'inventarioans';
		$this->rights[$r][5] = 'read'; // In php code, permission will be checked by test if ($user->rights->controldeinventario->emisionderequisiciones->read)
		$r++;
		$this->rights[$r][0] = $this->numero . sprintf("%02d", $r + 1); // Permission id (must not be already used)
		$this->rights[$r][1] = 'Crear/Editar inventario Agroquímicos'; // Permission label
		$this->rights[$r][4] = 'inventarioans';
		$this->rights[$r][5] = 'write'; // In php code, permission will be checked by test if ($user->rights->controldeinventario->emisionderequisiciones->write)
		$r++;
		$this->rights[$r][0] = $this->numero . sprintf("%02d", $r + 1); // Permission id (must not be already used)
		$this->rights[$r][1] = 'borrar inventario Agroquímicos'; // Permission label
		$this->rights[$r][4] = 'inventarioans';
		$this->rights[$r][5] = 'delete'; // In php code, permission will be checked by test if ($user->rights->controldeinventario->emisionderequisiciones->delete)
		$r++;

		//contador?
		$this->rights[$r][0] = $this->numero . sprintf("%02d", $r + 1); // Permission id (must not be already used)
		$this->rights[$r][1] = 'Ver contadores'; // Permission label
		$this->rights[$r][4] = 'contadores';
		$this->rights[$r][5] = 'read'; // In php code, permission will be checked by test if ($user->rights->controldeinventario->emisionderequisiciones->read)
		$r++;
		$this->rights[$r][0] = $this->numero . sprintf("%02d", $r + 1); // Permission id (must not be already used)
		$this->rights[$r][1] = 'Crear/Editar contadores'; // Permission label
		$this->rights[$r][4] = 'contadores';
		$this->rights[$r][5] = 'write'; // In php code, permission will be checked by test if ($user->rights->controldeinventario->emisionderequisiciones->write)
		$r++;
		$this->rights[$r][0] = $this->numero . sprintf("%02d", $r + 1); // Permission id (must not be already used)
		$this->rights[$r][1] = 'borrar contadores'; // Permission label
		$this->rights[$r][4] = 'contadores';
		$this->rights[$r][5] = 'delete'; // In php code, permission will be checked by test if ($user->rights->controldeinventario->emisionderequisiciones->delete)
		$r++;

		//pruebas
		$this->rights[$r][0] = $this->numero . sprintf("%02d", $r + 1); // Permission id (must not be already used)
		$this->rights[$r][1] = 'Pruebas A'; // Permission label
		$this->rights[$r][4] = 'pruebas';
		$this->rights[$r][5] = 'read'; // In php code, permission will be checked by test if ($user->rights->controldeinventario->emisionderequisiciones->read)
		$r++;
		$this->rights[$r][0] = $this->numero . sprintf("%02d", $r + 1); // Permission id (must not be already used)
		$this->rights[$r][1] = 'Crear/Editar pruebas'; // Permission label
		$this->rights[$r][4] = 'pruebas';
		$this->rights[$r][5] = 'write'; // In php code, permission will be checked by test if ($user->rights->controldeinventario->emisionderequisiciones->write)
		$r++;
		$this->rights[$r][0] = $this->numero . sprintf("%02d", $r + 1); // Permission id (must not be already used)
		$this->rights[$r][1] = 'borrar pruebas'; // Permission label
		$this->rights[$r][4] = 'pruebas';
		$this->rights[$r][5] = 'delete'; // In php code, permission will be checked by test if ($user->rights->controldeinventario->emisionderequisiciones->delete)
		$r++;
		//Permisos de reportes CUSTOMIZADO
		$this->rights[$r][0] = $this->numero . sprintf("%02d", $r + 1); // Permission id (must not be already used)
		$this->rights[$r][1] = 'Ver Reportes'; // Permission label
		$this->rights[$r][4] = 'report';
		$this->rights[$r][5] = 'read'; // In php code, permission will be checked by test if ($user->rights->controldeinventario->report->read)
		$r++;
		$this->rights[$r][0] = $this->numero . sprintf("%02d", $r + 1); // Permission id (must not be already used)
		$this->rights[$r][1] = 'Reporte Stock Por Familias'; // Permission label
		$this->rights[$r][4] = 'reporte_familia';
		$this->rights[$r][5] = 'read'; // In php code, permission will be checked by test if ($user->rights->controldeinventario->report->read)
		$r++;
		$this->rights[$r][0] = $this->numero . sprintf("%02d", $r + 1); // Permission id (must not be already used)
		$this->rights[$r][1] = 'Reporte Stock por Ubicación'; // Permission label
		$this->rights[$r][4] = 'reporte_ubicacion';
		$this->rights[$r][5] = 'read'; // In php code, permission will be checked by test if ($user->rights->controldeinventario->report->read)
		$r++;
		$this->rights[$r][0] = $this->numero . sprintf("%02d", $r + 1); // Permission id (must not be already used)
		$this->rights[$r][1] = 'Requisiciones no surtidas.'; // Permission label
		$this->rights[$r][4] = 'reporte_surtido';
		$this->rights[$r][5] = 'read'; // In php code, permission will be checked by test if ($user->rights->controldeinventario->report->read)
		$r++;
		$this->rights[$r][0] = $this->numero . sprintf("%02d", $r + 1); // Permission id (must not be already used)
		$this->rights[$r][1] = 'Stock Diario'; // Permission label
		$this->rights[$r][4] = 'reporte_diario';
		$this->rights[$r][5] = 'read'; // In php code, permission will be checked by test if ($user->rights->controldeinventario->report->read)
		$r++;
		$this->rights[$r][0] = $this->numero . sprintf("%02d", $r + 1); // Permission id (must not be already used)
		$this->rights[$r][1] = 'Partes Afectadas'; // Permission label
		$this->rights[$r][4] = 'reporte_afectadas';
		$this->rights[$r][5] = 'read'; // In php code, permission will be checked by test if ($user->rights->controldeinventario->report->read)
		$r++;
		/* END MODULEBUILDER PERMISSIONS */

		// Main menu entries to add
		$this->menu = array();
		$r = 0;
		// Add here entries to declare new menus
		/* BEGIN MODULEBUILDER TOPMENU */
		$this->menu[$r++] = array(
			'fk_menu'=>'', // '' if this is a top menu. For left menu, use 'fk_mainmenu=xxx' or 'fk_mainmenu=xxx,fk_leftmenu=yyy' where xxx is mainmenucode and yyy is a leftmenucode
			'type'=>'top', // This is a Top menu entry
			'titre'=>'ModuleControlDeInventarioName',
			'prefix' => img_picto('', $this->picto, 'class="paddingright pictofixedwidth valignmiddle"'),
			'mainmenu'=>'controldeinventario',
			'leftmenu'=>'',
			'url'=>'/controldeinventario/controldeinventarioindex.php',
			'langs'=>'controldeinventario@controldeinventario', // Lang file to use (without .lang) by module. File must be in langs/code_CODE/ directory.
			'position'=>1000 + $r,
			'enabled'=>'$conf->controldeinventario->enabled', // Define condition to show or hide menu entry. Use '$conf->controldeinventario->enabled' if entry must be visible if module is enabled.
			'perms'=>'1', // Use 'perms'=>'$user->rights->controldeinventario->emisionderequisiciones->read' if you want your menu with a permission rules
			'target'=>'',
			'user'=>0, // 0=Menu for internal users, 1=external users, 2=both
		);
		/* END MODULEBUILDER TOPMENU */
		/* BEGIN MODULEBUILDER LEFTMENU EMISIONDEREQUISICIONES*/
		$this->menu[$r++]=array(
			'fk_menu'=>'fk_mainmenu=controldeinventario',      // '' if this is a top menu. For left menu, use 'fk_mainmenu=xxx' or 'fk_mainmenu=xxx,fk_leftmenu=yyy' where xxx is mainmenucode and yyy is a leftmenucode
			'type'=>'left',                          // This is a Top menu entry
			'titre'=>'Menú Principal',
			'prefix' => img_picto('', 'controldeinventario@controldeinventario', 'class="paddingright pictofixedwidth valignmiddle"'),
			'mainmenu'=>'controldeinventario',
			'leftmenu'=>'emisionderequisiciones',
			'url'=>'/controldeinventario/controldeinventarioindex.php',
			'langs'=>'controldeinventario@controldeinventario',	        // Lang file to use (without .lang) by module. File must be in langs/code_CODE/ directory.
			'position'=>1000+$r,
			'enabled'=>'$conf->controldeinventario->enabled',  // Define condition to show or hide menu entry. Use '$conf->controldeinventario->enabled' if entry must be visible if module is enabled.
			'perms'=>'$user->rights->controldeinventario->emisionderequisiciones->read',			                // Use 'perms'=>'$user->rights->controldeinventario->level1->level2' if you want your menu with a permission rules
			'target'=>'',
			'user'=>0,				                // 0=Menu for internal users, 1=external users, 2=both
		);
		/*
		$this->menu[$r++]=array(
			'fk_menu'=>'fk_mainmenu=controldeinventario,fk_leftmenu=emisionderequisiciones',	    // '' if this is a top menu. For left menu, use 'fk_mainmenu=xxx' or 'fk_mainmenu=xxx,fk_leftmenu=yyy' where xxx is mainmenucode and yyy is a leftmenucode
			'type'=>'left',			                // This is a Left menu entry
			'titre'=>'Nueva requisición (Stock)',
			'mainmenu'=>'controldeinventario',
			'leftmenu'=>'new_req',
			'url'=>'/controldeinventario/emisionderequisiciones_card.php?action=create&stocktype=0',
			'langs'=>'controldeinventario@controldeinventario',	        // Lang file to use (without .lang) by module. File must be in langs/code_CODE/ directory.
			'position'=>1000+$r,
			'enabled'=>'$conf->controldeinventario->enabled',  // Define condition to show or hide menu entry. Use '$conf->controldeinventario->enabled' if entry must be visible if module is enabled. Use '$leftmenu==\'system\'' to show if leftmenu system is selected.
			'perms'=>'$user->rights->controldeinventario->emisionderequisiciones->write',			                // Use 'perms'=>'$user->rights->controldeinventario->level1->level2' if you want your menu with a permission rules
			'target'=>'',
			'user'=>0,				                // 0=Menu for internal users, 1=external users, 2=both
		);
		$this->menu[$r++]=array(
			'fk_menu'=>'fk_mainmenu=controldeinventario,fk_leftmenu=emisionderequisiciones',	    // '' if this is a top menu. For left menu, use 'fk_mainmenu=xxx' or 'fk_mainmenu=xxx,fk_leftmenu=yyy' where xxx is mainmenucode and yyy is a leftmenucode
			'type'=>'left',			                // This is a Left menu entry
			'titre'=>'Nueva requisición (NS)',
			'mainmenu'=>'controldeinventario',
			'leftmenu'=>'new_req_ns',
			'url'=>'/controldeinventario/emisionderequisiciones_card.php?action=create&stocktype=1',
			'langs'=>'controldeinventario@controldeinventario',	        // Lang file to use (without .lang) by module. File must be in langs/code_CODE/ directory.
			'position'=>1000+$r,
			'enabled'=>'$conf->controldeinventario->enabled',  // Define condition to show or hide menu entry. Use '$conf->controldeinventario->enabled' if entry must be visible if module is enabled. Use '$leftmenu==\'system\'' to show if leftmenu system is selected.
			'perms'=>'$user->rights->controldeinventario->emisionderequisiciones->write',			                // Use 'perms'=>'$user->rights->controldeinventario->level1->level2' if you want your menu with a permission rules
			'target'=>'',
			'user'=>0,				                // 0=Menu for internal users, 1=external users, 2=both
		);
		$this->menu[$r++]=array(
			'fk_menu'=>'fk_mainmenu=controldeinventario,fk_leftmenu=emisionderequisiciones',	    // '' if this is a top menu. For left menu, use 'fk_mainmenu=xxx' or 'fk_mainmenu=xxx,fk_leftmenu=yyy' where xxx is mainmenucode and yyy is a leftmenucode
			'type'=>'left',			                // This is a Left menu entry
			'titre'=>'Nueva requisición (OS)',
			'mainmenu'=>'controldeinventario',
			'leftmenu'=>'new_req_os',
			'url'=>'/controldeinventario/emisionderequisiciones_card.php?action=create&stocktype=4',
			'langs'=>'controldeinventario@controldeinventario',	        // Lang file to use (without .lang) by module. File must be in langs/code_CODE/ directory.
			'position'=>1000+$r,
			'enabled'=>'$conf->controldeinventario->enabled',  // Define condition to show or hide menu entry. Use '$conf->controldeinventario->enabled' if entry must be visible if module is enabled. Use '$leftmenu==\'system\'' to show if leftmenu system is selected.
			'perms'=>'$user->rights->controldeinventario->emisionderequisiciones->write',			                // Use 'perms'=>'$user->rights->controldeinventario->level1->level2' if you want your menu with a permission rules
			'target'=>'',
			'user'=>0,				                // 0=Menu for internal users, 1=external users, 2=both
		);
		$this->menu[$r++]=array(
			'fk_menu'=>'fk_mainmenu=controldeinventario,fk_leftmenu=emisionderequisiciones',	    // '' if this is a top menu. For left menu, use 'fk_mainmenu=xxx' or 'fk_mainmenu=xxx,fk_leftmenu=yyy' where xxx is mainmenucode and yyy is a leftmenucode
			'type'=>'left',			                // This is a Left menu entry
			'titre'=>'Nueva requisición (AGQ)',
			'mainmenu'=>'controldeinventario',
			'leftmenu'=>'new_req_ag',
			'url'=>'/controldeinventario/emisionderequisiciones_card.php?action=create&stocktype=6',
			'langs'=>'controldeinventario@controldeinventario',	        // Lang file to use (without .lang) by module. File must be in langs/code_CODE/ directory.
			'position'=>1000+$r,
			'enabled'=>'$conf->controldeinventario->enabled',  // Define condition to show or hide menu entry. Use '$conf->controldeinventario->enabled' if entry must be visible if module is enabled. Use '$leftmenu==\'system\'' to show if leftmenu system is selected.
			'perms'=>'$user->rights->controldeinventario->emisionderequisiciones->write',			                // Use 'perms'=>'$user->rights->controldeinventario->level1->level2' if you want your menu with a permission rules
			'target'=>'',
			'user'=>0,				                // 0=Menu for internal users, 1=external users, 2=both
		);*/

		$this->menu[$r++]=array(
			'fk_menu'=>'fk_mainmenu=controldeinventario',      // '' if this is a top menu. For left menu, use 'fk_mainmenu=xxx' or 'fk_mainmenu=xxx,fk_leftmenu=yyy' where xxx is mainmenucode and yyy is a leftmenucode
			'type'=>'left',                          // This is a Top menu entry
			'titre'=>'Inventario Stock',
			'prefix' => img_picto('', 'inventariogeneral@controldeinventario', 'class="paddingright pictofixedwidth valignmiddle"'),
			'mainmenu'=>'controldeinventario',
			'leftmenu'=>'inventariogeneral',
			'url'=>'/controldeinventario/inventariogeneral_list.php?search_tiporeq=0&sortfield=t.ref',
			'langs'=>'controldeinventario@controldeinventario',	        // Lang file to use (without .lang) by module. File must be in langs/code_CODE/ directory.
			'position'=>1000+$r,
			'enabled'=>'$conf->controldeinventario->enabled',  // Define condition to show or hide menu entry. Use '$conf->controldeinventario->enabled' if entry must be visible if module is enabled.
			'perms'=>'$user->rights->controldeinventario->inventariogeneral->read',			                // Use 'perms'=>'$user->rights->controldeinventario->level1->level2' if you want your menu with a permission rules
			'target'=>'',
			'user'=>0,				                // 0=Menu for internal users, 1=external users, 2=both
		);
		$this->menu[$r++]=array(
			'fk_menu'=>'fk_mainmenu=controldeinventario,fk_leftmenu=inventariogeneral',	    // '' if this is a top menu. For left menu, use 'fk_mainmenu=xxx' or 'fk_mainmenu=xxx,fk_leftmenu=yyy' where xxx is mainmenucode and yyy is a leftmenucode
			'type'=>'left',			                // This is a Left menu entry
			'titre'=>'Nuevo Producto (stock)',
			'mainmenu'=>'controldeinventario',
			'leftmenu'=>'inventariogeneral2',
			'url'=>'/controldeinventario/inventariogeneral_card.php?action=create&stock=0',
			'langs'=>'controldeinventario@controldeinventario',	        // Lang file to use (without .lang) by module. File must be in langs/code_CODE/ directory.
			'position'=>1000+$r,
			'enabled'=>'$conf->controldeinventario->enabled',  // Define condition to show or hide menu entry. Use '$conf->controldeinventario->enabled' if entry must be visible if module is enabled. Use '$leftmenu==\'system\'' to show if leftmenu system is selected.
			'perms'=>'$user->rights->controldeinventario->inventariogeneral->write',			                // Use 'perms'=>'$user->rights->controldeinventario->level1->level2' if you want your menu with a permission rules
			'target'=>'',
			'user'=>0,				                // 0=Menu for internal users, 1=external users, 2=both
		);
			//inventario no stock
			$this->menu[$r++]=array(
				'fk_menu'=>'fk_mainmenu=controldeinventario',      // '' if this is a top menu. For left menu, use 'fk_mainmenu=xxx' or 'fk_mainmenu=xxx,fk_leftmenu=yyy' where xxx is mainmenucode and yyy is a leftmenucode
				'type'=>'left',                          // This is a Top menu entry
				'titre'=>'Inventario NS',
				'prefix' => img_picto('', 'inventariogeneral@controldeinventario', 'class="paddingright pictofixedwidth valignmiddle"'),
				'mainmenu'=>'controldeinventario',
				'leftmenu'=>'inventarions',
				'url'=>'/controldeinventario/inventarions_list.php?sortfield=t.ref',
				'langs'=>'controldeinventario@controldeinventario',	        // Lang file to use (without .lang) by module. File must be in langs/code_CODE/ directory.
				'position'=>1000+$r,
				'enabled'=>'$conf->controldeinventario->enabled',  // Define condition to show or hide menu entry. Use '$conf->controldeinventario->enabled' if entry must be visible if module is enabled.
				'perms'=>'$user->rights->controldeinventario->inventarions->read',			                // Use 'perms'=>'$user->rights->controldeinventario->level1->level2' if you want your menu with a permission rules
				'target'=>'',
				'user'=>0,				                // 0=Menu for internal users, 1=external users, 2=both
			);
			//inventario ANS
			$this->menu[$r++]=array(
				'fk_menu'=>'fk_mainmenu=controldeinventario',      // '' if this is a top menu. For left menu, use 'fk_mainmenu=xxx' or 'fk_mainmenu=xxx,fk_leftmenu=yyy' where xxx is mainmenucode and yyy is a leftmenucode
				'type'=>'left',                          // This is a Top menu entry
				'titre'=>'Inventario ANS',
				'prefix' => img_picto('', 'inventariogeneral@controldeinventario', 'class="paddingright pictofixedwidth valignmiddle"'),
				'mainmenu'=>'controldeinventario',
				'leftmenu'=>'inventarioans',
				'url'=>'/controldeinventario/inventarioans_list.php?sortfield=t.ref',
				'langs'=>'controldeinventario@controldeinventario',	        // Lang file to use (without .lang) by module. File must be in langs/code_CODE/ directory.
				'position'=>1000+$r,
				'enabled'=>'$conf->controldeinventario->enabled',  // Define condition to show or hide menu entry. Use '$conf->controldeinventario->enabled' if entry must be visible if module is enabled.
				'perms'=>'$user->rights->controldeinventario->inventarioans->read',			                // Use 'perms'=>'$user->rights->controldeinventario->level1->level2' if you want your menu with a permission rules
				'target'=>'',
				'user'=>0,				                // 0=Menu for internal users, 1=external users, 2=both
			);
			
			// $this->menu[$r++]=array(
			// 	'fk_menu'=>'fk_mainmenu=controldeinventario,fk_leftmenu=inventarions',	    // '' if this is a top menu. For left menu, use 'fk_mainmenu=xxx' or 'fk_mainmenu=xxx,fk_leftmenu=yyy' where xxx is mainmenucode and yyy is a leftmenucode
			// 	'type'=>'left',			                // This is a Left menu entry
			// 	'titre'=>'Nuevo Producto (NS,OS,ANS)',
			// 	'mainmenu'=>'controldeinventario',
			// 	'leftmenu'=>'inventarions2',
			// 	'url'=>'/controldeinventario/inventarions_card.php?action=create',
			// 	'langs'=>'controldeinventario@controldeinventario',	        // Lang file to use (without .lang) by module. File must be in langs/code_CODE/ directory.
			// 	'position'=>1000+$r,
			// 	'enabled'=>'$conf->controldeinventario->enabled',  // Define condition to show or hide menu entry. Use '$conf->controldeinventario->enabled' if entry must be visible if module is enabled. Use '$leftmenu==\'system\'' to show if leftmenu system is selected.
			// 	'perms'=>'$user->rights->controldeinventario->inventarions->write',			                // Use 'perms'=>'$user->rights->controldeinventario->level1->level2' if you want your menu with a permission rules
			// 	'target'=>'',
			// 	'user'=>0,				                // 0=Menu for internal users, 1=external users, 2=both
			// );
	
		// $this->menu[$r++]=array(
		// 	'fk_menu'=>'fk_mainmenu=controldeinventario,fk_leftmenu=inventariogeneral',	    // '' if this is a top menu. For left menu, use 'fk_mainmenu=xxx' or 'fk_mainmenu=xxx,fk_leftmenu=yyy' where xxx is mainmenucode and yyy is a leftmenucode
		// 	'type'=>'left',			                // This is a Left menu entry
		// 	'titre'=>'Almacenes',
		// 	'mainmenu'=>'controldeinventario',
		// 	'leftmenu'=>'inventariogeneral_almacenes',
		// 	'url'=>'/controldeinventario/almacenes_list.php',
		// 	'langs'=>'controldeinventario@controldeinventario',	        // Lang file to use (without .lang) by module. File must be in langs/code_CODE/ directory.
		// 	'position'=>1000+$r,
		// 	'enabled'=>'$conf->controldeinventario->enabled',  // Define condition to show or hide menu entry. Use '$conf->controldeinventario->enabled' if entry must be visible if module is enabled. Use '$leftmenu==\'system\'' to show if leftmenu system is selected.
		// 	'perms'=>'$user->rights->controldeinventario->almacenes->write',			                // Use 'perms'=>'$user->rights->controldeinventario->level1->level2' if you want your menu with a permission rules
		// 	'target'=>'',
		// 	'user'=>0,				                // 0=Menu for internal users, 1=external users, 2=both
		// );
		//requisiciones
		$this->menu[$r++]=array(
			'fk_menu'=>'fk_mainmenu=controldeinventario',	    // '' if this is a top menu. For left menu, use 'fk_mainmenu=xxx' or 'fk_mainmenu=xxx,fk_leftmenu=yyy' where xxx is mainmenucode and yyy is a leftmenucode
			'type'=>'left',			                // This is a Left menu entry
			'titre'=>'Lista de Requisiciones',
			'prefix' =>img_picto('', 'emisionderequisiciones@controldeinventario', 'class="paddingright pictofixedwidth valignmiddle"'),
			'mainmenu'=>'controldeinventario',
			'leftmenu'=>'lst_req',
			'url'=>'/controldeinventario/emisionderequisiciones_list.php',
			'langs'=>'controldeinventario@controldeinventario',	        // Lang file to use (without .lang) by module. File must be in langs/code_CODE/ directory.
			'position'=>1000+$r,
			'enabled'=>'$conf->controldeinventario->enabled',  // Define condition to show or hide menu entry. Use '$conf->controldeinventario->enabled' if entry must be visible if module is enabled. Use '$leftmenu==\'system\'' to show if leftmenu system is selected.
			'perms'=>'$user->rights->controldeinventario->emisionderequisiciones->read',			                // Use 'perms'=>'$user->rights->controldeinventario->level1->level2' if you want your menu with a permission rules
			'target'=>'',
			'user'=>0,				                // 0=Menu for internal users, 1=external users, 2=both
		);
		//entradas
		$this->menu[$r++]=array(
			'fk_menu'=>'fk_mainmenu=controldeinventario',
			'type'=>'left',			                // This is a Left menu entry
			'titre'=>'Lista de entradas.',
			'prefix' => img_picto('', 'entradas@controldeinventario', 'class="paddingright pictofixedwidth valignmiddle"'),
			'mainmenu'=>'controldeinventario',
			'leftmenu'=>'entradas',
			'url'=>'/controldeinventario/entradas_list.php',
			'langs'=>'controldeinventario@controldeinventario',	        // Lang file to use (without .lang) by module. File must be in langs/code_CODE/ directory.
			'position'=>1000+$r,
			'enabled'=>'$conf->controldeinventario->enabled',  // Define condition to show or hide menu entry. Use '$conf->controldeinventario->enabled' if entry must be visible if module is enabled. Use '$leftmenu==\'system\'' to show if leftmenu system is selected.
			'perms'=>'$user->rights->controldeinventario->entradas->read',			                // Use 'perms'=>'$user->rights->controldeinventario->level1->level2' if you want your menu with a permission rules
			'target'=>'',
			'user'=>0,				                // 0=Menu for internal users, 1=external users, 2=both
		);/*
		$this->menu[$r++]=array(
			'fk_menu'=>'fk_mainmenu=controldeinventario,fk_leftmenu=entradas',
			'type'=>'left',			                // This is a Left menu entry
			'titre'=>'Entrada (Stock).',
			'mainmenu'=>'controldeinventario',
			'leftmenu'=>'entradas1',
			'url'=>'/controldeinventario/entradas_card.php?action=create',
			'langs'=>'controldeinventario@controldeinventario',	        // Lang file to use (without .lang) by module. File must be in langs/code_CODE/ directory.
			'position'=>1000+$r,
			'enabled'=>'$conf->controldeinventario->enabled',  // Define condition to show or hide menu entry. Use '$conf->controldeinventario->enabled' if entry must be visible if module is enabled. Use '$leftmenu==\'system\'' to show if leftmenu system is selected.
			'perms'=>'$user->rights->controldeinventario->entradas->read',			                // Use 'perms'=>'$user->rights->controldeinventario->level1->level2' if you want your menu with a permission rules
			'target'=>'',
			'user'=>0,				                // 0=Menu for internal users, 1=external users, 2=both
		);

		$this->menu[$r++]=array(
			'fk_menu'=>'fk_mainmenu=controldeinventario,fk_leftmenu=entradas',
			'type'=>'left',			                // This is a Left menu entry
			'titre'=>'Entrada (No Stock).',
			'mainmenu'=>'controldeinventario',
			'leftmenu'=>'entradas1',
			'url'=>'/controldeinventario/entradas_card.php?action=create&isstock=1',
			'langs'=>'controldeinventario@controldeinventario',	        // Lang file to use (without .lang) by module. File must be in langs/code_CODE/ directory.
			'position'=>1000+$r,
			'enabled'=>'$conf->controldeinventario->enabled',  // Define condition to show or hide menu entry. Use '$conf->controldeinventario->enabled' if entry must be visible if module is enabled. Use '$leftmenu==\'system\'' to show if leftmenu system is selected.
			'perms'=>'$user->rights->controldeinventario->entradas->read',			                // Use 'perms'=>'$user->rights->controldeinventario->level1->level2' if you want your menu with a permission rules
			'target'=>'',
			'user'=>0,				                // 0=Menu for internal users, 1=external users, 2=both
		);
		$this->menu[$r++]=array(
			'fk_menu'=>'fk_mainmenu=controldeinventario,fk_leftmenu=entradas',
			'type'=>'left',			                // This is a Left menu entry
			'titre'=>'Entrada (Servicio).',
			'mainmenu'=>'controldeinventario',
			'leftmenu'=>'entradas4',
			'url'=>'/controldeinventario/entradas_card.php?action=create&isstock=4',
			'langs'=>'controldeinventario@controldeinventario',	        // Lang file to use (without .lang) by module. File must be in langs/code_CODE/ directory.
			'position'=>1000+$r,
			'enabled'=>'$conf->controldeinventario->enabled',  // Define condition to show or hide menu entry. Use '$conf->controldeinventario->enabled' if entry must be visible if module is enabled. Use '$leftmenu==\'system\'' to show if leftmenu system is selected.
			'perms'=>'$user->rights->controldeinventario->entradas->read',			                // Use 'perms'=>'$user->rights->controldeinventario->level1->level2' if you want your menu with a permission rules
			'target'=>'',
			'user'=>0,				                // 0=Menu for internal users, 1=external users, 2=both
		);
		$this->menu[$r++]=array(
			'fk_menu'=>'fk_mainmenu=controldeinventario,fk_leftmenu=entradas',
			'type'=>'left',			                // This is a Left menu entry
			'titre'=>'Entrada (AGQ).',
			'mainmenu'=>'controldeinventario',
			'leftmenu'=>'entradasq',
			'url'=>'/controldeinventario/entradas_card.php?action=create&isstock=6',
			'langs'=>'controldeinventario@controldeinventario',	        // Lang file to use (without .lang) by module. File must be in langs/code_CODE/ directory.
			'position'=>1000+$r,
			'enabled'=>'$conf->controldeinventario->enabled',  // Define condition to show or hide menu entry. Use '$conf->controldeinventario->enabled' if entry must be visible if module is enabled. Use '$leftmenu==\'system\'' to show if leftmenu system is selected.
			'perms'=>'$user->rights->controldeinventario->entradas->read',			                // Use 'perms'=>'$user->rights->controldeinventario->level1->level2' if you want your menu with a permission rules
			'target'=>'',
			'user'=>0,				                // 0=Menu for internal users, 1=external users, 2=both
		);*/


		//salidas
		$this->menu[$r++]=array(
			'fk_menu'=>'fk_mainmenu=controldeinventario',
			'type'=>'left',			                // This is a Left menu entry
			'titre'=>'Lista de salidas',
			'mainmenu'=>'controldeinventario',
			'prefix' => img_picto('', 'salidas@controldeinventario', 'class="paddingright pictofixedwidth valignmiddle"'),
			'leftmenu'=>'salidas',
			'url'=>'/controldeinventario/salidas_list.php',
			'langs'=>'controldeinventario@controldeinventario',	        // Lang file to use (without .lang) by module. File must be in langs/code_CODE/ directory.
			'position'=>1000+$r,
			'enabled'=>'$conf->controldeinventario->enabled',  // Define condition to show or hide menu entry. Use '$conf->controldeinventario->enabled' if entry must be visible if module is enabled. Use '$leftmenu==\'system\'' to show if leftmenu system is selected.
			'perms'=>'$user->rights->controldeinventario->salidas->read',			                // Use 'perms'=>'$user->rights->controldeinventario->level1->level2' if you want your menu with a permission rules
			'target'=>'',
			'user'=>0,				                // 0=Menu for internal users, 1=external users, 2=both
		);/*
		$this->menu[$r++]=array(
			'fk_menu'=>'fk_mainmenu=controldeinventario,fk_leftmenu=salidas',
			'type'=>'left',			                // This is a Left menu entry
			'titre'=>'Salidas (stock)',
			'mainmenu'=>'controldeinventario',
			'leftmenu'=>'salidas_0',
			'url'=>'/controldeinventario/salidas_card.php?action=create',
			'langs'=>'controldeinventario@controldeinventario',	        // Lang file to use (without .lang) by module. File must be in langs/code_CODE/ directory.
			'position'=>1000+$r,
			'enabled'=>'$conf->controldeinventario->enabled',  // Define condition to show or hide menu entry. Use '$conf->controldeinventario->enabled' if entry must be visible if module is enabled. Use '$leftmenu==\'system\'' to show if leftmenu system is selected.
			'perms'=>'$user->rights->controldeinventario->salidas->read',			                // Use 'perms'=>'$user->rights->controldeinventario->level1->level2' if you want your menu with a permission rules
			'target'=>'',
			'user'=>0,				                // 0=Menu for internal users, 1=external users, 2=both
		);
		$this->menu[$r++]=array(
			'fk_menu'=>'fk_mainmenu=controldeinventario,fk_leftmenu=salidas',
			'type'=>'left',			                // This is a Left menu entry
			'titre'=>'Salidas (No stock)',
			'mainmenu'=>'controldeinventario',
			'leftmenu'=>'salidas_1',
			'url'=>'/controldeinventario/salidas_card.php?action=create&isstock=1',
			'langs'=>'controldeinventario@controldeinventario',	        // Lang file to use (without .lang) by module. File must be in langs/code_CODE/ directory.
			'position'=>1000+$r,
			'enabled'=>'$conf->controldeinventario->enabled',  // Define condition to show or hide menu entry. Use '$conf->controldeinventario->enabled' if entry must be visible if module is enabled. Use '$leftmenu==\'system\'' to show if leftmenu system is selected.
			'perms'=>'$user->rights->controldeinventario->salidas->read',			                // Use 'perms'=>'$user->rights->controldeinventario->level1->level2' if you want your menu with a permission rules
			'target'=>'',
			'user'=>0,				                // 0=Menu for internal users, 1=external users, 2=both
		);
		$this->menu[$r++]=array(
			'fk_menu'=>'fk_mainmenu=controldeinventario,fk_leftmenu=salidas',
			'type'=>'left',			                // This is a Left menu entry
			'titre'=>'Salidas (Servicio)',
			'mainmenu'=>'controldeinventario',
			'leftmenu'=>'salidas_4',
			'url'=>'/controldeinventario/salidas_card.php?action=create&isstock=4',
			'langs'=>'controldeinventario@controldeinventario',	        // Lang file to use (without .lang) by module. File must be in langs/code_CODE/ directory.
			'position'=>1000+$r,
			'enabled'=>'$conf->controldeinventario->enabled',  // Define condition to show or hide menu entry. Use '$conf->controldeinventario->enabled' if entry must be visible if module is enabled. Use '$leftmenu==\'system\'' to show if leftmenu system is selected.
			'perms'=>'$user->rights->controldeinventario->salidas->read',			                // Use 'perms'=>'$user->rights->controldeinventario->level1->level2' if you want your menu with a permission rules
			'target'=>'',
			'user'=>0,				                // 0=Menu for internal users, 1=external users, 2=both
		);
		$this->menu[$r++]=array(
			'fk_menu'=>'fk_mainmenu=controldeinventario,fk_leftmenu=salidas',
			'type'=>'left',			                // This is a Left menu entry
			'titre'=>'Salidas (AGQ)',
			'mainmenu'=>'controldeinventario',
			'leftmenu'=>'salidas_6',
			'url'=>'/controldeinventario/salidas_card.php?action=create&isstock=6',
			'langs'=>'controldeinventario@controldeinventario',	        // Lang file to use (without .lang) by module. File must be in langs/code_CODE/ directory.
			'position'=>1000+$r,
			'enabled'=>'$conf->controldeinventario->enabled',  // Define condition to show or hide menu entry. Use '$conf->controldeinventario->enabled' if entry must be visible if module is enabled. Use '$leftmenu==\'system\'' to show if leftmenu system is selected.
			'perms'=>'$user->rights->controldeinventario->salidas->read',			                // Use 'perms'=>'$user->rights->controldeinventario->level1->level2' if you want your menu with a permission rules
			'target'=>'',
			'user'=>0,				                // 0=Menu for internal users, 1=external users, 2=both
		);*/


		//menú familias
		$this->menu[$r++]=array(
			'fk_menu'=>'fk_mainmenu=controldeinventario',      // '' if this is a top menu. For left menu, use 'fk_mainmenu=xxx' or 'fk_mainmenu=xxx,fk_leftmenu=yyy' where xxx is mainmenucode and yyy is a leftmenucode
			'type'=>'left',                          // This is a Top menu entry
			'titre'=>'Familias',
			'prefix' => img_picto('package', $this->picto, 'class="paddingright pictofixedwidth valignmiddle"'),
			'mainmenu'=>'controldeinventario',
			'leftmenu'=>'familias',
			'url'=>'/controldeinventario/familias_list.php',
			'langs'=>'controldeinventario@controldeinventario',	        // Lang file to use (without .lang) by module. File must be in langs/code_CODE/ directory.
			'position'=>1000+$r,
			'enabled'=>'$conf->controldeinventario->enabled',  // Define condition to show or hide menu entry. Use '$conf->controldeinventario->enabled' if entry must be visible if module is enabled.
			'perms'=>'$user->rights->controldeinventario->familias->read',			                // Use 'perms'=>'$user->rights->controldeinventario->level1->level2' if you want your menu with a permission rules
			'target'=>'',
			'user'=>0,				                // 0=Menu for internal users, 1=external users, 2=both
		);

		$this->menu[$r++]=array(
			'fk_menu'=>'fk_mainmenu=controldeinventario,fk_leftmenu=familias',	    // '' if this is a top menu. For left menu, use 'fk_mainmenu=xxx' or 'fk_mainmenu=xxx,fk_leftmenu=yyy' where xxx is mainmenucode and yyy is a leftmenucode
			'type'=>'left',			                // This is a Left menu entry
			'titre'=>'Agregar Familia',
			'mainmenu'=>'controldeinventario',
			'leftmenu'=>'familias',
			'url'=>'/controldeinventario/familias_card.php?action=create',
			'langs'=>'controldeinventario@controldeinventario',	        // Lang file to use (without .lang) by module. File must be in langs/code_CODE/ directory.
			'position'=>1000+$r,
			'enabled'=>'$conf->controldeinventario->enabled',  // Define condition to show or hide menu entry. Use '$conf->controldeinventario->enabled' if entry must be visible if module is enabled. Use '$leftmenu==\'system\'' to show if leftmenu system is selected.
			'perms'=>'$user->rights->controldeinventario->familias->write',			                // Use 'perms'=>'$user->rights->controldeinventario->level1->level2' if you want your menu with a permission rules
			'target'=>'',
			'user'=>0,				                // 0=Menu for internal users, 1=external users, 2=both

		);
		$this->menu[$r++]=array(
			'fk_menu'=>'fk_mainmenu=controldeinventario,fk_leftmenu=familias',	    // '' if this is a top menu. For left menu, use 'fk_mainmenu=xxx' or 'fk_mainmenu=xxx,fk_leftmenu=yyy' where xxx is mainmenucode and yyy is a leftmenucode
			'type'=>'left',			                // This is a Left menu entry
			'titre'=>'grupos de prod.',
			'mainmenu'=>'controldeinventario',
			'leftmenu'=>'grupos',
			'url'=>'/controldeinventario/grupos_list.php',
			'langs'=>'controldeinventario@controldeinventario',	        // Lang file to use (without .lang) by module. File must be in langs/code_CODE/ directory.
			'position'=>1000+$r,
			'enabled'=>'$conf->controldeinventario->enabled',  // Define condition to show or hide menu entry. Use '$conf->controldeinventario->enabled' if entry must be visible if module is enabled. Use '$leftmenu==\'system\'' to show if leftmenu system is selected.
			'perms'=>'$user->rights->controldeinventario->grupos->read',			                // Use 'perms'=>'$user->rights->controldeinventario->level1->level2' if you want your menu with a permission rules
			'target'=>'',
			'user'=>0,				                // 0=Menu for internal users, 1=external users, 2=both

		);
		$this->menu[$r++]=array(
			'fk_menu'=>'fk_mainmenu=controldeinventario,fk_leftmenu=familias',	    // '' if this is a top menu. For left menu, use 'fk_mainmenu=xxx' or 'fk_mainmenu=xxx,fk_leftmenu=yyy' where xxx is mainmenucode and yyy is a leftmenucode
			'type'=>'left',			                // This is a Left menu entry
			'titre'=>'Agregar grupo.',
			'mainmenu'=>'controldeinventario',
			'leftmenu'=>'grupos',
			'url'=>'/controldeinventario/grupos_card.php?action=create',
			'langs'=>'controldeinventario@controldeinventario',	        // Lang file to use (without .lang) by module. File must be in langs/code_CODE/ directory.
			'position'=>1000+$r,
			'enabled'=>'$conf->controldeinventario->enabled',  // Define condition to show or hide menu entry. Use '$conf->controldeinventario->enabled' if entry must be visible if module is enabled. Use '$leftmenu==\'system\'' to show if leftmenu system is selected.
			'perms'=>'$user->rights->controldeinventario->grupos->write',			                // Use 'perms'=>'$user->rights->controldeinventario->level1->level2' if you want your menu with a permission rules
			'target'=>'',
			'user'=>0,				                // 0=Menu for internal users, 1=external users, 2=both

		);
			//'url'=>'/controldeinventario/entradas_card.php?action=create',

		/*Menú de reportes...es solo un link*/
		$this->menu[$r++]=array(
			'fk_menu'=>'fk_mainmenu=controldeinventario',      // '' if this is a top menu. For left menu, use 'fk_mainmenu=xxx' or 'fk_mainmenu=xxx,fk_leftmenu=yyy' where xxx is mainmenucode and yyy is a leftmenucode
			'type'=>'left',                          // This is a Top menu entry
			'titre'=>'Reportes',
			'prefix' => img_picto('', 'emisionderequisiciones@controldeinventario', 'class="paddingright pictofixedwidth valignmiddle"'),
			'mainmenu'=>'controldeinventario',
			'leftmenu'=>'reportes',
			'url'=>'/controldeinventario/controldeinventarioindex.php?action=reportes',
			'langs'=>'controldeinventario@controldeinventario',	        // Lang file to use (without .lang) by module. File must be in langs/code_CODE/ directory.
			'position'=>1000+$r,
			'enabled'=>'$conf->controldeinventario->enabled',  // Define condition to show or hide menu entry. Use '$conf->controldeinventario->enabled' if entry must be visible if module is enabled.
			'perms'=>'$user->rights->controldeinventario->report->read',// Use 'perms'=>'$user->rights->controldeinventario->level1->level2' if you want your menu with a permission rules
			'target'=>'',
			'user'=>0,	// 0=Menu for internal users, 1=external users, 2=both
		);
       

		/* END MODULEBUILDER LEFTMENU EMISIONDEREQUISICIONES */
		// Exports profiles provided by this module
		$r = 1;
		/* BEGIN MODULEBUILDER EXPORT EMISIONDEREQUISICIONES */
		
		$langs->load("controldeinventario@controldeinventario");
		$this->export_code[$r]=$this->rights_class.'_'.$r;
		$this->export_label[$r]='Inventario General';	// Translation key (used only if key ExportDataset_xxx_z not found)
		$this->export_icon[$r]='inventariogeneral@controldeinventario';
		// Define $this->export_fields_array, $this->export_TypeFields_array and $this->export_entities_array
		$keyforclass = 'inventariogeneral'; $keyforclassfile='/controldeinventario/class/inventariogeneral.class.php'; $keyforelement='inventariogeneral@controldeinventario';
		include DOL_DOCUMENT_ROOT.'/core/commonfieldsinexport.inc.php';
		//$this->export_fields_array[$r]['t.fieldtoadd']='FieldToAdd'; $this->export_TypeFields_array[$r]['t.fieldtoadd']='Text';
		unset($this->export_fields_array[$r]['t.fieldtoremove']);
		//$keyforclass = 'EmisionDeRequisicionesLine'; $keyforclassfile='/controldeinventario/class/emisionderequisiciones.class.php'; $keyforelement='emisionderequisicionesline@controldeinventario'; $keyforalias='tl';
		//include DOL_DOCUMENT_ROOT.'/core/commonfieldsinexport.inc.php';
		//$keyforselect='controldeinventario_inventariogeneral'; $keyforaliasextra='extra'; $keyforelement='inventariogeneral@controldeinventario';
		//include DOL_DOCUMENT_ROOT.'/core/extrafieldsinexport.inc.php';
		//$keyforselect='emisionderequisicionesline'; $keyforaliasextra='extraline'; $keyforelement='emisionderequisicionesline@controldeinventario';
		//include DOL_DOCUMENT_ROOT.'/core/extrafieldsinexport.inc.php';
		//$this->export_dependencies_array[$r] = array('emisionderequisicionesline'=>array('tl.rowid','tl.ref')); // To force to activate one or several fields if we select some fields that need same (like to select a unique key if we ask a field of a child to avoid the DISTINCT to discard them, or for computed field than need several other fields)
		//$this->export_special_array[$r] = array('t.field'=>'...');
		//$this->export_examplevalues_array[$r] = array('t.field'=>'Example');
		//$this->export_help_array[$r] = array('t.field'=>'FieldDescHelp');
		$this->export_sql_start[$r]='SELECT DISTINCT ';
		$this->export_sql_end[$r]  =' FROM '.MAIN_DB_PREFIX.'controldeinventario_inventariogeneral as t';
		//$this->export_sql_end[$r]  =' LEFT JOIN '.MAIN_DB_PREFIX.'emisionderequisiciones_line as tl ON tl.fk_emisionderequisiciones = t.rowid';
		$this->export_sql_end[$r] .=' WHERE 1 = 1';
		//$this->export_sql_end[$r] .=' AND t.entity IN ('.getEntity('inventariogeneral').')';
		$r++; 
		/* END MODULEBUILDER EXPORT EMISIONDEREQUISICIONES */

		// Imports profiles provided by this module
		
		/* BEGIN MODULEBUILDER IMPORT EMISIONDEREQUISICIONES */
		
		 $langs->load("controldeinventario@controldeinventario");
		 $this->import_code[$r]=$this->rights_class.'_'.$r;
		 $this->import_label[$r]='Inventario';	// Translation key (used only if key ExportDataset_xxx_z not found)
		 $this->import_icon[$r]='inventariogeneral@controldeinventario';
		 $keyforclass = 'inventariogeneral'; $keyforclassfile='/controldeinventario/class/inventariogeneral.class.php'; $keyforelement='inventariogeneral@controldeinventario';
		 include DOL_DOCUMENT_ROOT.'/core/commonfieldsinexport.inc.php';
		 $keyforselect='controldeinventario_inventariogeneral'; $keyforaliasextra='extra'; $keyforelement='inventariogeneral@controldeinventario';
		 include DOL_DOCUMENT_ROOT.'/core/extrafieldsinexport.inc.php';
		 //$this->export_dependencies_array[$r]=array('mysubobject'=>'ts.rowid', 't.myfield'=>array('t.myfield2','t.myfield3')); // To force to activate one or several fields if we select some fields that need same (like to select a unique key if we ask a field of a child to avoid the DISTINCT to discard them, or for computed field than need several other fields)
		 $this->import_sql_start[$r]='SELECT DISTINCT ';
		 $this->import_sql_end[$r]  =' FROM '.MAIN_DB_PREFIX.'controldeinventario_inventariogeneral as t';
		 $this->import_sql_end[$r] .=' WHERE 1 = 1';
		 //$this->export_sql_end[$r] .=' AND t.entity IN ('.getEntity('inventariogeneral').')';
		 $r++; 
		/* END MODULEBUILDER IMPORT EMISIONDEREQUISICIONES */
		$r = 1;
	}

	/**
	 *  Function called when module is enabled.
	 *  The init function add constants, boxes, permissions and menus (defined in constructor) into Dolibarr database.
	 *  It also creates data directories
	 *
	 *  @param      string  $options    Options when enabling module ('', 'noboxes')
	 *  @return     int             	1 if OK, 0 if KO
	 */
	public function init($options = '')
	{
		global $conf, $langs;

		$result = $this->_load_tables('/controldeinventario/sql/');
		if ($result < 0) {
			return -1; // Do not activate module if error 'not allowed' returned when loading module SQL queries (the _load_table run sql with run_sql with the error allowed parameter set to 'default')
		}

		// Create extrafields during init
		//include_once DOL_DOCUMENT_ROOT.'/core/class/extrafields.class.php';
		//$extrafields = new ExtraFields($this->db);
		//$result1=$extrafields->addExtraField('controldeinventario_myattr1', "New Attr 1 label", 'boolean', 1,  3, 'thirdparty',   0, 0, '', '', 1, '', 0, 0, '', '', 'controldeinventario@controldeinventario', '$conf->controldeinventario->enabled');
		//$result2=$extrafields->addExtraField('controldeinventario_myattr2', "New Attr 2 label", 'varchar', 1, 10, 'project',      0, 0, '', '', 1, '', 0, 0, '', '', 'controldeinventario@controldeinventario', '$conf->controldeinventario->enabled');
		//$result3=$extrafields->addExtraField('controldeinventario_myattr3', "New Attr 3 label", 'varchar', 1, 10, 'bank_account', 0, 0, '', '', 1, '', 0, 0, '', '', 'controldeinventario@controldeinventario', '$conf->controldeinventario->enabled');
		//$result4=$extrafields->addExtraField('controldeinventario_myattr4', "New Attr 4 label", 'select',  1,  3, 'thirdparty',   0, 1, '', array('options'=>array('code1'=>'Val1','code2'=>'Val2','code3'=>'Val3')), 1,'', 0, 0, '', '', 'controldeinventario@controldeinventario', '$conf->controldeinventario->enabled');
		//$result5=$extrafields->addExtraField('controldeinventario_myattr5', "New Attr 5 label", 'text',    1, 10, 'user',         0, 0, '', '', 1, '', 0, 0, '', '', 'controldeinventario@controldeinventario', '$conf->controldeinventario->enabled');

		// Permissions
		$this->remove($options);

		$sql = array();

		// Document templates
		$moduledir = 'controldeinventario';
		$myTmpObjects = array();
		$myTmpObjects['EmisionDeRequisiciones'] = array('includerefgeneration'=>0, 'includedocgeneration'=>0);

		foreach ($myTmpObjects as $myTmpObjectKey => $myTmpObjectArray) {
			if ($myTmpObjectKey == 'EmisionDeRequisiciones') {
				continue;
			}
			if ($myTmpObjectArray['includerefgeneration']) {
				$src = DOL_DOCUMENT_ROOT.'/install/doctemplates/controldeinventario/template_emisionderequisicioness.odt';
				$dirodt = DOL_DATA_ROOT.'/doctemplates/controldeinventario';
				$dest = $dirodt.'/template_emisionderequisicioness.odt';

				if (file_exists($src) && !file_exists($dest)) {
					require_once DOL_DOCUMENT_ROOT.'/core/lib/files.lib.php';
					dol_mkdir($dirodt);
					$result = dol_copy($src, $dest, 0, 0);
					if ($result < 0) {
						$langs->load("errors");
						$this->error = $langs->trans('ErrorFailToCopyFile', $src, $dest);
						return 0;
					}
				}

				$sql = array_merge($sql, array(
					"DELETE FROM ".MAIN_DB_PREFIX."document_model WHERE nom = 'standard_".strtolower($myTmpObjectKey)."' AND type = '".strtolower($myTmpObjectKey)."' AND entity = ".$conf->entity,
					"INSERT INTO ".MAIN_DB_PREFIX."document_model (nom, type, entity) VALUES('standard_".strtolower($myTmpObjectKey)."','".strtolower($myTmpObjectKey)."',".$conf->entity.")",
					"DELETE FROM ".MAIN_DB_PREFIX."document_model WHERE nom = 'generic_".strtolower($myTmpObjectKey)."_odt' AND type = '".strtolower($myTmpObjectKey)."' AND entity = ".$conf->entity,
					"INSERT INTO ".MAIN_DB_PREFIX."document_model (nom, type, entity) VALUES('generic_".strtolower($myTmpObjectKey)."_odt', '".strtolower($myTmpObjectKey)."', ".$conf->entity.")"
				));
			}
		}

		return $this->_init($sql, $options);
	}

	/**
	 *  Function called when module is disabled.
	 *  Remove from database constants, boxes and permissions from Dolibarr database.
	 *  Data directories are not deleted
	 *
	 *  @param      string	$options    Options when enabling module ('', 'noboxes')
	 *  @return     int                 1 if OK, 0 if KO
	 */
	public function remove($options = '')
	{
		$sql = array();
		return $this->_remove($sql, $options);
	}
}
