CREATE OR REPLACE FUNCTION "tie"."ft_categoria_ime"(
    p_administrador integer, p_id_usuario integer, p_tabla character varying, p_transaccion character varying)
    RETURNS character varying AS
$BODY$
DECLARE

v_consulta            varchar;
    v_parametros          record;
    v_nombre_funcion       text;
    v_resp                varchar;
    v_id_categoria              integer;
    v_categoria              record;
BEGIN
    v_nombre_funcion = 'tie.ft_categoria.ime';
    v_parametros = pxp.f_get_record(p_tabla);

    /*********************************    
     #TRANSACCION:  'TIE_categoria_INS'
     #DESCRIPCION:    Insercion de registros
     #AUTOR:        admin    
     #FECHA:        17-04-2020 01:52:57
    ***********************************/

    if(p_transaccion='TIE_CATEGORIA_INS')then

begin
INSERT into tie.tcategoria(
    id_usuario_reg,
    id_usuario_mod,
    fecha_reg,
    fecha_mod,
    estado_reg,
    id_usuario_ai,
    usuario_ai,
    obs_dba,
    nombre,
    color
) VALUES (
             p_id_usuario,
             null,
             now(),
             null,
             'activo',
             null,
             null,
             null,
             v_parametros.nombre,
             v_parametros.color
             ) RETURNING id_categoria into v_id_categoria;



v_resp = pxp.f_agrega_clave(v_resp,'mensaje','inserccion exitoso'||v_id_categoria||')');
            v_resp = pxp.f_agrega_clave(v_resp,'v_id_categoria',v_id_categoria::varchar);

            --Devuelve la respuesta
return v_resp;

end;

    /*********************************
     #TRANSACCION:  'TIE_categoria_ELI'
     #DESCRIPCION:    eliminar categoria
     #AUTOR:        admin
     #FECHA:        17-04-2020 01:52:57
    ***********************************/

    elsif(p_transaccion='TIE_CATEGORIA_ELI')then

begin
DELETE from tie.tcategoria
where id_categoria = v_parametros.id_categoria;



v_resp = pxp.f_agrega_clave(v_resp,'mensaje','eliminado exitoso'||v_parametros.id_categoria||')');
            v_resp = pxp.f_agrega_clave(v_resp,'v_id_categoria',v_parametros.id_categoria::varchar);

            --Devuelve la respuesta
return v_resp;

end;

    /*********************************
     #TRANSACCION:  'TIE_categoria_MOD'
     #DESCRIPCION:    ELIMINAR categoria
     #AUTOR:        favio figueroa
     #FECHA:        17-04-2020 01:52:57
    ***********************************/

    elsif(p_transaccion='TIE_CATEGORIA_MOD')then

begin


UPDATE tie.tcategoria SET nombre = v_parametros.nombre,
                      fecha_mod = now(),
                      id_usuario_mod = p_id_usuario,
                      color = v_parametros.color
where id_categoria = v_parametros.id_categoria;


v_resp = pxp.f_agrega_clave(v_resp,'mensaje','modificado exitoso'||v_parametros.id_categoria||')');
            v_resp = pxp.f_agrega_clave(v_resp,'v_id_categoria',v_parametros.id_categoria::varchar);

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
ALTER FUNCTION "tie"."ft_categoria.ime"(integer, integer, character varying, character varying) OWNER TO postgres;
