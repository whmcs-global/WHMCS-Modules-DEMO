<?php

if (!defined('WHMCS'))
    die('This file cannot be accessed directly');
if (file_exists(__DIR__ . "/class.php")) {
    require_once __DIR__ . "/class.php";
}

function wgsdomains_getConfigArray() {
    $config_array = [
        'FriendlyName' => [
            'Type' => 'System',
            'Value' => 'WGS Domain Sample Module',
        ],
        'Description' => [
            'Type' => 'System',
            'Value' => '<a href="https://whmcsglobalservices.com/">WHMCS GLOBAL SERVICES</a> | <a href="https://www.registry.net.za">Registry</a>',
        ],
        'url' => [
            'FriendlyName' => 'Production API URL',
            'Type' => 'text',
            'Default' => '',
            'Size' => 64,
            'Description' => '',
        ],
        'Username' => [
            'FriendlyName' => 'Production Username',
            'Type' => 'text',
            'Default' => '',
            'Size' => 64,
            'Description' => '',
        ],
        'Password' => [
            'FriendlyName' => 'Production Password',
            'Type' => 'password',
            'Default' => '',
            'Size' => 64,
            'Description' => '',
        ],
        'autorenewenable' => [
            'FriendlyName' => 'Auto Renew',
            'Type' => 'yesno',
            'Default' => false,
            'Description' => 'Enable Auto Renew',
        ],
        'TestMode' => [
            'FriendlyName' => 'Test Mode',
            'Type' => 'yesno',
            'Default' => '',
            'Description' => '',
        ],
    ];
    return $config_array;
}

function wgsdomains_GetNameservers($params) {
    try{
        $domain = $params['domainname'];
        return ['ns1' => $params['ns1'], 'ns2' => $params['ns2'], 'ns3' => $params['ns3'], 'ns4' => $params['ns4']];
    } catch (Exception $e) {
        logModuleCall('WGS Domain Module', __FUNCTION__, $params, $e->getMessage(), $e->getTraceAsString());
        return $e->getMessage();
    }
}

function wgsdomains_SaveNameservers($params) {
    try{
        $domain = $params['domainname'];
        $ns1 = $params['ns1'];
        $ns2 = $params['ns2'];
        $ns3 = $params['ns3'];
        $ns4 = $params['ns4'];
    } catch (Exception $e) {
        logModuleCall('WGS Domain Module', __FUNCTION__, $params, $e->getMessage(), $e->getTraceAsString());
        return $e->getMessage();
    }
}

function wgsdomains_RegisterDomain($params) {
    try{
        $domain = $params['domainname'];
        $ns1 = $params['ns1'];
        $ns2 = $params['ns2'];
        $ns3 = $params['ns3'];
        $ns4 = $params['ns4'];
        $firstName = $params['firstname'];
        $lastName = $params['lastname'];
        $fullName = $params['fullname'];
        $email = $params['email'];
        $phoneNo = $params['fullphonenumber'];
        $city = $params['city'];
        $country = $params['country'];
        $state = $params['state'];
    } catch (Exception $e) {
        logModuleCall('WGS Domain Module', __FUNCTION__, $params, $e->getMessage(), $e->getTraceAsString());
        return $e->getMessage();
    }
}

function wgsdomains_TransferDomain($params) {
    try{
        $domain = $params['domainname'];
        $eppCode = $params['eppcode'];
    } catch (Exception $e) {
        logModuleCall('WGS Domain Module', __FUNCTION__, $params, $e->getMessage(), $e->getTraceAsString());
        return $e->getMessage();
    }
}

function wgsdomains_RenewDomain($params) {
    try{
        $domain = $params['domainname'];
        $period = $params['period'];
    } catch (Exception $e) {
        logModuleCall('WGS Domain Module', __FUNCTION__, $params, $e->getMessage(), $e->getTraceAsString());
        return $e->getMessage();
    }
}

function wgsdomains_GetContactDetails($params) {
    try{
        $domain = $params['domainname'];
        $values["Registrant"]["Contact Name"] = $params['fullname'];
        $values["Registrant"]["Organisation"] = $params['companyname'];
        $values["Registrant"]["Address line 1"] = $params['address1'];
        $values["Registrant"]["Address line 2"] = $params['address1'];
        $values["Registrant"]["TownCity"] = $params['city'];
        $values["Registrant"]["Zip code"] = $params['postalcode'];
        $values["Registrant"]["Country Code"] = $params['country'];
        $values["Registrant"]["Phone"] = $params['address1'];
        $values["Registrant"]["Email"] = $params['email'];

        $values["Tech"]["Contact Name"] = $params['fullname'];
        $values["Tech"]["Organisation"] = $params['companyname'];
        $values["Tech"]["Address line 1"] = $params['address1'];
        $values["Tech"]["Address line 2"] = $params['address2'];
        $values["Tech"]["TownCity"] = $params['city'];
        $values["Tech"]["Zip code"] = $params['postalcode'];
        $values["Tech"]["Country Code"] = $params['country'];
        $values["Tech"]["Phone"] = $params['phone'];
        $values["Tech"]["Email"] = $params['email'];
        
        $values["Admin"]["Contact Name"] = $params['fullname'];
        $values["Admin"]["Organisation"] = $params['companyname'];
        $values["Admin"]["Address line 1"] = $params['address1'];
        $values["Admin"]["Address line 2"] = $params['address2'];
        $values["Admin"]["TownCity"] = $params['city'];
        $values["Admin"]["Zip code"] = $params['postalcode'];
        $values["Admin"]["Country Code"] = $params['country'];
        $values["Admin"]["Phone"] = $params['phone'];
        $values["Admin"]["Email"] = $params['email'];

        
        $values["Billing"]["Contact Name"] = $params['fullname'];
        $values["Billing"]["Organisation"] = $params['companyname'];
        $values["Billing"]["Address line 1"] = $params['address1'];
        $values["Billing"]["Address line 2"] = $params['address2'];
        $values["Billing"]["TownCity"] = $params['city'];
        $values["Billing"]["Zip code"] = $params['postalcode'];
        $values["Billing"]["Country Code"] = $params['country'];
        $values["Billing"]["Phone"] = $params['phone'];
        $values["Billing"]["Email"] = $params['email'];

    } catch (Exception $e) {
        logModuleCall('WGS Domain Module', __FUNCTION__, $params, $e->getMessage(), $e->getTraceAsString());
        return $e->getMessage();
    }
    
    return $values;
}

function wgsdomains_SaveContactDetails($params) {
    try{
        $domain = $params['domainname'];
        $values["Registrant"]["Contact Name"] = $params['fullname'];
        $values["Registrant"]["Organisation"] = $params['companyname'];
        $values["Registrant"]["Address line 1"] = $params['address1'];
        $values["Registrant"]["Address line 2"] = $params['address1'];
        $values["Registrant"]["TownCity"] = $params['city'];
        $values["Registrant"]["Zip code"] = $params['postalcode'];
        $values["Registrant"]["Country Code"] = $params['country'];
        $values["Registrant"]["Phone"] = $params['address1'];
        $values["Registrant"]["Email"] = $params['email'];

        $values["Tech"]["Contact Name"] = $params['fullname'];
        $values["Tech"]["Organisation"] = $params['companyname'];
        $values["Tech"]["Address line 1"] = $params['address1'];
        $values["Tech"]["Address line 2"] = $params['address2'];
        $values["Tech"]["TownCity"] = $params['city'];
        $values["Tech"]["Zip code"] = $params['postalcode'];
        $values["Tech"]["Country Code"] = $params['country'];
        $values["Tech"]["Phone"] = $params['phone'];
        $values["Tech"]["Email"] = $params['email'];
        
        $values["Admin"]["Contact Name"] = $params['fullname'];
        $values["Admin"]["Organisation"] = $params['companyname'];
        $values["Admin"]["Address line 1"] = $params['address1'];
        $values["Admin"]["Address line 2"] = $params['address2'];
        $values["Admin"]["TownCity"] = $params['city'];
        $values["Admin"]["Zip code"] = $params['postalcode'];
        $values["Admin"]["Country Code"] = $params['country'];
        $values["Admin"]["Phone"] = $params['phone'];
        $values["Admin"]["Email"] = $params['email'];

        
        $values["Billing"]["Contact Name"] = $params['fullname'];
        $values["Billing"]["Organisation"] = $params['companyname'];
        $values["Billing"]["Address line 1"] = $params['address1'];
        $values["Billing"]["Address line 2"] = $params['address2'];
        $values["Billing"]["TownCity"] = $params['city'];
        $values["Billing"]["Zip code"] = $params['postalcode'];
        $values["Billing"]["Country Code"] = $params['country'];
        $values["Billing"]["Phone"] = $params['phone'];
        $values["Billing"]["Email"] = $params['email'];

    } catch (Exception $e) {
        logModuleCall('WGS Domain Module', __FUNCTION__, $params, $e->getMessage(), $e->getTraceAsString());
        return $e->getMessage();
    }
    
    return $values;
}

function wgsdomains_RequestDelete($params) {
    try{
        $domain = $params['domainname'];
        $period = $params['period'];
    } catch (Exception $e) {
        logModuleCall('WGS Domain Module', __FUNCTION__, $params, $e->getMessage(), $e->getTraceAsString());
        return $e->getMessage();
    }
}

function wgsdomains_GetEPPCode($params) {
    try{
        $domain = $params['domainname'];
        return $params['eppcode'];
    } catch (Exception $e) {
        logModuleCall('WGS Domain Module', __FUNCTION__, $params, $e->getMessage(), $e->getTraceAsString());
        return $e->getMessage();
    }
}

function wgsdomains_Sync($params) {
    try{
        $domain = $params['domainname'];
        $domainStatusGet = $params['status'];
        if ($domainStatusGet == "ok") {
            $values['active'] = true;
        } elseif ($domainStatusGet == "serverHold") {
            
        } elseif ($domainStatusGet == "expired" || $domainStatusGet == "pendingDelete" || $domainStatusGet == "inactive") {
            $values['expired'] = true;
        } else {
            $values['error'] = "Sync/domain-info: Unknown status code '$domainStatusGet'";
        }
    } catch (Exception $e) {
        logModuleCall('WGS Domain Module', __FUNCTION__, $params, $e->getMessage(), $e->getTraceAsString());
        return $e->getMessage();
    }
    return $values;
}

function wgsdomains_TransferSync($params) {
    try{
        $domain = $params['domainname'];
        $domainStatusGet = $params['status'];
        if ($domainStatusGet == "ok") {
            $values['active'] = true;
        } elseif ($domainStatusGet == "serverHold") {
            
        } elseif ($domainStatusGet == "expired" || $domainStatusGet == "pendingDelete" || $domainStatusGet == "inactive") {
            $values['expired'] = true;
        } else {
            $values['error'] = "Sync/domain-info: Unknown status code '$domainStatusGet'";
        }
    } catch (Exception $e) {
        logModuleCall('WGS Domain Module', __FUNCTION__, $params, $e->getMessage(), $e->getTraceAsString());
        return $e->getMessage();
    }
    return $values;
}

?>