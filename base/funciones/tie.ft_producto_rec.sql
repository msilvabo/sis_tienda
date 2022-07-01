CREATE OR REPLACE FUNCTION "tie"."ft_producto_rec"(
    p_administrador integer,
     p_id_usuario integer, 
     p_tabla character varying, 
     p_transaccion character varying)
    RETURNS setof record AS
$BODY$
/**************************************************************************
 SISTEMA:        tie
 FUNCION:         tie.ft_producto_rec
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
    v_registros_prod        record;

BEGIN



    if(p_transaccion='TIE_PRODUCTO2_SEL')then
        begin

            FOR v_registros_prod in (select tp.id_producto,
                                            tp.estado_reg,
                                            tp.nombre,tp.precio,
                                            tp.id_usuario_reg,
                                            tp.fecha_reg,
                                            tp.usuario_ai,
                                            tp.id_usuario_ai,
                                            tp.id_usuario_mod,
                                            tp.fecha_mod,
                                            usu1.cuenta as usr_reg,
                                            usu2.cuenta as usr_mod,
                                            tp.id_marca,
                                            tm.nombre as desc_marca,
                                            (select string_agg(tpc.id_categoria::text, ',')::varchar as id_categoria  from tie.tproducto_categoria tpc where tp.id_producto = tpc.id_producto),
                                            ta.nombre_archivo as desc_archivo_tiepro,
                                            ta.folder,
                                            ta.extension
                                     FROM tie.tproducto tp
                                              inner join segu.tusuario usu1 on usu1.id_usuario = tp.id_usuario_reg
                                              left join segu.tusuario usu2 on usu2.id_usuario = tp.id_usuario_mod
                                              inner join tie.tmarca tm on tm.id_marca = tp.id_marca
                                              left join param.tarchivo ta on ta.id_tabla = tp.id_producto and ta.id_archivo_fk is NOT NULL
                                              left join param.ttipo_archivo tta on tta.id_tipo_archivo = ta.id_tipo_archivo AND tta.codigo = 'TIEPRO') loop

                    RETURN NEXT v_registros_prod;
                END LOOP;

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
ALTER FUNCTION "tie"."ft_producto_rec"(integer, integer, character varying, character varying) OWNER TO postgres;


