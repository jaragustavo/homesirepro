function init(){
    $.post("../../controller/usuario.php?op=cantidadesTramites",function (data) {
        data = JSON.parse(data);
        $('#lbltramitesrealizados').html(data.lbltramitesrealizados);
    });

    $.post("../../controller/usuario.php?op=cantidadesReposos",function (data) {
        data = JSON.parse(data);
        $('#lblreposos').html(data.lblreposos);
    });

    $.post("../../controller/usuario.php?op=totalRepososVisados",function (data) {
        data = JSON.parse(data);
        $('#lbltotalrepososvisados').html(data.lbltotalrepososvisados);
    });

    $.post("../../controller/usuario.php?op=cantidadEspecialidad",function (data) {
        data = JSON.parse(data);
        $('#lblespecialidad').html(data.lblespecialidad);
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