<?php
header("content-type: text/javascript; charset=UTF-8");

?>
<script>
    Phx.vista.ProductoHijo3 = {
        require: '../../../sis_tienda/vista/producto/ProductoBase.php',
        requireclase: 'Phx.vista.ProductoBase',
        title: 'Producto Hijo sin combo',
        nombreVista: 'producto_hijo_3',
        id_marca: undefined,
        constructor: function (config) {
            this.id_marca = config.id_marca;
            Phx.vista.ProductoHijo3.superclass.constructor.call(this,config);
            this.load({params:{start:0, limit:this.tam_pag, id_marca: config.id_marca}});
            this.loadValoresIniciales();
        },
        loadValoresIniciales: function () {
            this.Cmp.id_marca.setValue(this.id_marca);
        }
    }
</script>
