<?php

use WHMCS\Database\Capsule;

class Manage_provisioning_module {

    function __construct() {
        
    }

    function provisioning_module_CreateConfigOptions($pid) {

        $nameExist = Capsule::table('tblproductconfiggroups')->where('name', 'provisioning_module-' . $pid)->first();

        if (empty($nameExist)) {
            try {
                $insertdata = [
                    'name' => 'provisioning_module-' . $pid,
                ];
                $gid = Capsule::table('tblproductconfiggroups')->insertGetId($insertdata);
            } catch (\Exception $e) {
                logActivity("Unable to insert: {$e->getMessage()}");
            }
        } else {
            $gid = $nameExist->id;
        }
        if ($gid) {
            if (Capsule::table('tblproductconfiglinks')->where('gid', $gid)->where('pid', $pid)->count() == 0) {
                try {
                    $insertdata = [
                        'gid' => $gid,
                        'pid' => $pid,
                    ];
                    Capsule::table('tblproductconfiglinks')->insert($insertdata);
                } catch (\Exception $e) {
                    logActivity("Unable to insert: {$e->getMessage()}");
                }
            }
        }

        $configOptionArr = [
            "user_quota" => [
                "optionname" => "user_quota|User Quota",
                "optiontype" => "4",
                "qtyminimum" => "",
                "qtymaximum" => "100",
            ],
            "user_quota_object" => [
                "optionname" => "user_quota_object|User Quota Object",
                "optiontype" => "4",
                "qtyminimum" => "",
                "qtymaximum" => "10",
            ]
        ];

        //$gidExit = Capsule::table('tblproductconfiglinks')->where('gid')->count();
        foreach ($configOptionArr as $key => $value) {
            $count = Capsule::table('tblproductconfigoptions')->where('gid', $gid)->where('optionname', 'like', '%' . $key . '%')->count();
            /* echo $count;
              die; */
            if ($count == 0) {
                try {
                    $value['gid'] = $gid;
                    $configId = Capsule::table('tblproductconfigoptions')->insertGetId($value);
                    $optsub = Capsule::table('tblproductconfigoptionssub')->where('configid', $configId)->where('optionname', 'like', '%' . $key . '%')->count();
                    if ($optsub == 0) {
                        $insertData = ['configid' => $configId, 'optionname' => $value['optionname']];
                        $relid = Capsule::table('tblproductconfigoptionssub')->insertGetId($insertData);
                        $currencyData = Capsule::table('tblcurrencies')->get();
                        foreach ($currencyData as $currency) {
                            $count = Capsule::table('tblpricing')->where('relid', $relid)->where('currency', $currency->id)->where('type', 'configoptions')->count();
                            if ($count == 0) {
                                try {
                                    $insertdata = [
                                        "type" => "configoptions",
                                        "currency" => $currency->id,
                                        "relid" => $relid
                                    ];
                                } catch (Exception $ex) {
                                    logActivity("Unable to insert data in tblpricing: {$ex->getMessage()}");
                                }
                            }
                        }
                    }
                } catch (Exception $ex) {
                    logActivity("Unable to insert data in tblproductconfigoptions: {$ex->getMessage()}");
                }
            }
        }
    }

    function provisioning_module_Login($params) {
        $url = $params['configoption1'] . 'auth/login-form';
        $data = 'username=' . $params['configoption2'] . '&password=' . $params['configoption3'] . '&grant_type=password';

        $result = $this->provisioning_module_DoRequest($url, 'POST', $data);
        return $result;
    }

    function provisioning_module_LogOut($params) {
        $url = $params['configoption1'] . 'auth/logout';
        $result = $this->provisioning_module_DoRequest($url, 'POST');
        return $result;
    }

    function provisioning_module_GetUsers($params, $accessToken) {
        $url = $params['configoption1'];
        $headers = [
            "Authorization: Bearer {$accessToken} ",
            "Content-Type: application/json"
        ];
        $result = $this->provisioning_module_DoRequest($url, 'GET', '', $headers);
        logModuleCall('provisioning_module Provisioning Module', 'get users', $url, $result);
        return $result;
    }

    function provisioning_module_GetUserskey($params, $accessToken, $uid) {
        $url = $params['configoption1']  . $uid . '/key';
        $headers = [
            "Authorization: Bearer {$accessToken} ",
            "Content-Type: application/json"
        ];
        $result = $this->provisioning_module_DoRequest($url, 'GET', '', $headers);
        logModuleCall('provisioning_module Provisioning Module', 'get users key', $url, $result);
        return $result;
    }

    function provisioning_module_CreateUser($params, $accessToken) {
        $url = $params['configoption1'];
        $uid = $params['clientsdetails']['firstname'] . $params['serviceid'];
        $name = $params['clientsdetails']['firstname'];
        $email = $params['clientsdetails']['email'];
        $data = [
            "uid" => $uid,
            "name" => $name,
            "email" => $email,
        ];
        $headers = [
            "Authorization: Bearer {$accessToken} ",
            "Content-Type: application/json"
        ];
        $result = $this->provisioning_module_DoRequest($url, 'POST', json_encode($data), $headers);
        logModuleCall('provisioning_module Provisioning Module', 'create user', $data, $result);
        return $result;
    }

    function provisioning_module_AssignUserQuota($params, $accessToken, $uid) {
        $url = $params['configoption1']  . $uid . '/quota';
        $maxSizeKb = (empty($params['configoptions']['user_quota'])) ? $params['configoption6'] : $params['configoptions']['user_quota'] + $params['configoption6'];
        $maxObjects = (empty($params['configoptions']['user_quota_object'])) ? $params['configoption7'] : $params['configoptions']['user_quota_object'] + $params['configoption7'];
        $maxSizeKb = $this->provisioning_module_GetUnit($maxSizeKb, $params['configoption8']);
        $data = [
            "enabled" => true,
            "max_size_kb" => $maxSizeKb,
            "max_objects" => $maxObjects,
        ];
        $headers = [
            "Authorization: Bearer {$accessToken} ",
            "Content-Type: application/json"
        ];
        if ($maxSizeKb > 0)
            $result = $this->provisioning_module_DoRequest($url, 'PUT', json_encode($data), $headers);
        else
            $result = null;
        logModuleCall('provisioning_module Provisioning Module', 'assign user quota', $data, $result);
        return $result;
    }


    private function provisioning_module_GetUnit($size, $unit) {
        if ($unit == 'mb')
            $size = $size * 1000;
        elseif ($unit == 'gb')
            $size = $size * 1000 * 1000;
        elseif ($unit == 'tb')
            $size = $size * 1000 * 1000 * 1000;
        return $size;
    }

    function provisioning_module_Suspend($params, $accessToken, $uid) {
        $url = $params['configoption1']  . $uid;
        $data = [
            "suspended" => true,
        ];
        $headers = [
            "Authorization: Bearer {$accessToken} ",
            "Content-Type: application/json"
        ];
        $result = $this->provisioning_module_DoRequest($url, 'PATCH', json_encode($data), $headers);
        logModuleCall('provisioning_module Provisioning Module', 'Suspend user', $data, $result);
        return $result;
    }

    function provisioning_module_Unsuspend($params, $accessToken, $uid) {
        $url = $params['configoption1']  . $uid;
        $data = [
            "suspended" => false,
        ];
        $headers = [
            "Authorization: Bearer {$accessToken} ",
            "Content-Type: application/json"
        ];
        $result = $this->provisioning_module_DoRequest($url, 'PATCH', json_encode($data), $headers);
        logModuleCall('provisioning_module Provisioning Module', 'Unsuspend user', $data, $result);
        return $result;
    }

    function provisioning_module_Terminate($params, $accessToken, $uid) {
        $url = $params['configoption1']  . $uid;
        $headers = [
            "Authorization: Bearer {$accessToken} ",
            "Content-Type: application/json"
        ];
        $data = null;
        $result = $this->provisioning_module_DoRequest($url, 'DELETE', json_encode($data), $headers);
        logModuleCall('provisioning_module Provisioning Module', 'terminate user', $url, $result);
        return $result;
    }

    function provisioning_module_DoRequest($url, $method, $postData = NULL, $headers = false) {
        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, $url);
        if ($headers) {
            curl_setopt($ch, CURLOPT_HEADER, false);
            curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        }
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        if ($method == 'POST') {
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $postData);
        }
        if ($method == 'GET') {
            curl_setopt($ch, CURLOPT_HTTPGET, true);
        }
        if ($method == 'DELETE') {
            curl_setopt($ch, CURLOPT_CUSTOMREQUEST, $method);
        }
        if ($method == 'PUT') {
            curl_setopt($ch, CURLOPT_CUSTOMREQUEST, $method);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $postData);
        }
        if ($method == 'PATCH') {
            curl_setopt($ch, CURLOPT_CUSTOMREQUEST, $method);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $postData);
        }
        $response = curl_exec($ch);
        $httpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);

        curl_close($ch);
        return ['code' => $httpcode, 'result' => json_decode($response, true)];
    }

    function provisioning_module_CreateCustomFields($pid) {
        $Arr = [
            "provisioning_module_uid" => [
                "fieldname" => "provisioning_module_uid|provisioning_module User Id",
                "type" => "product",
                "relid" => $pid,
                "fieldtype" => "text",
                "showorder" => "",
                "required" => "",
                "adminonly" => "on",
            ]
        ];

        foreach ($Arr as $key => $value) {
            $count = Capsule::table('tblcustomfields')->where('type', 'product')->where('relid', $pid)->where('fieldname', 'like', '%' . $key . '%')->count();

            if ($count == 0) {
                try {
                    Capsule::table('tblcustomfields')->insert($value);
                } catch (Exception $ex) {
                    logActivity("Unable to insert data in tblcustomfields: {$ex->getMessage()}");
                }
            }
        }
    }

    function provisioning_module_GetCustomFieldId($relid, $fieldname) {
        $data = Capsule::table('tblcustomfields')->where('type', 'product')->where('relid', $relid)->where('fieldname', 'like', '%' . $fieldname . '%')->first();
        return $data->id;
    }

    function provisioning_module_CustomFieldvalue($params, $fieldname, $uid = null) {
        $fieldId = $this->provisioning_module_GetCustomFieldId($params['pid'], $fieldname);
        $data = [
            "fieldid" => $fieldId,
            "relid" => $params['serviceid'],
            "value" => $uid
        ];
        if (Capsule::table('tblcustomfieldsvalues')->where('relid', $params['serviceid'])->where('fieldid', $fieldId)->count() == 0) {
            try {
                Capsule::table('tblcustomfieldsvalues')->insert($data);
            } catch (Exception $ex) {
                logActivity("Unable to insert data in tblcustomfieldsvalues: {$ex->getMessage()}");
            }
        } else {
            try {
                Capsule::table('tblcustomfieldsvalues')->where('relid', $params['serviceid'])->where('fieldid', $fieldId)->update($data);
            } catch (Exception $ex) {
                logActivity("Unable to udpate data in tblcustomfieldsvalues: {$ex->getMessage()}");
            }
        }
    }
}

?>