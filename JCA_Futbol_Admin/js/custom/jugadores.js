/*
 * Javascript que contiene la logica para el modulo de Equipo
 * @author Sebastian Melo
 * @created 12/01/2017
 * @copyright DG Solutions sas
 */

var idJugadorEditar = "";
 var idJugadorEliminar = "";
 var idCampeonatoSeleccionado = "";
 var idEquipoSeleccionado = "";
$(document).ready(function () {
   if(SessionPerfil != "JUGADOR"){
    $('#myPleaseWait').modal('show');
    cargarTabla();
}
});

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
            consultarEquiposCampeonato();
            return false;
        },
        autoFocus: true,
        minLength: 3
    });

});
function consultarEquiposCampeonato()
{
    $('#txtEquipo').autocomplete({
            source: function (request, response) {
                $.ajax({
                    url: 'BL/JugadoresBL.php',
                    dataType: "json",
                    type: "POST",
                    data: {
                        term: request.term,
                        idCampeonato: idCampeonatoSeleccionado,
                        action: 'AutoCompletarEquipos'
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
                idEquipoSeleccionado = ui.item.id;

                document.getElementById("txtEquipo").value = ui.item.value;

                document.getElementById("btnRegistrar").disabled = false;
                cargarTablaFiltrada(idEquipoSeleccionado);
                return false;
            },
            autoFocus: true,
            minLength: 3
        });
    }

function obtenerLineaEliminar(lnk)
{
    var row = lnk.parentNode.parentNode;
    var rowIndex = row.rowIndex - 1;
    idJugadorEliminar = row.cells[1].innerHTML;
    VentanaEliminar('Confirmar Eliminacion', '¿Esta seguro de eliminar el ID <b>' + idJugadorEliminar + '</b>?', 'SI', 'NO');
}
function obtenerLineaEditar(lnk)
{
    var row=lnk.parentNode.parentNode;
    var rowIndex=row.rowIndex-1;
    idJugadorEditar=row.cells[1].innerHTML;
    $('#VentanaEditar').modal('show');
    document.getElementById("txtIdJugadorEditar").value = row.cells[1].innerHTML;
    document.getElementById("txtNombreJugadorEditar").value=row.cells[2].innerHTML;
    document.getElementById("txtDocumentoEditar").value=row.cells[3].innerHTML;
    document.getElementById("txtCorreoElectronicoEditar").value=row.cells[4].innerHTML;
    document.getElementById("txtCelularEditar").value=row.cells[5].innerHTML;
    document.getElementById("chkDirectorTecnicoEditar").checked= row.cells[6].innerHTML.includes("checked");
    document.getElementById("chkDelegadoEditar").checked=row.cells[7].innerHTML.includes("checked");
    document.getElementById("chkRepresentanteLegalEditar").checked=row.cells[8].innerHTML.includes("checked");
    //if(row.cells[6].innerHTML.includes("checked"))
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
             if(SessionPerfil != "JUGADOR"){
                 cargarTablaFiltrada(idEquipoSeleccionado);
            }else{
                cargarTablaFiltrada(idEquipoSession);
                cargarCantidadJugadores(idEquipoSession);
            }
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
                "responsive":false,
                "tableTools": {
                    "sSwfPath": "http://cdn.datatables.net/tabletools/2.2.2/swf/copy_csv_xls_pdf.swf",
                    aButtons: [
                        {sExtends: "csv",
                            "sButtonText": '<br><a href="#" data-dismiss="modal" class="label label-primary" OnClick="return obtenerLineaEliminar(this)"><i class="fa fa-file-excel-o"></i> Descargar </a><br>',
                            sFileName: 'Equipos.csv',
                            sFieldSeperator: ",",
                            exportOptions: {columns: [0, 1, 2, 3, 4, 5, 6, 7, 8,9,10]}
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
                        bSortable: false
                    },
                    {
                        'data': 'IdJugador',
                        "sClass": "center",
                        "width": "auto"
                    },
                    {
                        'data': 'NombreJugador',
                        "sClass": "center",
                        "width": "auto"
                    },
                    {
                        'data': 'Documento',
                        "sClass": "center",
                        "width": "auto"
                    },
                    {
                        'data': 'CorreoElectronico',
                        "sClass": "center",
                        "width": "auto"
                    },
                    {
                        'data': 'Celular',
                        "sClass": "center",
                        "width": "auto"
                    },
                    {
                        'data': 'DT',
                        "sClass": "center",
                        "width": "auto"
                    },
                    {
                        'data': 'Delegado',
                        "sClass": "center",
                        "width": "auto"
                    },
                    {
                        'data': 'RepresentanteLegal',
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
                    },
                    /*{
                        data: null,
                        className: "center",
                        bSortable: false,
                        render: function(data, type, row) {
                            if (type === 'display') {
                                    if(SessionPerfil != "JUGADOR")
                                        return '<a href="#" data-dismiss="modal" class="btn btn-info btn-xs" Title="Carnet" OnClick="return generarCarnet(this)"><i class="fa fa-credit-card"></i></a>';
                                    else
                                        return '';
                            }
                            return data;
                        }
                    }
					*/
					{
                        data: null,
                        className: "center",
                        bSortable: false,
						defaultContent: '<a href="#" data-dismiss="modal" class="btn btn-info btn-xs" Title="Carnet" OnClick="return generarCarnet(this)"><i class="fa fa-credit-card"></i></a>'
                    }
                  ],
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

//Metodo que carga la informacion en la tabla
function cargarTablaFiltrada(idEquipoSeleccionado) {
    $.ajax({
        type: "post",
        dataType: "json",
        url: "BL/JugadoresBL.php",
        data: {
            idEquipo: idEquipoSeleccionado
            , action: 'obtenerJugadoresFlitro'
        },
        success: function (data) {
            $('#tableJugadores').dataTable({
                "iDisplayLength": 10,
                "bProcessing": true,
                "bPaginate": true,
                "bDestroy": true,
                "sPaginationType": "full_numbers",
                "sDom": 'T<"clear">lfrtip',
                "responsive":false,
                "tableTools": {
                    "sSwfPath": "http://cdn.datatables.net/tabletools/2.2.2/swf/copy_csv_xls_pdf.swf",
                    aButtons: [
                        {sExtends: "csv",
                            "sButtonText": '<br><a href="#" data-dismiss="modal" class="label label-primary" OnClick="return obtenerLineaEliminar(this)"><i class="fa fa-file-excel-o"></i> Descargar </a><br>',
                            sFileName: 'Equipos.csv',
                            sFieldSeperator: ",",
                            exportOptions: {columns: [0, 1, 2, 3, 4, 5, 6, 7, 8,9,10]}
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
                        bSortable: false
                    },
                    {
                        'data': 'IdJugador',
                        "sClass": "center",
                        "width": "auto"
                    },
                    {
                        'data': 'NombreJugador',
                        "sClass": "center",
                        "width": "auto"
                    },
                    {
                        'data': 'Documento',
                        "sClass": "center",
                        "width": "auto"
                    },
                    {
                        'data': 'CorreoElectronico',
                        "sClass": "center",
                        "width": "auto"
                    },
                    {
                        'data': 'Celular',
                        "sClass": "center",
                        "width": "auto"
                    },
                    {
                        'data': 'DT',
                        "sClass": "center",
                        "width": "auto"
                    },
                    {
                        'data': 'Delegado',
                        "sClass": "center",
                        "width": "auto"
                    },
                    {
                        'data': 'RepresentanteLegal',
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
                    },
					/*
                    {
                        data: null,
                        className: "center",
                        bSortable: false,
                        render: function(data, type, row) {
                            if (type === 'display') {
                                    if(SessionPerfil != "JUGADOR")
                                        return '<a href="#" data-dismiss="modal" class="btn btn-info btn-xs" Title="Carnet" OnClick="return generarCarnet(this)"><i class="fa fa-credit-card"></i></a>';
                                    else
                                        return '';
                            }
                            return data;
                        }
                    }
					*/
					{
                        data: null,
                        className: "center",
                        bSortable: false,
						defaultContent: '<a href="#" data-dismiss="modal" class="btn btn-info btn-xs" Title="Carnet" OnClick="return generarCarnet(this)"><i class="fa fa-credit-card"></i></a>'
                    }
                  ],
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

function cargarCantidadJugadores(idEquipoSeleccionado)
{
  var action = 'cantidadJugadores';
  var registrados="";
  jQuery.post('BL/JugadoresBL.php', {idEquipoSeleccionado: idEquipoSeleccionado, action: action}, function (data) {
      if (data.error === 1)
      {
          alert("ERROR");
      } else
      {
          var obj = JSON.parse(data);
          registrados= obj[0].CantidadRegistrados+"/"+obj[0].CantidadMaxima;
          var CantidadRegistrados = obj[0].CantidadRegistrados;
          var CantidadMaxima = obj[0].CantidadMaxima;
          //document.getElementById("btnRegistrar").insertAdjacentHTML("afterbegin", " <span class='badge'>"+registrados+"</span>");
          document.getElementById("btnRegistrar").innerHTML="Registrar Jugador <span class='badge'>"+registrados+"</span>";
          if( parseInt(CantidadRegistrados) >= parseInt(CantidadMaxima))
          {
            document.getElementById("btnRegistrar").disabled = true;
          }else
          {
            document.getElementById("btnRegistrar").disabled = false;
          }
      }
  });
}

//Metodo que almacena el equipo en la base de datos
function guardarJugador(){

     if(SessionPerfil === "JUGADOR"){
         idEquipoSeleccionado=idEquipoSession;
     }

    var verdadero = $('#form1').parsley().validate("block1", true);
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

            jQuery.post('BL/JugadoresBL.php', {NombreJugador: NombreJugador, Documento: Documento, CorreoElectronico: CorreoElectronico, Celular: Celular,DT:DT, Delegado:Delegado,RepresentanteLegal:RepresentanteLegal, Url:Url,idEquipoSeleccionado: idEquipoSeleccionado,action: action}, function (data) {
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
                    if(SessionPerfil != "JUGADOR"){
                        cargarTablaFiltrada(idEquipoSeleccionado);
                    }else{
                        cargarTablaFiltrada(idEquipoSession)
                         cargarCantidadJugadores(idEquipoSession);
                    }
                }
            });
        }
    }
}
function actualizarJugador(){
    var verdadero = $('#form1').parsley().validate("block2", true);
    if (verdadero)
    {
        {
            console.log("ingreso");
            var NombreJugadorEditar = document.getElementById("txtNombreJugadorEditar").value;
            var DocumentoEditar = document.getElementById("txtDocumentoEditar").value;
            var CorreoElectronicoEditar = document.getElementById("txtCorreoElectronicoEditar").value;
            var CelularEditar = document.getElementById("txtCelularEditar").value;
            var DTEditar = document.getElementById("chkDirectorTecnicoEditar").checked;
            var DelegadoEditar = document.getElementById("chkDelegadoEditar").checked;
            var RepresentanteLegalEditar = document.getElementById("chkRepresentanteLegalEditar").checked;
            var UrlEditar = document.getElementById("archivoImageEditar").value;
            UrlEditar = UrlEditar.replace("C:\\fakepath\\","");
            var idJugadorEditar = document.getElementById("txtIdJugadorEditar").value;

            var action = 'ActualizarJugador';

            jQuery.post('BL/JugadoresBL.php', {idJugadorEditar:idJugadorEditar ,NombreJugadorEditar: NombreJugadorEditar, DocumentoEditar: DocumentoEditar, CorreoElectronicoEditar: CorreoElectronicoEditar, CelularEditar: CelularEditar,DTEditar:DTEditar, DelegadoEditar:DelegadoEditar,RepresentanteLegalEditar:RepresentanteLegalEditar, UrlEditar:UrlEditar,action: action}, function (data) {
                if (data.error === 1)
                {

                } else
                {
                    $('#VentanaEditar').modal('hide');
                    new PNotify({
                        title: 'Transaccion Exitos!',
                        text: 'Jugador Actualizado Correctamente',
                        type: 'success'
                    });
                    if(SessionPerfil != "JUGADOR"){
						cargarTabla();
                    }else{
                        cargarTablaFiltrada(idEquipoSession)
                    }
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
//Metodo que consulta los grupos del campeonato seleccionado
function consultarEquipos()
{
    var ddlGrupoEquipo = document.getElementById("ddlGrupoEquipo");
    var action = 'consultarEquipos';
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


function generarCarnet(lnk)
{
  $('#myPleaseWait').modal('show');
  var row = lnk.parentNode.parentNode;
  var rowIndex = row.rowIndex - 1;
  idJugadorGenerarCarnet = row.cells[1].innerHTML;

    $.ajax({
        type: "POST",
        url: 'BL/ReportesBL.php',
        data: {action: 'generarCarnetJugador', idJugadorGenerarCarnet: idJugadorGenerarCarnet}
      })
      .done(function (data, textStatus, jqXHR) {
                if (data.error === 1)
                {
                  $('#myPleaseWait').modal('hide');
                } else
                {
              $('#VentanaGenerarCarnet').modal('show');
                  var divCarnet1=document.getElementById("divCarnet");
                  divCarnet1.innerHTML="";

                   var divCarnet=document.getElementById("divCarnet");
                   var object="<object type='application/pdf' data='"+data+"' width='100%' height='900px'></object>";
                   divCarnet.innerHTML+=object;
                   $('#myPleaseWait').modal('hide');
                }          })
            .fail(function (jqXHR, textStatus, errorThrown) {
                if (console && console.log) {
                    console.log("La solicitud a fallado: " + textStatus);
                }
            });
}
