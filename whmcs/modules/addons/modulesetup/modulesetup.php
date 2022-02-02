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

if (!defined("WHMCS"))
    die("This file cannot be accessed directly");

if (file_exists(__DIR__ . '/classes/class.php'))
    require_once __DIR__ . '/classes/class.php';

/*
 *  Module configure
 *  */

function modulesetup_config()
{
    $configarray = array(
        "name" => "Selling Module Setup Addon",
        "description" => "In this module you can set up your selling module",
        "version" => "1.0",
        "author" => "WHMCS GLOBAL SERVICES",
        "language" => "english",
    );
    return $configarray;
}

/*
 *  Module activate
 *  */

function modulesetup_activate()
{
    # Create Custom DB Table

    if (!Capsule::Schema()->hasTable('mod_modulesetup')) {
        Capsule::schema()->create('mod_modulesetup', function ($table) {
            $table->increments('id');
            $table->string('name', '100');
            $table->string('desc', '500');
            $table->string('overview', '500');
            $table->string('order', '500');
        });
    }

    # Return Result
    return array('status' => 'success', 'description' => 'Activated successfully');
}

/*
 *  Module deactivate
 *  */

function modulesetup_deactivate()
{
    # Delete Custom DB Table
    Capsule::schema()->dropIfExists('mod_modulesetup');

    # Return Result
    return array('status' => 'success', 'description' => 'Deactivated successfully.');
}

/*
 *  Module output
 *  */

function modulesetup_output($vars)
{
    echo '<script type="text/javascript" language="javascript" src="../modules/addons/modulesetup/js/jquery.js"></script>';
    echo '<link rel="stylesheet" type="text/css" href="../modules/addons/modulesetup/css/style.css">';


    $modulelink = $vars['modulelink'];
    $LANG = $vars['_lang'];

    $object = new Modulesetup($vars);

    if (isset($_REQUEST["action"])) {
        if (file_exists(__DIR__ . '/includes/' . $_REQUEST["action"] . '.php')) {
            require_once __DIR__ . '/includes/' . $_REQUEST["action"] . '.php';
        }
    } else {
        if (file_exists(__DIR__ . '/includes/' . 'homepage.php')) {
            require_once __DIR__ . '/includes/' . 'homepage.php';
        }
    }
}
