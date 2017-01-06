function generarReporte()
{
    jQuery.post('BL/ReportesBL.php', {action: 'obtenerReporte'}, function (data) {
        if (data.error === 1)
        {
        }
        else
        {
			alert(data);
           var divResultado=document.getElementById("divResultado");
           var object="<object type='application/pdf' data='"+data+"' width='100%' height='900px'></object>";
           divResultado.innerHTML+=object; 
            //var win = window.open('', '_blank');
            //win.location.href = data;
        }
    });
}