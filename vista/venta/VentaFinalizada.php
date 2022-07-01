<?php
header("content-type: text/javascript; charset=UTF-8");

?>
<script>
    Phx.vista.VentaFinalizada = {
        require: '../../../sis_tienda/vista/venta/Venta.php',
        requireclase: 'Phx.vista.Venta',
        title: 'Venta en borrador',
        nombreVista: 'VentaFinalizada',
        constructor: function (config) {            
            Phx.vista.VentaFinalizada.superclass.constructor.call(this,config);
            this.store.baseParams.estado = 'finalizado';
            this.load({params:{start:0, limit:this.tam_pag}});
            this.iniciarEventos();
        },   
    }
</script>
