
//Date Piker
//http://getbootstrap.com/components/
$.datepicker.regional['es'] = {
    closeText: 'Cerrar',
    prevText: '< Ant',
    nextText: 'Sig >',
    currentText: 'Hoy',
    monthNames: ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'],
    monthNamesShort: ['Ene', 'Feb', 'Mar', 'Abr', 'May', 'Jun', 'Jul', 'Ago', 'Sep', 'Oct', 'Nov', 'Dic'],
    dayNames: ['Domingo', 'Lunes', 'Martes', 'Miércoles', 'Jueves', 'Viernes', 'Sábado'],
    dayNamesShort: ['Dom', 'Lun', 'Mar', 'Mié', 'Juv', 'Vie', 'Sáb'],
    dayNamesMin: ['Do', 'Lu', 'Ma', 'Mi', 'Ju', 'Vi', 'Sá'],
    weekHeader: 'Sm',
    dateFormat: 'dd/mm/yy',
    firstDay: 1,
    isRTL: false,
    showMonthAfterYear: false,
    yearSuffix: ''
};
$.datepicker.setDefaults($.datepicker.regional['es']);

$(function () {
    $("#a-fecha").datepicker();
    $("#a-fecha-v").datepicker();
    //$("#fecha-envio").datepicker();

    // bootstrap-datepicker
    $('#fecha-envio').datepicker({
        format: "dd-mm-yyyy",
        language: "es",
        autoclose: true,
        todayBtn: true

    }).on(

        'show', function () {
            // Obtener valores actuales z-index de cada elemento
            var zIndexModal = $('#modal-zip').css('z-index');
            var zIndexFecha = $('.datepicker').css('z-index');

            // alert(zIndexModal + zIndexFEcha);

            // Re asignamos el valor z-index para mostrar sobre la ventana modal
            $('.datepicker').css('z-index', zIndexModal + 2000);
        });
});

