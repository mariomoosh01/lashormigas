-- Copyright (C) ---Put here your own copyright and developer email---
--
-- This program is free software: you can redistribute it and/or modify
-- it under the terms of the GNU General Public License as published by
-- the Free Software Foundation, either version 3 of the License, or
-- (at your option) any later version.
--
-- This program is distributed in the hope that it will be useful,
-- but WITHOUT ANY WARRANTY; without even the implied warranty of
-- MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
-- GNU General Public License for more details.
--
-- You should have received a copy of the GNU General Public License
-- along with this program.  If not, see https://www.gnu.org/licenses/.


CREATE TABLE llx_controldeinventario_entradas(
	-- BEGIN MODULEBUILDER FIELDS
	rowid integer AUTO_INCREMENT PRIMARY KEY NOT NULL, 
	ref varchar(9) DEFAULT '(PROV)' NOT NULL, 
	fk_codific integer, 
	codific varchar(64) NOT NULL, 
	description varchar(64), 
	udm varchar(5), 
	get_qty real, 
	qty real, 
	ext_qty real, 
	cost double, 
	t_cost double, 
	factura varchar(128) NOT NULL, 
	usuario varchar(64), 
	ubicacion varchar(16), 
	date_creation datetime NOT NULL, 
	tms timestamp, 
	fk_user_creat integer NOT NULL, 
	fk_user_modif integer, 
	import_key varchar(14), 
	status smallint DEFAULT 1 NOT NULL, 
	tiporeq smallint NOT NULL
	-- END MODULEBUILDER FIELDS
) ENGINE=innodb;
