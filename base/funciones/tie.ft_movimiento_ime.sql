CREATE OR REPLACE FUNCTION "tie"."ft_movimiento_ime"(
    p_administrador integer, p_id_usuario integer, p_tabla character varying, p_transaccion character varying)
    RETURNS character varying AS
$BODY$
DECLARE

    v_consulta            varchar;
    v_parametros          record;
    v_nombre_funcion       text;
    v_resp                varchar;
    v_id_movimiento              integer;
    v_categoria              record;
    v_sum_entrada   integer;
    v_sum_salida    integer;
    v_stock    integer;
BEGIN
    v_nombre_funcion = 'tie.ft_movimiento_ime';
    v_parametros = pxp.f_get_record(p_tabla);

    /*********************************
     #TRANSACCION:  'TIE_MOV_INS'
     #DESCRIPCION:    Insercion de registros
     #AUTOR:        admin
     #FECHA:        17-04-2020 01:52:57
    ***********************************/

    if(p_transaccion='TIE_MOV_INS')then

        begin
            INSERT into tie.tmovimiento(
                id_usuario_reg,
                id_usuario_mod,
                fecha_reg,
                fecha_mod,
                estado_reg,
                id_usuario_ai,
                usuario_ai,
                obs_dba,
                id_producto,
                tipo,
                cantidad_movida
            ) VALUES (
                         p_id_usuario,
                         null,
                         now(),
                         null,
                         'activo',
                         null,
                         null,
                         null,
                         v_parametros.id_producto,
                         v_parametros.tipo,
                         v_parametros.cantidad_movida
                     ) RETURNING id_movimiento into v_id_movimiento;




            v_resp = pxp.f_agrega_clave(v_resp,'mensaje','inserccion exitoso'||v_id_movimiento||')');
            v_resp = pxp.f_agrega_clave(v_resp,'v_id_categoria',v_id_movimiento::varchar);

            --Devuelve la respuesta
            return v_resp;

        end;

        /*********************************
         #TRANSACCION:  'TIE_MOV_ELI'
         #DESCRIPCION:    eliminar categoria
         #AUTOR:        admin
         #FECHA:        17-04-2020 01:52:57
        ***********************************/

    elsif(p_transaccion='TIE_MOV_ELI')then

        begin
            DELETE from tie.tmovimiento
            where id_movimiento = v_parametros.id_movimiento;



            v_resp = pxp.f_agrega_clave(v_resp,'mensaje','eliminado exitoso'||v_parametros.id_movimiento||')');
            v_resp = pxp.f_agrega_clave(v_resp,'v_id_movimiento',v_parametros.id_movimiento::varchar);

            --Devuelve la respuesta
            return v_resp;

        end;

        /*********************************
         #TRANSACCION:  'TIE_MOV_MOD'
         #DESCRIPCION:    ELIMINAR categoria
         #AUTOR:        favio figueroa
         #FECHA:        17-04-2020 01:52:57
        ***********************************/

    elsif(p_transaccion='TIE_MOV_MOD')then

        begin


            UPDATE tie.tmovimiento SET fecha_mod = now(),
                                      id_usuario_mod = p_id_usuario,
                                      id_producto = v_parametros.id_producto,
                                      tipo = v_parametros.tipo,
                                      cantidad_movida = v_parametros.cantidad_movida
            where id_movimiento = v_parametros.id_movimiento;


            v_resp = pxp.f_agrega_clave(v_resp,'mensaje','modificado exitoso'||v_parametros.id_movimiento||')');
            v_resp = pxp.f_agrega_clave(v_resp,'v_id_movimiento',v_parametros.id_movimiento::varchar);

            --Devuelve la respuesta
            return v_resp;

        end;


        /*********************************
         #TRANSACCION:  'TIE_MOV_MOD'
         #DESCRIPCION:    ELIMINAR categoria
         #AUTOR:        favio figueroa
         #FECHA:        17-04-2020 01:52:57
        ***********************************/

    elsif(p_transaccion='TIE_MOV_MOD')then

        begin


            UPDATE tie.tmovimiento SET fecha_mod = now(),
                                      id_usuario_mod = p_id_usuario,
                                      id_producto = v_parametros.id_producto,
                                      tipo = v_parametros.tipo,
                                      cantidad_movida = v_parametros.cantidad_movida
            where id_movimiento = v_parametros.id_movimiento;


            v_resp = pxp.f_agrega_clave(v_resp,'mensaje','modificado exitoso'||v_parametros.id_movimiento||')');
            v_resp = pxp.f_agrega_clave(v_resp,'v_id_movimiento',v_parametros.id_movimiento::varchar);

            --Devuelve la respuesta
            return v_resp;

        end;


        /*********************************
         #TRANSACCION:  'TIE_MOV_VS'
         #DESCRIPCION:   VER STOCK
         #AUTOR:        favio figueroa
         #FECHA:        17-04-2020 01:52:57
        ***********************************/

    elsif(p_transaccion='TIE_MOV_VS')then

        begin


            v_stock:= tie.f_ver_stock(v_parametros.id_producto);


            v_resp = pxp.f_agrega_clave(v_resp,'mensaje','modificado exitoso'||v_stock||')');
            v_resp = pxp.f_agrega_clave(v_resp,'v_stock',v_stock::varchar);

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
ALTER FUNCTION "tie"."ft_movimiento_ime"(integer, integer, character varying, character varying) OWNER TO postgres;
