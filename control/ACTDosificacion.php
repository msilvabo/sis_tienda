<?php

class ACTDosificacion extends ACTbase
{
    function listarDosificacion() {
        $this->objParam->defecto('ordenacion', 'id_dosificacion');
        $this->objParam->defecto('dir_ordenacion', 'ASC');

        if($this->objParam->getParametro('id_dosificacion') != '') {
            $this->objParam->addFiltro("td.id_dosificacion= ".$this->objParam->getParametro('id_dosificacion'));
        }

        if ($this->objParam->getParametro('tipoReporte') == 'excel_grid' || $this->objParam->getParametro('tipoReporte') == 'pdf_grid') {
            $this->objReporte = new Reporte($this->objParam, $this);
            $this->res = $this->objReporte->generarReporteListado('MODDosificacion', 'listarDosificacion');
        } else {
            $this->objFunc = $this->create('MODDosificacion');
            $this->res = $this->objFunc->listarDosificacion($this->objParam);

        }
        $this->res->imprimirRespuesta($this->res->generarJson());

    }

    function insertarDosificacion() {
        $this->objFunc=$this->create('MODDosificacion');
        if($this->objParam->insertar('id_dosificacion')){
            $this->res=$this->objFunc->insertarDosificacion($this->objParam);
        } else{
            $this->res=$this->objFunc->modificarDosificacion($this->objParam);
        }
        $this->res->imprimirRespuesta($this->res->generarJson());
    }
    function eliminarDosificacion() {
        $this->objFunc=$this->create('MODDosificacion');
        $this->res=$this->objFunc->eliminarDosificacion($this->objParam);
        $this->res->imprimirRespuesta($this->res->generarJson());
    }
}
?>