<?php

class ACTCliente extends ACTbase
{
    function listarCliente() {
        $this->objParam->defecto('ordenacion', 'id_cliente');
        $this->objParam->defecto('dir_ordenacion', 'ASC');

        if ($this->objParam->getParametro('tipoReporte') == 'excel_grid' || $this->objParam->getParametro('tipoReporte') == 'pdf_grid') {
            $this->objReporte = new Reporte($this->objParam, $this);
            $this->res = $this->objReporte->generarReporteListado('MODCliente', 'listarCliente');
        } else {
            $this->objFunc = $this->create('MODCliente');
            $this->res = $this->objFunc->listarCliente($this->objParam);

        }
        $this->res->imprimirRespuesta($this->res->generarJson());

    }

    function insertarCliente() {
        $this->objFunc=$this->create('MODCliente');
        if($this->objParam->insertar('id_cliente')){
            $this->res=$this->objFunc->insertarCliente($this->objParam);
        } else{
            $this->res=$this->objFunc->modificarCliente($this->objParam);
        }
        $this->res->imprimirRespuesta($this->res->generarJson());
    }
    function eliminarCliente() {
        $this->objFunc=$this->create('MODCliente');
        $this->res=$this->objFunc->eliminarCliente($this->objParam);
        $this->res->imprimirRespuesta($this->res->generarJson());
    }
}
?>