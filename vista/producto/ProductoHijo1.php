<?php
header("content-type: text/javascript; charset=UTF-8");

?>
<script>
    Phx.vista.ProductoHijo1 = {
        require: '../../../sis_tienda/vista/producto/ProductoBase.php',
        requireclase: 'Phx.vista.ProductoBase',
        title: 'Producto Hijo con combo',
        nombreVista: 'producto_hijo_1',
        constructor: function (config) {
            this.Atributos[this.getIndAtributo('id_marca')] = {
                config: {
                    name: 'id_marca',
                    fieldLabel: 'Marca',
                    allowBlank: false,
                    emptyText: 'Elija una opcion',
                    store: new Ext.data.JsonStore({
                        url: '../../sis_tienda/control/Marca/listarMarca',
                        id: 'id_marca',
                        root: 'datos',
                        sortInfo: {
                            field: 'id_marca',
                            direction: 'ASC',
                        },
                        totalProperty: 'total',
                        fields: ['id_marca', 'nombre'],
                        remoteSort: true,
                        baseParams: {par_filtro: 'tm.nombre'},
                    }),
                    valueField: 'id_marca',
                    displayField: 'nombre',
                    gdisplayField: 'desc_marca',
                    hiddenName: 'id_marca',
                    forceSelection: true,
                    typeHead: false,
                    triggerAction: 'all',
                    lazyRender: true,
                    mode: 'remote',
                    pageSize: 15,
                    queryDelay: 1000,
                    anchor: '100%',
                    gwidth: 150,
                    minChars: 2,
                    renderer: function (value, p, record) {
                        return String.format('{0}', record.data['desc_marca'])
                    },
                },
                type: 'ComboBox',
                id_grupo: 0,
                filters: {pfiltro: 'tm.nombre', type:'string'},
                grid: true,
                form: true,

            };
            Phx.vista.ProductoHijo1.superclass.constructor.call(this,config);
            this.load({params:{start:0, limit:this.tam_pag}});
            this.iniciarEventos();
        },
        iniciarEventos: function () {
            this.Cmp.id_marca.on('select', function (combo, record) {
                console.log('combo',combo)
                console.log('record',record)
                this.Cmp.nombre.setValue(`${record.data.nombre}-`);
            }, this);

            console.log('this.Cmp.nombre',this.Cmp.nombre)
            this.Cmp.nombre.on('blur', function () {

                console.log('asdasdasdasdas')
            }, this);
        },
        tabeast: [ //tabsouth o tabeast
            {
                url: '../../../sis_tienda/vista/movimiento/Movimiento.php',
                title: 'MOvimiento ',
                width: '35%',
                cls: 'Movimiento',
            },
            {
                url: '../../../sis_tienda/vista/producto_categoria/ProductoCategoria.php',
                title: 'ProductoCategoria ',
                width: '35%',
                cls: 'ProductoCategoria',
            }
        ],
        onButtonEdit: function () {
            Phx.vista.ProductoHijo1.superclass.onButtonEdit.call(this);
            var rec = this.sm.getSelected();
            console.log('rec',rec)
            this.Cmp.id_marca.setValue(rec.data.id_marca)
        }

    }
</script>
