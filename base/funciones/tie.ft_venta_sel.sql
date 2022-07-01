CREATE OR REPLACE FUNCTION tie.ft_venta_sel(p_administrador integer, p_id_usuario integer, p_tabla character varying, p_transaccion character varying)
 RETURNS character varying
 LANGUAGE plpgsql
AS $function$
DECLARE
    v_consulta            varchar;
    v_parametros          record;
    v_nombre_funcion       text;
    v_resp                varchar;
BEGIN
    v_nombre_funcion = 'decr.ft_liquidacion_sel';
    v_parametros = pxp.f_get_record(p_tabla);
    if(p_transaccion='TIE_VENTA_SEL')then
        begin
            v_consulta:= 'select tv.id_venta,
						tv.estado_reg,
						tv.id_cliente,
                        tv.id_periodo,
                        tv.fecha,
                        tv.nro_fac,
                        tv.nro_venta,
                        tv.total,
						tv.id_usuario_reg,
						tv.fecha_reg,
						tv.usuario_ai,
						tv.id_usuario_ai,
						tv.id_usuario_mod,
						tv.fecha_mod,
						usu1.cuenta as usr_reg,
						usu2.cuenta as usr_mod,
						tv.id_dosificacion,
						tv.id_estado_wf,
						tv.id_proceso_wf,
                        tv.estado,
						tv.nro_tramite
						 FROM tie.tventa tv
                         inner join segu.tusuario usu1 on usu1.id_usuario = tv.id_usuario_reg
                         left join segu.tusuario usu2 on usu2.id_usuario = tv.id_usuario_mod
                          where  ';

--Definicion de la respuesta
            v_consulta:=v_consulta||v_parametros.filtro;
            v_consulta:=v_consulta||' order by ' ||v_parametros.ordenacion|| ' ' || v_parametros.dir_ordenacion || ' limit ' || v_parametros.cantidad || ' offset ' || v_parametros.puntero;

            --Devuelve la respuesta
            return v_consulta;

        end;

        /*********************************
         #TRANSACCION:  'TIE_VENTA_CONT'
         #DESCRIPCION:    Conteo de registros
         #AUTOR:        Favio Figueroa
         #FECHA:        17-04-2020 01:54:37
        ***********************************/

    elsif(p_transaccion='TIE_VENTA_CONT')then

        begin
            --Sentencia de la consulta de conteo de registros
            v_consulta:='select count(tv.id_venta)
                        FROM tie.tventa tv
                         inner join segu.tusuario usu1 on usu1.id_usuario = tv.id_usuario_reg
                         left join segu.tusuario usu2 on usu2.id_usuario = tv.id_usuario_mod
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
$function$
;
