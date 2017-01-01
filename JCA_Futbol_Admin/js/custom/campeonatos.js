var idCampeonatoEliminar = "";
var idCampeonato = "";
$(document).ready(function () {
    $('#myPleaseWait').modal('show');
    cargarTabla();
});

function obtenerLineaEliminar(lnk)
{
    var row = lnk.parentNode.parentNode;
    var rowIndex = row.rowIndex - 1;
    idCampeonatoEliminar = row.cells[0].innerHTML;
    VentanaEliminar('Confirmar Eliminacion', '¿Esta seguro de eliminar el ID <b>' + idCampeonatoEliminar + '</b>?', 'SI', 'NO');
}

function Eliminar()
{
    jQuery.post('BL/CampeonatosBL.php', {action: 'eliminarCampeonato',IdCampeonato: idCampeonatoEliminar}, function (data) {
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
        url: "BL/CampeonatosBL.php",
        data: {action: 'obtenerCampeonatos'},
        success: function (data) {
            $('#tableCampeonatos').dataTable({
                "iDisplayLength": 10,
                "bProcessing": true,
                "bPaginate": true,
                "bDestroy": true,
                "sPaginationType": "full_numbers",
                "sDom": 'T<"clear">lfrtip',
                "tableTools": {
                    "sSwfPath": "http://cdn.datatables.net/tabletools/2.2.2/swf/copy_csv_xls_pdf.swf",
                    aButtons: [
                        {
                            sExtends: "csv",
                            "sButtonText": '<br><a href="#" data-dismiss="modal" class="label label-primary" OnClick="return obtenerLineaEliminar(this)"><i class="fa fa-file-excel-o"></i> Descargar </a><br>',
                            sFileName: 'Campeonatos.csv',
                            sFieldSeperator: ",",
                            'mColumns': [0, 1, 2, 3, 4]
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
                        'data': 'IdCampeonato',
                        "sClass": "justify",
                        "width": "auto"
                    },
                    {
                        'data': 'Campeonato',
                        "sClass": "justify",
                        "width": "auto"
                    },
                    {
                        'data': 'Descripcion',
                        "sClass": "justify",
                        "width": "auto"
                    },
                    {
                        'data': 'Grupos',
                        "sClass": "justify",
                        "width": "auto"
                    },
                    {
                        'data': 'Equipos',
                        "sClass": "justify",
                        "width": "auto"
                    },
                    {
                        data: null,
                        className: "center",
                        bSortable: false,
                        defaultContent: '<a href="#" data-dismiss="modal" class="btn btn-warning btn-xs" OnClick="return registrarEquipoModal(this)"><i class="fa fa-plus"></i> Equipos</a><a href="#" data-dismiss="modal" class="btn btn-danger btn-xs" OnClick="return obtenerLineaEliminar(this)"><i class="fa fa-trash-o"></i> Eliminar </a>'
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

function registrarEquipoModal(lnk)
{
    limpiar();
    var row = lnk.parentNode.parentNode;
    idCampeonato = row.cells[0].innerHTML;
    var nombreCampeonato = row.cells[1].innerHTML;
    $('#VentanaRegistroEquipo').modal('show');
    document.getElementById("txtCampeonatoRegistro").value = nombreCampeonato;
    var ddlGrupoEquipo = document.getElementById("ddlGrupoEquipo");
    var letras = ['', 'A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J'];
    var cantidad = ddlGrupoEquipo.length;
    for (var i = 0; i <= cantidad; i++) {
        $("#ddlGrupoEquipo option[value='" + i + "']").remove();
    }
    var action = 'consultarGruposCampeonato';

    jQuery.post('BL/CampeonatosBL.php', {idCampeonato: idCampeonato, action: action}, function (data) {
        if (data.error === 1)
        {
            alert("ERROR");
        } else
        {
            var obj = JSON.parse(data);
            for (i = 0; i < obj[0].Grupos; i++)
            {
                var option = new Option(letras[i + 1], i + 1);
                ddlGrupoEquipo.append(option);
            }
        }
    });
}

function registrarEquipoCampeonato()
{
    var ddlGrupoEquipo = document.getElementById("ddlGrupoEquipo");
    var idGrupo = ddlGrupoEquipo.options[ddlGrupoEquipo.selectedIndex].value;

    var verdadero = $('#form1').parsley().validate("block2", true);
    if (verdadero)
    {
        var nombreEquipo = document.getElementById("txtNombreEquipoRegistro").value;
        var descripcionEquipo = document.getElementById("txtDescripcionEquipoRegistro").value;
        var action = 'registrarEquipoGrupo';

        jQuery.post('BL/EquiposBL.php', {nombreEquipo: nombreEquipo, descripcionEquipo: descripcionEquipo, idGrupo: idGrupo, idCampeonato: idCampeonato, action: action}, function (data) {
            if (data.error === 1)
            {

            } else
            {
                $('#VentanaRegistroEquipo').modal('hide');
                new PNotify({
                    title: 'Transaccion Exitos!',
                    text: 'Equipo Registrado Correctamente',
                    type: 'success'
                });
                cargarTabla();
            }
        });
    }
}

function guardarCampeonato()
{
    var verdadero = $('#form1').parsley().validate("block1", true);
    if (verdadero)
    {
        var campeonato = document.getElementById("txtCampeonato").value;
        var descripcion = document.getElementById("txtDescripcion").value;
        var grupos = document.getElementById("txtGrupos").value;
        var equipos = document.getElementById("txtEquipos").value;
        var action = 'registrarCampeonato';

        jQuery.post('BL/CampeonatosBL.php', {campeonato: campeonato, descripcion: descripcion, grupos: grupos, equipos: equipos, action: action}, function (data) {
            if (data.error === 1)
            {
            } else
            {
                $('#VentanaRegistro').modal('hide');
                new PNotify({
                    title: 'Transaccion Exitosa!',
                    text: 'Campeonato Registrado Correctamente',
                    type: 'success'
                });
                cargarTabla();
            }
        });
    }
}