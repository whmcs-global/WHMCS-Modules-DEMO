jQuery(document).ready(function() {
    GetInfo("uid");
    ApiCall('placements');
});

function GetInfo(uid) {
    jQuery("#getdetail").hide();
    jQuery('#keyerror').remove();
    jQuery.ajax({
        url: '',
        type: 'POST',
        data: "customAction=" + uid,

        beforeSend: function() {
            jQuery("#loader").addClass("fa fa-spinner fa-spin fa-pulse fa-1x fa-fw");
        },
        success: function(data) {
            jQuery("#loader").removeClass("fa fa-spinner fa-spin fa-pulse fa-1x fa-fw");
            //alert(data);
            var decode = JSON.parse(data);
            /* alert(data);
            die(); */
            jQuery("#getdetail").show();
            console.log(decode);
            jQuery("#userid1").val(decode.uid);
            jQuery("#displayname1").val(decode.name);
            jQuery("#email1").val(decode.email);
            if (decode.status == 'error') {
                jQuery("#getdetail").hide();
                jQuery("#getdetail").before('<div id="keyerror"><div class="alert alert-danger"><strong>Error!</strong>' + decode.error + '  </div></div>');
            } else {
                jQuery("#userid").text(decode.uid);
                jQuery("#displayname").text(decode.name);
                jQuery("#email").text(decode.email);
                //alert(decode.userQuota.max_size_kb);
                jQuery("#userQuotasize").text(decode.userQuota.max_size_kb);
                jQuery("#userQuotaobject").text(decode.userQuota.max_objects);

            }
        }
    });

}

function UpdateInfo(obj, update) {
    var updateparam = jQuery("#update_form").serialize();
    jQuery("#update_resp").html('<i class="fa fa-spinner fa-spin"></i>');
    jQuery(obj).css("pointer-events", "none");
    jQuery.ajax({
        url: '',
        type: 'post',
        data: "customAction=" + update + "&" + updateparam,
        success: function(data) {
            jQuery(obj).css("pointer-events", "auto");
            jQuery("#update_resp").html(data);
            GetInfo("uid");
        }
    });
}

function ApiCall(action) {
    var customAction = action;
    jQuery.ajax({
        url: '',
        type: 'post',
        data: "customAction=" + customAction,

        success: function(data) {
            var json_encode = JSON.parse(data);

            if (customAction == 'placements') {
                $(json_encode).each(function(index, value) {
                    $("#placement").append("<option>" + value.name + "</option>");
                });

            }
        }
    });

}

function Getkeys(obj) {

    jQuery(obj).html('Get keys <i class="fa fa-spinner fa-spin"></i>');
    jQuery(obj).attr('disabled', true);
    jQuery("#getkeys").hide();
    jQuery('#keyerror').remove();
    jQuery.ajax({
        url: '',
        type: 'POST',
        data: "customAction=getkeys",
        success: function(response) {
            jQuery(obj).html('Get keys');
            jQuery(obj).attr('disabled', false);
            var decode = JSON.parse(response);
            jQuery("#getkeys").show();
            if (decode.status == 'success') {
                jQuery("#username").text(decode.user);
                jQuery("#accesskey").text(decode.access_key);
                jQuery("#secretkey").text(decode.secret_key);
            } else {
                jQuery("#getkeys").hide();
                jQuery("#getkeys").before('<div id="keyerror"><div class="alert alert-danger"><strong>Error!</strong> ' + decode.msg + '</div></div>');
            }
        }
    });
}

function check_box() {
    var checkBox = document.getElementById("myCheck");
    var text = document.getElementById("text");

    if (checkBox.checked == true) {
        text.style.display = "block";
    } else {
        text.style.display = "none";
    }
}