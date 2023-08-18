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


CREATE TABLE llx_controldeinventario_contadores(
	-- BEGIN MODULEBUILDER FIELDS
	rowid integer AUTO_INCREMENT PRIMARY KEY NOT NULL, 
	ref varchar(16) NOT NULL, 
	label varchar(128) NOT NULL, 
	req_ST int NOT NULL, 
	req_NT int NOT NULL, 
	req_OS int NOT NULL, 
	req_ANS int NOT NULL, 
	ent_ST int NOT NULL, 
	ent_NT int NOT NULL, 
	ent_OS int NOT NULL, 
	ent_ANS int NOT NULL, 
	sal_ST int NOT NULL, 
	sal_NS int NOT NULL, 
	sal_OS int NOT NULL, 
	sal_ANS int NOT NULL, 
	date_creation datetime NOT NULL, 
	tms timestamp, 
	fk_user_creat integer NOT NULL, 
	fk_user_modif integer, 
	import_key varchar(14)
	-- END MODULEBUILDER FIELDS
) ENGINE=innodb;
