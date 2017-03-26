var idCampeonatoSeleccionado = "";
/*---------------------------
 Autocompletar Campeonato
 ----------------------------*/
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
            document.getElementById("txtCampeonato").disabled = true;

            return false;
        },
        autoFocus: true,
        minLength: 3
    });
});

/*---------------------------
 Limpiar reporte
 ----------------------------*/
function limpiarReporte()
{
    document.getElementById("txtCampeonato").disabled = false;
    document.getElementById("txtCampeonato").value = "";
}

function generarReporte()
{
	$('#myPleaseWait').modal('show');
    jQuery.post('BL/ReportesBL.php', {action: 'obtenerReporte'}, function (data) {
        if (data.error === 1)
        {
            $('#myPleaseWait').modal('hide');
        }
        else
        {
          var obj = JSON.parse(data);
          window.location.href = obj.url;
          $('#myPleaseWait').modal('hide');
        }
    });
}

function generarReporteGoles()
{
	$('#myPleaseWait').modal('show');
      var nombreCampeonato=document.getElementById("txtCampeonato").value;
    jQuery.post('BL/PlantillasBL.php', {action: 'generarReporteGoles', idCampeonato: idCampeonatoSeleccionado, nombreCampeonato:nombreCampeonato}, function (data) {
        if (data.error === 1)
        {
            $('#myPleaseWait').modal('hide');
        }
        else
        {
          var obj = JSON.parse(data);
          window.location.href = obj.url;
          $('#myPleaseWait').modal('hide');
        }
    });
	$('#myPleaseWait').modal('hide');
}

function generarReporteCampeonato()
{
	$('#myPleaseWait').modal('show');
    var nombreCampeonato=document.getElementById("txtCampeonato").value;

    jQuery.post('BL/PlantillasBL.php', {action: 'generarReporteCampeonato', idCampeonato: idCampeonatoSeleccionado, nombreCampeonato:nombreCampeonato}, function (data) {
        if (data.error === 1)
        {
            $('#myPleaseWait').modal('hide');
        }
        else
        {
            var obj = JSON.parse(data);
            window.location.href = obj.url;
            $('#myPleaseWait').modal('hide');
        }
    });
	$('#myPleaseWait').modal('hide');
}

function generarReporteFairPlayCampeonato()
{
	$('#myPleaseWait').modal('show');
    var nombreCampeonato=document.getElementById("txtCampeonato").value;
    jQuery.post('BL/PlantillasBL.php', {action: 'generarReporteJuegoLimpioCampeonato', idCampeonato: idCampeonatoSeleccionado, nombreCampeonato:nombreCampeonato}, function (data) {
        if (data.error === 1)
        {
            $('#myPleaseWait').modal('hide');
        }
        else
        {
            var obj = JSON.parse(data);
            window.location.href = obj.url;
            $('#myPleaseWait').modal('hide');
        }
    });
	$('#myPleaseWait').modal('hide');
}



function generarReporteAmonestados()
{
  $('#myPleaseWait').modal('show');
  var nombreCampeonato=document.getElementById("txtCampeonato").value;
  var action="generarReporteAmonestados";
  jQuery.post('BL/PlantillasBL.php', {action: action, idCampeonato: idCampeonatoSeleccionado,nombreCampeonato:nombreCampeonato}, function (data) {
      if (data.error === 1)
      {
        $('#myPleaseWait').modal('hide');
      }else
      {
          var obj = JSON.parse(data);
          window.location.href = obj.url;
          $('#myPleaseWait').modal('hide');
      }
  });
}
