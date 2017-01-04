var idResultadoEliminar = "";
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
                        className: "center",
                        bSortable: false,
                        defaultContent: '<a href="#" data-dismiss="modal" class="btn btn-danger" OnClick="return obtenerLineaEliminar(this)"> Eliminar </a>'
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
        var IdFecha= document.getElementById("txtIdFecha").value;
        var IdCampeonato = document.getElementById("txtIdCampeonato").value;
        var IdEquipo1 = document.getElementById("txtIdEquipo1").value;
        var IdEquipo2 = document.getElementById("txtIdEquipo2").value;
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