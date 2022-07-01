CREATE OR REPLACE FUNCTION "tie"."ft_venta_detalle_ime"(
    p_administrador integer, p_id_usuario integer, p_tabla character varying, p_transaccion character varying)
    RETURNS character varying AS
$BODY$
DECLARE

    v_consulta            varchar;
    v_parametros          record;
    v_nombre_funcion      text;
    v_resp                varchar;
    v_id_venta_detalle    integer;
    v_venta_detalle       record;
BEGIN
    v_nombre_funcion = 'tie.ft_venta_detalle_ime';
    v_parametros = pxp.f_get_record(p_tabla);

    if(p_transaccion='TIE_VENTADETALLE_INS')then

        begin
            INSERT into tie.tventa_detalle (
                id_usuario_reg,
                id_usuario_mod,
                fecha_reg,
                fecha_mod,
                estado_reg,
                id_usuario_ai,
                usuario_ai,
                obs_dba,
                id_venta,
                id_producto,
                cantidad_vendida,
                precio_unitario,
                precio_total
            ) VALUES (
                         p_id_usuario,
                         null,
                         now(),
                         null,
                         'activo',
                         null,
                         null,
                         null,
                         v_parametros.id_venta,
                         v_parametros.id_producto,
                         v_parametros.cantidad_vendida,
                         v_parametros.precio_unitario,
                         v_parametros.precio_total
                     ) RETURNING id_venta_detalle into v_id_venta_detalle;

            v_resp = pxp.f_agrega_clave(v_resp,'mensaje','insercion exitoso'||v_id_venta_detalle||')');
            v_resp = pxp.f_agrega_clave(v_resp,'v_id_venta_detalle',v_id_venta_detalle::varchar);

            --Devuelve la respuesta
            return v_resp;

        end;

    elsif(p_transaccion='TIE_VENTADETALLE_ELI')then

        begin
            DELETE from tie.tventa_detalle td
            where id_venta_detalle = v_parametros.id_venta_detalle;
            v_resp = pxp.f_agrega_clave(v_resp,'mensaje','eliminado exitoso'||v_parametros.id_venta_detalle||')');
            v_resp = pxp.f_agrega_clave(v_resp,'v_id_ventadetalle',v_parametros.id_venta_detalle::varchar);

            --Devuelve la respuesta
            return v_resp;

        end;

    elsif(p_transaccion='TIE_VENTADETALLE_MOD')then
        begin
            UPDATE tie.tventa_detalle SET id_producto = v_parametros.id_producto,
                                          cantidad_vendida = v_parametros.cantidad_vendida,
                                          precio_unitario = v_parametros.precio_unitario,
                                          precio_total = v_parametros.precio_total,
                                          fecha_mod = now(),
                                          id_usuario_mod = p_id_usuario
            where id_venta_detalle = v_parametros.id_venta_detalle;
            v_resp = pxp.f_agrega_clave(v_resp,'mensaje','modificado exitoso'||v_parametros.id_venta_detalle||')');
            v_resp = pxp.f_agrega_clave(v_resp,'v_id_ventadetalle',v_parametros.id_venta_detalle::varchar);
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
ALTER FUNCTION "tie"."ft_venta_detalle_ime"(integer, integer, character varying, character varying) OWNER TO postgres;
