<?php
/**
 *@package pXP
 *@file gen-MODDevweb.php
 *@author  (admin)
 *@date 04-07-2016 15:19:06
 *@description Clase que envia los parametros requeridos a la Base de datos para la ejecucion de las funciones, y que recibe la respuesta del resultado de la ejecucion de las mismas
 */

class MODProductoCategoria extends MODbase
{

    function __construct(CTParametro $pParam)
    {
        parent::__construct($pParam);
    }

    function listarProductoCategoria(){
        //Definicion de variables para ejecucion del procedimientp
        $this->procedimiento='tie.ft_producto_categoria_sel';
        $this->transaccion='TIE_PRODCAT_SEL';
        $this->tipo_procedimiento='SEL';//tipo de transaccion


        //Definicion de la lista del resultado del query
        $this->captura('id_producto_categoria','int4');
        $this->captura('id_producto','int4');
        $this->captura('id_categoria','int4');
        $this->captura('estado_reg','varchar');
        $this->captura('id_usuario_reg','int4');
        $this->captura('fecha_reg','timestamp');
        $this->captura('usuario_ai','varchar');
        $this->captura('id_usuario_ai','int4');
        $this->captura('id_usuario_mod','int4');
        $this->captura('fecha_mod','timestamp');
        $this->captura('usr_reg','varchar');
        $this->captura('usr_mod','varchar');
        $this->captura('desc_categoria','varchar');


        //Ejecuta la instruccion
        $this->armarConsulta();
        $this->ejecutarConsulta();

        //Devuelve la respuesta
        return $this->respuesta;
    }





}
?>