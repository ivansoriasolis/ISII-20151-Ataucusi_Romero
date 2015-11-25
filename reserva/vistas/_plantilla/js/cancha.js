$(function(){
    
    $('.buscar_cancha').submit(function(evt){
        var _cancha = $('#cancha').val();
        $.ajax({
            url: 'cancha/buscar_cancha/' + _cancha,
            success: function (data){
                $('.login_body').html(data);
                cargado();
            }            
        });
        evt.preventDefault();
    });
});