var idVideoEliminar = "";
$(document).ready(function () {
    $('#myPleaseWait').modal('show');
    cargarTabla();
});

function cargarTabla() {
    $.ajax({
        type: "post",
        dataType: "json",
        url: "../BL/EquiposBL.php",
        data: {action: 'obtenerEquipos'},
        success: function (data) {
            $('#tableEquipos').dataTable({
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
                        'data': 'IdEquipo',
                        "sClass": "justify",
                        "width": "auto"
                    },
                    {
                        'data': 'Campeonato',
                        "sClass": "justify",
                        "width": "auto"
                    },
                    {
                        'data': 'Nombre',
                        "sClass": "justify",
                        "width": "auto"
                    },
                    {
                        'data': 'Descripcion',
                        "sClass": "justify",
                        "width": "auto"
                    },
                    {
                        'data': 'Puntos',
                        "sClass": "justify",
                        "width": "auto"
                    },      
                    {
                        'data': 'Grupo',
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