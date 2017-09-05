jQuery(document).ready(function() {
    jQuery('.' + drupalSettings.div_uuid + ' .publish-button').hide();
    jQuery('.' + drupalSettings.div_uuid + ' .purchase-button').hide();
    jQuery('.' + drupalSettings.div_uuid + ' .thumbnail-upload').hide();
});

function toggleForwardDiv(uuid) {

    // If the video-upload is visible, toggle the thumbnail-upload
    if ( jQuery('.' + uuid + ' .video-upload').css('display') != 'none' ) {
        jQuery('.' + uuid + ' .video-upload').hide();
        jQuery('.' + uuid + ' .thumbnail-upload').show();

    // Else, if the thumbnail is visible, toggle the purchase and publish button
    } else if ( jQuery('.' + uuid + ' .thumbnail-upload').css('display') != 'none' ) {
        jQuery('.' + uuid + ' .thumbnail-upload').hide();
        jQuery('.' + uuid + ' .purchase-button').show();
        jQuery('.' + uuid + ' .publish-button').show();

    // If the purchase button is visible, toggle no more
    } else {} 
    
};

function toggleBackwardDiv(uuid) {

    // If the purchase-button is visible, toggle the thumbnail-upload
    if ( jQuery('.' + uuid + ' .purchase-button').css('display') != 'none' ) {
        jQuery('.' + uuid + ' .purchase-button').hide();
        jQuery('.' + uuid + ' .publish-button').hide();
        jQuery('.' + uuid + ' .thumbnail-upload').show();

    // Else, if the thumbnail-upload is visible, toggle the video-upload
    } else if ( jQuery('.' + uuid + ' .thumbnail-upload').css('display') != 'none' ) {
        jQuery('.' + uuid + ' .thumbnail-upload').hide();
        jQuery('.' + uuid + ' .video-upload').show();

    // If the video-upload is visible, toggle no more
    } else {} 
    
};