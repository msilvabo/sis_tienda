<?php
/**
 *@package pXP
 *@file gen-MODDevweb.php
 *@author  (admin)
 *@date 04-07-2016 15:19:06
 *@description Clase que envia los parametros requeridos a la Base de datos para la ejecucion de las funciones, y que recibe la respuesta del resultado de la ejecucion de las mismas
 */

class MODDosificacion extends MODbase
{

    function __construct(CTParametro $pParam)
    {
        parent::__construct($pParam);
    }

    function listarDosificacion(){
        //Definicion de variables para ejecucion del procedimientp
        $this->procedimiento='tie.ft_dosificacion_sel';
        $this->transaccion='TIE_DOSI_SEL';
        $this->tipo_procedimiento='SEL';//tipo de transaccion


        //Definicion de la lista del resultado del query
        $this->captura('id_dosificacion','int4');
        $this->captura('llave','varchar');
        $this->captura('fecha_ini','date');
        $this->captura('fecha_fin','date');
        $this->captura('nro_aut','varchar');
        $this->captura('nro_inicio','int4');
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

    function insertarDosificacion() {
        $this->procedimiento='tie.ft_dosificacion_ime';
        $this->transaccion='TIE_DOSI_INS';
        $this->tipo_procedimiento='IME';

        $this->setParametro('id_dosificacion','id_dosificacion','int4');
        $this->setParametro('llave','llave','varchar');
        $this->setParametro('fecha_ini','fecha_ini','date');
        $this->setParametro('fecha_fin','fecha_fin','date');
        $this->setParametro('nro_aut','nro_aut','varchar');
        $this->setParametro('nro_inicio','nro_inicio','integer');


        //Ejecuta la instruccion
        $this->armarConsulta();
        $this->ejecutarConsulta();

        //Devuelve la respuesta
        return $this->respuesta;

    }
    function modificarDosificacion() {
        $this->procedimiento='tie.ft_dosificacion_ime';
        $this->transaccion='TIE_DOSI_MOD';
        $this->tipo_procedimiento='IME';

        $this->setParametro('id_dosificacion','id_dosificacion','int4');
        $this->setParametro('llave','llave','varchar');
        $this->setParametro('fecha_ini','fecha_ini','date');
        $this->setParametro('fecha_fin','fecha_fin','date');
        $this->setParametro('nro_aut','nro_aut','varchar');
        $this->setParametro('nro_inicio','nro_inicio','integer');

        //Ejecuta la instruccion
        $this->armarConsulta();
        $this->ejecutarConsulta();

        //Devuelve la respuesta
        return $this->respuesta;

    }
    function eliminarDosificacion() {
        $this->procedimiento='tie.ft_dosificacion_ime';
        $this->transaccion='TIE_DOSI_ELI';
        $this->tipo_procedimiento='IME';

        $this->setParametro('id_dosificacion','id_dosificacion','int4');

        //Ejecuta la instruccion
        $this->armarConsulta();
        $this->ejecutarConsulta();

        //Devuelve la respuesta
        return $this->respuesta;

    }

}
?>