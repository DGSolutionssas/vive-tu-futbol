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
        }
        else
        {
           var divResultado=document.getElementById("divResultado");
           var object="<object type='application/pdf' data='"+data+"' width='100%' height='900px'></object>";
           divResultado.innerHTML+=object; 
            //var win = window.open('', '_blank');
            //win.location.href = data;
        }
    });
}

function generarReporteGoles()
{
	$('#myPleaseWait').modal('show');
    jQuery.post('BL/ReportesBL.php', {action: 'generarReporteGoles', idCampeonato: idCampeonatoSeleccionado}, function (data) {
        if (data.error === 1)
        {
        }
        else
        {
           var divResultado=document.getElementById("divResultado");
           var object="<object type='application/pdf' data='"+data+"' width='100%' height='900px'></object>";
           divResultado.innerHTML+=object; 
            //var win = window.open('', '_blank');
            //win.location.href = data;
        }
    });
	$('#myPleaseWait').modal('hide');
}

function generarReporteCampeonato()
{
	$('#myPleaseWait').modal('show');
    jQuery.post('BL/ReportesBL.php', {action: 'generarReporteCampeonato', idCampeonato: idCampeonatoSeleccionado}, function (data) {
        if (data.error === 1)
        {
        }
        else
        {
           var divResultado=document.getElementById("divResultado");
           var object="<object type='application/pdf' data='"+data+"' width='100%' height='900px'></object>";
           divResultado.innerHTML+=object; 
            //var win = window.open('', '_blank');
            //win.location.href = data;
        }
    });
	$('#myPleaseWait').modal('hide');
}

function generarReporteFairPlayCampeonato()
{
	$('#myPleaseWait').modal('show');
    jQuery.post('BL/ReportesBL.php', {action: 'generarReporteJuegoLimpioCampeonato', idCampeonato: idCampeonatoSeleccionado}, function (data) {
        if (data.error === 1)
        {
        }
        else
        {
           var divResultado=document.getElementById("divResultado");
           var object="<object type='application/pdf' data='"+data+"' width='100%' height='900px'></object>";
           divResultado.innerHTML+=object; 
            //var win = window.open('', '_blank');
            //win.location.href = data;
        }
    });
	$('#myPleaseWait').modal('hide');
}
