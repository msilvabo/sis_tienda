<?php
/**
 *@package pXP
 *@file gen-MODDevweb.php
 *@author  (admin)
 *@date 04-07-2016 15:19:06
 *@description Clase que envia los parametros requeridos a la Base de datos para la ejecucion de las funciones, y que recibe la respuesta del resultado de la ejecucion de las mismas
 */

class MODCategoria extends MODbase
{

    function __construct(CTParametro $pParam)
    {
        parent::__construct($pParam);
    }

    function listarCategoria(){
        //Definicion de variables para ejecucion del procedimientp
        $this->procedimiento='tie.ft_categoria_sel';
        $this->transaccion='TIE_CATEGORIA_SEL';
        $this->tipo_procedimiento='SEL';//tipo de transaccion


        //Definicion de la lista del resultado del query
        $this->captura('id_categoria','int4');
        $this->captura('estado_reg','varchar');
        $this->captura('nombre','varchar');
        $this->captura('color','varchar');
        $this->captura('id_usuario_reg','int4');
        $this->captura('fecha_reg','timestamp');
        $this->captura('usuario_ai','varchar');
        $this->captura('id_usuario_ai','int4');
        $this->captura('id_usuario_mod','int4');
        $this->captura('fecha_mod','timestamp');
        $this->captura('usr_reg','varchar');
        $this->captura('usr_mod','varchar');
        $this->captura('desc_archivo_tiecat','varchar');
        $this->captura('folder','varchar');
        $this->captura('extension','varchar');

        //Ejecuta la instruccion
        $this->armarConsulta();
        $this->ejecutarConsulta();

        //Devuelve la respuesta
        return $this->respuesta;
    }

    function insertarCategoria() {
        $this->procedimiento='tie.ft_categoria_ime';
        $this->transaccion='TIE_CATEGORIA_INS';
        $this->tipo_procedimiento='IME';

        $this->setParametro('id_categoria','id_categoria','int4');
        $this->setParametro('nombre','nombre','varchar');
        $this->setParametro('color','color','varchar');

        //Ejecuta la instruccion
        $this->armarConsulta();
        $this->ejecutarConsulta();

        //Devuelve la respuesta
        return $this->respuesta;

    }
    function modificarCategoria() {
        $this->procedimiento='tie.ft_categoria_ime';
        $this->transaccion='TIE_CATEGORIA_MOD';
        $this->tipo_procedimiento='IME';

        $this->setParametro('id_categoria','id_categoria','int4');
        $this->setParametro('nombre','nombre','varchar');
        $this->setParametro('color','color','varchar');

        //Ejecuta la instruccion
        $this->armarConsulta();
        $this->ejecutarConsulta();

        //Devuelve la respuesta
        return $this->respuesta;

    }
    function eliminarMarca() {
        $this->procedimiento='tie.ft_categoria_ime';
        $this->transaccion='TIE_CATEGORIA_ELI';
        $this->tipo_procedimiento='IME';

        $this->setParametro('id_categoria','id_categoria','int4');

        //Ejecuta la instruccion
        $this->armarConsulta();
        $this->ejecutarConsulta();

        //Devuelve la respuesta
        return $this->respuesta;

    }




}
?>