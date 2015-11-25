$(function () {
    $('#fecha').change(function () {
        $.ajax({
            url: 'reserva/ver_horas/' + $('#cancha_id').val() + '/' + $(this).val(),
            success: function (datos) {
                $('.horas').html(datos);
            }
        });
    });

    $('#fecha').on({
        focusin: function () {
            $('.carga_calendar').html($('#marco').html());
            $('.carga_calendar').show();
            $.ajax({
                url: 'publico/estatico/calendar.php?fecha=' + $('#fecha').val(),
                cache: true,
                success: function (data) {
                    $('.carga_calendar').html(data);
                }
            });
        }
    });

    $('.calendario .cal_clo').live('click', function (evt) {
        $('.carga_calendar').fadeOut(300);
        evt.preventDefault();
    });

    $('#cal_anio').live('change', function (evt) {
        $('.carga_calendar').html($('#marco').html());
        $('.carga_calendar').show();
        $.ajax({
            url: 'publico/estatico/calendar.php?fecha=01-01-' + $(this).val(),
            cache: true,
            success: function (data) {
                $('.carga_calendar').html(data);
            }
        });
    });

    $('#cal_mes').live('change', function (evt) {
        var _mes = $('#cal_mes').val();
        var _anio = $('#cal_anio').val();
        $('.carga_calendar').html($('#marco').html());
        $('.carga_calendar').show();
        $.ajax({
            url: 'publico/estatico/calendar.php?fecha=01-' + _mes + '-' + _anio,
            cache: true,
            success: function (data) {
                $('.carga_calendar').html(data);
            }
        });
    });
    
    $('.calendario .cal_btn').live('click', function () {
        var dia = $(this).html();
        if (dia < 10) {
            dia = '0' + dia;
        }
        $('#fecha').val(dia + '-' + $('#cal_mes').val() + '-' + $('#cal_anio').val());
        $('.carga_calendar').html('');
        $('#fecha').change();
    });
});