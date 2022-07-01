CREATE OR REPLACE FUNCTION "tie"."ft_producto_json"(
    p_administrador integer, p_id_usuario integer, p_tabla character varying, p_transaccion character varying)
    RETURNS character varying AS
$BODY$
DECLARE

    v_consulta            varchar;
    v_parametros          record;
    v_nombre_funcion       text;
    v_resp                varchar;
    v_id_producto              integer;
    v_categoria              record;
    v_producto_json           json;
    v_count           integer;
    v_bottom_filtro_value           varchar;
BEGIN
    v_nombre_funcion = 'tie.ft_producto_json';
    v_parametros = pxp.f_get_record(p_tabla);

    /*********************************
     #TRANSACCION:  'TIE_PRODUCTO_JSON'
     #DESCRIPCION:    Insercion de registros
     #AUTOR:        Ivan Callapa Quiroz
     #FECHA:        17-04-2020 01:52:57
    ***********************************/

    if(p_transaccion='TIE_PRODUCTO_JSON')then

        begin



            IF pxp.f_existe_parametro(p_tabla, 'bottom_filtro_value')
            THEN
                v_bottom_filtro_value := upper(v_parametros.bottom_filtro_value);
            END IF;


            select count(*)
            INTO v_count
            from tie.tproducto tp
            where (case when v_bottom_filtro_value is not NULL then upper(tp.nombre) like '%'||v_bottom_filtro_value|| '%' ELSE 1=1 END );

            WITH t_producto AS (
                SELECT tp.id_producto, tp.nombre, tp.precio
                FROM tie.tproducto tp
                where (case when v_bottom_filtro_value is not NULL then upper(tp.nombre) like '%'||v_bottom_filtro_value|| '%' ELSE 1=1 END )
                limit v_parametros.cantidad OFFSET v_parametros.puntero
            )
            SELECT to_json(row_to_json(jsonData))
            INTO v_producto_json
            FROM (
                     SELECT (
                                SELECT array_to_json(array_agg(row_to_json(t_pro_json)))
                                FROM (SELECT * FROM t_producto) t_pro_json
                            )       AS datos,
                            v_count AS total
                 ) jsonData;



            v_resp = pxp.f_agrega_clave(v_resp,'mensaje',v_producto_json::varchar);
            v_resp = pxp.f_agrega_clave(v_resp,'json',v_producto_json::varchar);
            v_resp = pxp.f_agrega_clave(v_resp,'v_id_producto',v_id_producto::varchar);

            --Devuelve la respuesta
            return v_resp;

        end;

    
    else

        raise exception 'Transaccion inexistente: %',p_transaccion;

    end if;

EXCEPTION

    WHEN OTHERS THEN
        v_resp='';
        v_resp = pxp.f_agrega_clave(v_resp,'mensaje',SQLERRM);
        v_resp = pxp.f_agrega_clave(v_resp,'codigo_error',SQLSTATE);
        v_resp = pxp.f_agrega_clave(v_resp,'procedimientos',v_nombre_funcion);
        raise exception '%',v_resp;

END;
$BODY$
    LANGUAGE 'plpgsql' VOLATILE
                       COST 100;
ALTER FUNCTION "tie"."ft_producto_json"(integer, integer, character varying, character varying) OWNER TO postgres;
