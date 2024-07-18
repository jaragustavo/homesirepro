function init(){
    $.post("../../controller/usuario.php?op=cantidadesTramites",function (data) {
        data = JSON.parse(data);
        $('#lbltramitesrealizados').html(data.lbltramitesrealizados);
    });

    $.post("../../controller/usuario.php?op=cantidadesReposos",function (data) {
        data = JSON.parse(data);
        $('#lblreposos').html(data.lblreposos);
    });

}

$(document).ready(function(){
    var usuario_id = $('#user_idx').val();

    $.post("../../controller/usuario.php?op=grafico", {usuario_id:usuario_id},function (data) {
        data = JSON.parse(data);

        new Morris.Bar({
            element: 'divgrafico',
            data: data,
            xkey: 'nom',
            ykeys: ['total'],
            labels: ['Value'],
            barColors: ["#1AB244"], 
        });
    }); 

});

init();

function guardarDatosPersonales(){
    $.post("../../controller/usuario.php?op=mostrarDatosPersonales",function(data){
        $('#observacion').summernote('code', data);
    });
    return;
}