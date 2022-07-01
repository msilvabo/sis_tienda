CREATE OR REPLACE FUNCTION tie.f_ver_stock(
    p_id_producto integer
)
    RETURNS integer AS
$body$
DECLARE

    v_resp           varchar;
    v_nombre_funcion varchar;
    v_sum_entrada   integer;
    v_sum_salida    integer;
    v_stock    integer;

BEGIN
    v_nombre_funcion := 'tie.f_ver_stock';

    SELECT sum(cantidad_movida) as sum_entrada
    INTO v_sum_entrada
    FROM tie.tmovimiento
    WHERE tipo = 'ENTRADA'
      AND id_producto = p_id_producto;


    SELECT sum(cantidad_movida) as sum_salida
    into v_sum_salida
    FROM tie.tmovimiento
    WHERE tipo = 'SALIDA'
      AND id_producto = p_id_producto;

    v_stock:= v_sum_entrada - v_sum_salida;

    RETURN v_stock;


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