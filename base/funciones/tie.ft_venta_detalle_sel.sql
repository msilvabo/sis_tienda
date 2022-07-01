CREATE OR REPLACE FUNCTION "tie"."ft_venta_detalle_sel"(
    p_administrador integer, p_id_usuario integer, p_tabla character varying, p_transaccion character varying)
    RETURNS character varying AS
$BODY$
/**************************************************************************
 SISTEMA:        tie
 FUNCION:         tie.ft_venta_detalle_sel
 DESCRIPCION:    alguna descripción
 AUTOR:          (admin)
 FECHA:            17-04-2020 01:54:37
 COMENTARIOS:    
***************************************************************************
 HISTORIAL DE MODIFICACIONES:
#ISSUE                FECHA                AUTOR                DESCRIPCION
 #0                17-04-2020 01:54:37      Ivan Callapa Quiroz     Created
 #
 ***************************************************************************/

DECLARE

    v_consulta            varchar;
    v_parametros          record;
    v_nombre_funcion       text;
    v_resp                varchar;

BEGIN

    v_nombre_funcion = 'tie.ft_venta_detalle_sel';
    v_parametros = pxp.f_get_record(p_tabla);

    /*********************************    
     #TRANSACCION:  'TIE_VEDET_SEL'
     #DESCRIPCION:    Consulta de datos
     #AUTOR:        Ivan Callapa Quiroz
     #FECHA:        17-04-2020 01:54:37
    ***********************************/

    if(p_transaccion='TIE_VEDET_SEL')then
        begin
            v_consulta:= 'select tvd.id_venta_detalle ,
                           tvd.id_venta,
                           tvd.id_producto,
                           tvd.cantidad_vendida ,
                           tvd.precio_unitario ,
                           tvd.precio_total ,
                           tp.nombre,
                           tvd.estado_reg,
                           tvd.id_usuario_reg,
                           tvd.fecha_reg,
                           tvd.usuario_ai,
                           tvd.id_usuario_ai,
                           tvd.id_usuario_mod,
                           tvd.fecha_mod,
                           usu1.cuenta as usr_reg,
                           usu2.cuenta as usr_mod
                    FROM tie.tventa_detalle tvd
                             inner join segu.tusuario usu1 on usu1.id_usuario = tvd.id_usuario_reg
                             left join segu.tusuario usu2 on usu2.id_usuario = tvd.id_usuario_mod
                             inner join tie.tproducto tp on tp.id_producto =tvd.id_producto
                          where  ';

            --Definicion de la respuesta
            v_consulta:=v_consulta||v_parametros.filtro;
            --v_consulta:=v_consulta||' order by ' ||v_parametros.ordenacion|| ' ' || v_parametros.dir_ordenacion || ' limit ' || v_parametros.cantidad || ' offset ' || v_parametros.puntero;
            --Devuelve la respuesta
            return v_consulta;
        end;

        /*********************************
         #TRANSACCION:  'TIE_VEDET_CONT'
         #DESCRIPCION:    Conteo de registros
         #AUTOR:        Ivan Callapa Quiroz
         #FECHA:        17-04-2020 01:54:37
        ***********************************/

    elsif(p_transaccion='TIE_VEDET_CONT')then

        begin
            --Sentencia de la consulta de conteo de registros
            v_consulta:='select count(tvd.id_venta_detalle)
                        FROM tie.tventa_detalle tvd
                             inner join segu.tusuario usu1 on usu1.id_usuario = tvd.id_usuario_reg
                             left join segu.tusuario usu2 on usu2.id_usuario = tvd.id_usuario_mod
                             inner join tie.tproducto tp on tp.id_producto =tvd.id_producto
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
    LANGUAGE 'plpgsql' VOLATILE COST 100;
ALTER FUNCTION "tie"."ft_venta_detalle_sel"(integer, integer, character varying, character varying) OWNER TO postgres;


