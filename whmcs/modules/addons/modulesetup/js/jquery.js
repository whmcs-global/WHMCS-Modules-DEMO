function deleteData(obj, id, url) {
//    jQuery('#location_'+linodeid).html('<i class="fa fa-spinner fa-pulse"></i>');
    var confrm = confirm('Are you sure want to delete?');
    if (confrm) {
        jQuery.ajax({
            type: 'post',
            url: '../modules/addons/modulesetup/includes/action.php',
            data: 'moduleaction=delete&id=' + id,
            success: function (response) {
                if (response == 1) {
                    jQuery('#message').html('<div class="alert customsuccess">Successfully deleted.</div>');
                    setTimeout(function () {
                        jQuery('#message').html('');
                        window.location.href = url;
                    }, 2000);

                } else {
                    jQuery('#message').html('<div class="alert customdanger">Error: ' + response + '.</div>');
                    setTimeout(function () {
                        jQuery('#message').html('');
                        window.location.href = url;
                    }, 2000);
                }
            }
        });
    }
}

function editModule(obj, id, url) {
    jQuery('#popupBody').html('<div id="progress"><i class="fa fa-circle-o-notch fa-spin"></i></div>');
    jQuery('#addAdimUser').modal('show');
    jQuery('#moduleid').val(id);
    jQuery.ajax({
        type: 'post',
        url: '../modules/addons/modulesetup/includes/action.php',
        data: 'moduleaction=getdetail&id=' + id,
        success: function (response) {
            jQuery('#popupBody').html(response);
        }
    });
}

function updateModule(obj, url) {

    if (jQuery('#name').val() == '') {
        jQuery('#name').attr('required', true);
        return false;
    } else if (jQuery('#overview').val() == '') {
        jQuery('#overview').attr('required', true);
        return false;
    } else if (jQuery('#order').val() == '') {
        jQuery('#order').attr('required', true);
        return false;
    } else {
        jQuery(obj).html('Save Changes&nbsp;<i class="fa fa-spinner fa-pulse"></i>');
        jQuery.ajax({
            type: 'post',
            url: '../modules/addons/modulesetup/includes/action.php',
            data: jQuery('#popupFrom').serialize(),
            success: function (response) {
                jQuery(obj).html('Save Changes');
                jQuery('#addAdimUser').modal('hide');
                if (response == 'success')
                    jQuery('#message').html('<div class="alert customsuccess">Successfully updated.</div>');
                else {
                    jQuery('#message').html('<div class="alert customdanger">Error: ' + response + '.</div>');
                }
                setTimeout(function () {
                    jQuery('#message').html('');
                    window.location.href = url;
                }, 2000);
            }
        });
    }
}