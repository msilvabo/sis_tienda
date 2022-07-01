<?php

class ACTVentaDetalle extends ACTbase
{
    function listarVentaDetalle() {


        $this->objParam->defecto('ordenacion', 'id_venta_detalle');
        $this->objParam->defecto('dir_ordenacion', 'ASC');

        if($this->objParam->getParametro('id_venta') != '') {
            $this->objParam->addFiltro("tvd.id_venta= ".$this->objParam->getParametro('id_venta'));
        }

        if ($this->objParam->getParametro('tipoReporte') == 'excel_grid' || $this->objParam->getParametro('tipoReporte') == 'pdf_grid') {
            $this->objReporte = new Reporte($this->objParam, $this);
            $this->res = $this->objReporte->generarReporteListado('MODVentaDetalle', 'listarVentaDetalle');
        } else {
            $this->objFunc = $this->create('MODVentaDetalle');
            $this->res = $this->objFunc->listarVentaDetalle($this->objParam);

        }
        $this->res->imprimirRespuesta($this->res->generarJson());

    }

}
?>