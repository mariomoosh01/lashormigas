# CHANGELOG CONTROLDEINVENTARIO

# 0.1.0

+ Versión alpha inicial

# 0.1.1

+ Añadidura de tablas extra "Familia", "Grupos", y "Unidades de medida".

# 0.1.2

+ Agregado sistema de Triggers

# 0.1.3

+ Hecho que el objeto "Requisiciones" añade automáticamente un nuevo produto si esta requisiciónes es de tipo
"No Stock" U "Orden de Servicio".

+ Corregido un error de permisos al borrar inventario.

# 0.1.4

+ Añadida la posibilidad de exportar los datos de inventario por medio de la herramienta de exportación de Dolibarr.

+ Al agregar producto, el precio total se calcula automáticamente al ingresar precio individual y cantidad de productos.

* Corregido error al leer registros de requisiciones no stock que generaban registros de inventarios dobles.

* Corregido error al actualizar registros de requicisiones no stock, que no registraban los datos actualizados.

# 0.1.5

+ Entradas y salidas afectan directamente inventario Stock. 

+ Salidas puede generar automáticamente requicisiones la cantidad es inferior
a cierto criterio establecido en los productos stock.

# 0.2.0

* Entradas y salidas generan número de requisición automático (solo inventario Stock)

+ Agregado la requisición de Agroquímicos (AGR)

* Corregido errores de modificación de datos, donde a pesar de fallar en agregar una entrada, el inventario se modificaba de todos modos.

# 0.2.1
+ Agregado Generador de documentos. Genera reportes desde el menú principal.

# 0.2.2
* Corregido el generador de reportes. 

* Cambiado el orden y nombres de las cabezeras de algunas tablas. Esto no debería afectar la base de datos.

# 0.3.0
+ Añadido un menú principal, y simplificado el menú lateral.

# 0.3.1
* Corregido error al volver de un nuevo objeto al menú principal: Se añadió un botón de atrás para volver al menú principal.

# 0.3.2
+ Agregada la opción "Reportes" en el menú lateral.

# 0.3.3
+ Nueva tabla de las entradas más reciente en requicisiones, entradas y salidas. 

# 0.3.4
+ Agregado nuevo widget para dar entrada al sistema más intuitivamente.

# 0.3.5
* Rediseñado los menús de inserción de datos de requisición, entradas y salidas, aun conservando compatibilidad con dolibarr.

# 0.3.6
* Rediseñado y corregido el sistema de entradas y requisiciones. Con busqueda de rellenaod de datos automáticos.

# 0.3.7
* Corregido error en entradas.
+ Sistema de Salidas en funcionamiento.

# 0.3.8
+ Añadido logotipo visual al entrar al sistema.

* Corregido los contadores: ahora cuentan cada tipo re requicision independientemente.

# 0.4.0
* Modificado totalmente la página de Inventario, además de agregar nueva entrada de menú
titulada "Sistema general de control de inventarios Stock", y agregar nuevas entradas del sistema.

* cambiadas las apariencias de los sistemas de entrada, salida y requicisión para ser similar a la lista de partes, haciendo más congruencias.

* dado acceso a la lista de familias desde el menú principal.

# 0.4.1

+ POR FIN ser capáz de leer datos de un campo "Select" procesado por DOLIBAAR (solo funciona en Stock, en otras requisiciones, se sigue leyendo el texto manualmente???).

# 0.4.2

* Arregladondo bugs varios.
+ POR FIN se pueden hacer requisiciones que afecten partes, entradas y salidas (STOCK) donde se afecta el inventario stock.
* Se pueden hacer requisiciones, entradas y salidas diferentes de stock. estas salidas SOLO afectan entradas, no inventario.

# 0.4.3

* Corregido error al cargar partes en requisiciones y salidas.

# 0.4.5

* Corregido algunos subsistemas que se modificaron a la hora de cargar datos y guardarlos al hacer requisión stock.
* Saldato una cifra en la versión por que corregir javascript no es tan sencillo.

# 0.4.6
+ Añadido la capacidad de borrar a usuarios con permisos permitidos.
* Corregido errores al proceder con Salidas.

# 0.4.7
* Modificada la lista de inventario
* Corregido errores en los reportes.
* Dar permiso de editar entradas en la misma lista de inventario, solo si el usuario tiene permiso de...borrar los datos. (Detalles de Dolibarr que tomar en cuenta). Indicado por un pequeño ìcono de cuaderno.

# 0.4.8
* Corregido errores en edición de inventario stock, entradas y requisiciones.

# 0.4.9
* Corregido error de carga de datos de requisición, entradas y salidas.
* cambiado el color predeterminado.

# 0.4.10
* Corregido error de requisiciones no stock, que no corregia ni cambiaba la requisición.
* Cambiando entrada de menú "Inventario" para que sea de inventario stock por default.

# 0.4.11
+ Añadido un nuevo campo a la tabla de entradas; "Proveedor", Renombrado el campo "Facturas proveedor" a "Facturas".

# 0.4.12
* Cambiadas las posiciones de textos de entrada (NOTA, afecta a TODO Dolibarr en general.)

# 0.5.1
+ Agregada la habilidad de definir en pesos o dólares la cantidad de entradas.
+ Agregada la habilidad de calcular I.V.A si el usuario así lo define en las entradas.

# 0.5.2
* Corregido la edición de inventario general.
* Añadida la habilidad de regresar requisiciones a su estado original tras borrar la entrada correspondiente (No stock, Orden de servicio, Agroquímicos)

# 0.5.3
*Corregido un error que forzaba el tipo de requesicion en entradas, salidas y requisiciones al editar dichos datos.

# 0.6.0
+ Agregado una base de datos para los inventarios no Stock (NS, OS, ANS). Separado del Stock.
* Corregidos numerosos bugs que prevenian al sistema de crear entradas, asignar requisiciones, etc.

# 0.6.1
* Modificado las salidas para que funcionen con el nuevo inventario no stock.
* corregido algunos errores.

# 0.6.2
* Corregido errores a la hora de editar y procesar entradas no stock
+ Separada la lista de requisiciones ANS, de NS y OS.
*Corregido errror a la hora de producir nuevos inventarios stock.
+ Añadida la habilidad de introducir nuevas partes Stock.
* corregido error al mostrar precios con iva en inventario No stock, Ordenes de servicio y Agroquímicos.
* Cambiado apariencia de listas de Entradas, salidas y Requisiciones, para coincidir con las listas de inventarios.
* Corregido errores en el archivo "commonfields_add.tpl.php" que afectaba a la páginas de familias e inventario stock.
* Corregido errores en las salidas STOCK, agregaba más requecisiones en vez de actualizar las ya existenctes. Este error ya fue corregido.

# 0.6.3
+ Añadido íconos para el menú pricipal.
+ Añadido seguro para evitar entradas repetidas en el inventario Stock.

# 0.6.4
+ Añadido contador personalizado para emision de requicisiones para cada requisicion.

# 0.7.0
+ Añadido reportes customizables: Reporte de Inventario por familias y por ubicación.
* cambiado los reportes de entradas no stock - Se reflejan los cambios que hacen las entradas y salidas en el inventario NO stock (NS, OS, ANS).

# 0.7.1
* cambiado el comportamiento de la búsqueda de familias: Al dar click a una familia en la lista, automatícamente genera el reporte con dicha familia seleccionada.

# 0.7.2
* Corregido un error que generaba inventario no stock aun cuando se excedia la cantidad de la requisición adjunta.

# 0.7.3
* modificadas las listas de inventario NS, OS y ANS para mostrar números de salidas mas pequeños y formateados.
* Añadidos nuevos reportes para requisiciones en espera y reporte del día anterior.
* Corregido error de requisiciones stock, contador de stock no avanzaba al hacer una requisición manualmente.

# 0.7.4
* Corregido un error que hacia que las cantidades las agarrara como enteros en vez de fracciones.
* Corregido error donde las entradas y salidas erroneas afectavan inventario, cuando no debe ser el caso.

# 0.7.5
* Cambiado el comportamiento de las ediciones. en entradas, salidas y otras cosas.
+ rehabilitada la habilidad de EDITAR salidas....con el pequeño cambio de que se alistan por # de salida.

# 0.7.6
* Cambiado el orden default de la lista de "inventariogeneral" de "rowid" a "ref".

# 0.7.7
* Añadido comportamiento para Stock, el borrar entradas y borrar salidas regresa el inventario afectado a como estaba antes.
* Corregido comportamiento de stock con requisiciones

# 0.8
* Corregido error de permisos cuando los usuarios no tienen permiso de editar, crear, ver o borrar DATOS.
* Borrado el botón de enviar E-MAIL; No es necesario de momento.
+ Agregado permisos para REPORTES.

# 0.8.1
* Corregido un bug donde no te permitia auto calcular los precios de laspartes a la hora de hacer entradas STOCK.

# 0.8.2
* Corregido un error donde no se actualiza la fecha de edición de partes cuando se actualizan automáticamente al realizar una acciòn que no es editarlos.
* Corregido un error donde se sumaba la cantidad pedida y no la cantidad recibida en entradas de inventario Stock.

# 0.8.3
+ Agregado reporte de inventario con existencia donde elige la fecha de modificación de los inventarios.

# 0.8.4
+ Cambiado detalles de un reporte.
* corregido permisos para Reportes 

# 0.8.5
* Cambiado ciertos comportamientos en reportes.
* Corregido lista de inventario NS, OS y ANS
* Añadido campo "auditoria" en el inventario Stock.

# 0.8.6
* Correcciones menores en listas de inventarion ns, os, ans.
* Corregido títulos de reportes.
* Hecho el reporte de ANS permanente: toma en cuenta las entradas completadas y pendientes.

# 0.8.7
* Corregido comportamiento de salidas: ahora, a la hora de borrar una salida, restaura el inventario que se quitó con la salida, (ademas de quitar el número de salida del inventario NS, OS y ANS).

# 0.8.8
* Modificado el Menú: Ahora el menú lateral izquierdo se esconde a menos que acerces el mouse a el.
* Cambiando la presentación de inicio.
* 
# 0.8.9
+ Agregado un reporte de requisiciones por fecha, mostrando estado y tipo de requisición.

# 0.8.10
* Corregido un error donde el buscador de entradas no filtraba las requisiciones por tipo de almacenaje (ej. podias leer requisiciones STOCK en una entrada NO STOCK; Esto 
no solo causa problemas si no que ademas la base de datos no se actualiza correctamente, provocando entradas falsas).

# 0.8.11
* Corregido un error en el generador de Reportes donde no cortaba las decimales de precios con MUCHAS decimales si este no estaba con I.V.A incluido. Ahora son redondeadas correctamente.

# 0.8.12
(2022/07/22)
* Corregido los botones siguiente y Anterior en las listas; afinada la lógica para cuando se muestren y cuando no; Agregado a listas que no tenian la lógica.
    
# 0.8.13
(2022/10/22)
* Corregido un error que permitía requisiciones, entradas, y salidas repetidas; se han implementado medidas para evitar entradas duplicadas.

# 0.9.0
(2022/11/14)
+ Agregado un apartado en la lista de inventario stock donde se suma la Cantidad de dinero en el (suma de inventario real * precio unitario de TODO el inventario).
+ Agregado un apartado en la lista de entradas de almacén, donde se agregan una suma de artículos separados por los precios en PESOS y DOLARES