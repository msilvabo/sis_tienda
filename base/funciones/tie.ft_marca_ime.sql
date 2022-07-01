CREATE OR REPLACE FUNCTION "tie"."ft_marca_ime"(
    p_administrador integer, p_id_usuario integer, p_tabla character varying, p_transaccion character varying)
    RETURNS character varying AS
$BODY$
DECLARE

    v_consulta            varchar;
    v_parametros          record;
    v_nombre_funcion       text;
    v_resp                varchar;
    v_id_marca              integer;
BEGIN
    v_nombre_funcion = 'tie.ft_marca_ime';
    v_parametros = pxp.f_get_record(p_tabla);

    /*********************************    
     #TRANSACCION:  'TIE_MARCA_INS'
     #DESCRIPCION:    Insercion de registros
     #AUTOR:        admin    
     #FECHA:        17-04-2020 01:52:57
    ***********************************/

    if(p_transaccion='TIE_MARCA_INS')then
                    
        begin
            INSERT into tie.tmarca(
                id_usuario_reg,
                id_usuario_mod,
                fecha_reg,
                fecha_mod,
                estado_reg,
                id_usuario_ai,
                usuario_ai,
                obs_dba,
                nombre
            ) VALUES (
                      p_id_usuario,
                      null,
                      now(),
                      null,
                      'activo',
                      null,
                      null,
                      null,
                      v_parametros.nombre) RETURNING id_marca into v_id_marca;


            v_resp = pxp.f_agrega_clave(v_resp,'mensaje','inserccion exitoso'||v_id_marca||')');
            v_resp = pxp.f_agrega_clave(v_resp,'v_id_marca',v_id_marca::varchar);

            --Devuelve la respuesta
            return v_resp;

        end;

    /*********************************
     #TRANSACCION:  'TIE_MARCA_ELI'
     #DESCRIPCION:    eliminar marca
     #AUTOR:        admin
     #FECHA:        17-04-2020 01:52:57
    ***********************************/

    elsif(p_transaccion='TIE_MARCA_ELI')then

        begin
            DELETE from tie.tmarca
                where id_marca = v_parametros.id_marca;



            v_resp = pxp.f_agrega_clave(v_resp,'mensaje','eliminado exitoso'||v_parametros.id_marca||')');
            v_resp = pxp.f_agrega_clave(v_resp,'v_id_marca',v_parametros.id_marca::varchar);

            --Devuelve la respuesta
            return v_resp;

        end;

    /*********************************
     #TRANSACCION:  'TIE_MARCA_MOD'
     #DESCRIPCION:    ELIMINAR marca
     #AUTOR:        favio figueroa
     #FECHA:        17-04-2020 01:52:57
    ***********************************/

    elsif(p_transaccion='TIE_MARCA_MOD')then

        begin


            UPDATE tie.tmarca SET nombre = v_parametros.nombre,
                                  fecha_mod = now(),
                                  id_usuario_mod = p_id_usuario
                                  where id_marca = v_parametros.id_marca;


            v_resp = pxp.f_agrega_clave(v_resp,'mensaje','modificado exitoso'||v_parametros.id_marca||')');
            v_resp = pxp.f_agrega_clave(v_resp,'v_id_marca',v_parametros.id_marca::varchar);

            --Devuelve la respuesta
            return v_resp;

        end;


    /*********************************
     #TRANSACCION:  'TIE_MARCA_JSON'
     #DESCRIPCION:    PRUEBA DE JSON
     #AUTOR:        favio figueroa
     #FECHA:        17-04-2020 01:52:57
    ***********************************/

    elsif(p_transaccion='TIE_MARCA_JSON')then

        begin





            v_resp = pxp.f_agrega_clave(v_resp,'mensaje','modificado exitoso'||v_parametros.id_marca||')');
            v_resp = pxp.f_agrega_clave(v_resp,'v_id_marca',v_parametros.id_marca::varchar);

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
ALTER FUNCTION "tie"."ft_marca_ime"(integer, integer, character varying, character varying) OWNER TO postgres;
