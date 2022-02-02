<?php
global $whmcs;
$customAction = $whmcs->get_req_var("customAction");

function formatSizeUnits($bytes) {
    if ($bytes >= 1000000000) {
        $bytes = number_format($bytes / 1000000000, 2) . ' TB';
    } elseif ($bytes >= 1000000) {
        $bytes = number_format($bytes / 1000000, 2) . ' GB';
    } elseif ($bytes >= 1000) {
        $bytes = number_format($bytes / 1000, 2) . ' MB';
    } elseif ($bytes < 1000) {
        $bytes = $bytes . ' KB';
    }

    return $bytes;
}

if ($customAction == "update") {
    $url = $params['configoption1']  . $uid;
    //$userid= $whmcs->get_req_var("userid");
    $displayname = $whmcs->get_req_var("displayname");
    $userUpdated_email = $whmcs->get_req_var("email");
    $provisioning_module_GetUsers = $provisioning_module->provisioning_module_GetUsers($params, $accessToken); #Check User Exist
    logModuleCall('provisioning_module Provisioning Module', ' get user detail', $data, $provisioning_module_GetUsers);
    /* echo"<pre>";
      print_r($provisioning_module_GetUsers);
      die; */
    if (!empty($provisioning_module_GetUsers['result']['message'])) {
        $msg = '<div class="alert alert-danger">
				  <strong>Error!</strong> ' . $provisioning_module_GetUsers['result']['message'] . '
				</div>';
        echo $msg;
        die();
    } else {
        foreach ($provisioning_module_GetUsers['result'] as $user) {
            if ($user['uid'] == $uid) {
                continue;
            } elseif ($user['email'] == $email && $user['uid'] != $uid) {
                $msg = '<div class="alert alert-danger">
				  <strong>Error!</strong> could not update user: unable to update user, user: ' . $email . ' exists
				</div>';
                echo $msg;
                die();
                break;
            }
            continue;
        }
    }
    $data = [
        "name" => $displayname,
        "email" => $userUpdated_email,
    ];

    $headers = [
        "Authorization: Bearer {$accessToken} ",
        "Content-Type: application/json"
    ];

    $result = $provisioning_module->provisioning_module_DoRequest($url, 'PATCH', json_encode($data), $headers);

    logModuleCall('provisioning_module Provisioning Module', 'Update user Info', $data, $result);
    $provisioning_module_LogOut = $provisioning_module->provisioning_module_LogOut($params);
    if (!empty($result['result']['message'])) {
        $msg = '<div class="alert alert-danger">
				  <strong>Error!</strong> ' . $result['result']['message'] . '
				</div>';
        echo $msg;
        die();
    } else {
        $msg = '<div class="alert alert-success">
				  <strong>Success!</strong> Data has been succesfully updated.
				</div>';
        echo $msg;
        die();
    }
}

if ($customAction == "subuser") {
    $url = $params['configoption1']  . $uid;
    $permission = $whmcs->get_req_var("permission");
    $addsubuser = $whmcs->get_req_var("addsubuser");
    $provisioning_module_GetUsers = $provisioning_module->provisioning_module_GetUsers($params, $accessToken); #Check subUser Exist
    logModuleCall('provisioning_module Provisioning Module', ' add Subuser', $data, $provisioning_module_GetUsers);

    if (!empty($provisioning_module_GetUsers['result']['message'])) {
        $msg = '<div class="alert alert-danger">
				  <strong>Error!</strong> ' . $provisioning_module_GetUsers['result']['message'] . '
				</div>';
        echo $msg;
        die();
    } else {
        foreach ($provisioning_module_GetUsers['result'] as $user) {
            foreach ($user['subusers'] as $subusersvalue) {
                if ($subusersvalue['subuser'] == $addsubuser) {
                    $msg = '<div class="alert alert-danger">
				  <strong>Error!</strong> could not Add Subuser: unable to Add Subuser, user: ' . $addsubuser . ' exists
				</div>';
                    echo $msg;
                    die();
                    break;
                } else {
                    $permission['subuser'] = $subusersvalue['subuser'];
                    $permission['permission'] = $subusersvalue['permission'];
                }
                continue;
            }
            continue;
        }
        echo json_encode($permission);
        echo json_encode($addsubuser);
        die;
    }
    $data = [
        "subuser" => $addsubuser,
        "permissions" => $permission,
    ];

    $headers = [
        "Authorization: Bearer {$accessToken} ",
        "Content-Type: application/json"
    ];

    $result = $provisioning_module->provisioning_module_DoRequest($url, 'POST', json_encode($data), $headers);

    logModuleCall('provisioning_module Provisioning Module', 'add Subuser', $data, $result);
    $provisioning_module_LogOut = $provisioning_module->provisioning_module_LogOut($params);
}

if ($customAction == "getkeys") {
    $provisioning_module_GetUserskey = $provisioning_module->provisioning_module_GetUserskey($params, $accessToken, $uid); #Check Userkey
    logModuleCall('provisioning_module Provisioning Module', ' get user key', $data, $provisioning_module_GetUserskey);
    $response = '';
    if (!empty($provisioning_module_GetUserskey['result']['message']))
        $response = ['status' => 'error', 'msg' => $provisioning_module_GetUserskey['result']['message']];
    else
        $response = ['status' => 'success', "user" => $provisioning_module_GetUserskey['result']['user'], "access_key" => $provisioning_module_GetUserskey['result']['access_key'], "secret_key" => $provisioning_module_GetUserskey['result']['secret_key']];
    print json_encode($response);
    die;
}

if ($customAction == "placements") {
    $provisioning_module_GetPlacement_rule = $provisioning_module->provisioning_module_GetPlacement_rule($params, $accessToken, $uid);
    logModuleCall('provisioning_module Provisioning Module', ' Get Placements ', $data, $provisioning_module_GetPlacement_rule);
    echo json_encode($provisioning_module_GetPlacement_rule['result']);
    die();
}

?>
<script type="text/javascript" src="js/client.js"></script>
