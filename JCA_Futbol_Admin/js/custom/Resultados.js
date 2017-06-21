var idResultadoEliminar = "";
var idCampeonatoSeleccionado = "";
var idFechaSeleccionado = "";
var idEquipo1Seleccionado = "";
var idEquipo2Seleccionado = "";
var idCampeonatoSeleccionadoEditar = "";
var idFechaSeleccionadoEditar = "";
var idEquipo1SeleccionadoEditar = "";
var idEquipo2SeleccionadoEditar = "";
var idResultadoEditar = "";

$(document).ready(function() {
    $('#myPleaseWait').modal('show');
    cargarTabla();
});

function obtenerLineaEliminar(lnk){
    var row = lnk.parentNode.parentNode;
    var rowIndex = row.rowIndex - 1;
    idResultadoEliminar = row.cells[0].innerHTML;
    VentanaEliminar('Confirmar Eliminacion', '¿Esta seguro de eliminar el ID <b>' + idResultadoEliminar + '</b>?', 'SI', 'NO');
}

function obtenerLineaEditar(lnk){
    var row = lnk.parentNode.parentNode;
    var rowIndex = row.rowIndex - 1;
    idResultadoEditar = row.cells[0].innerHTML;
    $('#VentanaEditarRegistro').modal('show');
    idFechaSeleccionadoEditar = document.getElementById("txtIdFechaEditar").value = row.cells[1].innerHTML;
    idCampeonatoSeleccionadoEditar = document.getElementById("txtIdCampeonatoEditar").value = row.cells[2].innerHTML;
    idEquipo1SeleccionadoEditar= document.getElementById("txtIdEquipo1Editar").value = row.cells[3].innerHTML;
    document.getElementById("txtGoles1Editar").value = row.cells[5].innerHTML;
    idEquipo2SeleccionadoEditar = document.getElementById("txtIdEquipo2Editar").value = row.cells[4].innerHTML;
    document.getElementById("txtGoles2Editar").value = row.cells[6].innerHTML;
}

function Eliminar(){
    jQuery.post('BL/ResultadosBL.php', {action: 'eliminarResultado', IdResultado: idResultadoEliminar}, function(data) {
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
$(document).ready(function() {
    $('#txtIdCampeonato').autocomplete({
        source: function(request, response) {
            $.ajax({
                url: 'BL/CampeonatosBL.php',
                dataType: "json",
                type: "POST",
                data: {
                    term: request.term,
                    action: 'autoCompletarCampeonato'
                },
                success: function(data) {
                    response($.map(data, function(objeto) {
                        return {
                            label: objeto.value,
                            value: objeto.value,
                            id: objeto.id
                        }
                    }));
                }
            });
        },
        select: function(event, ui) {
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
$(document).ready(function() {
    $('#txtIdFecha').autocomplete({
        source: function(request, response) {
            $.ajax({
                url: 'BL/FechasBL.php',
                dataType: "json",
                type: "POST",
                data: {
                    term: request.term,
                    action: 'autoCompletarFechas'
                },
                success: function(data) {
                    response($.map(data, function(objeto) {
                        return {
                            label: objeto.value,
                            value: objeto.value,
                            id: objeto.id
                        }
                    }));
                }
            });
        },
        select: function(event, ui) {
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
$(document).ready(function() {
    $('#txtIdEquipo1').autocomplete({
        source: function(request, response) {
            $.ajax({
                url: 'BL/EquiposBL.php',
                dataType: "json",
                type: "POST",
                data: {
                    term: request.term,
                    action: 'autoCompletarEquipo',
                    IdCampeonato: idCampeonatoSeleccionado
                },
                success: function(data) {
                    response($.map(data, function(objeto) {
                        return {
                            label: objeto.value,
                            value: objeto.value,
                            id: objeto.id
                        }
                    }));
                }
            });
        },
        select: function(event, ui) {
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
$(document).ready(function() {
    $('#txtIdEquipo2').autocomplete({
        source: function(request, response) {
            $.ajax({
                url: 'BL/EquiposBL.php',
                dataType: "json",
                type: "POST",
                data: {
                    term: request.term,
                    action: 'autoCompletarEquipo',
                    IdCampeonato: idCampeonatoSeleccionado
                },
                success: function(data) {
                    response($.map(data, function(objeto) {
                        return {
                            label: objeto.value,
                            value: objeto.value,
                            id: objeto.id
                        }
                    }));
                }
            });
        },
        select: function(event, ui) {
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
        success: function(data) {
            $('#tableResultados').dataTable({
                "iDisplayLength": 10,
                "bProcessing": true,
                "bPaginate": true,
                "bDestroy": true,
                "sPaginationType": "full_numbers",
                "responsive":true,
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
                        defaultContent: '<a href="#" title="Ver Detalles" data-dismiss="modal" class="btn btn-warning btn-xs" OnClick="ObtenerDetalles(this)"><i class="fa fa-plus"></i>Detalles</a><a href="#" data-dismiss="modal" title="Editar" class="btn btn-success btn-xs" OnClick="return obtenerLineaEditar(this)"><i class="fa fa-pencil-square-o"></i></a><a href="#" data-dismiss="modal" title="Eliminar" class="btn btn-danger btn-xs" OnClick="return obtenerLineaEliminar(this)"><i class="fa fa-trash-o"></i></a>'
                    }],
            });
            $('#myPleaseWait').modal('hide');
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

function guardarResultado(){
    var verdadero = $('#form1').parsley().validate("block1", true);
    if (verdadero)
    {
        var Checkwe1 = document.getElementById("chkw1").checked;
        var Checkwe2 = document.getElementById("chkw2").checked;
        if ((Checkwe1) && (Checkwe2))
        {
            new PNotify({
                            title: 'Error!',
                            text: 'No pueden ganar por W dos equipos',
                            type: 'error'
                        });
        }
        else
        {
            if  (Checkwe1)
            {
                var IdFecha = idFechaSeleccionado;
                var IdCampeonato = idCampeonatoSeleccionado;
                var IdEquipo1 = idEquipo1Seleccionado;
                var IdEquipo2 = idEquipo2Seleccionado;
                var Goles1 = 3;
                var Goles2 = 0;
                var PW = 1;
                var action = 'registrarResultado';
                var equipo1=document.getElementById("txtcargaequipo1").value = equipo1=document.getElementById("txtIdEquipo1").value;
                var equipo2=document.getElementById("txtcargaequipo2").value = equipo2=document.getElementById("txtIdEquipo2").value;

                jQuery.post('BL/ResultadosBL.php', {IdFecha: IdFecha, IdCampeonato: IdCampeonato, IdEquipo1: IdEquipo1, IdEquipo2: IdEquipo2, Goles1: Goles1, Goles2: Goles2, PW: PW,  action: action}, function(data) {
                if (data.error === 1)
                    {
                    }
                else
                    {
                    //alert ("datos enviados " + IdFecha + ", " + IdCampeonato + ", " + IdEquipo1 + ", " + IdEquipo2 + ", " + Goles1 + ", " + Goles2 + ", " + PW);
                    //$('#VentanaRegistro').modal('hide');
                        new PNotify({
                            title: 'Transaccion Exitosa!',
                            text: 'Resultado Registrado Correctamente',
                            type: 'success'
                        });
                        cargarTabla();
                    }
                });
                $('#VentanaRegistro').modal('hide');
                cargarTabla();
            }  
            else
            {
                if  (Checkwe2)
                {
                    var IdFecha = idFechaSeleccionado;
                    var IdCampeonato = idCampeonatoSeleccionado;
                    var IdEquipo1 = idEquipo1Seleccionado;
                    var IdEquipo2 = idEquipo2Seleccionado;
                    var Goles1 = 0;
                    var Goles2 = 3;
                    var w = 1;
                    var action = 'registrarResultado';
                    var equipo1=document.getElementById("txtcargaequipo1").value = equipo1=document.getElementById("txtIdEquipo1").value;
                    var equipo2=document.getElementById("txtcargaequipo2").value = equipo2=document.getElementById("txtIdEquipo2").value;

                    jQuery.post('BL/ResultadosBL.php', {IdFecha: IdFecha, IdCampeonato: IdCampeonato, IdEquipo1: IdEquipo1, IdEquipo2: IdEquipo2, Goles1: Goles1, Goles2: Goles2, PW: w, action: action}, function(data) {
                    if (data.error === 1)
                        {
                        }
                    else
                        {
                        //$('#VentanaRegistro').modal('hide');
                            new PNotify({
                                title: 'Transaccion Exitosa!',
                                text: 'Resultado Registrado Correctamente',
                                type: 'success'
                            });
                           
                        }
                    });
                    $('#VentanaRegistro').modal('hide');
                    cargarTabla();
                }
                else
                {
                    var IdFecha = idFechaSeleccionado;
                    var IdCampeonato = idCampeonatoSeleccionado;
                    var IdEquipo1 = idEquipo1Seleccionado;
                    var IdEquipo2 = idEquipo2Seleccionado;
                    var Goles1 = document.getElementById("txtGoles1").value;
                    var Goles2 = document.getElementById("txtGoles2").value;
                    var w = 0;
                    var action = 'registrarResultado';
                    var equipo1=document.getElementById("txtcargaequipo1").value = equipo1=document.getElementById("txtIdEquipo1").value;
                    var equipo2=document.getElementById("txtcargaequipo2").value = equipo2=document.getElementById("txtIdEquipo2").value;

                    jQuery.post('BL/ResultadosBL.php', {IdFecha: IdFecha, IdCampeonato: IdCampeonato, IdEquipo1: IdEquipo1, IdEquipo2: IdEquipo2, Goles1: Goles1, Goles2: Goles2, PW: w, action: action}, function(data) {
                        if (data.error === 1)
                        {
                        }
                        else
                        {
                            //$('#VentanaRegistro').modal('hide');
                            new PNotify({
                                title: 'Transaccion Exitosa!',
                                text: 'Resultado Registrado Correctamente',
                                type: 'success'
                            });
                            cargarTabla();
                        }
                    });
                    cargartablaJL();
                }
            }
        }
    }
}

function cargartablaJL() {
    var IdEquipo1 = idEquipo1Seleccionado;
        $('#VentanaJL').modal('show');
        $.ajax({
            type: "post",
            dataType: "json",
            url: "BL/ResultadosBL.php",
            data: {action: 'obtenerResultadosJL',IdEquipo1:IdEquipo1},
            success: function(data) {
                $('#tableJL').dataTable({
                    "iDisplayLength": 10,
                    "bProcessing": true,
                    "bPaginate": false,
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
                        //"sUrl": "",
                        "sInfoThousands": ",",
                        "sLoadingRecords": "Cargando...",
                        /*"oAria": {
                            "sSortAscending": ": Activar para ordenar la columna de manera ascendente",
                            "sSortDescending": ": Activar para ordenar la columna de manera descendente"
                        }*/
                    },
                    data: data,
                    columns: [{
                            'data': 'id',
                            "sClass": "justify",
                            "width": "auto",
                            //"visible": false
                        },
                        {
                            'data': 'nombre',
                            "sClass": "justify",
                            "width": "auto"
                        },
                        {
                            "sDefaultContent": "",
                            render: function(data, type, row) {
                                if (type === 'display') {
                                    //return '<input maxlength="2" size="1px" id="txtgoles" name="txtgoles
                                    return '<input maxlength="2" size="1px" id="txtgolese1'+row.id+'" name="txtgoles" value="0">';
                                }
                                return data;
                            },
                            "orderable": "false",
                            "width": "auto"
                        },
                        {
                            "sDefaultContent": "Edit",
                            "width": "auto",
                            'data': 'active',
                            render: function(data, type, row) {
                                if (type === 'display') {
                                    return '<input type="checkbox" id="checkAmarillae1'+row.id+'" class="editor-active">';
                                }
                                return data;
                            }
                        },
                        {
                            "sDefaultContent": "Edit",
                            "width": "auto",
                            'data': 'active',
                            render: function(data, type, row) {
                                if (type === 'display') {
                                    return '<input type="checkbox" id="checkAzule1'+row.id+'" class="editor-active">';
                                }
                                return data;
                            }
                        },
                        {
                            "sDefaultContent": "Edit",
                            "width": "auto",
                            'data': 'active',
                            render: function(data, type, row) {
                                if (type === 'display') {
                                    return '<input type="checkbox" id="checkRojae1'+row.id+'" class="editor-active">';
                                }
                                return data;
                            }
                        }
                    ],
                });
                $('#myPleaseWait').modal('hide');
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

function cargartablaJL1() {
    var IdEquipo2 = idEquipo2Seleccionado;
        $('#VentanaJL1').modal('show');
        $.ajax({
            type: "post",
            dataType: "json",
            url: "BL/ResultadosBL.php",
            data: {action: 'obtenerResultadosJL1',IdEquipo2:IdEquipo2},
            success: function(data) {
                $('#tableJL1').dataTable({
                    "iDisplayLength": 10,
                    "bProcessing": true,
                    "bPaginate": false,
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
                        //"sUrl": "",
                        "sInfoThousands": ",",
                        "sLoadingRecords": "Cargando..."
                    },
                    data: data,
                    columns: [{
                            'data': 'id',
                            "sClass": "justify",
                            "width": "auto"
                            //"visible": false
                        },
                        {
                            'data': 'nombre',
                            "sClass": "justify",
                            "width": "auto"
                        },
                        {
                            "sDefaultContent": "",
                            render: function(data, type, row) {
                                if (type === 'display') {
                                    //return '<input maxlength="2" size="1px" id="txtgoles" name="txtgoles\n\
                                    return '<input maxlength="2" size="1px" id="txtgolese2'+row.id+'" name="txtgoles" value="0">';
                                }
                                return data;
                            },
                            "orderable": "false",
                            "width": "auto"
                        },
                        {
                            "sDefaultContent": "Edit",
                            "width": "auto",
                            'data': 'active',
                            render: function(data, type, row) {
                                if (type === 'display') {
                                    return '<input type="checkbox" id="checkAmarillae2'+row.id+'" class="editor-active">';
                                }
                                return data;
                            }
                        },
                        {
                            "sDefaultContent": "Edit",
                            "width": "auto",
                            'data': 'active',
                            render: function(data, type, row) {
                                if (type === 'display') {
                                    return '<input type="checkbox" id="checkAzule2'+row.id+'" class="editor-active">';
                                }
                                return data;
                            }
                        },
                        {
                            "sDefaultContent": "Edit",
                            "width": "auto",
                            'data': 'active',
                            render: function(data, type, row) {
                                if (type === 'display') {
                                    return '<input type="checkbox" id="checkRojae2'+row.id+'" class="editor-active">';
                                }
                                return data;
                            }
                        }
                    ],
                });
                $('#myPleaseWait').modal('hide');
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

function registrardetalle(lnk) {
    var tabla = document.getElementById('tableJL').rows.length -1;
    for(i = 1; i <= tabla; i++){
        var row = document.getElementById('tableJL').rows[i];
        //var row = lnk.parentNode.parentNode;
        var rowIndex = row.rowIndex - 1;
        var IdJugador = row.cells[0].innerHTML;
        var IdEquipo1 = idEquipo1Seleccionado;
        var IdResultado = idResultadoEditar;
        Goles = document.getElementById('txtgolese1' + IdJugador).value;
        Amarilla = document.getElementById('checkAmarillae1' + IdJugador).checked;
        Azul = document.getElementById('checkAzule1' + IdJugador).checked;
        Roja = document.getElementById('checkRojae1' + IdJugador).checked;
        if(Goles > 0 || Amarilla || Azul  || Roja )
        {
            var action = 'registrarDetalle';
            jQuery.post('BL/ResultadosBL.php', {IdResultado: IdResultado, IdJugador: IdJugador, Amarilla: Amarilla, Azul: Azul, Roja: Roja, Goles: Goles, IdEquipo: IdEquipo1, action: action}, function (data) {
            if (data.error === 1)
            {
                //alert("se jodio esta vaina");
            } else
            {
                    new PNotify({
                    title: 'Transaccion Exitosa!',
                    text: 'Resultado Registrado Correctamente',
                    type: 'success'
                });
                cargartablaJL1();
            }
        });
        }
        else
        {
            cargartablaJL1();
        }
    }
}

function registrardetalle1(lnk) {
   var tabla = document.getElementById('tableJL1').rows.length -1;
    for(i = 1; i <= tabla; i++){
        var row = document.getElementById('tableJL1').rows[i];
        var rowIndex = row.rowIndex - 1;
        var IdJugador = row.cells[0].innerHTML;
        var IdEquipo2 = idEquipo2Seleccionado;
        Goles = document.getElementById('txtgolese2' + IdJugador).value;
        Amarilla = document.getElementById('checkAmarillae2' + IdJugador).checked;
        Azul = document.getElementById('checkAzule2' + IdJugador).checked;
        Roja = document.getElementById('checkRojae2' + IdJugador).checked;
        if(Goles > 0 || Amarilla || Azul  || Roja )
        {
            var action = 'registrarDetalle';
            jQuery.post('BL/ResultadosBL.php', {IdJugador: IdJugador, Amarilla: Amarilla, Azul: Azul, Roja: Roja, Goles: Goles, IdEquipo: IdEquipo2, action: action}, function (data) {
            if (data.error === 1)
            {} 
            else
            {
                    new PNotify({
                    title: 'Transaccion Exitosa!',
                    text: 'Resultado Registrado Correctamente',
                    type: 'success'
                });
                terminarregistro();
            }
        });
        }
        else
        {
            terminarregistro();
        }
    }
}

function terminarregistro() {
    $('#VentanaJL1').modal('hide');
    $('#VentanaJL').modal('hide');
    $('#VentanaRegistro').modal('hide');
    cargarTabla();
}

function actualizarresultado() {
    var verdadero = $('#form1').parsley().validate("blockeditar", true);
    if (verdadero)
    {
	var Checkwe1editar = document.getElementById("chkw1editar").checked;
        var Checkwe2editar = document.getElementById("chkw2editar").checked;
        if ((Checkwe1editar) && (Checkwe2editar))
        {
            new PNotify({
                            title: 'Error!',
                            text: 'No pueden ganar por W dos equipos',
                            type: 'error'
                        });
        }
	else
        {
            if  (Checkwe1editar)
            {
                var IdResultadoEditar = idResultadoEditar;
                var IdFechaEditar = idFechaSeleccionadoEditar;
                var IdCampeonatoEditar = idCampeonatoSeleccionadoEditar;
                var IdEquipo1Editar = idEquipo1SeleccionadoEditar;
                var IdEquipo2Editar = idEquipo2SeleccionadoEditar;
                var Goles1Editar = 3;
                var Goles2Editar = 0;
                var PWeditar = 1;
                var action = 'registrarResultadoeditado';
                var equipo1editar=document.getElementById("txtcargaequipo1Editar").value = equipo1=document.getElementById("txtIdEquipo1Editar").value;
                var equipo2editar=document.getElementById("txtcargaequipo2Editar").value = equipo2=document.getElementById("txtIdEquipo2Editar").value;

                jQuery.post('BL/ResultadosBL.php', {IdResultado: IdResultadoEditar, IdFecha: IdFechaEditar, IdCampeonato: IdCampeonatoEditar, IdEquipo1: IdEquipo1Editar, IdEquipo2: IdEquipo2Editar, Goles1: Goles1Editar, Goles2: Goles2Editar, PW: PWeditar, action: action}, function(data) {
                    if (data.error === 1)
                    {
                    }
                    else
                    {
                            //$('#VentanaRegistro').modal('hide');
                            new PNotify({
                                    title: 'Transaccion Exitosa!',
                                    text: 'Resultado Registrado Correctamente',
                                    type: 'success'
                            });
                            cargarTabla();
                    }
                });
                $('#VentanaEditarRegistro').modal('hide');
                cargarTabla();
            }
            else
            {
                if  (Checkwe2editar)
                {
                    var IdResultadoEditar = idResultadoEditar;
                    var IdFechaEditar = idFechaSeleccionadoEditar;
                    var IdCampeonatoEditar = idCampeonatoSeleccionadoEditar;
                    var IdEquipo1Editar = idEquipo1SeleccionadoEditar;
                    var IdEquipo2Editar = idEquipo2SeleccionadoEditar;
                    var Goles1Editar = 0;
                    var Goles2Editar = 3;
                    var PWeditar = 1;
                    var action = 'registrarResultadoeditado';
                    var equipo1editar=document.getElementById("txtcargaequipo1Editar").value = equipo1=document.getElementById("txtIdEquipo1Editar").value;
                    var equipo2editar=document.getElementById("txtcargaequipo2Editar").value = equipo2=document.getElementById("txtIdEquipo2Editar").value;

                    jQuery.post('BL/ResultadosBL.php', {IdResultado: IdResultadoEditar, IdFecha: IdFechaEditar, IdCampeonato: IdCampeonatoEditar, IdEquipo1: IdEquipo1Editar, IdEquipo2: IdEquipo2Editar, Goles1: Goles1Editar, Goles2: Goles2Editar, PW: PWeditar, action: action}, function(data) {
                            if (data.error === 1)
                            {
                            }
                            else
                            {
                                    //$('#VentanaRegistro').modal('hide');
                                    new PNotify({
                                            title: 'Transaccion Exitosa!',
                                            text: 'Resultado Registrado Correctamente',
                                            type: 'success'
                                    });
                                    cargarTabla();
                            }
                    });
                    $('#VentanaEditarRegistro').modal('hide');
                    cargarTabla();
                }
                else
                {
                        var IdResultadoEditar = idResultadoEditar;
                        var IdFechaEditar = idFechaSeleccionadoEditar;
                        var IdCampeonatoEditar = idCampeonatoSeleccionadoEditar;
                        var IdEquipo1Editar = idEquipo1SeleccionadoEditar;
                        var IdEquipo2Editar = idEquipo2SeleccionadoEditar;
                        var Goles1Editar = document.getElementById("txtGoles1Editar").value;
                        var Goles2Editar = document.getElementById("txtGoles2Editar").value;
                        var PWeditar = 0;
                        var action = 'registrarResultadoeditado';
                        var equipo1editar=document.getElementById("txtcargaequipo1Editar").value = equipo1=document.getElementById("txtIdEquipo1Editar").value;
                        var equipo2editar=document.getElementById("txtcargaequipo2Editar").value = equipo2=document.getElementById("txtIdEquipo2Editar").value;

                        jQuery.post('BL/ResultadosBL.php', {IdResultado: IdResultadoEditar, IdFecha: IdFechaEditar, IdCampeonato: IdCampeonatoEditar, IdEquipo1: IdEquipo1Editar, IdEquipo2: IdEquipo2Editar, Goles1: Goles1Editar, Goles2: Goles2Editar, PW: PWeditar, action: action}, function(data) {
                                if (data.error === 1)
                                {
                                }
                                else
                                {
                                        //$('#VentanaRegistro').modal('hide');
                                        new PNotify({
                                                title: 'Transaccion Exitosa!',
                                                text: 'Resultado Registrado Correctamente',
                                                type: 'success'
                                        });
                                        cargarTabla();
                                }
                        });
                        cargartablaEditarJL();
                }
	    }
        }
    } 
}

//---------------------------
//para autocompletar el campeonato en Edicion
//----------------------------
$(document).ready(function() {
    $('#txtIdCampeonatoEditar').autocomplete({
        source: function(request, response) {
            $.ajax({
                url: 'BL/CampeonatosBL.php',
                dataType: "json",
                type: "POST",
                data: {
                    term: request.term,
                    action: 'autoCompletarCampeonato'
                },
                success: function(data) {
                    response($.map(data, function(objeto) {
                        return {
                            label: objeto.value,
                            value: objeto.value,
                            id: objeto.id,
                        }
                    }));
                }
            });
        },
        select: function(event, ui) {
            idCampeonatoSeleccionadoEditar = ui.item.id;
            document.getElementById("txtIdCampeonatoEditar").value = ui.item.value;
            document.getElementById("txtIdEquipo1Editar").disabled = false;
            document.getElementById("txtGoles1Editar").disabled = false;
            return false;
        },
        autoFocus: true,
        minLength: 3
    });
});
//---------------------------
//para autocompletar la Fecha en Edicion
//----------------------------
$(document).ready(function() {
    $('#txtIdFechaEditar').autocomplete({
        source: function(request, response) {
            $.ajax({
                url: 'BL/FechasBL.php',
                dataType: "json",
                type: "POST",
                data: {
                    term: request.term,
                    action: 'autoCompletarFechas'
                },
                success: function(data) {
                    response($.map(data, function(objeto) {
                        return {
                            label: objeto.value,
                            value: objeto.value,
                            id: objeto.id
                        }
                    }));
                }
            });
        },
        select: function(event, ui) {
            idFechaSeleccionadoEditar = ui.item.id;
            document.getElementById("txtIdFechaEditar").value = ui.item.value;
            document.getElementById("txtIdCampeonatoEditar").disabled = false;
            document.getElementById("chkw1editar").disabled = false;
            return false;
        },
        autoFocus: true,
        minLength: 3
    });
});
//---------------------------
//para autocompletar el equipo 1 En edicion
//----------------------------
$(document).ready(function() {
    $('#txtIdEquipo1Editar').autocomplete({
        source: function(request, response) {
            $.ajax({
                url: 'BL/EquiposBL.php',
                dataType: "json",
                type: "POST",
                data: {
                    term: request.term,
                    action: 'autoCompletarEquipo',
                    IdCampeonato: idCampeonatoSeleccionadoEditar
                },
                success: function(data) {
                    response($.map(data, function(objeto) {
                        return {
                            label: objeto.value,
                            value: objeto.value,
                            id: objeto.id
                        }
                    }));
                }
            });
        },
        select: function(event, ui) {
            idEquipo1SeleccionadoEditar = ui.item.id;
            document.getElementById("txtIdEquipo1Editar").value = ui.item.value;
            document.getElementById("txtIdEquipo2Editar").disabled = false;
            document.getElementById("txtGoles2Editar").disabled = false;
            document.getElementById("chkw2editar").disabled = false;
            return false;
        },
        autoFocus: true,
        minLength: 3
    });
});
//---------------------------
//para autocompletar el equipo 2 en Edicion
//----------------------------
$(document).ready(function() {
    $('#txtIdEquipo2Editar').autocomplete({
        source: function(request, response) {
            $.ajax({
                url: 'BL/EquiposBL.php',
                dataType: "json",
                type: "POST",
                data: {
                    term: request.term,
                    action: 'autoCompletarEquipo',
                    IdCampeonato: idCampeonatoSeleccionadoEditar
                },
                success: function(data) {
                    response($.map(data, function(objeto) {
                        return {
                            label: objeto.value,
                            value: objeto.value,
                            id: objeto.id
                        }
                    }));
                }
            });
        },
        select: function(event, ui) {
            idEquipo2SeleccionadoEditar = ui.item.id;
            document.getElementById("txtIdEquipo2Editar").value = ui.item.value;
            document.getElementById("ContinuaEdicion").disabled = false;
            return false;
        },
        autoFocus: true,
        minLength: 3
    });
});

function cargartablaEditarJL() {
    var IdResultado = idResultadoEditar;
    var IdEquipo1 = idEquipo1SeleccionadoEditar;
        $('#VentanaJLEditar').modal('show');
        $.ajax({
            type: "post",
            dataType: "json",
            url: "BL/ResultadosBL.php",
            data: {action: 'obtenerResultadosEditarJL',IdResultado:IdResultado,IdEquipo:IdEquipo1},
            success: function(data) {
                $('#tableJLEditar').dataTable({
                    "iDisplayLength": 10,
                    "bProcessing": true,
                    "bPaginate": false,
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
                        //"sUrl": "",
                        "sInfoThousands": ",",
                        "sLoadingRecords": "Cargando...",
                        /*"oAria": {
                            "sSortAscending": ": Activar para ordenar la columna de manera ascendente",
                            "sSortDescending": ": Activar para ordenar la columna de manera descendente"
                        }*/
                    },
                    data: data,
                    columns: [{
                            'data': 'id',
                            "sClass": "justify",
                            "width": "auto",
                            "bSortable": false
                            //"visible": false
                        },
                        {
                            'data': 'nombre',
                            "sClass": "justify",
                            "width": "auto",
                            "bSortable": false
                        },
                        {
                            "width": "auto",
                            "bSortable": false,
                            'data': 'active',
                            "sDefaultContent": "Edit",
                            render: function(data, type, row) {
                                if (type === 'display') {
                                    if(parseInt(row.Goles) > 0)
                                        return '<input maxlength="2" size="1px" id="txtgolese1'+row.id+'" value="'+row.Goles+'">';
                                    else
                                        return '<input maxlength="2" size="1px" id="txtgolese1'+row.id+'" value="0">';
                                }
                                return data;
                            },
                        },
                        {
                            "sDefaultContent": "Edit",
                            "width": "auto",
                            "bSortable": false,
                            'data': 'active',
                            render: function(data, type, row) {
                                if (type === 'display') {
                                        if(row.amarilla === '1')
                                            return '<input type="checkbox" id="checkAmarillae1'+row.id+'" class="editor-active" checked >';
                                        else
                                            return '<input type="checkbox" id="checkAmarillae1'+row.id+'" class="editor-active" >';
                                }
                                return data;
                            }
                        },
                        {
                            "sDefaultContent": "Edit",
                            "width": "auto",
                            "bSortable": false,
                            'data': 'active',
                            render: function(data, type, row) {
                                if (type === 'display') {
                                        if(row.azul === '1')
                                            return '<input type="checkbox" id="checkAzule1'+row.id+'" class="editor-active" checked >';
                                        else
                                            return '<input type="checkbox" id="checkAzule1'+row.id+'" class="editor-active">';
                                }
                                return data;
                            }
                        },
                        {
                            "sDefaultContent": "Edit",
                            "width": "auto",
                            "bSortable": false,
                            'data': 'active',
                            render: function(data, type, row) {
                                if (type === 'display') {
                                        if(row.roja === '1')
                                            return '<input type="checkbox" id="checkRojae1'+row.id+'" class="editor-active" checked>';
                                        else
                                            return '<input type="checkbox" id="checkRojae1'+row.id+'" class="editor-active">';
                                }
                                return data;
                            }
                        },
                        {
                        data: null,
                        width: "auto",
                        className: "center",
                        bSortable: false,
                        defaultContent: '<a href="#" id="Eliminar" class="btn btn-danger btn-xs" Title="Eliminar" OnClick="return EliminarJugadorDetalle(this)"><i class="fa fa-trash-o"></i></a>'
                        }],
                });
                $('#myPleaseWait').modal('hide');
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

function cargartablaEditarJL1() {
    var IdResultado = idResultadoEditar;
    var IdEquipo2 = idEquipo2SeleccionadoEditar;
        $('#VentanaJL1Editar').modal('show');
        $.ajax({
            type: "post",
            dataType: "json",
            url: "BL/ResultadosBL.php",
            data: {action: 'obtenerResultadosEditarJL',IdResultado:IdResultado, IdEquipo:IdEquipo2},
            success: function(data) {
                $('#tableJL1Editar').dataTable({
                    "iDisplayLength": 10,
                    "bProcessing": true,
                    "bPaginate": false,
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
                        //"sUrl": "",
                        "sInfoThousands": ",",
                        "sLoadingRecords": "Cargando...",
                        /*"oAria": {
                            "sSortAscending": ": Activar para ordenar la columna de manera ascendente",
                            "sSortDescending": ": Activar para ordenar la columna de manera descendente"
                        }*/
                    },
                    data: data,
                    columns: [{
                            'data': 'id',
                            "sClass": "justify",
                            "width": "auto",
                            "bSortable": false
                            //"visible": false
                        },
                        {
                            'data': 'nombre',
                            "sClass": "justify",
                            "width": "auto",
                            "bSortable": false
                        },
                        {
                            "width": "auto",
                            "bSortable": false,
                            'data': 'active',
                            "sDefaultContent": "",
                            render: function(data, type, row) {
                                if (type === 'display') {
                                    if(parseInt(row.Goles) > 0){
                                        return '<input maxlength="2" size="1px" id="txtgolese2'+row.id+'" value="'+row.Goles+'">';
                                    }
                                    else
                                        return '<input maxlength="3" size="1px" id="txtgolese2'+row.id+'" value="0">';
                                }
                                return data;
                            }
                        },
                        {
                            "sDefaultContent": "Edit",
                            "width": "auto",
                            "bSortable": false,
                            'data': 'active',
                            render: function(data, type, row) {
                                if (type === 'display') {
                                        if(row.amarilla === '1')
                                            return '<input type="checkbox" id="checkAmarillae2'+row.id+'" class="editor-active" checked >';
                                        else
                                            return '<input type="checkbox" id="checkAmarillae2'+row.id+'" class="editor-active" >';
                                }
                                return data;
                            }
                        },
                        {
                            "sDefaultContent": "Edit",
                            "width": "auto",
                            "bSortable": false,
                            'data': 'active',
                            render: function(data, type, row) {
                                if (type === 'display') {
                                        if(row.azul === '1')
                                            return '<input type="checkbox" id="checkAzule2'+row.id+'" class="editor-active" checked >';
                                        else
                                            return '<input type="checkbox" id="checkAzule2'+row.id+'" class="editor-active">';
                                }
                                return data;
                            }
                        },
                        {
                            "sDefaultContent": "Edit",
                            "width": "auto",
                            "bSortable": false,
                            'data': 'active',
                            render: function(data, type, row) {
                                if (type === 'display') {
                                        if(row.roja === '1')
                                            return '<input type="checkbox" id="checkRojae2'+row.id+'" class="editor-active" checked>';
                                        else
                                            return '<input type="checkbox" id="checkRojae2'+row.id+'" class="editor-active">';
                                }
                                return data;
                            }
                        },
                        {
                        data: null,
                        width: "auto",
                        className: "center",
                        bSortable: false,
                        defaultContent: '<a href="#" id="Eliminar" class="btn btn-danger btn-xs" Title="Eliminar" OnClick="return EliminarJugadorDetalle1(this)"><i class="fa fa-trash-o"></i></a>'
                    }
                    ],
                });
                $('#myPleaseWait').modal('hide');
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

function registrardetalleeditado(lnk) {
    var tabla = document.getElementById('tableJLEditar').rows.length -1;
    for(i = 1; i <= tabla; i++){
        var row = document.getElementById('tableJLEditar').rows[i];
        //var row = lnk.parentNode.parentNode;
        var rowIndex = row.rowIndex - 1;
        var IdJugador = row.cells[0].innerHTML;
        var IdEquipo1 = idEquipo1SeleccionadoEditar;
        var IdResultado = idResultadoEditar;
        Goles = document.getElementById('txtgolese1' + IdJugador).value;
        Amarilla = document.getElementById('checkAmarillae1' + IdJugador).checked;
        Azul = document.getElementById('checkAzule1' + IdJugador).checked;
        Roja = document.getElementById('checkRojae1' + IdJugador).checked;
        if(Goles > 0 || Amarilla || Azul  || Roja ){
            var action = 'registrarDetalleEditado';
            jQuery.post('BL/ResultadosBL.php', {IdResultado: IdResultado, IdJugador: IdJugador, Amarilla: Amarilla, Azul: Azul, Roja: Roja, Goles: Goles, IdEquipo: IdEquipo1, action: action}, function (data) {
            if (data.error === 1)
            {
                //alert("se jodio esta vaina");
            } else
            {
                    new PNotify({
                    title: 'Transaccion Exitosa!',
                    text: 'Resultado Registrado Correctamente',
                    type: 'success'
                });
                cargartablaEditarJL1();
            }
        });
        }
        else{
            //alert("Si ingreso");
            cargartablaEditarJL1();
        }
    }
}

function registrardetalleeditado1(lnk) {
    var tabla = document.getElementById('tableJL1Editar').rows.length -1;
    for(i = 1; i <= tabla; i++){
        var row = document.getElementById('tableJL1Editar').rows[i];
        //var row = lnk.parentNode.parentNode;
        var rowIndex = row.rowIndex - 1;
        
        var IdJugador = row.cells[0].innerHTML;
        var IdEquipo2 = idEquipo2SeleccionadoEditar;
        var IdResultado = idResultadoEditar;
        Goles = document.getElementById('txtgolese2' + IdJugador).value;
        Amarilla = document.getElementById('checkAmarillae2' + IdJugador).checked;
        Azul = document.getElementById('checkAzule2' + IdJugador).checked;
        Roja = document.getElementById('checkRojae2' + IdJugador).checked;
        if(Goles > 0 || Amarilla || Azul  || Roja ){
                var action = 'registrarDetalleEditado';
                jQuery.post('BL/ResultadosBL.php', {IdResultado: IdResultado, IdJugador: IdJugador, Amarilla: Amarilla, Azul: Azul, Roja: Roja, Goles: Goles, IdEquipo: IdEquipo2, action: action}, function (data) {
                if (data.error === 1)
                {
                    //alert("se jodio esta vaina");
                } else
                {
                        new PNotify({
                        title: 'Transaccion Exitosa!',
                        text: 'Resultado Registrado Correctamente',
                        type: 'success'
                    });
                    terminarregistroEditar();
                }
            });
        }
        else{
            //alert("Si ingreso");
            terminarregistroEditar();
        }
    }
}

function EliminarJugadorDetalle(lnk){
    var IdResultadoEditar = idResultadoEditar;
    var row = lnk.parentNode.parentNode;
    var rowIndex = row.rowIndex - 1;
    var IdJugador = row.cells[0].innerHTML;
    var action = 'EliminarJugadorDetalle';
    jQuery.post('BL/ResultadosBL.php', {IdResultado: IdResultadoEditar, IdJugador: IdJugador, action: action}, function(data) {
        if (data.error === 1)
        {
            //alert("se jodio esta vaina");
        }
        else
        {
            new PNotify({
                title: 'Transaccion Exitosa!',
                text: 'Resultado Registrado Correctamente',
                type: 'success'
            });
            
            cargartablaEditarJL();
        }
    });
}

function EliminarJugadorDetalle1(lnk){
    var IdResultadoEditar = idResultadoEditar;
    var row = lnk.parentNode.parentNode;
    var rowIndex = row.rowIndex - 1;
    var IdJugador = row.cells[0].innerHTML;
    var action = 'EliminarJugadorDetalle';
    jQuery.post('BL/ResultadosBL.php', {IdResultado: IdResultadoEditar, IdJugador: IdJugador, action: action}, function(data) {
        if (data.error === 1)
        {
            //alert("se jodio esta vaina");
        }
        else
        {
            new PNotify({
                title: 'Transaccion Exitosa!',
                text: 'Resultado Registrado Correctamente',
                type: 'success'
            });
            cargartablaEditarJL1();
        }
    });
}

function terminarregistroEditar() {
    $('#VentanaJL1Editar').modal('hide');
    $('#VentanaJLEditar').modal('hide');
    $('#VentanaEditarRegistro').modal('hide');
    cargarTabla();
}

function ObtenerDetalles(lnk){
    var row = lnk.parentNode.parentNode;
    var rowIndex = row.rowIndex - 1;
    IdResultadoDetalle = row.cells[0].innerHTML;
    $('#VerDetalles').modal('show');
    FechaDetalle = document.getElementById("FechaDetalle").value = row.cells[1].innerHTML;
    CampeonatoDetalle = document.getElementById("CampeonatoDetalle").value = row.cells[2].innerHTML;
    Equipo1Detalle= document.getElementById("Equipo1Detalle").value = row.cells[3].innerHTML;
    document.getElementById("GolesE1Detalle").value = row.cells[5].innerHTML;
    Equipo2Detalle = document.getElementById("Equipo2Detalle").value = row.cells[4].innerHTML;
    document.getElementById("GolesE2Detalle").value = row.cells[6].innerHTML;
    //var tabla = $('#tabledetallesgolese1').dataTable();
    //tabla.empty();
    $.ajax({
            type: "post",
            dataType: "json",
            url: "BL/ResultadosBL.php",
            data: {action: 'obtenerresultadosdetallese1',IdResultado:IdResultadoDetalle, IdEquipo:Equipo1Detalle},
            success: function(data) {
                $('#tabledetallesgolese1').dataTable({
                    "bPaginate": false,
                    "bFilter": false,
                    "bInfo":false,
                    "bDestroy":true,
                    "bAutoWidth": false,
                    data: data,
                    columns: [{
                            'data': 'Name',
                            "sClass": "justify",
                            "width": "auto",
                            "bSortable": false
                            //"visible": false
                        },
                        {
                            'data': 'Goals',
                            "sClass": "justify",
                            "bSortable": false,
                            "width": "auto"
                        },
                        {
                            "sDefaultContent": "Edit",
                            "width": "auto",
                            "bSortable": false,
                            'data': 'active',
                            render: function(data, type, row) {
                                if (type === 'display') {
                                        if(row.amarilla === '1')
                                            return '<input type="checkbox" class="editor-active" checked disabled>';
                                        else
                                            return '<input type="checkbox" class="editor-active" disabled>';
                                }
                                return data;
                            }
                        },
                        {
                            "sDefaultContent": "Edit",
                            "width": "auto",
                            "bSortable": false,
                            'data': 'active',
                            render: function(data, type, row) {
                                if (type === 'display') {
                                        if(row.azul === '1')
                                            return '<input type="checkbox" class="editor-active" checked disabled>';
                                        else
                                            return '<input type="checkbox" class="editor-active" disabled>';
                                }
                                return data;
                            }
                        },
                        {
                            "sDefaultContent": "Edit",
                            "width": "auto",
                            "bSortable": false,
                            'data': 'active',
                            render: function(data, type, row) {
                                if (type === 'display') {
                                        if(row.roja === '1')
                                            return '<input type="checkbox" class="editor-active" checked disabled>';
                                        else
                                            return '<input type="checkbox" class="editor-active" disabled>';
                                }
                                return data;
                            }
                        }],
                });  
            },
        });
        $.ajax({
            type: "post",
            dataType: "json",
            url: "BL/ResultadosBL.php",
            data: {action: 'obtenerresultadosdetallese2',IdResultado:IdResultadoDetalle, IdEquipo:Equipo2Detalle},
            success: function(data) {
                $('#tabledetallesgolese2').dataTable({
                    "bPaginate": false,
                    "bFilter": false,
                    "bInfo":false,
                    "bDestroy":true,
                    "bAutoWidth": false,
                    data: data,
                    columns: [{
                            'data': 'Name',
                            "sClass": "justify",
                            "width": "auto",
                            "bSortable": false
                            //"visible": false
                        },
                        {
                            'data': 'Goals',
                            "sClass": "justify",
                            "bSortable": false,
                            "width": "auto"
                        },
                        {
                            "sDefaultContent": "Edit",
                            "width": "auto",
                            "bSortable": false,
                            'data': 'active',
                            render: function(data, type, row) {
                                if (type === 'display') {
                                        if(row.amarilla === '1')
                                            return '<input type="checkbox" class="editor-active" checked disabled>';
                                        else
                                            return '<input type="checkbox" class="editor-active" disabled >';
                                }
                                return data;
                            }
                        },
                        {
                            "sDefaultContent": "Edit",
                            "width": "auto",
                            "bSortable": false,
                            'data': 'active',
                            render: function(data, type, row) {
                                if (type === 'display') {
                                        if(row.azul === '1')
                                            return '<input type="checkbox" class="editor-active" checked disabled>';
                                        else
                                            return '<input type="checkbox" class="editor-active" disabled>';
                                }
                                return data;
                            }
                        },
                        {
                            "sDefaultContent": "Edit",
                            "width": "auto",
                            "bSortable": false,
                            'data': 'active',
                            render: function(data, type, row) {
                                if (type === 'display') {
                                        if(row.roja === '1')
                                            return '<input type="checkbox" class="editor-active" checked disabled>';
                                        else
                                            return '<input type="checkbox" class="editor-active" disabled>';
                                }
                                return data;
                            }
                        }],
                });
            },
        });
}

function terminarconsulta(){
    $('#VerDetalles').modal('hide');
    cargarTabla();
}