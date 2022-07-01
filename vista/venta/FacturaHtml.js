var facturaHtml = ({data}) => {

    console.log('data',data)
    const html = `
    <!DOCTYPE html>
        <html lang="en">
        <head>
            <meta charset="UTF-8">
            <title>factura</title>
        </head>
        <body>
        <table>
            <thead>
            <tr>
                <td>NRO FAC: ${data.nro_fac}</td>
            </tr>
            <tr>
                <td>Razon Sodial: ${data.cli.razon_social}</td>
            </tr>
            <tr>
                <td>Nit Cliente: ${data.cli.nit}</td>
            </tr>
            <tr>
                <td>Codigo Control: ${data.codigo_control}</td>
            </tr>
            </thead>
        </table>
        <table>
            <thead>
            <tr>
                <th>Cant.</th>
                <th>Producto</th>
                <th>Precio U.</th>
                <th>Producto Total</th>
            </tr>
            </thead>
            <tbody>
            ${data.vd.map((ventaDetalle) => (`<tr>
                <td>${ventaDetalle.cantidad_vendida}</td>
                <td>${ventaDetalle.desc_producto}</td>
                <td>${ventaDetalle.precio_unitario}</td>
                <td>${ventaDetalle.precio_total}</td>
            </tr>`) ) }
           
            <tr>
                <td colspan="4">Precio Total: ${data.precio_venta_total}</td>
        
            </tr>
            </tbody>
        </table>
        </body>
        </html>
    `;


    return html;
}