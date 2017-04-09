import jQuery from 'jquery'
window.$ = jQuery
window.jquery = jQuery
;(function($){
    $.fn.numericInput = function () {
        $(this).on('keydown', (e)=>{
            if(isNumericKeyEvent(e)){
                return true
            }

            e.preventDefault()
        })

        return this
    }
}(jQuery))

window.isNumericKeyEvent = function(e){
    // Allow: backspace, delete, tab, and escape
    if (jQuery.inArray(e.keyCode, [46, 8, 9, 27]) !== -1 ||
         // Allow: Ctrl+A, Command+A
        (e.keyCode === 65 && (e.ctrlKey === true || e.metaKey === true)) ||
         // Allow: Ctrl+R, Command+R
        (e.keyCode === 82 && (e.ctrlKey === true || e.metaKey === true)) ||
         // Allow: home, end, left, right, down, up
        (e.keyCode >= 35 && e.keyCode <= 40)) {
             // let it happen, don't do anything
             return true
    }
    // Ensure that it is a number and stop the keypress
    if ((e.shiftKey || (e.keyCode < 48 || e.keyCode > 57)) && (e.keyCode < 96 || e.keyCode > 105)) {
        return false
    }

    return true
}
