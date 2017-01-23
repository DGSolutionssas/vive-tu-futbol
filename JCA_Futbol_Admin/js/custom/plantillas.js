var idCampeonatoSeleccionado = "";
var idEquipo1Seleccionado = "";
var idEquipo2Seleccionado = "";

$(document).ready(function () {
    $('#divEquipo1').hide();
    $('#divEquipo2').hide();
    $('#divTipoPlantilla').hide();
    $('#divBtnPlantilla').hide();
});

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
            $('#divEquipo1').show();
            return false;
        },
        autoFocus: true,
        minLength: 3
    });
});

/*---------------------------
 Autocompletar Equipo 1
 ----------------------------*/
$(document).ready(function () {
    $('#txtEquipo1').autocomplete({
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
            document.getElementById("txtEquipo1").value = ui.item.value;
            document.getElementById("txtEquipo1").disabled = true;
            $('#divEquipo2').show();
            return false;
        },
        autoFocus: true,
        minLength: 3
    });
});

/*---------------------------
 Autocompletar Equipo 2
 ----------------------------*/
$(document).ready(function () {
    $('#txtEquipo2').autocomplete({
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
            document.getElementById("txtEquipo2").value = ui.item.value;
            document.getElementById("txtEquipo2").disabled = true;
            $('#divTipoPlantilla').show();
            $('#divBtnPlantilla').show();
            return false;
        },
        autoFocus: true,
        minLength: 3
    });
});


/*---------------------------
 Limpiar Plantilla
 ----------------------------*/
function limpiarPlantilla()
{
    $('#divEquipo1').hide();
    $('#divEquipo2').hide();
    $('#divTipoPlantilla').hide();
    $('#divBtnPlantilla').hide();
    document.getElementById("txtCampeonato").disabled = false;
    document.getElementById("txtCampeonato").value = "";
    document.getElementById("txtEquipo1").disabled = false;
    document.getElementById("txtEquipo1").value = "";
    document.getElementById("txtEquipo2").disabled = false;
    document.getElementById("txtEquipo2").value = "";

}

function generarPlantilla()
{
    $('#myPleaseWait').modal('show');
    var action = 'generarPlantilla';
    var ddlTipoPlantilla = document.getElementById("ddlTipoPlantilla");
    var idTipoPlantilla = ddlTipoPlantilla.options[ddlTipoPlantilla.selectedIndex].value;    
    var campeonato=document.getElementById("txtCampeonato").value;
    var equipo1=document.getElementById("txtEquipo1").value;
    var equipo2=document.getElementById("txtEquipo2").value;
    

    jQuery.post('BL/PlantillasBL.php', {campeonato:campeonato, equipo1:equipo1, equipo2:equipo2, idCampeonato: idCampeonatoSeleccionado, idEquipo1: idEquipo1Seleccionado, idEquipo2: idEquipo2Seleccionado, idTipoPlantilla:idTipoPlantilla, action: action}, function (data) {
        if (data.error === 1)
        {
        }else
        {
            var obj = JSON.parse(data);
            window.location.href = obj.url;
        }
    });
    $('#myPleaseWait').modal('hide');
}