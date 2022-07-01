<?php
header("content-type: text/javascript; charset=UTF-8");
?>
<script>
    Phx.vista.VentaDetalle=Ext.extend(Phx.gridInterfaz,{
            constructor:function(config){
                this.maestro=config.maestro;
                //llama al constructor de la clase padre
                Phx.vista.VentaDetalle.superclass.constructor.call(this,config);
                this.init();

                //this.load({params:{start:0, limit:this.tam_pag, id_venta: config.id_venta}})
            },

            Atributos:[
                {
                    config:{
                        labelSeparator:'',
                        inputType:'hidden',
                        name: 'id_venta_detalle'
                    },
                    type:'Field',
                    form:true
                },
                {
                    config:{
                        labelSeparator:'',
                        inputType:'hidden',
                        name: 'id_venta'
                    },
                    type:'Field',
                    form:true
                },
                {
                    config:{
                        labelSeparator:'',
                        inputType:'hidden',
                        name: 'id_producto'
                    },
                    type:'Field',
                    form:true
                },
                {
                    config:{
                        name: 'nombre',
                        fieldLabel: 'Nombre Producto',
                        allowBlank: true,
                        anchor: '80%',
                        gwidth: 100,
                        maxLength:255
                    },
                    type:'TextField',
                    filters:{pfiltro:'tp.nombre',type:'string'},
                    id_grupo:1,
                    grid:true,
                    form:true,
                    bottom_filter: true,
                },
                {
                    config:{
                        name: 'cantidad_vendida',
                        fieldLabel: 'Cantidad Vendida',
                        allowBlank: true,
                        anchor: '80%',
                        gwidth: 100,
                        maxLength:255
                    },
                    type:'TextField',
                    filters:{pfiltro:'tvd.cantidad_vendida',type:'string'},
                    id_grupo:1,
                    grid:true,
                    form:true,
                    bottom_filter: true,
                },
                {
                    config:{
                        name: 'precio_unitario',
                        fieldLabel: 'Precio Unitario',
                        allowBlank: true,
                        anchor: '80%',
                        gwidth: 100,
                        maxLength:255
                    },
                    type:'TextField',
                    filters:{pfiltro:'tvd.precio_unitario',type:'string'},
                    id_grupo:1,
                    grid:true,
                    form:true,
                    bottom_filter: true,
                },
                {
                    config:{
                        name: 'precio_total',
                        fieldLabel: 'Precio  Total',
                        allowBlank: true,
                        anchor: '80%',
                        gwidth: 100,
                        maxLength:255
                    },
                    type:'TextField',
                    filters:{pfiltro:'tvd.precio_total',type:'string'},
                    id_grupo:1,
                    grid:true,
                    form:true,
                    bottom_filter: true,
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
                    filters:{pfiltro:'tvd.estado_reg',type:'string'},
                    id_grupo:1,
                    grid:true,
                    form:false
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
                    filters:{pfiltro:'tvd.fecha_reg',type:'date'},
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
                    filters:{pfiltro:'tvd.id_usuario_ai',type:'numeric'},
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
                    filters:{pfiltro:'tvd.usuario_ai',type:'string'},
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
                    filters:{pfiltro:'tvd.cuenta',type:'string'},
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
                    filters:{pfiltro:'tvd.fecha_mod',type:'date'},
                    id_grupo:1,
                    grid:true,
                    form:false
                }
            ],
            tam_pag:50,
            title:'VentaDetalle',
            //ActSave:'../../sis_tienda/control/VentaDetalle/insertarVentaDetalle',
            //ActDel:'../../sis_tienda/control/VentaDetalle/eliminarVentaDetalle',
            ActList:'../../sis_tienda/control/VentaDetalle/listarVentaDetalle',
            id_store:'id_venta_detalle',
            fields: [
                {name:'id_venta_detalle', type: 'numeric'},
                {name:'id_venta', type: 'numeric'},
                {name:'id_producto', type: 'numeric'},
                {name:'cantidad_vendida', type: 'numeric'},
                {name:'precio_unitario', type: 'numeric'},
                {name:'precio_total', type: 'numeric'},
                {name:'nombre', type: 'string'},
                {name:'estado_reg', type: 'string'},
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
                field: 'id_venta_detalle',
                direction: 'ASC'
            },
            bdel:true,
            bsave:true,
            onReloadPage: function(m) {
                this.maestro = m;
                this.store.baseParams = { id_venta: this.maestro.id_venta };
                this.load({params: {start: 0, limit: 50 }});
            },
            loadValoresIniciales: function () {
                this.Cmp.id_venta.setValue(this.maestro.id_venta);
                Phx.vista.VentaDetalle.superclass.loadValoresIniciales.call(this);
            }

        }
    )
</script>