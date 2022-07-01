/*******************************************I-DAT-FFP-TIE-1-18/06/2021***********************************************/

INSERT INTO segu.tsubsistema ( codigo, nombre, fecha_reg, prefijo, estado_reg, nombre_carpeta, id_subsis_orig)
VALUES ('TIE', 'tienda', '2021-06-18', 'TIE', 'activo', 'tienda', NULL);

select pxp.f_insert_tgui ('TIENDA', '', 'TIE', 'si', 1, '', 1, '', '', 'TIE');

select pxp.f_insert_tgui ('Marca', 'Marca', 'MAR', 'si', 1, 'sis_tienda/vista/marca/Marca.php', 2, '', 'Marca', 'TIE');

/*******************************************F-DAT-FFP-TIE-1-18/06/2021***********************************************/

/*******************************************I-DAT-ICQ-TIE-2-18/06/2021***********************************************/
select pxp.f_insert_tgui ('Producto', 'Producto', 'PROD', 'si', 2, 'sis_tienda/vista/producto/Producto.php', 2, '', 'Producto', 'TIE');
/*******************************************F-DAT-ICQ-TIE-2-18/06/2021***********************************************/


/*******************************************I-DAT-ICQ-FFP-1-22/06/2021***********************************************/

select pxp.f_insert_tgui ('Producto', 'Producto', 'PROD', 'si', 2, 'sis_tienda/vista/producto/ProductoHijo1.php', 2, '', 'ProductoHijo1', 'TIE');

/*******************************************F-DAT-ICQ-FFP-1-22/06/2021***********************************************/

/*******************************************I-DAT-ICQ-DZ-1-23/06/2021***********************************************/

select pxp.f_insert_tgui ('Categoria', 'Categoria', 'CAT', 'si', 3, 'sis_tienda/vista/categoria/Categoria.php', 2, '', 'Categoria', 'TIE');

/*******************************************F-DAT-ICQ-DZ-1-23/06/2021***********************************************/

/*******************************************I-DAT-ICQ-DS-1-26/06/2021***********************************************/
select pxp.f_insert_tgui ('Venta', 'Venta', 'VT', 'si', 5, 'sis_tienda\vista\venta\Venta.php', 2, '', 'Venta', 'TIE');
/*******************************************F-DAT-ICQ-DS-1-26/06/2021***********************************************/

/*******************************************I-DAT-EAQ-DZ-1-26/06/2021***********************************************/

select pxp.f_insert_tgui ('Cliente', 'Cliente', 'CLIE', 'si', 6, 'sis_tienda/vista/cliente/Cliente.php', 2, '', 'Cliente', 'TIE');

/*******************************************F-DAT-EAQ-DZ-1-26/06/2021***********************************************/

/*******************************************I-DAT-ATB-DZ-1-26/06/2021***********************************************/

select pxp.f_insert_tgui ('<i class="fa fa-shopping-cart fa-2x"></i> TIENDA', '', 'TIE', 'si', 1, '', 1, '', '', 'TIE');
select pxp.f_insert_tgui ('Dosificacion', 'Dosificacion', 'DOSI', 'si', 4, 'sis_tienda/vista/dosificacion/Dosificacion.php', 2, '', 'Dosificacion', 'TIE');

/*******************************************F-DAT-ATB-DZ-1-26/06/2021***********************************************/


/*******************************************I-DAT-FFP-TIE-1-29/06/2021***********************************************/

INSERT INTO param.ttipo_archivo (id_usuario_reg, id_usuario_mod, fecha_reg, fecha_mod, estado_reg, id_usuario_ai, usuario_ai, obs_dba, nombre_id, tipo_archivo, tabla, codigo, nombre, multiple, extensiones_permitidas, ruta_guardar, tamano, orden, obligatorio) VALUES (1, null, '2021-06-29 23:04:27.485711', null, 'activo', null, 'NULL', null,  'id_producto', 'imagen', 'tie.tproducto', 'TIEPRO', 'TIEPRO', 'no', 'png,gif,bmp,jpeg,jpg', '', 1, null, null);
INSERT INTO param.ttipo_archivo (id_usuario_reg, id_usuario_mod, fecha_reg, fecha_mod, estado_reg, id_usuario_ai, usuario_ai, obs_dba, nombre_id, tipo_archivo, tabla, codigo, nombre, multiple, extensiones_permitidas, ruta_guardar, tamano, orden, obligatorio) VALUES (1, null, '2021-06-29 23:13:29.836518', null, 'activo', null, 'NULL', null,  'id_producto', 'documento', 'tie.tproducto', 'CATALOGOPRO', 'CATALOGOPRO', 'no', 'doc,docx,pdf,jpg,jpeg,bmp,gif,png,PDF,DOC,DOCX,xls,xlsx,XLS,XLSX,rar', '', 5, null, null);

/*******************************************F-DAT-FFP-TIE-1-29/06/2021***********************************************/

/*******************************************I-DAT-EAQ-TIE-1-1/07/2021***********************************************/
select param.f_import_tipo_archivo ('{"id_tipo_archivo":"3","nombre_id":"id_categoria","multiple":"no","codigo":"ICOCAT","tipo_archivo":"imagen","tabla":"tie.tcategoria","nombre":"ICOCAT","estado_reg":"activo","id_usuario_ai":null,"usuario_ai":"NULL","fecha_reg":"2021-06-30 23:41:01.13486","id_usuario_reg":"1","fecha_mod":null,"id_usuario_mod":null,"usr_reg":"admin","usr_mod":null,"extensiones_permitidas":"doc,docx,pdf,jpg,jpeg,bmp,gif,png,PDF,DOC,DOCX,xls,xlsx","ruta_guardar":"","tamano":"2","orden":null,"obligatorio":null}', '[]', '[]');
/*******************************************F-DAT-EAQ-TIE-1-1/07/2021***********************************************/
