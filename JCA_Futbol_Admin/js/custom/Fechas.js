/*
 * Javascript que contiene la logica para el modulo de Fecha
 * @author Diego Saavedra
 * @created 29/12/2016
 * @copyright DG Solutions sas
 */
 var idFechaEliminar = "";
var idCampeonatoSeleccionado = "";
$(document).ready(function () {
    $('#myPleaseWait').modal('show');
	$('#dtFecha').datepicker({
		clearBtn: true,
		autoclose: true,
		format: "yyyy-mm-dd",
		todayHighlight: true
	});
    cargarTabla();
});

function obtenerLineaEliminar(lnk)
{
    var row = lnk.parentNode.parentNode;
    var rowIndex = row.rowIndex - 1;
    idFechaEliminar = row.cells[0].innerHTML;
    VentanaEliminar('Confirmar Eliminacion', '¿Esta seguro de eliminar el ID <b>' + idFechaEliminar + '</b>?', 'SI', 'NO');
}

function Eliminar()
{
    jQuery.post('BL/FechasBL.php', {action: 'eliminarFecha',idFechaEliminar: idFechaEliminar}, function (data) {
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

//Metodo que autocompleta el texto para el campeonato
$(document).ready(function () {
    $('#txtCampeonato').autocomplete({
        source: function (request, response) {
            $.ajax({
                url: 'BL/CampeonatosBL.php',
                dataType: "json",
                type: "POST",
                data: {
                    term: request.term,
                    action: 'autoCompletarCampeonato'
                },
                success: function (data) {
                    response($.map(data, function (objeto) {
                        return {
                            label: objeto.value,
                            value: objeto.value,
                            id: objeto.id
                        }
                    }));
                }
            });
        },
        select: function (event, ui) {
            idCampeonatoSeleccionado = ui.item.id;
            document.getElementById("txtCampeonato").value = ui.item.value;
            return false;
        },
        autoFocus: true,
        minLength: 3
    });
});

//Metodo que carga la informacion en la tabla
function cargarTabla() {
    $.ajax({
        type: "post",
        dataType: "json",
        url: "BL/FechasBL.php",
        data: {action: 'obtenerFechas'},
        success: function (data) {
            $('#tableFechas').dataTable({
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
                            sFileName: 'Fechas.csv',
                            sFieldSeperator: ",",
                            exportOptions: {columns: [0, 1, 2, 3]}
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
                        'data': 'idfecha',
                        "sClass": "justify",
                        "width": "auto"
                    },
                    {
                        'data': 'nombrefecha',
                        "sClass": "justify",
                        "width": "auto"
                    },
                    {
                        'data': 'fecha',
                        "sClass": "justify",
                        "width": "auto"
                    },
                    {
                        'data': 'Campeonato',
                        "sClass": "justify",
                        "width": "auto"
                    },
                    {
                        data: null,
                        className: "center",
                        bSortable: false,
                        defaultContent: '<a href="#" data-dismiss="modal" class="btn btn-danger btn-xs" OnClick="return obtenerLineaEliminar(this)"><i class="fa fa-trash-o"></i> Eliminar </a>'
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
function guardarFecha()
{
    var idCampeonato = idCampeonatoSeleccionado;

    var verdadero = $('#form1').parsley().validate("block1", true);
    if (verdadero)
    {
        {
            var nombreFecha = document.getElementById("txtNombreFecha").value;
            var fecha = document.getElementById("dtFecha").value;
            var action = 'registrarFecha';

            jQuery.post('BL/FechasBL.php', {idCampeonato: idCampeonato, nombreFecha: nombreFecha, fecha: fecha, action: action}, function (data) {
                if (data.error === 1)
                {

                } else
                {
                    $('#VentanaRegistro').modal('hide');
                    new PNotify({
                        title: 'Transaccion Exitosa!',
                        text: 'Fecha Registrada Correctamente',
                        type: 'success'
                    });
                    cargarTabla();
                }
            });
        }
    }
}
