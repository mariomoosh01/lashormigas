<?php
/* Copyright (C) 2004-2017  Laurent Destailleur <eldy@users.sourceforge.net>
 * Copyright (C) 2018-2021  Frédéric France     <frederic.france@netlogic.fr>
 * Copyright (C) 2021 SuperAdmin
 *
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program.  If not, see <https://www.gnu.org/licenses/>.
 */

/**
 * \file    controldeinventario/core/boxes/controldeinventariowidget1.php
 * \ingroup controldeinventario
 * \brief   Widget provided by ControlDeInventario
 *
 * Put detailed description here.
 */

include_once DOL_DOCUMENT_ROOT."/core/boxes/modules_boxes.php";


/**
 * Class to manage the box
 *
 * Warning: for the box to be detected correctly by dolibarr,
 * the filename should be the lowercase classname
 */
class controldeinventariowidget1 extends ModeleBoxes
{
	/**
	 * @var string Alphanumeric ID. Populated by the constructor.
	 */
	public $boxcode = "controldeinventariobox";

	/**
	 * @var string Box icon (in configuration page)
	 * Automatically calls the icon named with the corresponding "object_" prefix
	 */
	public $boximg = "controldeinventario@controldeinventario";

	/**
	 * @var string Box label (in configuration page)
	 */
	public $boxlabel;

	/**
	 * @var string[] Module dependencies
	 */
	public $depends = array('controldeinventario');

	/**
	 * @var DoliDb Database handler
	 */
	public $db;

	/**
	 * @var mixed More parameters
	 */
	public $param;

	/**
	 * @var array Header informations. Usually created at runtime by loadBox().
	 */
	public $info_box_head = array();

	/**
	 * @var array Contents informations. Usually created at runtime by loadBox().
	 */
	public $info_box_contents = array();

	/**
	 * @var string 	Widget type ('graph' means the widget is a graph widget)
	 */
	public $widgettype = 'graph';


	/**
	 * Constructor
	 *
	 * @param DoliDB $db Database handler
	 * @param string $param More parameters
	 */
	public function __construct(DoliDB $db, $param = '')
	{
		global $user, $conf, $langs;
		$langs->load("boxes");
		$langs->load('controldeinventario@controldeinventario');

		parent::__construct($db, $param);

		$this->boxlabel = $langs->transnoentitiesnoconv("MyWidget");

		$this->param = $param;

		//$this->enabled = $conf->global->FEATURES_LEVEL > 0;         // Condition when module is enabled or not
		//$this->hidden = ! ($user->rights->controldeinventario->myobject->read);   // Condition when module is visible by user (test on permission)
	}

	/**
	 * Load data into info_box_contents array to show array later. Called by Dolibarr before displaying the box.
	 *
	 * @param int $max Maximum number of records to load
	 * @return void
	 */
	public function loadBox($max = 5)
	{
		global $langs;

		// Use configuration value for max lines count
		$this->max = $max;

		//dol_include_once("/controldeinventario/class/controldeinventario.class.php");

		// Populate the head at runtime
		$text = $langs->trans("ControlDeInventarioBoxDescription", $max);
		$this->info_box_head = array(
			// Title text
			'text' => '',
			// Add a link
			'sublink' => '/custom/controldeinventario/controldeinventarioindex.php',
			// Sublink icon placed after the text
			'subpicto' => 'object_controldeinventario@controldeinventario',
			// Sublink icon HTML alt text
			'subtext' => '',
			// Sublink HTML target
			'target' => '',
			// HTML class attached to the picto and link
			'subclass' => 'center',
			// Limit and truncate with "…" the displayed text lenght, 0 = disabled
			'limit' => 0,
			// Adds translated " (Graph)" to a hidden form value's input (?)
			'graph' => false
		);

		// Populate the contents at runtime
		$this->info_box_contents = array(
			0 => array( // First line
				0 => array( // First Column
					//  HTML properties of the TR element. Only available on the first column.
					'tr' => 'class="left"',
					// HTML properties of the TD element
					'td' => 'hola, probando widget.',

					// Main text for content of cell
					'text' => '',
					// Link on 'text' and 'logo' elements
					'url' => '/custom/controldeinventario/controldeinventarioindex.php?idmenu=34990&mainmenu=controldeinventario&leftmenu=',
					// Link's target HTML property
					'target' => '',
					// Fist line logo (deprecated. Include instead logo html code into text or text2, and set asis property to true to avoid HTML cleaning)
					//'logo' => 'monmodule@monmodule',
					// Unformatted text, added after text. Usefull to add/load javascript code
					'textnoformat' => '',

					// Main text for content of cell (other method)
					'text2' => '
									
						<img style="
						width: 60%;
						margin: auto !important;
						display: block;
						margin-left: auto;
						margin-right: auto;
						" width=600 src="/custom/controldeinventario/img/logo_3.png">
						<p style="
					display: inline-block;
					width: -webkit-fill-available;
					text-align: center;
					">
						<img style="width:40% " width=600 src="/custom/controldeinventario/img/hormigatrabajando01.jpg"></p>
					<p style="display: inline-block;width: -webkit-fill-available;text-align: center;">
						<a class="button"href="../custom/controldeinventario/controldeinventarioindex.php?idmenu=35120&mainmenu=controldeinventario&leftmenu=">Entrar</a>
					</p>',

					// Truncates 'text' element to the specified character length, 0 = disabled
					'maxlength' => 0,
					// Prevents HTML cleaning (and truncation)
					'asis' => false,
					// Same for 'text2'
					'asis2' => true
				),
				1 => array( // Another column
					// No TR for n≠0
					'td' => '',
					'text' => '',
				)
			),
			
		);
	}

	/**
	 * Method to show box. Called by Dolibarr eatch time it wants to display the box.
	 *
	 * @param array $head       Array with properties of box title
	 * @param array $contents   Array with properties of box lines
	 * @param int   $nooutput   No print, only return string
	 * @return string
	 */
	public function showBox($head = null, $contents = null, $nooutput = 0)
	{
		// You may make your own code here…
		// … or use the parent's class function using the provided head and contents templates		
		return parent::showBox($this->info_box_head, $this->info_box_contents, $nooutput);
	}
}
