/**
 * Created by caoxiang on 2016/11/1.
 */

function updateCode(obj, ware_type) {
    $.get('/admin/ware/get-temp-info?temp_id=' + $(obj).val() + '&type_id=' + ware_type, function (data) {
        var d = JSON.parse(data);
        $('#temp_code_' + ware_type).html(d.codes);
        $('#temp_param_' + ware_type).html(d.param);
    });
}

function newSection() {
    $.get('/admin/ware/new-section', function (data) {
        $('#template_params').append(data);
    });
}

function removeSection(id) {
    $('#section_' + id).remove();
}

function searchWare(keyword) {
    if (window.event.keyCode == 13) {
        $.get('/admin/section/search?keyword=' + keyword, function (data) {
            $('#ware_section').html(data);
            jQuery('#wares').sortable({"cursor":"move"});
            $( function() {
                $( "#selected_wares, #wares" ).sortable({
                    connectWith: ".ui-sortable"
                }).disableSelection();
            } );
        });
    }
}