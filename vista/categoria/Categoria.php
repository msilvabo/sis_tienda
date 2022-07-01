<?php
header("content-type: text/javascript; charset=UTF-8");
?>
<script>

    Phx.vista.Categoria=Ext.extend(Phx.gridInterfaz,{

            constructor:function(config){
                this.maestro=config.maestro;
                //llama al constructor de la clase padre
                Phx.vista.Categoria.superclass.constructor.call(this,config);
                this.init();
                this.load({params:{start:0, limit:this.tam_pag}})

                this.addButton('archivo', {
                    argument: {imprimir: 'archivo'},
                    text: '<i class="fa fa-thumbs-o-up fa-2x"></i> archivo', /*iconCls:'' ,*/
                    disabled: false,
                    handler: this.archivo
                })
            },

            Atributos:[
                {
                    //configuracion del componente
                    config:{
                        labelSeparator:'',
                        inputType:'hidden',
                        name: 'id_categoria'
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
                        name: 'color',
                        fieldLabel: 'color',
                        allowBlank: true,
                        anchor: '80%',
                        gwidth: 100,
                        maxLength:255
                    },
                    type:'TextField',
                    filters:{pfiltro:'tm.color',type:'string'},
                    id_grupo:1,
                    grid:true,
                    form:true,
                    bottom_filter: true,
                },
                {
                    config:{
                        name: 'archivo',
                        fieldLabel: 'archivo',
                        allowBlank: true,
                        anchor: '80%',
                        gwidth: 100,
                        maxLength:255,
                        renderer: function (value, p, record, rowIndex, colIndex) {
                            console.log('value',value)
                            console.log('p',p)
                            console.log('record',record)
                            const {json: {desc_archivo_tiecat, folder, extension}} = record;

                            const nombre_file = desc_archivo_tiecat ? `${folder}${desc_archivo_tiecat}.${extension}` : '../../../lib/imagenes/icono_awesome/awe_wrong.png';

                            return `<img width="50" src="${nombre_file}"/>`;
                        },
                    },
                    type:'TextField',
                    filters:{pfiltro:'tp.nombre',type:'string'},
                    id_grupo:1,
                    grid:true,
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
            title:'Categoria',
            ActSave:'../../sis_tienda/control/Categoria/insertarCategoria',
            ActDel:'../../sis_tienda/control/Categoria/eliminarCategoria',
            ActList:'../../sis_tienda/control/Categoria/listarCategoria',
            id_store:'id_categoria',
            fields: [
                {name:'id_categoria', type: 'numeric'},
                {name:'estado_reg', type: 'string'},
                {name:'nombre', type: 'string'},
                {name:'color', type: 'string'},
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
                field: 'id_categoria',
                direction: 'ASC'
            },
            bdel:true,
            bsave:true,

        archivo: function () {


            var rec = this.getSelectedData();

            //enviamos el id seleccionado para cual el archivo se deba subir
            rec.datos_extras_id = rec.id_categoria;
            //enviamos el nombre de la tabla
            rec.datos_extras_tabla = 'tie.tcategoria';
            //enviamos el codigo ya que una tabla puede tener varios archivos diferentes como ci,pasaporte,contrato,slider,fotos,etc
            rec.datos_extras_codigo = 'ICOCAT';

            //esto es cuando queremos darle una ruta personalizada
            //rec.datos_extras_ruta_personalizada = './../../../uploaded_files/favioVideos/videos/';

            Phx.CP.loadWindows('../../../sis_parametros/vista/archivo/Archivo.php',
                'Archivo',
                {
                    width: 900,
                    height: 400
                }, rec, this.idContenedor, 'Archivo');

        },
        }
    )

</script>
