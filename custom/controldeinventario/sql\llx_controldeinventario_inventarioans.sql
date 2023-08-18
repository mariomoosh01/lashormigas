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


CREATE TABLE llx_controldeinventario_inventarioans(
	-- BEGIN MODULEBUILDER FIELDS
	rowid integer AUTO_INCREMENT PRIMARY KEY NOT NULL, 
	ref varchar(128) NOT NULL, 
	description varchar(128), 
	udm varchar(5) NOT NULL, 
	cost double, 
	t_cost double, 
	moneda varchar(3) NOT NULL, 
	iva smallint(6) NOT NULL, 
	qty double NOT NULL, 
	rec_qty double NOT NULL, 
	max_qty double, 
	ubicacion varchar(24), 
	salidas text, 
	tiporeq smallint(6) NOT NULL, 
	date_creation datetime NOT NULL, 
	tms timestamp NOT NULL, 
	fk_user_creat integer NOT NULL, 
	fk_user_modif integer, 
	status smallint(6) NOT NULL
	-- END MODULEBUILDER FIELDS
) ENGINE=innodb;
