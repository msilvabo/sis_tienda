<?php


class RReporteVenta extends MYPDF
{
    function __construct(CTParametro $objParam) {

        parent::__construct('P',
            'mm',
            'A4',
            true,
            'UTF-8',
            false,
            false);


        $this->objParam = $objParam;
        $this->url_archivo = "../../../reportes_generados/" . $this->objParam->getParametro('nombre_archivo');




    }

    function factura($dataVenta, $dataVentaDetalle, $dataDosificacion) {
        //setlocale(LC_ALL,"es_ES@euro","es_ES","esp");

        date_default_timezone_set('America/New_York'); // porq ue el servidor esta alojado en amazon


        $this->SetCreator('Favio Figueroa');
        $this->SetAuthor('Favio Figueroa');
        $this->SetTitle('venta');
        $this->SetSubject('venta');
        $this->SetKeywords('venta, PDF, venta, test, guide');

        $this->SetHeaderData('','','','venta: ', '');

        // set header and footer fonts
        $this->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
        $this->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));


        // set default monospaced font
        $this->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

        // set margins
        $this->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
        $this->SetHeaderMargin(PDF_MARGIN_HEADER);
        $this->SetFooterMargin(PDF_MARGIN_FOOTER);


        $this->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);
        // set image scale factor
        $this->setImageScale(PDF_IMAGE_SCALE_RATIO);

        // set font
        $this->SetFont('dejavusans', '', 10);

        $vacio = '';
        // add a page
        $this->AddPage();

        $nombre_archivo = $this->objParam->getParametro('nombre_archivo');


       $html = '<style>
table {
width: 100%;
font-size: 8px;
}
th{
border-bottom: 1pt solid black;
}

.border-blanco > td {
border-bottom: 1px solid white;
}


</style>';


        $html .= '
        
        <table>
            <thead>
            <tr class="border-blanco">
                <td>NRO AUT: '.$dataDosificacion[0]['nro_aut'].'</td>
            </tr>
            <tr class="border-blanco">
                <td>NRO FAC: '.$dataVenta[0]['nro_fac'].'</td>
            </tr>
            <tr class="border-blanco">
                <td>Razon Sodial: ffigueroa</td>
            </tr>
            <tr class="border-blanco">
                <td>Nit Cliente: 123123123</td>
            </tr>
            <tr class="border-blanco">
                <td>Codigo Control: '.$dataVenta[0]['codigo_control'].'</td>
            </tr>
            </thead>
        </table>';


        $html .= '<table>
            <thead>
            <tr>
                <th>Cant.</th>
                <th>Producto</th>
                <th>Precio U.</th>
                <th>Producto Total</th>
            </tr>
            </thead>
            <tbody>';

        $precioVentaTotal = 0;
        foreach ($dataVentaDetalle as $detalle) {

            $precioVentaTotal = $precioVentaTotal + $detalle["precio_unitario"];
            $html.= '<tr>
                    <td>'.$detalle["cantidad_vendida"].'</td>
                    <td>'.$detalle["desc_producto"].'</td>
                    <td>'.$detalle["precio_unitario"].'</td>
                    <td>'.$detalle["precio_total"].'</td>
                    
                    </tr>';
        }

            $html .= '<tr>
                <td colspan="4">Precio Total: '.$precioVentaTotal.'</td>
        
            </tr>
            </tbody>
        </table>
        
        ';
        
        
        $this->writeHtml($html, true, false, false, false, 'left');
        $this->lastPage();

        $this->Output(dirname(__FILE__) . "/../../reportes_generados/" . $this->objParam->getParametro('nombre_archivo'), 'F');

    }
    
    function facturaJson($dataJson) {
        //setlocale(LC_ALL,"es_ES@euro","es_ES","esp");

        date_default_timezone_set('America/New_York'); // porq ue el servidor esta alojado en amazon


        $this->SetCreator('Favio Figueroa');
        $this->SetAuthor('Favio Figueroa');
        $this->SetTitle('venta');
        $this->SetSubject('venta');
        $this->SetKeywords('venta, PDF, venta, test, guide');

        $this->SetHeaderData('','','','venta: ', '');

        // set header and footer fonts
        $this->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
        $this->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));


        // set default monospaced font
        $this->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

        // set margins
        $this->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
        $this->SetHeaderMargin(PDF_MARGIN_HEADER);
        $this->SetFooterMargin(PDF_MARGIN_FOOTER);


        $this->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);
        // set image scale factor
        $this->setImageScale(PDF_IMAGE_SCALE_RATIO);

        // set font
        $this->SetFont('dejavusans', '', 10);

        $vacio = '';
        // add a page
        $this->AddPage();

      

       $html = '<style>
table {
width: 100%;
font-size: 8px;
}
th{
border-bottom: 1pt solid black;
}

.border-blanco > td {
border-bottom: 1px solid white;
}


</style>';


        $html .= '
        
        <table>
            <thead>
            <tr class="border-blanco">
                <td>NRO AUT: '.$dataJson->nro_aut.'</td>
            </tr>
            <tr class="border-blanco">
                <td>NRO FAC: '.$dataJson->nro_fac.'</td>
            </tr>
            <tr class="border-blanco">
                <td>Razon Sodial: ffigueroa</td>
            </tr>
            <tr class="border-blanco">
                <td>Nit Cliente: 123123123</td>
            </tr>
            <tr class="border-blanco">
                <td>Codigo Control: '.$dataJson->codigo_control.'</td>
            </tr>
            </thead>
        </table>';


        $html .= '<table>
            <thead>
            <tr>
                <th>Cant.</th>
                <th>Producto</th>
                <th>Precio U.</th>
                <th>Producto Total</th>
            </tr>
            </thead>
            <tbody>';

        foreach ($dataJson->vd as $detalle) {

            $html.= '<tr>
                    <td>'.$detalle->cantidad_vendida.'</td>
                    <td>'.$detalle->desc_producto.'</td>
                    <td>'.$detalle->precio_unitario.'</td>
                    <td>'.$detalle->precio_total.'</td>
                    
                    </tr>';
        }

            $html .= '<tr>
                <td colspan="4">Precio Total: '.$dataJson->precio_venta_total.'</td>
        
            </tr>
            </tbody>
        </table>
        
        ';
        
        
        $this->writeHtml($html, true, false, false, false, 'left');
        $this->lastPage();

        $this->Output(dirname(__FILE__) . "/../../reportes_generados/" . $this->objParam->getParametro('nombre_archivo'), 'F');

    }
    
    
    
}