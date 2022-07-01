<?php
header("content-type: text/javascript; charset=UTF-8");

?>
<script>
    Phx.vista.ProductoHijo2 = {
        require: '../../../sis_tienda/vista/producto/ProductoBase.php',
        requireclase: 'Phx.vista.ProductoBase',
        title: 'Producto Hijo sin combo',
        nombreVista: 'producto_hijo_2',
        constructor: function (config) {
            Phx.vista.ProductoHijo2.superclass.constructor.call(this,config);
        },
        onReloadPage: function(m) {
            this.maestro = m;
            this.store.baseParams = { id_marca: this.maestro.id_marca };
            this.load({params: {start: 0, limit: 50 }});
        },
        loadValoresIniciales: function () {
            this.Cmp.id_marca.setValue(this.maestro.id_marca);
            Phx.vista.ProductoHijo2.superclass.loadValoresIniciales.call(this);
        }
    }
</script>
