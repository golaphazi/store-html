jQuery(document).ready(function ($){
    var form_list_options = $('#metform-formlist');
    $('#post-query-submit').before(form_list_options.html());
    form_list_options.remove();

    $('.row-actions .edit a, .page-title-action').html('view');

});