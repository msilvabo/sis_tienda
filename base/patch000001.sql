/***********************************I-SCP-FFP-TIE-1-17/06/2021****************************************/
CREATE TABLE tie.tmarca (
    id_marca serial NOT NULL,
    nombre VARCHAR(50) NOT NULL,
    CONSTRAINT pk_tmarca__id_marca PRIMARY KEY(id_marca)
) INHERITS (pxp.tbase);
/***********************************F-SCP-FFP-TIE-1-17/06/2021*****************************************/

/***********************************I-SCP-ICQ-TIE-2-17/06/2021****************************************/
CREATE TABLE tie.tproducto (
    id_producto serial NOT NULL,
    nombre VARCHAR(50) NOT NULL,
    precio DECIMAL NOT NULL default 0,
    CONSTRAINT pk_tproducto__id_producto PRIMARY KEY(id_producto)
) INHERITS (pxp.tbase);
/***********************************F-SCP-ICQ-TIE-2-17/06/2021*****************************************/


/***********************************I-SCP-FFP-TIE-1-19/06/2021****************************************/
alter table tie.tproducto alter column precio type numeric(10,2) using precio::numeric(10,2);

/***********************************F-SCP-FFP-TIE-1-19/06/2021*****************************************/


/***********************************I-SCP-FFP-TIE-2-19/06/2021****************************************/

alter table tie.tproducto
    add id_marca integer;

/***********************************F-SCP-FFP-TIE-2-19/06/2021*****************************************/

/***********************************I-SCP-DZ-TIE-3-23/06/2021****************************************/
CREATE TABLE tie.tCategoria (
                                id_categoria serial NOT NULL,
                                nombre VARCHAR(50) NOT NULL,
                                color VARCHAR(50) NOT NULL,
                                CONSTRAINT pk_tcategoria__id_categoria PRIMARY KEY(id_categoria)
) INHERITS (pxp.tbase);
/***********************************F-SCP-DZ-TIE-3-23/06/2021*****************************************/


/***********************************I-SCP-FFP-TIE-3-23/06/2021****************************************/
CREATE TABLE tie.tproducto_categoria (
                                id_producto_categoria serial NOT NULL,
                                id_categoria integer,
                                id_producto integer,
                                CONSTRAINT pk_tproducto_categoria__id_producto_categoria PRIMARY KEY(id_producto_categoria)
) INHERITS (pxp.tbase);
/***********************************F-SCP-FFP-TIE-3-23/06/2021*****************************************/

/***********************************I-SCP-FFP-TIE-4-23/06/2021****************************************/
CREATE TABLE tie.tmovimiento (
                                 id_movimiento serial NOT NULL,
                                 id_producto integer,
                                 tipo varchar,
                                 cantidad_movida integer,
                                 CONSTRAINT pk_tmoviento_id PRIMARY KEY(id_movimiento)
) INHERITS (pxp.tbase);
/***********************************F-SCP-FFP-TIE-4-23/06/2021*****************************************/


/***********************************I-SCP-FFP-TIE-3-26/06/2021****************************************/

CREATE TABLE tie.tdosificacion (
                            id_dosificacion serial NOT NULL,
                            llave varchar,
                            fecha_ini date,
                            fecha_fin date,
                            nro_aut varchar,
                            nro_inicio varchar,
                            CONSTRAINT pk_tdosificacion__id_dosificacion PRIMARY KEY(id_dosificacion)
) INHERITS (pxp.tbase);

CREATE TABLE tie.tcliente (
                            id_cliente serial NOT NULL,
                            id_persona integer,
                            nit varchar,
                            razon_social varchar,
                            CONSTRAINT pk_tcliente__id_cliente PRIMARY KEY(id_cliente)
) INHERITS (pxp.tbase);


CREATE TABLE tie.tventa (
                             id_venta serial NOT NULL,
                             id_cliente integer,
                             id_periodo integer,
                             fecha date,
                             nro_fac integer,
                             nro_venta varchar,
                             total numeric,
                             CONSTRAINT pk_tventa__id_venta PRIMARY KEY(id_venta)
) INHERITS (pxp.tbase);

CREATE TABLE tie.tventa_detalle (
                             id_venta_detalle serial NOT NULL,
                             id_venta integer,
                             id_producto integer,
                             cantidad_vendida integer,
                             precio_unitario numeric(10,2),
                             precio_total numeric(10,2),
                             CONSTRAINT pk_tventa_detalle__id_venta_detalle PRIMARY KEY(id_venta_detalle)
) INHERITS (pxp.tbase);
/***********************************F-SCP-FFP-TIE-3-26/06/2021*****************************************/


/***********************************I-SCP-FFP-TIE-1-28/06/2021****************************************/
alter table tie.tventa
    add codigo_control varchar;


alter table tie.tdosificacion alter column nro_inicio type integer using nro_inicio::integer;


/***********************************F-SCP-FFP-TIE-1-28/06/2021*****************************************/

/***********************************I-SCP-FFP-TIE-1-02/07/2021****************************************/
alter table tie.tventa
    add id_dosificacion integer;
/***********************************F-SCP-FFP-TIE-1-02/07/2021*****************************************/


/***********************************I-SCP-ATB-TIE-1-21/07/2021****************************************/

alter table tie.tventa
    add id_proceso_wf integer;

alter table tie.tventa
    add id_estado_wf integer;

alter table tie.tventa
    add estado varchar;

alter table tie.tventa
    add nro_tramite varchar;

/***********************************F-SCP-ATB-TIE-1-21/07/2021*****************************************/