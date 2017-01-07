var idResultadoEliminar = "";
var idCampeonatoSeleccionado = "";
var idFechaSeleccionado = "";
var idEquipo1Seleccionado = "";
var idEquipo2Seleccionado = "";

$(document).ready(function () {
    $('#myPleaseWait').modal('show');
    cargarTabla();
});

function obtenerLineaEliminar(lnk)
{
    var row = lnk.parentNode.parentNode;
    var rowIndex = row.rowIndex - 1;
    idResultadoEliminar = row.cells[0].innerHTML;
    VentanaEliminar('Confirmar Eliminacion', '¿Esta seguro de eliminar el ID <b>' + idResultadoEliminar + '</b>?', 'SI', 'NO');
}


function Eliminar()
{
    jQuery.post('BL/ResultadosBL.php', {action: 'eliminarCampeonato',IdCampeonato: idResultadoEliminar}, function (data) {
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
//---------------------------
//para autocompletar el campeonato
//----------------------------
$(document).ready(function () {
    $('#txtIdCampeonato').autocomplete({
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
            document.getElementById("txtIdCampeonato").value = ui.item.value;
            return false;
        },
        autoFocus: true,
        minLength: 3
    });
});
//---------------------------
//para autocompletar la Fecha
//----------------------------
$(document).ready(function () {
    $('#txtIdFecha').autocomplete({
        source: function (request, response) {
            $.ajax({
                url: 'BL/FechasBL.php',
                dataType: "json",
                type: "POST",
                data: {
                    term: request.term,
                    action: 'autoCompletarFechas'
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
            idFechaSeleccionado = ui.item.id;
            document.getElementById("txtIdFecha").value = ui.item.value;
            return false;
        },
        autoFocus: true,
        minLength: 3
    });
});
//---------------------------
//para autocompletar el equipo 1
//----------------------------
$(document).ready(function () {
    $('#txtIdEquipo1').autocomplete({
        source: function (request, response) {
            $.ajax({
                url: 'BL/EquiposBL.php',
                dataType: "json",
                type: "POST",
                data: {
                    term: request.term,
                    action: 'autoCompletarEquipo',
                    IdCampeonato: idCampeonatoSeleccionado
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
            idEquipo1Seleccionado = ui.item.id;
            document.getElementById("txtIdEquipo1").value = ui.item.value;
            return false;
        },
        autoFocus: true,
        minLength: 3
    });
});
//---------------------------
//para autocompletar el equipo 2
//----------------------------
$(document).ready(function () {
    $('#txtIdEquipo2').autocomplete({
        source: function (request, response) {
            $.ajax({
                url: 'BL/EquiposBL.php',
                dataType: "json",
                type: "POST",
                data: {
                    term: request.term,
                    action: 'autoCompletarEquipo',
                    IdCampeonato: idCampeonatoSeleccionado
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
            idEquipo2Seleccionado = ui.item.id;
            document.getElementById("txtIdEquipo2").value = ui.item.value;
            return false;
        },
        autoFocus: true,
        minLength: 3
    });
});

function cargarTabla() {
    $.ajax({
        type: "post",
        dataType: "json",
        url: "BL/ResultadosBL.php",
        data: {action: 'obtenerResultados'},
        success: function (data) {
            $('#tableResultados').dataTable({
                "iDisplayLength": 10,
                "bProcessing": true,
                "bPaginate": true,
                "bDestroy": true,
                "sPaginationType": "full_numbers",
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
                        'data': 'IdResultado',
                        "sClass": "justify",
                        "width": "auto"
                    },
                    {
                        'data': 'IdFecha',
                        "sClass": "justify",
                        "width": "auto"
                    },
                    {
                        'data': 'IdCampeonato',
                        "sClass": "justify",
                        "width": "auto"
                    },
                    {
                        'data': 'IdEquipo1',
                        "sClass": "justify",
                        "width": "auto"
                    },
                    {
                        'data': 'IdEquipo2',
                        "sClass": "justify",
                        "width": "auto"
                    },
                    {
                        'data': 'Goles1',
                        "sClass": "justify",
                        "width": "auto"
                    },
                    {
                        'data': 'Goles2',
                        "sClass": "justify",
                        "width": "auto"
                    },
                    {
                        data: null,
                        className: "auto",
                        bSortable: false,
                        defaultContent: '<a href="#" data-dismiss="modal" class="btn btn-warning btn-xs" OnClick="return registrarEquipoModal(this)"><i class="fa fa-plus"></i> Equipos</a><a href="#" data-dismiss="modal" title="Eliminar" class="btn btn-danger btn-xs" OnClick="return obtenerLineaEliminar(this)"><i class="fa fa-trash-o"></i></a>'
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

function guardarResultado()
{
    var verdadero = $('#form1').parsley().validate("block1", true);
    if (verdadero)
    {
        var IdFecha= idFechaSeleccionado;
        var IdCampeonato = idCampeonatoSeleccionado;
        var IdEquipo1 = idEquipo1Seleccionado;
        var IdEquipo2 = idEquipo2Seleccionado;
        var Goles1 = document.getElementById("txtGoles1").value;
        var Goles2 = document.getElementById("txtGoles2").value;
        var action='registrarResultado';
        
        jQuery.post('BL/ResultadosBL.php', {IdFecha: IdFecha, IdCampeonato: IdCampeonato, IdEquipo1: IdEquipo1, IdEquipo2: IdEquipo2, Goles1: Goles1, Goles2: Goles2, action:action}, function (data) {
            if (data.error === 1)
            {
            }
            else
            {
                $('#VentanaRegistro').modal('hide');
                new PNotify({
                    title: 'Transaccion Exitosa!',
                    text: 'Resultado Registrado Correctamente',
                    type: 'success'
                });
                cargarTabla();
            }
        });
    }
}