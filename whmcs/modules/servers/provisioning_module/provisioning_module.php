<?php


/* * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
 *  Provisioning Module By whmcsglobalservices.com
 *
 *  Date: 07 Oct, 2021
 *  WHMCS Version: v8.x
 *
 *  By WHMCSGLOBALSERVICES    https://whmcsglobalservices.com
 *
 *  In this module will you to auto provisioning your service
 *
 *  @owner <whmcsglobalservices.com>
 *  @author <whmcsglobalservices.com>
 * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * */


if (!defined("WHMCS")) {
    die("This file cannot be accessed directly");
}
if (file_exists(__DIR__ . '/function.php'))
    include_once __DIR__ . '/function.php';

function provisioning_module_MetaData() {
    return array(
        'DisplayName' => 'provisioning_module Provisioning Module',
    );
}

/*
 *  Module configure
 *  */

function provisioning_module_ConfigOptions() {
    global $whmcs;
    $pid = $whmcs->get_req_var("id");
    #Class Object
    $provisioning_module = new Manage_provisioning_module();
    # Create Custom Fields
    $provisioning_module->provisioning_module_CreateCustomFields($pid);

    return array(
        'API_URL' => array(
            'FriendlyName' => 'API URL',
            'Type' => 'text',
            'Size' => '25',
            'Default' => ' ',
            'Description' => 'Enter API URL',
        ),
        'Username' => array(
            'FriendlyName' => 'Username',
            'Type' => 'text',
            'Size' => '25',
            'Default' => ' ',
            'Description' => 'Enter username',
        ),
        'Password_Field' => array(
            'FriendlyName' => 'Password',
            'Type' => 'password',
            'Size' => '25',
            'Default' => '',
            'Description' => 'Enter secret value here',
        ),
        'Default_Bucket_Quota' => array(
            'FriendlyName' => 'Default Bucket Quota',
            'Type' => 'text',
            'Size' => '25',
            'Default' => ' ',
            'Description' => 'Enter Bucket Quota',
        ),
        'Default_Bucket_Object' => array(
            'FriendlyName' => 'Default Bucket Object',
            'Type' => 'text',
            'Size' => '25',
            'Default' => '2',
            'Description' => 'Enter Bucket Object',
        ),
        'Default_Quota' => array(
            'FriendlyName' => 'Default User Quota',
            'Type' => 'text',
            'Size' => '25',
            'Default' => ' ',
            'Description' => 'Enter Default User Quota',
        ),
        'Default_Quota_Object' => array(
            'FriendlyName' => 'Default Quota Object',
            'Type' => 'text',
            'Size' => '25',
            'Default' => '2',
            'Description' => 'Enter Quota Object',
        ),
        'Dropdown Field' => array(
            'FriendlyName' => 'Quota Unit',
            'Type' => 'dropdown',
            'Options' => array(
                'kb' => 'KB',
                'mb' => 'MB',
                'gb' => 'GB',
                'tb' => 'TB',
            ),
            'Description' => 'Choose one',
        ),
    );
}
/*
 *  Module Create
 *  */
function provisioning_module_CreateAccount(array $params) {
    try {
        $provisioning_module = new Manage_provisioning_module();
    } catch (Exception $e) {
        logModuleCall('provisioning_module Provisioning Module', __FUNCTION__, $params, $e->getMessage(), $e->getTraceAsString());
        return $e->getMessage();
    }
    return 'success';
}
/*
 *  Module Suspend
 *  */
function provisioning_module_SuspendAccount(array $params) {
    $uid = $params['customfields']['provisioning_module_uid'];
    $provisioning_module = new Manage_provisioning_module();
    try {
        if (empty($uid))
            return "User id not found.";
    } catch (Exception $e) {
        logModuleCall('provisioning_module Provisioning Module', __FUNCTION__, $params, $e->getMessage(), $e->getTraceAsString());
    }
    return 'success';
}
/*
 *  Module Unsuspend
 *  */
function provisioning_module_UnsuspendAccount(array $params) {
    $uid = $params['customfields']['provisioning_module_uid'];
    $provisioning_module = new Manage_provisioning_module();
    try {
        if (empty($uid))
            return "User id not found.";        
    } catch (Exception $e) {
        logModuleCall('provisioning_module Provisioning Module', __FUNCTION__, $params, $e->getMessage(), $e->getTraceAsString());
    }
    return 'success';
}
/*
 *  Module Terminate
 *  */
function provisioning_module_TerminateAccount(array $params) {
    $uid = $params['customfields']['provisioning_module_uid'];
    $provisioning_module = new Manage_provisioning_module();
    try {
        if (empty($uid))
            return "User id not found.";
    } catch (Exception $e) {
        logModuleCall('provisioning_module Provisioning Module', __FUNCTION__, $params, $e->getMessage(), $e->getTraceAsString());
    }
    return 'success';
}
/*
 *  Module Change Package upgrade/downgrade
 *  */
function provisioning_module_ChangePackage(array $params) {
    $uid = $params['customfields']['provisioning_module_uid'];
    $provisioning_module = new Manage_provisioning_module();
    try {
        if (empty($uid))
            return "User id not found.";
    } catch (Exception $e) {
        logModuleCall('provisioning_module Provisioning Module', __FUNCTION__, $params, $e->getMessage(), $e->getTraceAsString());
    }
    return 'success';
}
/*
 *  Module Clientarea
 *  */
function provisioning_module_ClientArea(array $params) {
    $provisioning_module = new Manage_provisioning_module();
    $uid = $params['customfields']['provisioning_module_uid'];
    $displayname = $params['clientsdetails']['firstname'] . ' ' . $params['clientsdetails']['lastname'];
    $Email = $params['clientsdetails']['email'];
    $user_quota = $params['configoptions']['user_quota'];
    $user_quota_object = $params['configoptions']['user_quota_object'];

    if (isset($_POST['customAction']) && !empty($_POST['customAction'])) {
        include_once __DIR__ . '/ajax/ajax.php';
        exit();
    }

    return array(
        'tabOverviewReplacementTemplate' => 'template/clientarea.tpl',
        'templateVariables' => array(
            'user_id' => $uid,
            'displayname' => $displayname,
            'Email' => $Email,
            'user_quota' => $user_quota,
            'user_quota_object' => $user_quota_object,
        )
    );
}

?>