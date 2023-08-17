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


-- BEGIN MODULEBUILDER INDEXES
ALTER TABLE llx_controldeinventario_grupos ADD INDEX idx_controldeinventario_grupos_rowid (rowid);
ALTER TABLE llx_controldeinventario_grupos ADD INDEX idx_controldeinventario_grupos_ref (ref);
ALTER TABLE llx_controldeinventario_grupos ADD INDEX idx_controldeinventario_grupos_status (status);
-- END MODULEBUILDER INDEXES

--ALTER TABLE llx_controldeinventario_grupos ADD UNIQUE INDEX uk_controldeinventario_grupos_fieldxy(fieldx, fieldy);

--ALTER TABLE llx_controldeinventario_grupos ADD CONSTRAINT llx_controldeinventario_grupos_fk_field FOREIGN KEY (fk_field) REFERENCES llx_controldeinventario_myotherobject(rowid);

