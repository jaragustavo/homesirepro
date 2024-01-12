$(document).ready(function(){
    
    // var com_id = getUrlParameter('c');

    // $('#aso_id').select2();

    // $('#suc_id').select2();

    // $.post("controller/asociacion.php?op=combo",function(data){
    //     console.log(data);
    //     $("#aso_id").html(data);
    // });

    // $("#aso_id").change(function(){
    //     $("#aso_id").each(function(){
    //         aso_id = $(this).val();

    //         $.post("controller/sucursal.php?op=combo",{aso_id:aso_id},function(data){
    //             $("#suc_id").html(data);
    //         });
    //     });
    // });
});

/* TODO: Obtener parametro de URL */
var getUrlParameter = function getUrlParameter(sParam) {
    var sPageURL = decodeURIComponent(window.location.search.substring(1)),
        sURLVariables = sPageURL.split('&'),
        sParameterName,
        i;

    for (i = 0; i < sURLVariables.length; i++) {
        sParameterName = sURLVariables[i].split('=');

        if (sParameterName[0] === sParam) {
            return sParameterName[1] === undefined ? true : sParameterName[1];
        }
    }
};