function init(){

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