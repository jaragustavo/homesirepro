function init(){
    $.post("../../controller/usuario.php?op=cantidadesCurriculum",function (data) {
        data = JSON.parse(data);
        $('#lbldocspersonales').html(data.lbldocspersonales);
        $('#lbldocsacademicos').html(data.lbldocsacademicos);
        $('#lbltotalcurriculum').html(data.lbltotalcurriculum);
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