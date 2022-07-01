<?php

class ACTProducto extends ACTbase
{
    function listarProducto() {
        $this->objParam->defecto('ordenacion', 'id_producto');
        $this->objParam->defecto('dir_ordenacion', 'ASC');

        if($this->objParam->getParametro('id_marca') != '') {
            $this->objParam->addFiltro("tp.id_marca= ".$this->objParam->getParametro('id_marca'));
        }
        if($this->objParam->getParametro('id_producto') != '') {
            $this->objParam->addFiltro("tp.id_producto= ".$this->objParam->getParametro('id_producto'));
        }

        if ($this->objParam->getParametro('tipoReporte') == 'excel_grid' || $this->objParam->getParametro('tipoReporte') == 'pdf_grid') {
            $this->objReporte = new Reporte($this->objParam, $this);
            $this->res = $this->objReporte->generarReporteListado('MODProducto', 'listarProducto');
        } else {
            $this->objFunc = $this->create('MODProducto');
            $this->res = $this->objFunc->listarProducto($this->objParam);
        }


        $this->res->imprimirRespuesta($this->res->generarJson());

    }

    function insertarProducto() {
        $this->objFunc=$this->create('MODProducto');
        if($this->objParam->insertar('id_producto')){
            $this->res=$this->objFunc->insertarProducto($this->objParam);
        } else{
            $this->res=$this->objFunc->modificarProducto($this->objParam);
        }

        if($this->res->getTipo() != 'EXITO') {
            $this->res->imprimirRespuesta($this->res->generarJson());
            exit;
        }

        $data = $this->res->getDatos();
        $wsEvent = $data['v_ws_event'];


        $send = array(
            "tipo" => "enviarMensaje",
            "data" => array(
                "evento" => $wsEvent,
                "mensaje" => "tienes un nuevo producto"
            )
        );
        $res = $this->dispararEventoWS($send);


        $this->res->imprimirRespuesta($this->res->generarJson());
    }
    function eliminarProducto() {
        $this->objFunc=$this->create('MODProducto');
        $this->res=$this->objFunc->eliminarProducto($this->objParam);
        $this->res->imprimirRespuesta($this->res->generarJson());
    }
    function listarProductoConTipoRecord() {
        $this->objFunc=$this->create('MODProducto');
        $this->res=$this->objFunc->listarProductoConTipoRecord($this->objParam);
        $this->res->imprimirRespuesta($this->res->generarJson());
    }
    function listarProductoConJson() {
        $this->objFunc=$this->create('MODProducto');
        $this->res=$this->objFunc->listarProductoConJson($this->objParam);

        if($this->res->getTipo() != 'EXITO') {
            $this->res->imprimirRespuesta($this->res->generarJson());
            exit;
        }

        $data = $this->res->getDatos();
        $dataJSon = json_decode($data["json"]);
       /* $send = array(
            "total" => 0,
            "datos" => $dataJSon
        );*/
        $send =  json_encode($dataJSon, true);
        echo $send;

    }
}
?>