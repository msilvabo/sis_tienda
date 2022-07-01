<?php
/**
 *@package pXP
 *@file gen-MODDevweb.php
 *@author  (admin)
 *@date 04-07-2016 15:19:06
 *@description Clase que envia los parametros requeridos a la Base de datos para la ejecucion de las funciones, y que recibe la respuesta del resultado de la ejecucion de las mismas
 */

class MODCliente extends MODbase
{

    function __construct(CTParametro $pParam)
    {
        parent::__construct($pParam);
    }

    function listarCliente(){
        //Definicion de variables para ejecucion del procedimientp
        $this->procedimiento='tie.ft_cliente_sel';
        $this->transaccion='TIE_CLIENTE_SEL';
        $this->tipo_procedimiento='SEL';//tipo de transaccion


        //Definicion de la lista del resultado del query
        $this->captura('id_cliente','int4');
        $this->captura('id_persona','integer');
        $this->captura('nit','varchar');
        $this->captura('razon_social','varchar');
        $this->captura('nombre','varchar');
        $this->captura('desc_person','varchar');

        //Ejecuta la instruccion
        $this->armarConsulta();
        $this->ejecutarConsulta();

        //Devuelve la respuesta
        return $this->respuesta;
    }

    function insertarCliente() {
        $this->procedimiento='tie.ft_cliente_ime';
        $this->transaccion='TIE_CLIENTE_INS';
        $this->tipo_procedimiento='IME';

        $this->setParametro('id_persona','id_persona','int4');
        $this->setParametro('nit','nit','varchar');
        $this->setParametro('razon_social','razon_social','varchar');

        //Ejecuta la instruccion
        $this->armarConsulta();
        $this->ejecutarConsulta();

        //Devuelve la respuesta
        return $this->respuesta;

    }
    function modificarCliente() {
        $this->procedimiento='tie.ft_cliente_ime';
        $this->transaccion='TIE_CLIENTE_MOD';
        $this->tipo_procedimiento='IME';

        $this->setParametro('id_cliente','id_cliente','int4');
        $this->setParametro('id_persona','id_persona','int4');
        $this->setParametro('nit','nit','varchar');
        $this->setParametro('razon_social','razon_social','varchar');

        //Ejecuta la instruccion
        $this->armarConsulta();
        $this->ejecutarConsulta();

        //Devuelve la respuesta
        return $this->respuesta;

    }
    function eliminarCliente() {
        $this->procedimiento='tie.ft_cliente_ime';
        $this->transaccion='TIE_CLIENTE_ELI';
        $this->tipo_procedimiento='IME';

        $this->setParametro('id_cliente','id_cliente','int4');

        //Ejecuta la instruccion
        $this->armarConsulta();
        $this->ejecutarConsulta();

        //Devuelve la respuesta
        return $this->respuesta;

    }




}
?>