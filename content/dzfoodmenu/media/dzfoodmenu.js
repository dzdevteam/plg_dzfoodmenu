jQuery(document).ready(function(){
    jQuery('input[name="jform[attribs][title]"]').val(jQuery('input[name="jform[params][title]"]').val());
    jQuery('textarea[name="jform[attribs][description]"]').html(jQuery('input[name="jform[params][description]"]').val());
});
