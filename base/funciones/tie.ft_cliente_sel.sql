--------------- SQL ---------------

CREATE OR REPLACE FUNCTION tie.ft_cliente_sel (
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
BEGIN
    v_nombre_funcion = 'tie.ft_cliente_sel';
    v_parametros = pxp.f_get_record(p_tabla);
    if(p_transaccion='TIE_CLIENTE_SEL')then
        begin
            v_consulta:= 'select c.id_cliente,
                          c.id_persona,
                          c.nit,
                          c.razon_social,
                          p.nombre,
                          p.nombre_completo2::varchar AS desc_person


                          FROM tie.tcliente c
                         inner join segu.tusuario usu1 on usu1.id_usuario = c.id_usuario_reg
                         left join segu.tusuario usu2 on usu2.id_usuario = c.id_usuario_mod
                         left join segu.vpersona p on p.id_persona=c.id_persona
                          where  ';

--Definicion de la respuesta
            v_consulta:=v_consulta||v_parametros.filtro;
            v_consulta:=v_consulta||' order by ' ||v_parametros.ordenacion|| ' ' || v_parametros.dir_ordenacion || ' limit ' || v_parametros.cantidad || ' offset ' || v_parametros.puntero;

            --Devuelve la respuesta
            return v_consulta;

        end;

        /*********************************
         #TRANSACCION:  'TIE_CLIENTE_CONT'
         #DESCRIPCION:    Conteo de registros
         #AUTOR:        Favio Figueroa
         #FECHA:        17-04-2020 01:54:37
        ***********************************/

    elsif(p_transaccion='TIE_CLIENTE_CONT')then

        begin
            --Sentencia de la consulta de conteo de registros
            v_consulta:='select count(c.id_cliente)
                        FROM tie.tcliente c
                         inner join segu.tusuario usu1 on usu1.id_usuario = c.id_usuario_reg
                         left join segu.tusuario usu2 on usu2.id_usuario = c.id_usuario_mod
                         left join segu.tpersona p on p.id_persona=c.id_persona
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
$body$
    LANGUAGE 'plpgsql'
    VOLATILE
    CALLED ON NULL INPUT
    SECURITY INVOKER
    PARALLEL UNSAFE
    COST 100;