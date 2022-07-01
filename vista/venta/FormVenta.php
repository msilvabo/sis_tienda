<?php
header("content-type: text/javascript; charset=UTF-8");
?>
<script>
    Phx.vista.FormVenta = Ext.extend(Phx.frmInterfaz, {
        ActSave: '../../sis_tienda/control/Venta/insertarVenta',
        tam_pag: 10,
        layout: 'fit',
        autoScroll: false,
        breset: false,
        labelSubmit: '<i class="fa fa-check"></i>Siguiente',
        storeDatosIniciales: {},
        id_venta: 0,
        constructor: function (config) {
            
            this.buildComponentesDetalle();
            this.buildDetailGrid();
            this.buildGrupos();
            Phx.vista.FormVenta.superclass.constructor.call(this, config);
            this.init();
            this.iniciarEventos();
        },
        buildComponentesDetalle: function () {

            this.detCmp = {
                'id_producto': new Ext.form.ComboBox({
                    name: 'id_producto',
                    msgTarget: 'title',
                    fieldLabel: 'Producto',
                    allowBlank: false,
                    emptyText: 'Elija una opción...',
                    store: new Ext.data.JsonStore({
                        url: '../../sis_tienda/control/Producto/listarProducto',
                        id: 'id_producto',
                        root: 'datos',
                        sortInfo: {
                            field: 'nombre',
                            direction: 'ASC'
                        },
                        totalProperty: 'total',
                        fields: ['id_producto', 'nombre','precio'],
                        remoteSort: true,
                        baseParams: {par_filtro: 'tp.nombre'}
                    }),
                    valueField: 'id_producto',
                    displayField: 'nombre',
                    gdisplayField: 'nombre',
                    hiddenName: 'id_producto',
                    forceSelection: true,
                    typeAhead: false,
                    triggerAction: 'all',
                    lazyRender: true,
                    mode: 'remote',
                    pageSize: 15,
                    queryDelay: 1000,
                    anchor: '100%',
                    gwidth: 150,
                    minChars: 2,
                    renderer : function(value, p, record) {
                        return String.format('{0}', record.data['nombre']);
                    }
                }),
              
                'cantidad_vendida': new Ext.form.NumberField({
                    name: 'cantidad_vendida',
                    msgTarget: 'title',
                    fieldLabel: 'Cantidad vendida',
                    allowBlank: false,
                    allowDecimals: true,
                    minValue: 0,
                    maxLength: 10
                }),
                'precio_unitario': new Ext.form.NumberField({
                    name: 'precio_unitario',
                    msgTarget: 'title',
                    fieldLabel: 'Precio unitario',
                    allowBlank: false,
                    allowDecimals: true,
                    minValue: 0,
                    maxLength: 10
                }),
                'precio_total': new Ext.form.NumberField({
                    name: 'precio_total',
                    msgTarget: 'title',
                    fieldLabel: 'Precio total',
                    allowBlank: false,
                    allowDecimals: true,
                    minValue: 0,
                    maxLength: 10
                }),




            }
            
        },

        evaluaGrilla: function () {
            //al eliminar si no quedan registros en la grilla desbloquea los requisitos en el maestro
            var count = this.mestore.getCount();
            if (count == 0) {
                //this.bloqueaRequisitos(false);
            }
        },
        onCancelAdd: function (re, save) {
            if (this.sw_init_add) {
                this.mestore.remove(this.mestore.getAt(0));
            }

            this.sw_init_add = false;
            this.evaluaGrilla();
        },
        onAfterEdit: function (re, o, rec, num) {
            //set descriptins values ...  in combos boxs

            //todo borrar esto despues
            var cmb_rec = this.detCmp['id_producto'].store.getById(rec.get('id_producto'));
            if (cmb_rec) {
                rec.set('id_producto', cmb_rec.get('nombre'));
            }

        },
        buildDetailGrid: function () {

            //cantidad,detalle,peso,totalo
            var Items = Ext.data.Record.create([ {
                name: 'id_producto',
                type: 'int'
            }
            ]);

            this.mestore = new Ext.data.JsonStore({
                url: '../../sis_tienda/control/VentaDetalle/listarVentaDetalle',
                id: 'id_venta_detalle',
                root: 'datos',
                totalProperty: 'total',
                fields: ['id_venta_detalle', 'id_venta', 'id_producto'], remoteSort: true,
                baseParams: {dir: 'ASC', sort: 'id_venta_detalle', limit: '50', start: '0', id_venta: this.id_venta}
            });

            this.editorDetail = new Ext.ux.grid.RowEditor({
                saveText: 'Aceptar',
                name: 'btn_editor'

            });

            this.summary = new Ext.ux.grid.GridSummary();
            // al iniciar la edicion
            this.editorDetail.on('beforeedit', () => {
                console.log('beforeedit')
            }, this);

            //al cancelar la edicion
            this.editorDetail.on('canceledit', this.onCancelAdd, this);

            //al cancelar la edicion
            this.editorDetail.on('validateedit', () => {
                console.log('validateedit');
            }, this);

            this.editorDetail.on('afteredit', this.onAfterxEdit, this);


            this.megrid = new Ext.grid.GridPanel({
                layout: 'fit',
                store: this.mestore,
                region: 'center',
                split: true,
                border: false,
                plain: true,
                //autoHeight: true,
                plugins: [this.editorDetail, this.summary],
                stripeRows: true,
                tbar: [{
                    /*iconCls: 'badd',*/
                    text: '<i class="fa fa-plus-circle fa-lg"></i> Agregar Concepto',
                    scope: this,
                    width: '100',
                    handler: function () {
                        var e = new Items({
                            id_producto: undefined,
                            precio_unitario: 0,
                            precio_total: 0,
                        });
                        this.editorDetail.stopEditing();
                        this.mestore.insert(0, e);
                        this.megrid.getView().refresh();
                        this.megrid.getSelectionModel().selectRow(0);
                        this.editorDetail.startEditing(0);
                        this.sw_init_add = true;

                    }
                }, {
                    ref: '../removeBtn',
                    text: '<i class="fa fa-trash fa-lg"></i> Eliminar',
                    scope: this,
                    handler: function () {
                        this.editorDetail.stopEditing();
                        var s = this.megrid.getSelectionModel().getSelections();
                        for (var i = 0, r; r = s[i]; i++) {
                            this.mestore.remove(r);
                        }
                        this.evaluaGrilla();
                    }
                }],

                columns: [
                    new Ext.grid.RowNumberer(),
                    {

                        // id: 'cantidad',
                        header: 'Cant.',
                        dataIndex: 'cantidad_vendida',
                        width: 60,
                        sortable: true,
                        hidden: false,
                        hideable: false,
                        editor: this.detCmp.cantidad_vendida,
                        summaryType: 'count',

                        summaryRenderer: function (v, params, data) {
                            return ((v === 0 || v > 1) ? '(' + v + ' items)' : '(1 item)');
                        },
                    },

                    {

                        header: 'Producto',
                        dataIndex: 'id_producto',
                        align: 'center',
                        width: 200,
                        editor: this.detCmp.id_producto
                    },


                    {

                        header: 'P. Unit',
                        dataIndex: 'precio_unitario',
                        align: 'center',
                        width: 130,
                        trueText: 'Yes',
                        falseText: 'No',
                        //minValue: 0.001,
                        minValue: 0,
                        summaryType: 'sum',
                        editor: this.detCmp.precio_unitario
                    },


                    {

                        header: 'Total',
                        dataIndex: 'precio_total',
                        css: {
                            background: "#ccc",
                        },
                        format: '$0,0.00',
                        align: 'center',
                        width: 130,
                        summaryType: 'sum',
                        trueText: 'Yes',
                        falseText: 'No',
                        //minValue: 0.001,
                        minValue: 0,
                        summaryType: 'sum',
                        editor: this.detCmp.precio_total
                    },

                   /* {
                        xtype: 'numbercolumn',
                        header: 'Importe Devolver',
                        dataIndex: 'importe_devolver',

                        format: '$0,0.00',
                        width: 100,
                        sortable: false,
                        summaryType: 'sum',
                        editor: this.detCmp.importe_devolver
                    },*/



                ]
            });



        },
        buildGrupos: function () {

            this.Grupos = [{
                layout: 'border',
                border: true,
                frame: true,
                //labelAlign: 'top',
                items: [
                    {
                        xtype: 'fieldset',
                        border: false,
                        split: true,
                        layout: 'column',
                        region: 'north',
                        autoScroll: true,
                        autoHeight: true,
                        collapseFirst: false,
                        collapsible: true,
                        width: '100%',
                        padding: '0 0 0 10',
                        items: [
                            {
                                bodyStyle: 'padding-right:5px;',

                                border: false,
                                autoHeight: true,
                                columnWidth: .32,
                                items: [{
                                    xtype: 'fieldset',
                                    //frame: true,
                                    layout: 'form',
                                    title: ' Cliente ',
                                    //width: '33%',

                                    //border: false,
                                    //margins: '0 0 0 5',
                                    padding: '0 0 0 10',
                                    bodyStyle: 'padding-left:5px;',
                                    id_grupo: 0,
                                    items: [],
                                }]
                            },
                            {
                                bodyStyle: 'padding-right:5px;',

                                border: false,
                                autoHeight: true,
                                columnWidth: .32,
                                items: [{
                                    xtype: 'fieldset',
                                    //frame: true,
                                    layout: 'form',
                                    title: ' Datos Generales ',
                                    //width: '33%',

                                    //border: false,
                                    //margins: '0 0 0 5',
                                    padding: '0 0 0 10',
                                    bodyStyle: 'padding-left:5px;',
                                    id_grupo: 1,
                                    items: [],
                                }]
                            },
                        ]
                    },
                    this.megrid
                ]
            }];
            
        },


        Atributos:[
            {
                //configuracion del componente
                config:{
                    labelSeparator:'',
                    inputType:'hidden',
                    name: 'id_venta'
                },
                type:'Field',
                form:true
            },

            {
                config: {
                    name: 'id_cliente',
                    fieldLabel: 'Cliente',
                    allowBlank: false,
                    emptyText: 'Elija una opcion',
                    store: new Ext.data.JsonStore({
                        url: '../../sis_tienda/control/Cliente/listarCliente',
                        id: 'id_cliente',
                        root: 'datos',
                        sortInfo: {
                            field: 'id_cliente',
                            direction: 'ASC',
                        },
                        totalProperty: 'total',
                        fields: ['id_cliente', 'nit', 'razon_social'],
                        remoteSort: true,
                        baseParams: {par_filtro: 'c.nit'},
                    }),
                    valueField: 'id_cliente',
                    displayField: 'razon_social',
                    gdisplayField: 'razon_social',
                    hiddenName: 'id_cliente',
                    forceSelection: true,
                    typeHead: false,
                    triggerAction: 'all',
                    lazyRender: true,
                    mode: 'remote',
                    pageSize: 15,
                    queryDelay: 1000,
                    anchor: '70%',
                    gwidth: 150,
                    minChars: 2,
                    turl: '../../../sis_tienda/vista/cliente/Cliente.php',
                    ttitle: 'Clientes',
                    tasignacion: true,
                    tname: 'id_cliente',
                    tdata: {},
                    tcls: 'Cliente',
                    tpl:'<tpl for="."><div class="x-combo-list-item"><p>{nit}-{razon_social}</p><div></tpl>',
                    renderer: function (value, p, record) {
                        return String.format('{0}', record.data['razon_social'])
                    },
                },
                type: 'TrigguerCombo',
                id_grupo: 0,
                filters: {pfiltro: 'tm.nombre', type:'string'},
                grid: true,
                form: true,

            },
            {
                config:{
                    name: 'fecha',
                    fieldLabel: 'Fecha',
                    allowBlank: true,
                    anchor: '60%',
                    gwidth: 100,
                    maxLength:255
                },
                type:'DateField',
                filters:{pfiltro:'tv.fecha',type:'numeric'},
                id_grupo:1,
                grid:true,
                form:true,
                bottom_filter: true,
            },

            {
                config:{
                    name: 'nro_venta',
                    fieldLabel: 'Numero Venta',
                    allowBlank: true,
                    anchor: '60%',
                    gwidth: 100,
                    maxLength:255
                },
                type:'TextField',
                filters:{pfiltro:'tv.nro_venta',type:'String'},
                id_grupo:1,
                grid:true,
                form:true,
            },

        ],
        obtenerPrecioTotalEnDetalle: function () {
            const precioUnitario = this.detCmp.precio_unitario.getValue();
            const cantidad = this.detCmp.cantidad_vendida.getValue();
            const total = parseFloat(precioUnitario) * parseFloat(cantidad);
            this.detCmp.precio_total.setValue(total);
        },
        iniciarEventos: function () {



            this.detCmp.precio_unitario.on('blur', function () {
                this.obtenerPrecioTotalEnDetalle();
            }, this);
            this.detCmp.cantidad_vendida.on('blur', function () {
                this.obtenerPrecioTotalEnDetalle();
            }, this);
            this.detCmp.id_producto.on('select', function (combo, record) {
                const { json: { precio } } = record;

                //const precio = record.json.precio;
                this.detCmp.precio_unitario.setValue(precio);
                this.obtenerPrecioTotalEnDetalle();
            }, this);
        },
        onSubmit: function (o) {

            //if(this.form.getForm().isValid)
            var arra = [], i, me = this;
            for(i = 0; i < me.megrid.store.getCount(); i++) {
                const record = me.megrid.store.getAt(i);
                arra[i] = record.data;

            }

            me.argumentExtraSubmit = {
                'details': JSON.stringify(arra)
            }

            Phx.vista.FormVenta.superclass.onSubmit.call(this, o, undefined, true);

        },
        successSave: function (resp) {
            Phx.CP.loadingHide();
            var objRes = '';
            this.fireEvent('successSave', this, resp)
        }

    });
</script>

