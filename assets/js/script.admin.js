jQuery(document).ready(function(){
    var request;
    jQuery( "#report-organism" ).change( function() {
        submit(jQuery(this));
    });
    
    var val = jQuery("#report-organism").find(":selected").val();
    if(val>0){
        submit(jQuery("#report-organism"));
    }
    
    function submit(container){
        var data = {
            'action': 'select_organism',
            'report_id' : container.attr('data-id'),
            'organism_id' : container.find(":selected").val()
        };
        var options   = {
            url : wppd_object_var.ajax_url,
            method: "POST",
            data: data,
            beforeSend: function( xhr ) {
                jQuery('.preloader').fadeIn();
            }
        }
        
        if(request != undefined){
            request.abort();
        }
        request = jQuery.ajax(options)
        .done(function(result) {
            console.log(result);
            jQuery('.preloader').fadeOut();
            jQuery('#report-results-container').html(result);
        })
        .fail(function(err) {
            jQuery('.preloader').fadeOut();
            console.log(err);
        });
    }
});