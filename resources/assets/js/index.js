// import jquery from 'jquery'
// require('jquery')
require('./pincode-input.js')
require('./numeric-input.js')
require('./../css/pincode-input.css')

// global.$ = global.jQuery = require('jquery');

// $('#totp_token').hide();
// jQuery('#totp_token').pincodeInput({
//     hidedigits: false,
//     inputs: 6,
//     complete: alert('hi')
// })
window.$('#totp_token').pincodeInput({

  // 4 input boxes = code of 4 digits long
  inputs:6,

  // hide digits like password input
  hideDigits:true,

  // keyDown callback
  keydown : function(e){},

  // callback when all inputs are filled in (keyup event)
  complete : function(value, e, errorElement){
    // value = the entered code
    // e = last keyup event
    // errorElement = error span next to to this, fill with html
    // e.g. : $(errorElement).html("Code not correct");
  }
});
$('input.pincode-input-text').numericInput().eq(0).focus()