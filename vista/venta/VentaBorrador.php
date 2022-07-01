<?php
header("content-type: text/javascript; charset=UTF-8");

?>
<script>
    Phx.vista.VentaBorrador = {
        require: '../../../sis_tienda/vista/venta/Venta.php',
        requireclase: 'Phx.vista.Venta',
        title: 'Venta en borrador',
        nombreVista: 'VentaBorrador',
        constructor: function (config) {            
            Phx.vista.VentaBorrador.superclass.constructor.call(this,config);
            this.store.baseParams.estado = 'borrador';
            this.load({params:{start:0, limit:this.tam_pag}});
            this.iniciarEventos();
        },   
    }
</script>
