<?php

class ACTProductoCategoria extends ACTbase
{
    function listarProductoCategoria() {
        $this->objParam->defecto('ordenacion', 'id_categoria');
        $this->objParam->defecto('dir_ordenacion', 'ASC');

        if($this->objParam->getParametro('id_producto') != '') {
            $this->objParam->addFiltro("tpc.id_producto= ".$this->objParam->getParametro('id_producto'));
        }

        if ($this->objParam->getParametro('tipoReporte') == 'excel_grid' || $this->objParam->getParametro('tipoReporte') == 'pdf_grid') {
            $this->objReporte = new Reporte($this->objParam, $this);
            $this->res = $this->objReporte->generarReporteListado('MODProductoCategoria', 'listarProductoCategoria');
        } else {
            $this->objFunc = $this->create('MODProductoCategoria');
            $this->res = $this->objFunc->listarProductoCategoria($this->objParam);

        }
        $this->res->imprimirRespuesta($this->res->generarJson());

    }
}
?>