jQuery(document).ready(function($) {

    // NProgress
    $('body').show();
    NProgress.start();

});

$(window).on('load', function() {
    setTimeout(function() {
        NProgress.done()
    }, 2000);
});

// load the image
// var loadFile = function(event) {
//     var output = document.getElementById('output');
//     output.src = URL.createObjectURL(event.target.files[0]);
//     output.onload = function() {
//         URL.revokeObjectURL(output.src) // free memory
//     }
// };
