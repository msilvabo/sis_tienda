CREATE OR REPLACE FUNCTION "tie"."ft_movimiento_sel"(
    p_administrador integer, p_id_usuario integer, p_tabla character varying, p_transaccion character varying)
    RETURNS character varying AS
$BODY$
DECLARE
    v_consulta            varchar;
    v_parametros          record;
    v_nombre_funcion       text;
    v_resp                varchar;
BEGIN
    v_nombre_funcion = 'tie.ft_movimiento_sel';
    v_parametros = pxp.f_get_record(p_tabla);
    if(p_transaccion='TIE_MOV_SEL')then
        begin
            v_consulta:= 'select tmo.id_movimiento,
						tmo.id_producto,
						tmo.tipo,
                        tmo.cantidad_movida,
						tmo.id_usuario_reg,
						tmo.fecha_reg,
						tmo.usuario_ai,
						tmo.id_usuario_ai,
						tmo.id_usuario_mod,
						tmo.fecha_mod,
						usu1.cuenta as usr_reg,
						usu2.cuenta as usr_mod
                         FROM tie.tmovimiento tmo
                         inner join segu.tusuario usu1 on usu1.id_usuario = tmo.id_usuario_reg
                         left join segu.tusuario usu2 on usu2.id_usuario = tmo.id_usuario_mod
                          where ';

--Definicion de la respuesta
            v_consulta:=v_consulta||v_parametros.filtro;
            v_consulta:=v_consulta||' order by ' ||v_parametros.ordenacion|| ' ' || v_parametros.dir_ordenacion || ' limit ' || v_parametros.cantidad || ' offset ' || v_parametros.puntero;

            --Devuelve la respuesta
            return v_consulta;

        end;

        /*********************************
         #TRANSACCION:  'TIE_MOV_CONT'
         #DESCRIPCION:    Conteo de registros
         #AUTOR:        Favio Figueroa
         #FECHA:        17-04-2020 01:54:37
        ***********************************/

    elsif(p_transaccion='TIE_MOV_CONT')then

        begin
            --Sentencia de la consulta de conteo de registros
            v_consulta:='select count(tmo.id_movimiento)
                        FROM tie.tmovimiento tmo
                         inner join segu.tusuario usu1 on usu1.id_usuario = tmo.id_usuario_reg
                         left join segu.tusuario usu2 on usu2.id_usuario = tmo.id_usuario_mod
                          where ';

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
ALTER FUNCTION "tie"."ft_movimiento_sel"(integer, integer, character varying, character varying) OWNER TO postgres;


