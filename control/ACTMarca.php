<?php

class ACTMarca extends ACTbase
{
    function listarMarca() {
        $this->objParam->defecto('ordenacion', 'id_marca');
        $this->objParam->defecto('dir_ordenacion', 'ASC');

        if ($this->objParam->getParametro('tipoReporte') == 'excel_grid' || $this->objParam->getParametro('tipoReporte') == 'pdf_grid') {
            $this->objReporte = new Reporte($this->objParam, $this);
            $this->res = $this->objReporte->generarReporteListado('MODMarca', 'listarMarca');
        } else {
            $this->objFunc = $this->create('MODMarca');
            $this->res = $this->objFunc->listarMarca($this->objParam);


        }
        $this->res->imprimirRespuesta($this->res->generarJson());

    }

    function insertarMarca() {
        $this->objFunc=$this->create('MODMarca');
        if($this->objParam->insertar('id_marca')){
            $this->res=$this->objFunc->insertarMarca($this->objParam);
        } else{
            $this->res=$this->objFunc->modificarMarca($this->objParam);
        }

        if($this->res->getTipo() != 'EXITO') {
            $this->res->imprimirRespuesta($this->res->generarJson());
            exit;
        }

        $data = array(
            "evento" => "sis_marca_marca_nuevas_marcas",
            "mensaje" => "tienes una nueva marca"
        );
        $send = array(
            "tipo" => "enviarMensaje",
            "data" => $data
        );
        $res = $this->dispararEventoWS($send);

        $this->res->imprimirRespuesta($this->res->generarJson());
    }
    function eliminarMarca() {
        $this->objFunc=$this->create('MODMarca');
        $this->res=$this->objFunc->eliminarMarca($this->objParam);
        $this->res->imprimirRespuesta($this->res->generarJson());
    }
    function marcaJson() {
        $this->objFunc=$this->create('MODMarca');
        $this->res=$this->objFunc->marcaJson($this->objParam);
        $this->res->imprimirRespuesta($this->res->generarJson());
    }
}
?>