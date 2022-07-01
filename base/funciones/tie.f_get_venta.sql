CREATE OR REPLACE FUNCTION tie.f_get_venta(
    p_id_venta integer
)
    RETURNS json AS
$body$
DECLARE

    v_resp           varchar;
    v_nombre_funcion varchar;
    v_json    json;

BEGIN
    v_nombre_funcion := 'tie.f_get_venta';


    WITH t_venta AS (
        SELECT tv.*, td.nro_aut
        FROM tie.tventa tv
        inner join tie.tdosificacion td on td.id_dosificacion = tv.id_dosificacion
        WHERE tv.id_venta = p_id_venta limit 1
    ), t_venta_detalle AS (
        select *, tp.nombre as desc_producto
        from tie.tventa_detalle tvd
                 inner join t_venta tv on tv.id_venta = tvd.id_venta
                 inner join tie.tproducto tp on tp.id_producto = tvd.id_producto
    ), t_cliente AS (
        select * from tie.tcliente tc
                          inner join t_venta tv on tv.id_cliente = tc.id_cliente
    )
    SELECT (
               (
                   SELECT to_json(venta)
                   FROM (
                            SELECT *,
                                   (
                                       SELECT array_to_json(ARRAY_AGG(row_to_json(venta_detalle)))
                                       FROM (SELECT * FROM t_venta_detalle tv) AS venta_detalle
                                   ) vd,
                                   (
                                       select to_json(cliente) FROM  (SELECT * from t_cliente) cliente
                                   ) cli,
                                   (select sum(precio_total) from t_venta_detalle) as precio_venta_total
                            FROM t_venta
                        ) venta
               )
           ) AS datos into v_json;


    RETURN v_json;


EXCEPTION

    WHEN OTHERS THEN
        v_resp = '';
        v_resp = pxp.f_agrega_clave(v_resp, 'mensaje', SQLERRM);
        v_resp = pxp.f_agrega_clave(v_resp, 'codigo_error', SQLSTATE);
        v_resp = pxp.f_agrega_clave(v_resp, 'procedimientos', v_nombre_funcion);
        RAISE EXCEPTION '%',v_resp;

END ;
$body$
    LANGUAGE 'plpgsql'
    VOLATILE
    CALLED ON NULL INPUT
    SECURITY INVOKER
    COST 100;