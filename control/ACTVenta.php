<?php

require_once(dirname(__FILE__).'/../reporte/RReporteVenta.php');

class ACTVenta extends ACTbase
{
    function listarVenta() {
        $this->objParam->defecto('ordenacion', 'id_venta');
        $this->objParam->defecto('dir_ordenacion', 'ASC');

        if ($this->objParam->getParametro('estado') != '') {
            $estado = $this->objParam->getParametro('estado');
            $this->objParam->addFiltro("tv.estado = ''$estado''");
        }

        if ($this->objParam->getParametro('tipoReporte') == 'excel_grid' || $this->objParam->getParametro('tipoReporte') == 'pdf_grid') {
            $this->objReporte = new Reporte($this->objParam, $this);
            $this->res = $this->objReporte->generarReporteListado('MODVenta', 'listarVenta');
        } else {
            $this->objFunc = $this->create('MODVenta');
            $this->res = $this->objFunc->listarVenta($this->objParam);

        }
        $this->res->imprimirRespuesta($this->res->generarJson());

    }

    function insertarVenta() {
        
        $this->objFunc=$this->create('MODVenta');
        if($this->objParam->insertar('id_venta')){
            $this->res=$this->objFunc->insertarVenta($this->objParam);
        } else{
            $this->res=$this->objFunc->modificarVenta($this->objParam);
        }
        $this->res->imprimirRespuesta($this->res->generarJson());
    }

    function siguienteEstadoVenta() {
        $this->objFunc=$this->create('MODVenta');
        $this->objParam->addParametro('id_funcionario_usu',$_SESSION["ss_id_funcionario"]);
        $this->res=$this->objFunc->siguienteEstadoVenta($this->objParam);        
        $this->res->imprimirRespuesta($this->res->generarJson());
    }

    function anteriorEstadoVenta() {
        $this->objFunc=$this->create('MODVenta');
        $this->objParam->addParametro('id_funcionario_usu',$_SESSION["ss_id_funcionario"]);
        $this->res=$this->objFunc->anteriorEstadoVenta($this->objParam);        
        $this->res->imprimirRespuesta($this->res->generarJson());
    }
    function eliminarVenta() {
        $this->objFunc=$this->create('MODVenta');
        $this->res=$this->objFunc->eliminarVenta($this->objParam);
        $this->res->imprimirRespuesta($this->res->generarJson());
    }

    function generarVenta() {

        //p: {"start":"0","limit":"50","sort":"id_venta","dir":"ASC","contenedor":"docs-VT"}

        $this->objParam->addFiltro("tv.id_venta= ".$this->objParam->getParametro('id_venta'));
        $this->objFunc=$this->create('MODVenta');
        $this->res=$this->objFunc->listarVenta($this->objParam);

        if($this->res->getTipo() != 'EXITO'){
            $this->res->imprimirRespuesta($this->res->generarJson());
            exit;
        }

        $dataVenta = $this->res->getDatos();


        //obtener venta detalle

        $this->objParam->parametros_consulta['filtro'] = ' 0 = 0 ';
        $this->objParam->addFiltro("tvd.id_venta = ".$dataVenta[0]['id_venta']." ");
        $this->objFunc = $this->create('MODVentaDetalle');
        $this->res = $this->objFunc->listarVentaDetalle($this->objParam);

        if($this->res->getTipo() != 'EXITO'){
            $this->res->imprimirRespuesta($this->res->generarJson());
            exit;
        }
        $dataVentaDetalle = $this->res->getDatos();


        //obtener dosificacion

        $this->objParam->defecto('dir_ordenacion', 'ASC');
        $this->objParam->parametros_consulta['ordenacion'] = 'id_dosificacion';


        $this->objParam->parametros_consulta['filtro'] = ' 0 = 0 ';
        $this->objParam->addFiltro("td.id_dosificacion = ".$dataVenta[0]['id_dosificacion']." ");


        $this->objFunc = $this->create('MODDosificacion');
        $this->res = $this->objFunc->listarDosificacion($this->objParam);

        if($this->res->getTipo() != 'EXITO'){
            $this->res->imprimirRespuesta($this->res->generarJson());
            exit;
        }
        $dataDosificacion = $this->res->getDatos();



        //$arrRes = array("venta" => $dataVenta, "venta_detalle" => $dataVentaDetalle, "dosificacion" => $dataDosificacion);


        $nombre_archivo = $dataVenta[0]['nro_fac'].'_'.$dataVenta[0]['id_venta'].'.pdf';
        $this->objParam->addParametro('nombre_archivo', $nombre_archivo);

        $this->objReporteVenta = new RReporteVenta($this->objParam);

        $this->objReporteVenta->factura($dataVenta, $dataVentaDetalle, $dataDosificacion);

        $temp['pdfs'] = $nombre_archivo;
        $this->res->setDatos($temp);
        $this->res->imprimirRespuesta($this->res->generarJson());


    }


    function generarVentaJson() {
        $this->objFunc=$this->create('MODVenta');
        $this->res=$this->objFunc->generarventaJson($this->objParam);
        if($this->res->getTipo() != 'EXITO'){
            $this->res->imprimirRespuesta($this->res->generarJson());
            exit;
        }
        $data = $this->res->getDatos();
        $dataJson = json_decode($data["json"]);

        $nombre_archivo = $dataJson->nro_fac.'_'.$dataJson->id_venta.'.pdf';
        $this->objParam->addParametro('nombre_archivo', $nombre_archivo);

        $this->objReporteVenta = new RReporteVenta($this->objParam);

        $this->objReporteVenta->facturaJson($dataJson);

        $temp['pdfs'] = $nombre_archivo;
        $data["json"] = $nombre_archivo;

        $this->res->setDatos($temp);
        $this->res->imprimirRespuesta($this->res->generarJson());


    }
    
}
?>