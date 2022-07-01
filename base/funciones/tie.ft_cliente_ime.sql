--------------- SQL ---------------

CREATE OR REPLACE FUNCTION tie.ft_cliente_ime (
    p_administrador integer,
    p_id_usuario integer,
    p_tabla varchar,
    p_transaccion varchar
)
    RETURNS varchar AS
$body$
DECLARE

    v_consulta            varchar;
    v_parametros          record;
    v_nombre_funcion       text;
    v_resp                varchar;
    v_id_cliente              integer;
    v_categoria              record;
BEGIN
    v_nombre_funcion = 'tie.ft_cliente_ime';
    v_parametros = pxp.f_get_record(p_tabla);

    /*********************************
     #TRANSACCION:  'TIE_CLIENTE_INS'
     #DESCRIPCION:    Insercion de registros
     #AUTOR:        admin
     #FECHA:        17-04-2020 01:52:57
    ***********************************/

    if(p_transaccion='TIE_CLIENTE_INS')then

        begin
            INSERT into tie.tcliente(
                id_usuario_reg,
                id_usuario_mod,
                fecha_reg,
                fecha_mod,
                estado_reg,
                id_usuario_ai,
                usuario_ai,
                obs_dba,
                id_persona,
                nit,
                razon_social

            ) VALUES (
                         p_id_usuario,
                         null,
                         now(),
                         null,
                         'activo',
                         null,
                         null,
                         null,
                         v_parametros.id_persona,
                         v_parametros.nit,
                         v_parametros.razon_social
                     ) RETURNING id_cliente into v_id_cliente;



            v_resp = pxp.f_agrega_clave(v_resp,'mensaje','inserccion exitoso'||v_id_cliente||')');
            v_resp = pxp.f_agrega_clave(v_resp,'v_id_categoria',v_id_cliente::varchar);

            --Devuelve la respuesta
            return v_resp;

        end;

        /*********************************
         #TRANSACCION:  'TIE_CLIENTE_ELI'
         #DESCRIPCION:    eliminar categoria
         #AUTOR:        admin
         #FECHA:        17-04-2020 01:52:57
        ***********************************/

    elsif(p_transaccion='TIE_CLIENTE_ELI')then

        begin
            DELETE from tie.tcliente
            where id_cliente = v_parametros.id_cliente;



            v_resp = pxp.f_agrega_clave(v_resp,'mensaje','eliminado exitoso'||v_parametros.id_cliente||')');
            v_resp = pxp.f_agrega_clave(v_resp,'v_id_categoria',v_parametros.id_cliente::varchar);

            --Devuelve la respuesta
            return v_resp;

        end;

        /*********************************
         #TRANSACCION:  'TIE_CLIENTE_MOD'
         #DESCRIPCION:    ELIMINAR categoria
         #AUTOR:        favio figueroa
         #FECHA:        17-04-2020 01:52:57
        ***********************************/

    elsif(p_transaccion='TIE_CLIENTE_MOD')then

        begin


            UPDATE tie.tcliente SET id_persona = v_parametros.id_persona,
                                    fecha_mod = now(),
                                    id_usuario_mod = p_id_usuario,
                                    nit = v_parametros.nit,
                                    razon_social = v_parametros.razon_social

            where id_cliente = v_parametros.id_cliente;


            v_resp = pxp.f_agrega_clave(v_resp,'mensaje','modificado exitoso'||v_parametros.id_cliente||')');
            v_resp = pxp.f_agrega_clave(v_resp,'v_id_categoria',v_parametros.id_cliente::varchar);

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
$body$
    LANGUAGE 'plpgsql'
    VOLATILE
    CALLED ON NULL INPUT
    SECURITY INVOKER
    PARALLEL UNSAFE
    COST 100;