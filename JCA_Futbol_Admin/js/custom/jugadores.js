/*
 * Javascript que contiene la logica para el modulo de Equipo
 * @author Sebastian Melo
 * @created 12/01/2017
 * @copyright DG Solutions sas
 */
 var idJugadorEliminar = "";
$(document).ready(function () {
    $('#myPleaseWait').modal('show');
    cargarTabla();
});

function obtenerLineaEliminar(lnk)
{
    var row = lnk.parentNode.parentNode;
    var rowIndex = row.rowIndex - 1;
    idJugadorEliminar = row.cells[1].innerHTML;
    VentanaEliminar('Confirmar Eliminacion', '¿Esta seguro de eliminar el ID <b>' + idJugadorEliminar + '</b>?', 'SI', 'NO');
}

function Eliminar()
{
    jQuery.post('BL/JugadoresBL.php', {action: 'eliminarJugador',idJugadorEliminar: idJugadorEliminar}, function (data) {
        if (data.error === 1)
        {
        }
        else
        {
            new PNotify({
                title: 'Transaccion Exitosa!',
                text: 'Se Elimino Correctamente',
                type: 'success'
            });
            confirmModal.modal('hide');
            cargarTabla();
        }
    });
}


//Metodo que carga la informacion en la tabla
function cargarTabla() {
    $.ajax({
        type: "post",
        dataType: "json",
        url: "BL/JugadoresBL.php",
        data: {action: 'obtenerJugadores'},
        success: function (data) {
            $('#tableJugadores').dataTable({
                "iDisplayLength": 10,
                "bProcessing": true,
                "bPaginate": true,
                "bDestroy": true,
                "sPaginationType": "full_numbers",
                "sDom": 'T<"clear">lfrtip',
				"responsive":true,
                "tableTools": {
                    "sSwfPath": "http://cdn.datatables.net/tabletools/2.2.2/swf/copy_csv_xls_pdf.swf",
                    aButtons: [
                        {sExtends: "csv",
                            "sButtonText": '<br><a href="#" data-dismiss="modal" class="label label-primary" OnClick="return obtenerLineaEliminar(this)"><i class="fa fa-file-excel-o"></i> Descargar </a><br>',
                            sFileName: 'Equipos.csv',
                            sFieldSeperator: ",",
                            exportOptions: {columns: [0, 1, 2, 3, 4, 5, 6, 7, 8]}
                        }
                    ]},
                language: {
                    "sProcessing": "Procesando...",
                    "sLengthMenu": "Mostrar _MENU_ registros",
                    "sZeroRecords": "No se encontraron resultados",
                    "sEmptyTable": "Ningún dato disponible en esta tabla",
                    "sInfo": "<b>Mostrando registros del _START_ al _END_ de un total de _TOTAL_ registros</b>",
                    "sInfoEmpty": "Mostrando registros del 0 al 0 de un total de 0 registros",
                    "sInfoFiltered": "(filtrado de un total de _MAX_ registros)",
                    "sInfoPostFix": "",
                    "sSearch": "<b>Buscar : </b>",
                    "sUrl": "",
                    "sInfoThousands": ",",
                    "sLoadingRecords": "Cargando...",
                    "oPaginate": {
                        "sFirst": "Primero",
                        "sLast": "Último",
                        "sNext": "Siguiente",
                        "sPrevious": "Anterior"
                    },
                    "oAria": {
                        "sSortAscending": ": Activar para ordenar la columna de manera ascendente",
                        "sSortDescending": ": Activar para ordenar la columna de manera descendente"
                    }
                },
                data: data,
                columns: [{
                        data: 'Url',
                        className: "center",
                        bSortable: false,
                    },
                    {
                        'data': 'IdJugador',
                        "sClass": "justify",
                        "width": "auto"
                    },
                    {
                        'data': 'NombreJugador',
                        "sClass": "justify",
                        "width": "auto"
                    },
                    {
                        'data': 'Documento',
                        "sClass": "justify",
                        "width": "auto"
                    },
                    {
                        'data': 'CorreoElectronico',
                        "sClass": "justify",
                        "width": "auto"
                    },
                    {
                        'data': 'Celular',
                        "sClass": "justify",
                        "width": "auto"
                    },
                    {
                        'data': 'DT',
                        "sClass": "justify",
                        "width": "auto"
                    },
                    {
                        'data': 'Delegado',
                        "sClass": "justify",
                        "width": "auto"
                    },
                    {
                        'data': 'RepresentanteLegal',
                        "sClass": "justify",
                        "width": "auto"
                    },
                    {
                        data: null,
                        className: "center",
                        bSortable: false,
                        defaultContent: '<a href="#" data-dismiss="modal" class="btn btn-danger btn-xs" Title="Eliminar" OnClick="return obtenerLineaEliminar(this)"><i class="fa fa-trash-o"></i></a>'
                    }],
            });
            $('#myPleaseWait').modal('hide');
        },
        error: function () {
            $('#myPleaseWait').modal('hide');
            new PNotify({
                title: 'Error!',
                text: 'Por favor intentelo nuevamente.<br><b>Si el problema persiste contacte al Administrador</b>',
                type: 'error'
            });

        }
    });
}

//Metodo que almacena el equipo en la base de datos
function guardarJugador()
{

    var verdadero = $('#form1').parsley().validate("block1", true);
console.log(verdadero);
    if (verdadero)
    {
        {
            console.log("ingreso");
            var NombreJugador = document.getElementById("txtNombreJugador").value;
            var Documento = document.getElementById("txtDocumento").value;
            var CorreoElectronico = document.getElementById("txtCorreoElectronico").value;
            var Celular = document.getElementById("txtCelular").value;
            var DT = document.getElementById("chkDirectorTecnico").checked;
            var Delegado = document.getElementById("chkDelegado").checked;
            var RepresentanteLegal = document.getElementById("chkRepresentanteLegal").checked;
            var Url = document.getElementById("archivoImage").value;
            Url = Url.replace("C:\\fakepath\\","");
            var action = 'registrarJugador';

            jQuery.post('BL/JugadoresBL.php', {NombreJugador: NombreJugador, Documento: Documento, CorreoElectronico: CorreoElectronico, Celular: Celular,DT:DT, Delegado:Delegado,RepresentanteLegal:RepresentanteLegal, Url:Url,action: action}, function (data) {
                if (data.error === 1)
                {

                } else
                {
                    $('#VentanaRegistro').modal('hide');
                    new PNotify({
                        title: 'Transaccion Exitos!',
                        text: 'Jugador Registrado Correctamente',
                        type: 'success'
                    });
                    cargarTabla();
                }
            });
        }
    }
}
function uploadAjax()
{
    console.log("guardar imagen");
    var inputFileImage = document.getElementById("archivoImage");
    var file = inputFileImage.files[0];
    var data = new FormData();
    data.append("archivo",file);
    $('#myPleaseWait').modal('show');
    $.ajax({
        url:'CargarImagen.php',
        type:"POST",
        contentType:false,
        data: data,
        processData:false,
        cache:false,
        success: function(data) {
            $('#myPleaseWait').modal('hide');
            new PNotify({
                title: 'Correcto!',
                text: 'Archivo Cargado Correctamente '+ data.length ,
                type: 'info' 

             });

        },
            error: function() {
                $('#myPleaseWait').modal('hide');
                new PNotify({
                    title: 'Error!',
                    text: 'Por favor intentelo nuevamente.<br><b>Si el problema persiste contacte al Administrador</b>',
                    type: 'error'
                });
            }
        });
}