<?php
/**
 *@package pXP
 *@file gen-MODDevweb.php
 *@author  (admin)
 *@date 04-07-2016 15:19:06
 *@description Clase que envia los parametros requeridos a la Base de datos para la ejecucion de las funciones, y que recibe la respuesta del resultado de la ejecucion de las mismas
 */

class MODMovimiento extends MODbase
{

    function __construct(CTParametro $pParam)
    {
        parent::__construct($pParam);
    }

    function listarMovimiento(){
        //Definicion de variables para ejecucion del procedimientp
        $this->procedimiento='tie.ft_movimiento_sel';
        $this->transaccion='TIE_MOV_SEL';
        $this->tipo_procedimiento='SEL';//tipo de transaccion


        //Definicion de la lista del resultado del query
        $this->captura('id_movimiento','int4');
        $this->captura('id_producto','int4');
        $this->captura('tipo','varchar');
        $this->captura('cantidad_movida','int4');
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

    function insertarMovimiento() {
        $this->procedimiento='tie.ft_movimiento_ime';
        $this->transaccion='TIE_MOV_INS';
        $this->tipo_procedimiento='IME';

        $this->setParametro('id_movimiento','id_movimiento','int4');
        $this->setParametro('id_producto','id_producto','int4');
        $this->setParametro('tipo','tipo','varchar');
        $this->setParametro('cantidad_movida','cantidad_movida','int4');


        //Ejecuta la instruccion
        $this->armarConsulta();
        $this->ejecutarConsulta();

        //Devuelve la respuesta
        return $this->respuesta;

    }
    function modificarMovimiento() {
        $this->procedimiento='tie.ft_movimiento_ime';
        $this->transaccion='TIE_MOV_MOD';
        $this->tipo_procedimiento='IME';

        $this->setParametro('id_movimiento','id_movimiento','int4');
        $this->setParametro('id_producto','id_producto','int4');
        $this->setParametro('tipo','tipo','varchar');
        $this->setParametro('cantidad_movida','cantidad_movida','int4');

        //Ejecuta la instruccion
        $this->armarConsulta();
        $this->ejecutarConsulta();

        //Devuelve la respuesta
        return $this->respuesta;

    }
    function eliminarMovimiento() {
        $this->procedimiento='tie.ft_movimiento_ime';
        $this->transaccion='TIE_MOV_ELI';
        $this->tipo_procedimiento='IME';

        $this->setParametro('id_movimiento','id_movimiento','int4');

        //Ejecuta la instruccion
        $this->armarConsulta();
        $this->ejecutarConsulta();

        //Devuelve la respuesta
        return $this->respuesta;

    }
    function verStock() {
        $this->procedimiento='tie.ft_movimiento_ime';
        $this->transaccion='TIE_MOV_VS';
        $this->tipo_procedimiento='IME';

        $this->setParametro('id_producto','id_producto','int4');

        //Ejecuta la instruccion
        $this->armarConsulta();
        $this->ejecutarConsulta();

        //Devuelve la respuesta
        return $this->respuesta;

    }




}
?>