CREATE OR REPLACE FUNCTION tie.ft_venta_ime(p_administrador integer, p_id_usuario integer, p_tabla character varying, p_transaccion character varying)
 RETURNS character varying
 LANGUAGE plpgsql
AS $function$
DECLARE

    v_consulta            varchar;
    v_parametros          record;
    v_nombre_funcion       text;
    v_resp                varchar;
    v_id_venta             integer;
   v_id_gestion             integer;
    v_venta               record;
    v_details_json          json;
    record_detail          record;
    v_periodo          record;
    v_dosificacion          record;
    v_codigo_control text;
    v_nro_fac integer;
    v_nit varchar;
    v_importe_total numeric(10,2) DEFAULT 0;
    v_stock integer;

    v_json json;
    v_venta_json json;
   v_num_tramite	varchar;
    v_id_proceso_wf	integer;
    v_id_estado_wf	integer;
     v_codigo_estado	varchar;
     v_id_estado_actual integer;
     v_codigo_tipo_pro  varchar;
     v_codigo_llave     varchar;
    v_registros_proc    record;
   v_codigo_estado_siguiente	varchar;
     
BEGIN
    v_nombre_funcion = 'tie.ft_venta_ime';
    v_parametros = pxp.f_get_record(p_tabla);

    /*********************************
     #TRANSACCION:  'TIE_VENTA_INS'
     #DESCRIPCION:    Insercion de registros
     #AUTOR:        admin
     #FECHA:        17-04-2020 01:52:57`
    ***********************************/

    if(p_transaccion='TIE_VENTA_INS')then

        begin


            v_periodo:= param.f_get_periodo_gestion(v_parametros.fecha::date);

            SELECT id_dosificacion,llave, nro_aut, nro_inicio
            INTO v_dosificacion
            FROM tie.tdosificacion
            WHERE fecha_ini <= now()::date
            AND fecha_fin >= now()::date
            FOR UPDATE;


            IF(v_dosificacion is null) then
                RAISE EXCEPTION '%', 'No tienes una dosificacion';
            END IF;

            v_nro_fac:= v_dosificacion.nro_inicio;

            select nit
            into v_nit
            from tie.tcliente
                where id_cliente = v_parametros.id_cliente;

            --CREATE FUNCTION f_gen_cod_control(llave_dosificacion character varying, autorizacion character varying, nro_factura character varying, nit character varying, fecha_emision character varying, monto_facturado numeric) RETURNS text

			select id_gestion into v_id_gestion
			from param.tgestion g
			where g.gestion = to_char(now(), 'YYYY')::integer;
		
			SELECT
             ps_num_tramite ,
             ps_id_proceso_wf ,
             ps_id_estado_wf ,
             ps_codigo_estado
          into
             v_num_tramite,
             v_id_proceso_wf,
             v_id_estado_wf,
             v_codigo_estado

        FROM wf.f_inicia_tramite(
             p_id_usuario,
             v_parametros._id_usuario_ai,
             v_parametros._nombre_usuario_ai,
             v_id_gestion,
             'VEN',
             NULL,
             NULL,
             'Venta '||v_parametros.nro_venta,
             v_parametros.nro_venta
             );


            INSERT into tie.tventa(
                id_usuario_reg,
                id_usuario_mod,
                fecha_reg,
                fecha_mod,
                estado_reg,
                id_usuario_ai,
                usuario_ai,
                obs_dba,
                id_cliente,
                id_periodo,
                fecha,
                nro_fac,
                nro_venta,
                total,
                                   id_dosificacion,
                nro_tramite,
                id_proceso_wf,
                id_estado_wf,
                estado
            ) VALUES (
                         p_id_usuario,
                         null,
                         now(),
                         null,
                         'activo',
                         null,
                         null,
                         null,
                         v_parametros.id_cliente,
                         v_periodo.po_id_periodo,
                         v_parametros.fecha,
                         v_nro_fac,
                         v_parametros.nro_venta,
                         null,
                         v_dosificacion.id_dosificacion,
                         v_num_tramite,
			             v_id_proceso_wf,
			             v_id_estado_wf,
			             v_codigo_estado
                     ) RETURNING id_venta into v_id_venta;



            /*
           details":"[{\"id_producto\":\"7\",\"precio_unitario\":12,\"precio_total\":12,\"cantidad_vendida\":1}]"}
           */
            FOR record_detail IN (SELECT json_array_elements(v_parametros.details::json) obj)
                LOOP

                v_stock:= tie.f_ver_stock(cast(record_detail.obj->>'id_producto' as integer));
                IF v_stock < cast(record_detail.obj->>'cantidad_vendida' as integer) then
                    RAISE EXCEPTION '%', 'ERROR TU PRODUCTO NO TIENE STOCK';
                END IF;

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
                                 cast(record_detail.obj->>'id_producto' as integer),
                                 'SALIDA',
                                 cast(record_detail.obj->>'cantidad_vendida' as integer)
                             );

                    v_importe_total:= v_importe_total + (cast(record_detail.obj->>'cantidad_vendida' as integer) * cast(record_detail.obj->>'precio_unitario' as numeric));
                    INSERT into tie.tventa_detalle (
                        id_usuario_reg,
                        id_usuario_mod,
                        fecha_reg,
                        fecha_mod,
                        estado_reg,
                        id_usuario_ai,
                        usuario_ai,
                        obs_dba,
                        id_venta,
                        id_producto,
                        cantidad_vendida,
                        precio_unitario,
                        precio_total
                    ) VALUES (
                                 p_id_usuario,
                                 null,
                                 now(),
                                 null,
                                 'activo',
                                 null,
                                 null,
                                 null,
                                 v_id_venta,
                                 cast(record_detail.obj->>'id_producto' as integer),
                                 cast(record_detail.obj->>'cantidad_vendida' as integer),
                                 cast(record_detail.obj->>'precio_unitario' as numeric),
                                 cast(record_detail.obj->>'precio_total' as numeric)

                             );

                END LOOP;


            v_codigo_control:= pxp.f_gen_cod_control(v_dosificacion.llave,
                                                     v_dosificacion.nro_aut,
                                                     v_nro_fac::varchar,
                                                     v_nit::varchar,
                                                     to_char(now()::date, 'YYYYMMDD')::VARCHAR,
                                                     round(v_importe_total::numeric, 0)
                                   );

           update tie.tventa set codigo_control = v_codigo_control
            where id_venta = v_id_venta;




            UPDATE tie.tdosificacion
            SET nro_inicio = nro_inicio + 1
            WHERE id_dosificacion = v_dosificacion.id_dosificacion;




            WITH t_venta AS (
                SELECT *
                FROM tie.tventa
                WHERE id_venta = v_id_venta limit 1
            ), t_venta_detalle AS (
                select *, tp.nombre as desc_producto
                from tie.tventa_detalle tvd
                         inner join t_venta tv on tv.id_venta = tvd.id_venta
                         inner join tie.tproducto tp on tp.id_producto = tvd.id_producto
            ), t_cliente AS (
                select * from tie.tcliente tc
                                  inner join t_venta tv on tv.id_cliente = tc.id_cliente
            )
            SELECT (
                       (
                           SELECT to_json(venta)
                           FROM (
                                    SELECT *,
                                           (
                                               SELECT array_to_json(ARRAY_AGG(row_to_json(venta_detalle)))
                                               FROM (SELECT * FROM t_venta_detalle tv) AS venta_detalle
                                           ) vd,
                                           (
                                               select to_json(cliente) FROM  (SELECT * from t_cliente) cliente
                                           ) cli,
                                           (select sum(precio_total) from t_venta_detalle) as precio_venta_total
                                    FROM t_venta
                                ) venta
                       )
                   ) AS datos into v_json;




            v_resp = pxp.f_agrega_clave(v_resp,'mensaje',v_json::varchar);
            v_resp = pxp.f_agrega_clave(v_resp,'v_id_venta',v_json::varchar);

            --Devuelve la respuesta
            return v_resp;

        end;



        /*********************************
         #TRANSACCION:  'TIE_GETVEN_JSON'
         #DESCRIPCION:    Generar venta json
         #AUTOR:        favio figueroa
         #FECHA:        17-04-2020 01:52:57
        ***********************************/

    elsif(p_transaccion='TIE_GETVEN_JSON')then

        begin


           v_venta_json := tie.f_get_venta(v_parametros.id_venta);


            v_resp = pxp.f_agrega_clave(v_resp,'mensaje',v_venta_json::varchar);
            v_resp = pxp.f_agrega_clave(v_resp,'json',v_venta_json::varchar);

            --Devuelve la respuesta
            return v_resp;

        end;
    
       /*********************************
         #TRANSACCION:  'TIE_VENTASIGES_MOD'
         #DESCRIPCION:    Cambiar la venta al siguiente estado
         #AUTOR:        favio figueroa
         #FECHA:        17-04-2020 01:52:57
        ***********************************/

    elsif(p_transaccion='TIE_VENTASIGES_MOD')then

        begin       
            -- hay que recuperar el supervidor que seria el estado inmediato,...
             v_id_estado_actual =  wf.f_registra_estado_wf(v_parametros.id_tipo_estado,
                                                             v_parametros.id_funcionario_wf,
                                                             v_parametros.id_estado_wf_act,
                                                             v_parametros.id_proceso_wf_act,
                                                             p_id_usuario,
                                                             v_parametros._id_usuario_ai,
                                                             v_parametros._nombre_usuario_ai
                                                             );
            select
                 te.codigo
                into
                 v_codigo_estado_siguiente
                from wf.ttipo_estado te
                where te.id_tipo_estado = v_parametros.id_tipo_estado;

            FOR v_registros_proc in ( select * from json_populate_recordset(null::wf.proceso_disparado_wf, v_parametros.json_procesos::json)) LOOP

               --get cdigo tipo proceso
               select
                  tp.codigo,
                  tp.codigo_llave
               into
                  v_codigo_tipo_pro,
                  v_codigo_llave
               from wf.ttipo_proceso tp
                where  tp.id_tipo_proceso =  v_registros_proc.id_tipo_proceso_pro;


               -- disparar creacion de procesos seleccionados

              SELECT
                       ps_id_proceso_wf,
                       ps_id_estado_wf,
                       ps_codigo_estado
                 into
                       v_id_proceso_wf,
                       v_id_estado_wf,
                       v_codigo_estado
              FROM wf.f_registra_proceso_disparado_wf(
                       p_id_usuario,
                       v_parametros._id_usuario_ai,
                       v_parametros._nombre_usuario_ai,
                       v_id_estado_actual,
                       v_registros_proc.id_funcionario_wf_pro,
                       v_registros_proc.id_depto_wf_pro,
                       v_registros_proc.obs_pro,
                       v_codigo_tipo_pro,
                       v_codigo_tipo_pro);           


           END LOOP;

           update tie.tventa 
           set estado = v_codigo_estado_siguiente,
           id_estado_wf = v_id_estado_actual
           where id_proceso_wf = v_parametros.id_proceso_wf_act;


            v_resp = pxp.f_agrega_clave(v_resp,'mensaje','Cambio de estado de venta realizado');
            v_resp = pxp.f_agrega_clave(v_resp,'operacion','cambio exitoso');

            --Devuelve la respuesta
            return v_resp;

        end;
    elseif(p_transaccion='TIE_VENTAANTES_MOD')then
        begin

        --------------------------------------------------
        --Retrocede al estado inmediatamente anterior
        -------------------------------------------------
       --recuperaq estado anterior segun Log del WF
          SELECT

             ps_id_tipo_estado,
             ps_id_funcionario,
             ps_id_usuario_reg,
             ps_id_depto,
             ps_codigo_estado,
             ps_id_estado_wf_ant
          into
             v_id_tipo_estado,
             v_id_funcionario,
             v_id_usuario_reg,
             v_id_depto,
             v_codigo_estado,
             v_id_estado_wf_ant
          FROM wf.f_obtener_estado_ant_log_wf(v_parametros.id_estado_wf);


          -- registra nuevo estado

          v_id_estado_actual = wf.f_registra_estado_wf(
              v_id_tipo_estado,
              v_id_funcionario,
              v_parametros.id_estado_wf,
              v_id_proceso_wf,
              p_id_usuario,
              v_parametros._id_usuario_ai,
              v_parametros._nombre_usuario_ai
             );
             
            update tie.tventa 
           set estado = v_codigo_estado,
           id_estado_wf = v_id_estado_actual
           where id_proceso_wf = v_parametros.id_proceso_wf;

         -- si hay mas de un estado disponible  preguntamos al usuario
            v_resp = pxp.f_agrega_clave(v_resp,'mensaje','Se realizo el cambio de estado)');
            v_resp = pxp.f_agrega_clave(v_resp,'operacion','cambio_exitoso');


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
$function$
;
