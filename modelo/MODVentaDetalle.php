<?php
/**
 *@package pXP
 *@file gen-MODDevweb.php
 *@author  (admin)
 *@date 04-07-2016 15:19:06
 *@description Clase que envia los parametros requeridos a la Base de datos para la ejecucion de las funciones, y que recibe la respuesta del resultado de la ejecucion de las mismas
 */

class MODVentaDetalle extends MODbase
{

    function __construct(CTParametro $pParam)
    {
        parent::__construct($pParam);
    }

    function listarVentaDetalle(){
        $this->procedimiento='tie.ft_venta_detalle_sel';
        $this->transaccion='TIE_VEDET_SEL';
        $this->tipo_procedimiento='SEL';//tipo de transaccion


        //Definicion de la lista del resultado del query
        $this->captura('id_venta_detalle','int4');
        $this->captura('id_venta','int4');
        $this->captura('id_producto','int4');
        $this->captura('cantidad_vendida','int4');
        $this->captura('precio_unitario','numeric');
        $this->captura('precio_total','numeric');
        $this->captura('nombre','varchar');
        $this->captura('estado_reg','varchar');
        $this->captura('id_usuario_reg','int4');
        $this->captura('fecha_reg','timestamp');
        $this->captura('usuario_ai','varchar');
        $this->captura('id_usuario_ai','int4');
        $this->captura('id_usuario_mod','int4');
        $this->captura('fecha_mod','timestamp');
        $this->captura('usr_reg','varchar');
        $this->captura('usr_mod','varchar');

        //Ejecuta la instruccion
        $this->armarConsulta();
        $this->ejecutarConsulta();

        //Devuelve la respuesta
        return $this->respuesta;
    }

    function insertarVentaDetalle() {
        $this->procedimiento='tie.ft_venta_detalle_ime';
        $this->transaccion='TIE_VENTADETALLE_INS';
        $this->tipo_procedimiento='IME';

        $this->setParametro('id_venta_detalle','id_venta_detalle','int4');
        $this->setParametro('id_venta','id_venta','int4');
        $this->setParametro('id_producto','id_producto','int4');
        $this->setParametro('cantidad_vendida','cantidad_vendida','int4');
        $this->setParametro('precio_unitario','precio_unitario','numeric');
        $this->setParametro('precio_total','precio_total','numeric');

        //Ejecuta la instruccion
        $this->armarConsulta();
        $this->ejecutarConsulta();

        //Devuelve la respuesta
        return $this->respuesta;

    }
    function modificarVentaDetalle() {
        $this->procedimiento='tie.ft_venta_detalle_ime';
        $this->transaccion='TIE_VENTADETALLE_MOD';
        $this->tipo_procedimiento='IME';

        $this->setParametro('id_venta_detalle','id_venta_detalle','int4');
        $this->setParametro('id_producto','id_producto','int4');
        $this->setParametro('cantidad_vendida','cantidad_vendida','int4');
        $this->setParametro('precio_unitario','precio_unitario','numeric');
        $this->setParametro('precio_total','precio_total','numeric');

        //Ejecuta la instruccion
        $this->armarConsulta();
        $this->ejecutarConsulta();

        //Devuelve la respuesta
        return $this->respuesta;

    }
    function eliminarVentaDetalle() {
        $this->procedimiento='tie.ft_venta_detalle_ime';
        $this->transaccion='TIE_VENTADETALLE_ELI';
        $this->tipo_procedimiento='IME';

        $this->setParametro('id_venta_detalle','id_venta_detalle','int4');

        //Ejecuta la instruccion
        $this->armarConsulta();
        $this->ejecutarConsulta();

        //Devuelve la respuesta
        return $this->respuesta;

    }
}
?>