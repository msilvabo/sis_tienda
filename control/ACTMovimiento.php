<?php

class ACTMovimiento extends ACTbase
{
    function listarMovimiento() {
        $this->objParam->defecto('ordenacion', 'id_movimiento');
        $this->objParam->defecto('dir_ordenacion', 'ASC');

        if($this->objParam->getParametro('id_producto') != '') {
            $this->objParam->addFiltro("tmo.id_producto= ".$this->objParam->getParametro('id_producto'));
        }
        if($this->objParam->getParametro('tipo') != '') {
            $this->objParam->addFiltro("tmo.tipo= ''".$this->objParam->getParametro('tipo')."'' ");
        }

        if ($this->objParam->getParametro('tipoReporte') == 'excel_grid' || $this->objParam->getParametro('tipoReporte') == 'pdf_grid') {
            $this->objReporte = new Reporte($this->objParam, $this);
            $this->res = $this->objReporte->generarReporteListado('MODMovimiento', 'listarMovimiento');
        } else {
            $this->objFunc = $this->create('MODMovimiento');
            $this->res = $this->objFunc->listarMovimiento($this->objParam);
        }


        $this->res->imprimirRespuesta($this->res->generarJson());

    }

    function insertarMovimiento() {
        $this->objFunc=$this->create('MODMovimiento');
        if($this->objParam->insertar('id_movimiento')){
            $this->res=$this->objFunc->insertarMovimiento($this->objParam);
        } else{
            $this->res=$this->objFunc->modificarMovimiento($this->objParam);
        }
        $this->res->imprimirRespuesta($this->res->generarJson());
    }
    function eliminarMovimiento() {
        $this->objFunc=$this->create('MODMovimiento');
        $this->res=$this->objFunc->eliminarMovimiento($this->objParam);
        $this->res->imprimirRespuesta($this->res->generarJson());
    }
    function verStock() {
        $this->objFunc=$this->create('MODMovimiento');
        $this->res=$this->objFunc->verStock($this->objParam);
        $this->res->imprimirRespuesta($this->res->generarJson());
    }
}
?>