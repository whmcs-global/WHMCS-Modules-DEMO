<?php

if (isset($_REQUEST['getdata'])) {
    $token = '9D70eT91Tu4DvXbV279XhWq6YiyJ9v0T';    # for security purpose

    if ($_REQUEST['token'] == $token) {

        if (file_exists(dirname(__DIR__) . '/classes/class.php'))
            require_once dirname(__DIR__) . '/classes/class.php';

        if (file_exists('../../../../init.php'))
            require_once '../../../../init.php';

        $object = new Modulesetup();   #Create object

        $getDetail = $object->getData();

        print_r(json_encode($getDetail, true));
    } else {
        print_r(json_encode(array('result' => 'error', 'msg' => 'Invalid token'), true));
    }
    exit();
} else {
    print_r(json_encode(array('result' => 'error', 'msg' => 'Access Denied!'), true));
    exit();
}
