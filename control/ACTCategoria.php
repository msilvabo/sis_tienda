<?php

class ACTCategoria extends ACTbase
{
    function listarCategoria() {
        $this->objParam->defecto('ordenacion', 'id_categoria');
        $this->objParam->defecto('dir_ordenacion', 'ASC');

        if ($this->objParam->getParametro('tipoReporte') == 'excel_grid' || $this->objParam->getParametro('tipoReporte') == 'pdf_grid') {
            $this->objReporte = new Reporte($this->objParam, $this);
            $this->res = $this->objReporte->generarReporteListado('MODCategoria', 'listarCategoria');
        } else {
            $this->objFunc = $this->create('MODCategoria');
            $this->res = $this->objFunc->listarCategoria($this->objParam);

        }
        $this->res->imprimirRespuesta($this->res->generarJson());

    }

    function insertarCategoria() {
        $this->objFunc=$this->create('MODCategoria');
        if($this->objParam->insertar('id_categoria')){
            $this->res=$this->objFunc->insertarCategoria($this->objParam);
        } else{
            $this->res=$this->objFunc->modificarCategoria($this->objParam);
        }
        $this->res->imprimirRespuesta($this->res->generarJson());
    }
    function eliminarCategoria() {
        $this->objFunc=$this->create('MODCategoria');
        $this->res=$this->objFunc->eliminarCategoria($this->objParam);
        $this->res->imprimirRespuesta($this->res->generarJson());
    }
}
?>