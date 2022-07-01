<?php
header("content-type: text/javascript; charset=UTF-8");
?>
<script>

    Phx.vista.Dosificacion=Ext.extend(Phx.gridInterfaz,{

            constructor:function(config){
                this.maestro=config.maestro;
                //llama al constructor de la clase padre
                Phx.vista.Dosificacion.superclass.constructor.call(this,config);
                this.init();
                this.load({params:{start:0, limit:this.tam_pag}})
            },

            Atributos:[
                {
                    //configuracion del componente
                    config:{
                        labelSeparator:'',
                        inputType:'hidden',
                        name: 'id_dosificacion'
                    },
                    type:'Field',
                    form:true
                },
                {
                    config:{
                        name: 'llave',
                        fieldLabel: 'Llave',
                        allowBlank: true,
                        anchor: '80%',
                        gwidth: 200,
                        maxLength:20
                    },
                    type:'TextField',
                    filters:{pfiltro:'td.llave',type:'string'},
                    id_grupo:1,
                    grid:true,
                    form:true
                },

                {
                    config:{
                        name: 'fecha_ini',
                        fieldLabel: 'Fecha Inicio',
                        allowBlank: true,
                        anchor: '80%',
                        gwidth: 150,
                        format: 'd/m/Y',
                        renderer:function (value,p,record){return value?value.dateFormat('d/m/Y'):''}
                    },
                    type:'DateField',
                    filters:{pfiltro:'td.fecha_ini',type:'date'},
                    id_grupo:1,
                    grid:true,
                    form:true
                },

                {
                    config:{
                        name: 'fecha_fin',
                        fieldLabel: 'Fecha fin',
                        allowBlank: true,
                        anchor: '80%',
                        gwidth: 150,
                        format: 'd/m/Y',
                        renderer:function (value,p,record){return value?value.dateFormat('d/m/Y'):''}
                    },
                    type:'DateField',
                    filters:{pfiltro:'tm.fecha_reg',type:'date'},
                    id_grupo:1,
                    grid:true,
                    form:true
                },

                {
                    config:{
                        name: 'nro_aut',
                        fieldLabel: 'Nro. Autorizacion',
                        allowBlank: true,
                        anchor: '80%',
                        gwidth: 250,
                        maxLength:255
                    },
                    type:'TextField',
                    filters:{pfiltro:'td.nro_aut',type:'string'},
                    id_grupo:1,
                    grid:true,
                    form:true,
                    bottom_filter: true,
                },

                {
                    config:{
                        name: 'nro_inicio',
                        fieldLabel: 'Nro. Factura',
                        allowBlank: true,
                        anchor: '80%',
                        gwidth: 250,
                        maxLength:255
                    },
                    type:'TextField',
                    filters:{pfiltro:'td.nro_inicio',type:'numeric'},
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
            title:'Dosificacion',
            ActSave:'../../sis_tienda/control/Dosificacion/insertarDosificacion',
            ActDel:'../../sis_tienda/control/Dosificacion/eliminarDosificacion',
            ActList:'../../sis_tienda/control/Dosificacion/listarDosificacion',
            id_store:'id_dosificacion',
            fields: [
                {name:'id_dosificacion', type: 'numeric'},
                {name:'llave', type: 'string'},
                {name:'fecha_ini', type: 'date',dateFormat:'Y-m-d'},
                {name:'fecha_fin', type: 'date',dateFormat:'Y-m-d'},
                {name:'nro_aut', type: 'string'},
                {name:'nro_inicio', type: 'numeric'},
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
                field: 'id_dosificacion',
                direction: 'ASC'
            },
            bdel:true,
            bsave:true
        }
    )

</script>
