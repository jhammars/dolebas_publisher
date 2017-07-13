// Get upload price payment status based on drupalSettings.parent_nid

// If payment is not confirmed, create ajax modal link and follow the link

// If payment is confirmed, create regular link and follow the link

// //(function($) {
// (function ($, window, Drupal, drupalSettings) {
//     // Custom AJAX commands
// //    if(typeof Drupal.ajax != "undefined") { // Ensure follwing code will not generate errors in administration pages
//         Drupal.AjaxCommands.prototype.reloadPage = function(ajax, response, status) {
//             console.log("ajax command");
//             alert("alert this");
//             location.reload();
//         };
// //    }
//     console.log("test");
// //})(jQuery);
// })(jQuery, this, Drupal, drupalSettings);


//(function($) {


//    Drupal.ajax.prototype.commands.reloadPage = function(ajax, rsp, status) {

(function ($, Drupal) {
    function displayInprogress() {
        $("#ajaxProgressLinkText").text("Publishing in progress....");
        console.log("Progress callback");
        console.log("on click");
        
    });    
})(jQuery, Drupal);
console.log("Library loaded.");

}