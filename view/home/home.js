function init() {
    let cantidad_reposo = 0;
    $.post("../../controller/usuario.php?op=cantidadesTramites", function(data) {
        data = JSON.parse(data);
        $('#lbltramitesrealizados').html(data.lbltramitesrealizados);
    });

    $.post("../../controller/usuario.php?op=cantidadesReposos", function(data1) {

        var response1 = JSON.parse(data1);

        // Asegurarse de que 'lblreposos' sea tratado como un número
        var cantidad_reposo = parseInt(response1.lblreposos, 10) || 0;


        $.post("../../controller/usuario.php?op=obtenerCantidadRepososWeb", function(data2) {

            var response2 = JSON.parse(data2);

            // Asegurarse de que 'lblreposoVisadoWeb' sea tratado como un número
            var cantidad_reposo_visado_web = parseInt(response2.lblreposoVisadoWeb, 10) || 0;

            // Sumar los dos valores
            var total_reposos = cantidad_reposo + cantidad_reposo_visado_web;

            // Colocar el valor en el elemento con ID 'lblreposos'
            $('#lblreposos').html(total_reposos);
        });
    });


    $.post("../../controller/usuario.php?op=totalRepososVisados", function(data) {
        data = JSON.parse(data);
        $('#lbltotalrepososvisados').html(data.lbltotalrepososvisados);
    });

    $.post("../../controller/usuario.php?op=cantidadEspecialidad", function(data) {
        data = JSON.parse(data);
        $('#lblespecialidad').html(data.lblespecialidad);
    });

}

$(document).ready(function() {
    var usuario_id = $('#user_idx').val();

    $.post("../../controller/usuario.php?op=grafico", { usuario_id: usuario_id }, function(data) {
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