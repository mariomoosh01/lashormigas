<?php
/**
	 * Función extra añadida. Verifica que los campos obligatorios no estén vacios.
	 * 
	 * @return int	si 0, quiere decir que si llenamos los datos, 
	 */
	function isRequiredValsEmtpy($action,$permissiontoadd,$object){
		$error = 0;
		if ($action == 'add' || $action ='update' && !empty($permissiontoadd)) {
			foreach ($object->fields as $key => $val) {
				if ($object->fields[$key]['type'] == 'duration') {
					if (GETPOST($key.'hour') == '' && GETPOST($key.'min') == '') {
						continue; // The field was not submited to be edited
					}
				} else {
					if (!GETPOSTISSET($key)) {
						continue; // The field was not submited to be edited
					}
				}
				// Ignore special fields
				if (in_array($key, array('rowid', 'entity', 'import_key'))) {
					continue;
				}
				if (in_array($key, array('date_creation', 'tms', 'fk_user_creat', 'fk_user_modif'))) {
					if (!in_array(abs($val['visible']), array(1, 3))) {
						continue; // Only 1 and 3 that are case to create
					}
				}
		
				// Set value to insert
				if (in_array($object->fields[$key]['type'], array('text', 'html'))) {
					$value = GETPOST($key, 'restricthtml');
				} elseif ($object->fields[$key]['type'] == 'date') {
					$value = dol_mktime(12, 0, 0, GETPOST($key.'month', 'int'), GETPOST($key.'day', 'int'), GETPOST($key.'year', 'int'));	// for date without hour, we use gmt
				} elseif ($object->fields[$key]['type'] == 'datetime') {
					$value = dol_mktime(GETPOST($key.'hour', 'int'), GETPOST($key.'min', 'int'), GETPOST($key.'sec', 'int'), GETPOST($key.'month', 'int'), GETPOST($key.'day', 'int'), GETPOST($key.'year', 'int'), 'tzuserrel');
				} elseif ($object->fields[$key]['type'] == 'duration') {
					$value = 60 * 60 * GETPOST($key.'hour', 'int') + 60 * GETPOST($key.'min', 'int');
				} elseif (preg_match('/^(integer|price|real|double)/', $object->fields[$key]['type'])) {
					$value = price2num(GETPOST($key, 'alphanohtml')); // To fix decimal separator according to lang setup
				} elseif ($object->fields[$key]['type'] == 'boolean') {
					$value = ((GETPOST($key) == '1' || GETPOST($key) == 'on') ? 1 : 0);
				} elseif ($object->fields[$key]['type'] == 'reference') {
					//$tmparraykey = array_keys($object->param_list);
					$value = $tmparraykey[GETPOST($key)].','.GETPOST($key.'2');
				} else {
					$value = GETPOST($key, 'alphanohtml');
				}
				if (preg_match('/^integer:/i', $object->fields[$key]['type']) && $value == '-1') {
					$value = ''; // This is an implicit foreign key field
				}
				if (!empty($object->fields[$key]['foreignkey']) && $value == '-1') {
					$value = ''; // This is an explicit foreign key field
				}
		
				var_dump($key.' '.$value.' '.$object->fields[$key]['type']);
				$object->$key = $value;
				if ($val['notnull'] > 0 && $object->$key == '' && !is_null($val['default']) && $val['default'] == '(PROV)') {
					//$object->$key = '(PROV)';valor original
					$object->key = $object->getNextNumRef();
				}
				if ($val['notnull'] > 0 && $object->$key == '' && is_null($val['default'])) {
					$error++;					
				}
			}									
		}
		return $error;
	}
