CREATE OR REPLACE FUNCTION "tie"."ft_marca_sel"(
    p_administrador integer, p_id_usuario integer, p_tabla character varying, p_transaccion character varying)
    RETURNS character varying AS
$BODY$
/**************************************************************************
 SISTEMA:        tie
 FUNCION:         tie.ft_marca_sel
 DESCRIPCION:    alguna descripción
 AUTOR:          (admin)
 FECHA:            17-04-2020 01:54:37
 COMENTARIOS:    
***************************************************************************
 HISTORIAL DE MODIFICACIONES:
#ISSUE                FECHA                AUTOR                DESCRIPCION
 #0                17-04-2020 01:54:37      Favio Figueroa                     Created
 #
 ***************************************************************************/

DECLARE

    v_consulta            varchar;
    v_parametros          record;
    v_nombre_funcion       text;
    v_resp                varchar;

BEGIN

    v_nombre_funcion = 'decr.ft_liquidacion_sel';
    v_parametros = pxp.f_get_record(p_tabla);

    /*********************************    
     #TRANSACCION:  'TIE_MARCA_SEL'
     #DESCRIPCION:    Consulta de datos
     #AUTOR:        Favio Figueroa
     #FECHA:        17-04-2020 01:54:37
    ***********************************/

    if(p_transaccion='TIE_MARCA_SEL')then


        begin

            v_consulta:= 'select tm.id_marca,
						tm.estado_reg,
						tm.nombre,
						tm.id_usuario_reg,
						tm.fecha_reg,
						tm.usuario_ai,
						tm.id_usuario_ai,
						tm.id_usuario_mod,
						tm.fecha_mod,
						usu1.cuenta as usr_reg,
						usu2.cuenta as usr_mod
                         FROM tie.tmarca tm
                         inner join segu.tusuario usu1 on usu1.id_usuario = tm.id_usuario_reg
                         left join segu.tusuario usu2 on usu2.id_usuario = tm.id_usuario_mod

                          where  ';

--Definicion de la respuesta
            v_consulta:=v_consulta||v_parametros.filtro;
            v_consulta:=v_consulta||' order by ' ||v_parametros.ordenacion|| ' ' || v_parametros.dir_ordenacion || ' limit ' || v_parametros.cantidad || ' offset ' || v_parametros.puntero;

            --Devuelve la respuesta
            return v_consulta;

        end;

        /*********************************
         #TRANSACCION:  'TIE_MARCA_CONT'
         #DESCRIPCION:    Conteo de registros
         #AUTOR:        Favio Figueroa
         #FECHA:        17-04-2020 01:54:37
        ***********************************/

    elsif(p_transaccion='TIE_MARCA_CONT')then

        begin
            --Sentencia de la consulta de conteo de registros
            v_consulta:='select count(tm.id_marca)
                        FROM tie.tmarca tm
                         inner join segu.tusuario usu1 on usu1.id_usuario = tm.id_usuario_reg
                         left join segu.tusuario usu2 on usu2.id_usuario = tm.id_usuario_mod
                          where  ';

            --Definicion de la respuesta
            v_consulta:=v_consulta||v_parametros.filtro;

            --Devuelve la respuesta
            return v_consulta;

        end;



    else

        raise exception 'Transaccion inexistente';

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
ALTER FUNCTION "tie"."ft_marca_sel"(integer, integer, character varying, character varying) OWNER TO postgres;


