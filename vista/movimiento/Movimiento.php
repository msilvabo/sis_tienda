<?php
header("content-type: text/javascript; charset=UTF-8");
?>
<script>

    Phx.vista.Movimiento = Ext.extend(Phx.gridInterfaz, {

            tipoSeleccionado: 'ENTRADA',
            gruposBarraTareas: [
                {
                    name: 'ENTRADA',
                    title: '<h1 align="center">Entradas</h1>',
                    grupo: 0,
                    height: 0,
                },
                {
                    name: 'SALIDA',
                    title: '<h1 align="center">Salidas</h1>',
                    grupo: 0,
                    height: 0,
                },
            ],
            beditGroups: [0,1,2],
            bactGroups: [0,1,2],
            bexcelGroups: [0,1,2],
            constructor: function (config) {
                this.maestro = config.maestro;
                //llama al constructor de la clase padre



                Phx.vista.Movimiento.superclass.constructor.call(this, config);
                this.init();
                // this.load({params:{start:0, limit:this.tam_pag}})
            },

            Atributos: [
                {
                    //configuracion del componente
                    config: {
                        labelSeparator: '',
                        inputType: 'hidden',
                        name: 'id_movimiento'
                    },
                    type: 'Field',
                    form: true
                },
                {
                    //configuracion del componente
                    config: {
                        labelSeparator: '',
                        inputType: 'hidden',
                        name: 'id_producto'
                    },
                    type: 'Field',
                    form: true
                },
                // {
                //     config: {
                //         name: 'tipo',
                //         fieldLabel: 'Tipo Movimiento',
                //         allowBlank: true,
                //         anchor: '80%',
                //         gwidth: 100,
                //         maxLength: 10
                //     },
                //     type: 'TextField',
                //     filters: {pfiltro: 'tmo.tipo', type: 'string'},
                //     id_grupo: 1,
                //     grid: true,
                //     form: true
                // },
                {
                    config: {
                        name: 'tipo',
                        fieldLabel: 'Tipo Movimiento',
                        allowBlank: true,
                        emptyText: 'Tipo...',
                        typeAhead: true,
                        triggerAction: 'all',
                        lazyRender: true,
                        mode: 'local',
                        store: ['ENTRADA', 'SALIDA'],
                        width: 200
                    },
                    type: 'ComboBox',
                    id_grupo: 2,
                    form: true,
                    grid: true
                },


                {
                    config: {
                        name: 'cantidad_movida',
                        fieldLabel: 'Cantidad movida',
                        allowBlank: true,
                        anchor: '80%',
                        gwidth: 100,
                        maxLength: 255
                    },
                    type: 'TextField',
                    filters: {pfiltro: 'tm.cantidad_movida', type: 'string'},
                    id_grupo: 1,
                    grid: true,
                    form: true,
                    bottom_filter: true,
                },

                {
                    config: {
                        name: 'usr_reg',
                        fieldLabel: 'Creado por',
                        allowBlank: true,
                        anchor: '80%',
                        gwidth: 100,
                        maxLength: 4
                    },
                    type: 'Field',
                    filters: {pfiltro: 'usu1.cuenta', type: 'string'},
                    id_grupo: 1,
                    grid: true,
                    form: false
                },
                {
                    config: {
                        name: 'fecha_reg',
                        fieldLabel: 'Fecha creación',
                        allowBlank: true,
                        anchor: '80%',
                        gwidth: 100,
                        format: 'd/m/Y',
                        renderer: function (value, p, record) {
                            return value ? value.dateFormat('d/m/Y H:i:s') : ''
                        }
                    },
                    type: 'DateField',
                    filters: {pfiltro: 'tm.fecha_reg', type: 'date'},
                    id_grupo: 1,
                    grid: true,
                    form: false
                },
                {
                    config: {
                        name: 'id_usuario_ai',
                        fieldLabel: 'Fecha creación',
                        allowBlank: true,
                        anchor: '80%',
                        gwidth: 100,
                        maxLength: 4
                    },
                    type: 'Field',
                    filters: {pfiltro: 'tm.id_usuario_ai', type: 'numeric'},
                    id_grupo: 1,
                    grid: false,
                    form: false
                },
                {
                    config: {
                        name: 'usuario_ai',
                        fieldLabel: 'Funcionaro AI',
                        allowBlank: true,
                        anchor: '80%',
                        gwidth: 100,
                        maxLength: 300
                    },
                    type: 'TextField',
                    filters: {pfiltro: 'tm.usuario_ai', type: 'string'},
                    id_grupo: 1,
                    grid: true,
                    form: false
                },
                {
                    config: {
                        name: 'usr_mod',
                        fieldLabel: 'Modificado por',
                        allowBlank: true,
                        anchor: '80%',
                        gwidth: 100,
                        maxLength: 4
                    },
                    type: 'Field',
                    filters: {pfiltro: 'tm.cuenta', type: 'string'},
                    id_grupo: 1,
                    grid: true,
                    form: false
                },
                {
                    config: {
                        name: 'fecha_mod',
                        fieldLabel: 'Fecha Modif.',
                        allowBlank: true,
                        anchor: '80%',
                        gwidth: 100,
                        format: 'd/m/Y',
                        renderer: function (value, p, record) {
                            return value ? value.dateFormat('d/m/Y H:i:s') : ''
                        }
                    },
                    type: 'DateField',
                    filters: {pfiltro: 'tm.fecha_mod', type: 'date'},
                    id_grupo: 1,
                    grid: true,
                    form: false
                }
            ],
            tam_pag: 50,
            title: 'Movimiento',
            ActSave: '../../sis_tienda/control/Movimiento/insertarMovimiento',
            ActDel: '../../sis_tienda/control/Movimiento/eliminarMovimiento',
            ActList: '../../sis_tienda/control/Movimiento/listarMovimiento',
            id_store: 'id_movimiento',
            fields: [
                {name: 'id_movimiento', type: 'numeric'},
                {name: 'id_producto', type: 'numeric'},
                {name: 'tipo', type: 'string'},
                {name: 'cantidad_movida', type: 'numeric'},
                {name: 'id_usuario_reg', type: 'numeric'},
                {name: 'fecha_reg', type: 'date', dateFormat: 'Y-m-d H:i:s.u'},
                {name: 'id_usuario_ai', type: 'numeric'},
                {name: 'usuario_ai', type: 'string'},
                {name: 'id_usuario_mod', type: 'numeric'},
                {name: 'fecha_mod', type: 'date', dateFormat: 'Y-m-d H:i:s.u'},
                {name: 'usr_reg', type: 'string'},
                {name: 'usr_mod', type: 'string'},

            ],
            sortInfo: {
                field: 'id_movimiento',
                direction: 'ASC'
            },
            bdel: true,
            bsave: true,
            onReloadPage: function (e) {
                this.maestro = e;
                this.store.baseParams = {id_producto: this.maestro.id_producto};
                this.load({params: {start: 0, limit: 50, tipo: this.tipoSeleccionado}});
            },
            loadValoresIniciales: function () {
                this.Cmp.id_producto.setValue(this.maestro.id_producto);
                Phx.vista.Movimiento.superclass.loadValoresIniciales.call(this);
            },
            getParametrosFiltro: function () {
                    this.store.baseParams.tipo = this.tipoSeleccionado;
            },
            actualizarSegunTab: function (name, indice) {
                console.log('name',name)
                this.tipoSeleccionado = name;
                this.getParametrosFiltro();
                this.load({params:{start:0, limit:this.tam_pag}})
            },
        }
    )

</script>
