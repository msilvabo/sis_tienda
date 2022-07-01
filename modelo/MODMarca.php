<?php
/**
 *@package pXP
 *@file gen-MODDevweb.php
 *@author  (admin)
 *@date 04-07-2016 15:19:06
 *@description Clase que envia los parametros requeridos a la Base de datos para la ejecucion de las funciones, y que recibe la respuesta del resultado de la ejecucion de las mismas
 */

class MODMarca extends MODbase
{

    function __construct(CTParametro $pParam)
    {
        parent::__construct($pParam);
    }

    function listarMarca(){
        //Definicion de variables para ejecucion del procedimientp
        $this->procedimiento='tie.ft_marca_sel';
        $this->transaccion='TIE_MARCA_SEL';
        $this->tipo_procedimiento='SEL';//tipo de transaccion

        
        //Definicion de la lista del resultado del query
        $this->captura('id_marca','int4');
        $this->captura('estado_reg','varchar');
        $this->captura('nombre','varchar');
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

    function insertarMarca() {
        $this->procedimiento='tie.ft_marca_ime';
        $this->transaccion='TIE_MARCA_INS';
        $this->tipo_procedimiento='IME';

        $this->setParametro('id_marca','id_marca','int4');
        $this->setParametro('nombre','nombre','varchar');

        //Ejecuta la instruccion
        $this->armarConsulta();
        $this->ejecutarConsulta();

        //Devuelve la respuesta
        return $this->respuesta;

    }
    function modificarMarca() {
        $this->procedimiento='tie.ft_marca_ime';
        $this->transaccion='TIE_MARCA_MOD';
        $this->tipo_procedimiento='IME';

        $this->setParametro('id_marca','id_marca','int4');
        $this->setParametro('nombre','nombre','varchar');

        //Ejecuta la instruccion
        $this->armarConsulta();
        $this->ejecutarConsulta();

        //Devuelve la respuesta
        return $this->respuesta;

    }
    function eliminarMarca() {
        $this->procedimiento='tie.ft_marca_ime';
        $this->transaccion='TIE_MARCA_ELI';
        $this->tipo_procedimiento='IME';

        $this->setParametro('id_marca','id_marca','int4');

        //Ejecuta la instruccion
        $this->armarConsulta();
        $this->ejecutarConsulta();

        //Devuelve la respuesta
        return $this->respuesta;

    }
    function marcaJson() {
        $this->procedimiento='tie.ft_marca_ime';
        $this->transaccion='TIE_MARCA_JSON';
        $this->tipo_procedimiento='IME';

        $this->setParametro('id_marca','id_marca','int4');

        //Ejecuta la instruccion
        $this->armarConsulta();
        $this->ejecutarConsulta();

        //Devuelve la respuesta
        return $this->respuesta;

    }



    
}
?>