/* Admin script */
jQuery(function( $ ){
    var pWidth = parseInt($('#yc_exclude_products').parents('td').css('width'));
    var initW = [pWidth, 400];
    var tWidth = Math.min.apply(Math, initW)+'px';
    
    $("#yc_exclude_products").select2({
        placeholder: "Select products",
        allowClear: true,
    });
    
    $('#yc_exclude_products').parents('td').find('.select2-container').css({"width": "100%", "min-width": tWidth, "max-width": tWidth});
});