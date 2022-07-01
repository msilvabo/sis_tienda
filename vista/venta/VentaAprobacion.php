<?php
header("content-type: text/javascript; charset=UTF-8");

?>
<script>
    Phx.vista.VentaAprobacion = {
        require: '../../../sis_tienda/vista/venta/Venta.php',
        requireclase: 'Phx.vista.Venta',
        title: 'Venta en borrador',
        nombreVista: 'VentaAprobacion',
        constructor: function (config) {            
            Phx.vista.VentaAprobacion.superclass.constructor.call(this,config);
            this.store.baseParams.estado = 'aprobacion';
            this.load({params:{start:0, limit:this.tam_pag}});
            this.iniciarEventos();
        },   
    }
</script>
