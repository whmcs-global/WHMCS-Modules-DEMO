<?php

/* * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
 *  Module setup Addon Module By whmcsglobalservices.com
 *
 *  Date: 18 february, 2021
 *  WHMCS Version: v7,v8.x
 *
 *  By WHMCSGLOBALSERVICES    https://whmcsglobalservices.com
 *
 *  In this module you can set up your selling module
 *
 *  @owner <whmcsglobalservices.com>
 *  @author <whmcsglobalservices.com>
 * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * */

use Illuminate\Database\Capsule\Manager as Capsule;

class Modulesetup
{

    private $apiUrl;
    private $apiKey;
    private $table;

    public function __construct()
    {
        $this->table = 'mod_modulesetup';
    }

    # Save Data in db

    public function saveData($postData)
    {
        $values = array('name' => $postData['name'], 'desc' => $postData['desc'], 'overview' => $postData['overview'], 'order' => $postData['order']);
        Capsule::table($this->table)->insert($values);
    }

    # Get data from db

    public function getData($id = NULL)
    {
        if (!empty($id))
            $result = Capsule::table($this->table)->where('id', $id)->get();
        else
            $result = Capsule::table($this->table)->get();

        $data = [];
        foreach($result as $data){
            $data[] = (array) $data;
        }

        return array('result' => $data, 'rows' => count($result));
    }

    # Update data in db

    public function updateDetail($postData)
    {
        if (!empty($postData['id'])) {
            $values = array('name' => $postData['name'], 'desc' => $postData['desc'], 'overview' => $postData['overview'], 'order' => $postData['order']);
            Capsule::table($this->table)->where('id', $postData['id'])->update($values);
            return 'success';
        } else {
            return 'Error: Id is missing!';
        }
    }

    # Delete data from db

    public function deleteData($id)
    {
        if (!empty($id))
            Capsule::table($this->table)->where('id', $id)->delete();
        return true;
    }
}
