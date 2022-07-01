<?php
header("content-type: text/javascript; charset=UTF-8");
?>
<script>

    Phx.vista.Marca=Ext.extend(Phx.gridInterfaz,{

        cmbIdMarca: new Ext.form.ComboBox({
            name: 'id_marca',
            msgTarget: 'title',
            fieldLabel: 'Marca',
            allowBlank: false,
            emptyText: 'Elija una opción...',
            store: new Ext.data.JsonStore({
                url: '../../sis_tienda/control/Marca/listarMarca',
                id: 'id_marca',
                root: 'datos',
                sortInfo: {
                    field: 'nombre',
                    direction: 'ASC'
                },
                totalProperty: 'total',
                fields: ['id_marca', 'nombre'],
                remoteSort: true,
                baseParams: {par_filtro: 'tm.nombre'}
            }),
            valueField: 'id_marca',
            displayField: 'nombre',
            gdisplayField: 'nombre',
            hiddenName: 'id_marca',
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

        cmbIdProducto: new Ext.form.ComboBox({
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
            disabled: true,
        renderer : function(value, p, record) {
            return String.format('{0}', record.data['nombre']);
        }
    }),

            constructor:function(config){
                this.maestro=config.maestro;
                //llama al constructor de la clase padre
                Phx.vista.Marca.superclass.constructor.call(this,config);


                this.popUpExampleCombos = new Ext.Window({
                    layout: 'fit',
                    width: 500,
                    height: 250,
                    modal: true,
                    closeAction: 'hide',
                    items: new Ext.FormPanel({
                        labelWidth: 75, // label settings here cascade unless overridden
                        frame: true,
                        // title: 'Factura Manual Concepto',
                        bodyStyle: 'padding:5px 5px 0',
                        width: 339,
                        defaults: {width: 191},
                        // defaultType: 'textfield',

                        items: [this.cmbIdMarca, this.cmbIdProducto],

                        buttons: [{
                            text: 'Save',
                            handler: () => {
                                alert('save')
                            },

                            scope: this
                        }, {
                            text: 'Cancel',
                            handler: ()=>{this.popUpExampleCombos.hide()}
                        }]
                    })
                })


                this.init();
                this.load({params:{start:0, limit:this.tam_pag}})
                this.iniciarEventos();

                this.addButton('open_producto', {
                    text: 'Productos',
                    iconCls: 'badelante',
                    disabled: true,
                    handler: this.productos,
                    tooltip: '<b>este es un mensaje</b>'
                })
                this.addButton('btn_modal_ex1', {
                    text: 'Ejemplo Combobox',
                    iconCls: 'badelante',
                    disabled: false,
                    handler: ()=> {
                        this.popUpExampleCombos.show();
                    },
                    tooltip: '<b>este es un mensaje</b>'
                })
            },

            Atributos:[
                {
                    //configuracion del componente
                    config:{
                        labelSeparator:'',
                        inputType:'hidden',
                        name: 'id_marca'
                    },
                    type:'Field',
                    form:true
                },
                {
                    config:{
                        name: 'estado_reg',
                        fieldLabel: 'Estado Reg.',
                        allowBlank: true,
                        anchor: '80%',
                        gwidth: 100,
                        maxLength:10
                    },
                    type:'TextField',
                    filters:{pfiltro:'tm.estado_reg',type:'string'},
                    id_grupo:1,
                    grid:true,
                    form:false
                },

                {
                    config:{
                        name: 'nombre',
                        fieldLabel: 'nombre',
                        allowBlank: true,
                        anchor: '80%',
                        gwidth: 100,
                        maxLength:255
                    },
                    type:'TextField',
                    filters:{pfiltro:'tm.nombre',type:'string'},
                    id_grupo:1,
                    grid:true,
                    form:true,
                    bottom_filter: true,
                },
                {
                    config:{
                        name: 'usr_reg',
                        fieldLabel: 'Creado por',
                        allowBlank: true,
                        anchor: '80%',
                        gwidth: 100,
                        maxLength:4
                    },
                    type:'Field',
                    filters:{pfiltro:'usu1.cuenta',type:'string'},
                    id_grupo:1,
                    grid:true,
                    form:false
                },
                {
                    config:{
                        name: 'fecha_reg',
                        fieldLabel: 'Fecha creación',
                        allowBlank: true,
                        anchor: '80%',
                        gwidth: 100,
                        format: 'd/m/Y',
                        renderer:function (value,p,record){return value?value.dateFormat('d/m/Y H:i:s'):''}
                    },
                    type:'DateField',
                    filters:{pfiltro:'tm.fecha_reg',type:'date'},
                    id_grupo:1,
                    grid:true,
                    form:false
                },
                {
                    config:{
                        name: 'id_usuario_ai',
                        fieldLabel: 'Fecha creación',
                        allowBlank: true,
                        anchor: '80%',
                        gwidth: 100,
                        maxLength:4
                    },
                    type:'Field',
                    filters:{pfiltro:'tm.id_usuario_ai',type:'numeric'},
                    id_grupo:1,
                    grid:false,
                    form:false
                },
                {
                    config:{
                        name: 'usuario_ai',
                        fieldLabel: 'Funcionaro AI',
                        allowBlank: true,
                        anchor: '80%',
                        gwidth: 100,
                        maxLength:300
                    },
                    type:'TextField',
                    filters:{pfiltro:'tm.usuario_ai',type:'string'},
                    id_grupo:1,
                    grid:true,
                    form:false
                },
                {
                    config:{
                        name: 'usr_mod',
                        fieldLabel: 'Modificado por',
                        allowBlank: true,
                        anchor: '80%',
                        gwidth: 100,
                        maxLength:4
                    },
                    type:'Field',
                    filters:{pfiltro:'tm.cuenta',type:'string'},
                    id_grupo:1,
                    grid:true,
                    form:false
                },
                {
                    config:{
                        name: 'fecha_mod',
                        fieldLabel: 'Fecha Modif.',
                        allowBlank: true,
                        anchor: '80%',
                        gwidth: 100,
                        format: 'd/m/Y',
                        renderer:function (value,p,record){return value?value.dateFormat('d/m/Y H:i:s'):''}
                    },
                    type:'DateField',
                    filters:{pfiltro:'tm.fecha_mod',type:'date'},
                    id_grupo:1,
                    grid:true,
                    form:false
                }
            ],
            tam_pag:50,
            title:'Marca',
            ActSave:'../../sis_tienda/control/Marca/insertarMarca',
            ActDel:'../../sis_tienda/control/Marca/eliminarMarca',
            ActList:'../../sis_tienda/control/Marca/listarMarca',
            id_store:'id_marca',
            fields: [
                {name:'id_marca', type: 'numeric'},
                {name:'estado_reg', type: 'string'},
                {name:'nombre', type: 'string'},
                {name:'id_usuario_reg', type: 'numeric'},
                {name:'fecha_reg', type: 'date',dateFormat:'Y-m-d H:i:s.u'},
                {name:'id_usuario_ai', type: 'numeric'},
                {name:'usuario_ai', type: 'string'},
                {name:'id_usuario_mod', type: 'numeric'},
                {name:'fecha_mod', type: 'date',dateFormat:'Y-m-d H:i:s.u'},
                {name:'usr_reg', type: 'string'},
                {name:'usr_mod', type: 'string'},

            ],
            sortInfo:{
                field: 'id_marca',
                direction: 'ASC'
            },
            bdel:true,
            bsave:true,
            tabsouth: [
                {
                    url: '../../../sis_tienda/vista/producto/ProductoHijo2.php',
                    title: 'Hijos de Marca(Producto)',
                    height: '50%',
                    cls: 'ProductoHijo2',
                }
            ],

        marcasNuevas: function (mensaje) {
            console.log('marcasNuevas a llegado un mensaje', mensaje)
            this.load({params:{start:0, limit:this.tam_pag}})

        },
        iniciarEventos: function () {

            this.cmbIdMarca.on('select', function (rec, d) {
                console.log('d',d)
                this.cmbIdProducto.enable();
                this.cmbIdProducto.reset();
                this.cmbIdProducto.store.baseParams.id_marca = d.data.id_marca;
                this.cmbIdProducto.modificado = true;
            }, this);
            Phx.CP.webSocket.escucharEvento(`sis_marca_marca_nuevas_marcas`,this.idContenedor,'marcasNuevas', this);

        },
            preparaMenu: function () {
                //var data = this.getSelectedData();
                this.getBoton('open_producto').enable();
            },
            productos: function () {
               var rec = this.sm.getSelected();
                Phx.CP.loadWindows(
                    '../../../sis_tienda/vista/producto/ProductoHijo3.php',
                    'Produto',
                    {
                        width: '90%',
                        height: 500
                    },
                    rec.data,
                    this.idContenedor,
                    'ProductoHijo3'
                );
            },
        }
    )

</script>
