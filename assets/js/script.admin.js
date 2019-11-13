jQuery(document).ready(function(){
    jQuery( '.add-row' ).on('click', function() {
        var row = jQuery( '.empty-row.screen-reader-text' ).clone(true);
        row.removeClass( 'empty-row screen-reader-text' );
        row.insertBefore( '#repeatable-fieldset-one tbody>tr:last' );
        return false;
    });

    jQuery( '.remove-row' ).on('click', function() {
        jQuery(this).parents('tr').remove();
        return false;
    });
    
    jQuery( ".repeatable" ).each( function() {
        jQuery( this ).repeatable_fields();
    });
    
    jQuery( "#report-indicator" ).change( function() {
        var data = {
            'action': 'select_indicator',
            'report_id' : jQuery(this).attr('data-id'),
            'indicator_id' : jQuery(this).find(":selected").val()
        };
        console.log(data);
        var options   = {
            url : wppd_object_var.ajax_url,
            method: "POST",
            data: data,
            beforeSend: function( xhr ) {
                jQuery('.preloader').fadeIn();
            }
        }
        
        jQuery.ajax(options)
        .done(function(result) {
            console.log(result);
            jQuery('.preloader').fadeOut();
            jQuery('#report-results-container').html(result);
        })
        .fail(function(err) {
            jQuery('.preloader').fadeOut();
            console.log(err);
        });
    });
});