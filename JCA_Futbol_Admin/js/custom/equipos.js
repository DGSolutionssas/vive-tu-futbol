/*
 * Javascript que contiene la logica para el modulo de Equipo
 * @author Diego Saavedra
 * @created 29/12/2016
 * @copyright DG Solutions sas
 */
var idEquipoEditar = "";
var idEquipoEliminar = "";
var idCampeonatoSeleccionado = "";
$(document).ready(function () {
    $('#myPleaseWait').modal('show');
    cargarTabla();
});

function obtenerLineaEliminar(lnk)
{
    var row = lnk.parentNode.parentNode;
    var rowIndex = row.rowIndex - 1;
    idEquipoEliminar = row.cells[0].innerHTML;
    VentanaEliminar('Confirmar Eliminacion', '¿Esta seguro de eliminar el ID <b>' + idEquipoEliminar + '</b>?', 'SI', 'NO');
}

var table = $('#tableEquipos').dataTable();

function obtenerLineaEditar(lnk)
{
    var row = lnk.parentNode.parentNode;
    var rowIndex = row.rowIndex - 1;
    idEquipoEditar = row.cells[0].innerHTML;
    $('#VentanaEditar').modal('show');
    document.getElementById("txtCampeonatoEditar").value = row.cells[2].innerHTML;
    document.getElementById("txtNombreEquipoEditar").value = row.cells[3].innerHTML;
    document.getElementById("txtDescripcionEquipoEditar").value = row.cells[4].innerHTML;
    var idGrupo = row.cells[6].innerHTML;
    var idCampeonato = row.cells[1].innerHTML;


    var letras = ['', 'A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J'];
    var ddlGrupoEquipoEditar = document.getElementById("ddlGrupoEquipoEditar");
    var cantidad = ddlGrupoEquipoEditar.length;
    for (var i = 0; i <= cantidad; i++) {
        $("#ddlGrupoEquipoEditar option[value='" + i + "']").remove();
    }

    var action = 'consultarGruposCampeonato';

    $.ajax({
        type: "POST",
        url: 'BL/CampeonatosBL.php',
        data: {idCampeonato: idCampeonato, action: action},
        async: false

    })
            .done(function (data, textStatus, jqXHR) {
                if (data.error === 1)
                {
                    alert("ERROR");
                } else
                {
                    var obj = JSON.parse(data);
                    //alert(obj[0].Grupos);
                    for (i = 0; i < obj[0].Grupos; i++)
                    {
                        var option = new Option(letras[i + 1], i + 1);
                        ddlGrupoEquipoEditar.append(option);
                    }
                }
            })
            .fail(function (jqXHR, textStatus, errorThrown) {
                if (console && console.log) {
                    console.log("La solicitud a fallado: " + textStatus);
                }
            });
    document.getElementById("ddlGrupoEquipoEditar").value = idGrupo;

}


function Eliminar()
{
    jQuery.post('BL/EquiposBL.php', {action: 'eliminarEquipo', idEquipoEliminar: idEquipoEliminar}, function (data) {
        if (data.error === 1)
        {
        } else
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
            $('#divGrupo').show();
            consultarGruposCampeonato();
            return false;
        },
        autoFocus: true,
        minLength: 3
    });
});
//Metodo que consulta los grupos del campeonato seleccionado
function consultarGruposCampeonato()
{
    var letras = ['', 'A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J'];
    var ddlGrupoEquipo = document.getElementById("ddlGrupoEquipo");
    var cantidad = ddlGrupoEquipo.length;
    for (var i = 0; i <= cantidad; i++) {
        $("#ddlGrupoEquipo option[value='" + i + "']").remove();
    }
    var action = 'consultarGruposCampeonato';
    jQuery.post('BL/CampeonatosBL.php', {idCampeonato: idCampeonatoSeleccionado, action: action}, function (data) {
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


//Metodo que carga la informacion en la tabla
function cargarTabla() {


    $.ajax({
        type: "post",
        dataType: "json",
        url: "BL/EquiposBL.php",
        data: {action: 'obtenerEquipos'},
        success: function (data) {
            $('#tableEquipos').dataTable({
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
                            exportOptions: {columns: [0, 1, 2, 3, 4, 5]}
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
                        'data': 'IdEquipo',
                        "sClass": "center",
                        "width": "auto"
                    },
                    {
                        'data': 'IdCampeonato',
                        "sClass": "center",
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
                        "sClass": "center",
                        "width": "auto"
                    },
                    {
                        data: null,
                        className: "center",
                        bSortable: false,
                        defaultContent: '<a href="#" data-dismiss="modal" class="btn btn-warning btn-xs" Title="Editar" OnClick="return obtenerLineaEditar(this)"><i class="fa fa-pencil-square-o"></i></a>'
                    },
                    {
                        data: null,
                        className: "center",
                        bSortable: false,
                        defaultContent: '<a href="#" data-dismiss="modal" class="btn btn-danger btn-xs" Title="Eliminar" OnClick="return obtenerLineaEliminar(this)"><i class="fa fa-trash-o"></i></a>'
                    }]
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
function guardarEquipo()
{
    var ddlGrupoEquipo = document.getElementById("ddlGrupoEquipo");
    var idGrupo = ddlGrupoEquipo.options[ddlGrupoEquipo.selectedIndex].value;
    var idCampeonato = idCampeonatoSeleccionado;
    verdadero = $('#form1').parsley().validate("blockRegistro", true);
    if (verdadero)
    {
            var nombreEquipo = document.getElementById("txtNombreEquipo").value;
            var descripcionEquipo = document.getElementById("txtDescripcionEquipo").value;
            var action = 'registrarEquipoGrupo';
            jQuery.post('BL/EquiposBL.php', {nombreEquipo: nombreEquipo, descripcionEquipo: descripcionEquipo, idGrupo: idGrupo, idCampeonato: idCampeonato, action: action}, function (data) {
                if (data.error === 1)
                {

                } else
                {
                    $('#VentanaRegistro').modal('hide');
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

function actualizarEquipo()
{
    var nombreEquipoEditar = document.getElementById("txtNombreEquipoEditar").value;
    var descripcionEquipoEditar = document.getElementById("txtDescripcionEquipoEditar").value;
    var ddlGrupoEquipoEditar = document.getElementById("ddlGrupoEquipoEditar");
    var idGrupo = ddlGrupoEquipoEditar.options[ddlGrupoEquipoEditar.selectedIndex].value;

    var action = 'actualizarEquipoGrupo';
    jQuery.post('BL/EquiposBL.php', {idEquipo: idEquipoEditar, nombreEquipo: nombreEquipoEditar, descripcionEquipo: descripcionEquipoEditar, idGrupo: idGrupo, action: action}, function (data) {
        if (data.error === 1)
        {

        } else
        {
            $('#VentanaRegistro').modal('hide');
            new PNotify({
                title: 'Transaccion Exitos!',
                text: 'Equipo Actualizado Correctamente',
                type: 'success'
            });
            $('#VentanaEditar').modal('hide');
            cargarTabla();
        }
    });
}
