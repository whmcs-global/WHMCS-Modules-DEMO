<?php

if (isset($_POST['moduleaction'])) {
    switch ($_POST['moduleaction']) {
        case 'add':
            if (file_exists(dirname(__DIR__) . '/classes/class.php'))
                require_once dirname(__DIR__) . '/classes/class.php';

            $object = new Modulesetup($vars);   #Create object

            $result = $object->saveData($_POST);  # Save data in db

            break;
        case 'delete':
            if (file_exists(dirname(__DIR__) . '/classes/class.php'))
                require_once dirname(__DIR__) . '/classes/class.php';

            if (file_exists('../../../../init.php'))
                require_once '../../../../init.php';

            $object = new Modulesetup($vars);   #Create object

            $result = $object->deleteData($_POST['id']);  # Delete data in db
            echo $result;
            break;
        case 'getdetail':
            if (file_exists(dirname(__DIR__) . '/classes/class.php'))
                require_once dirname(__DIR__) . '/classes/class.php';

            if (file_exists('../../../../init.php'))
                require_once '../../../../init.php';

            $object = new Modulesetup($vars);   #Create object

            $getDetail = $object->getData($_POST['id']);
            $html = '';

            $html .= '<div class="customcontainer">';
            $html .= '<div class="label">';
            $html .= '<label>Name</label>';
            $html .= '</div>';
            $html .= '<div class="input">';
            $html .= '<input type="text" id="name" name="name" value="' . $getDetail['result'][0]['name'] . '">';
            $html .= '</div>';
            $html .= '<div class="label">';
            $html .= '<label>Overview link</label>';
            $html .= '</div>';
            $html .= '<div class="input">';
            $html .= '<input type="text" id="overview" name="overview" value="' . $getDetail['result'][0]['overview'] . '">';
            $html .= '</div>';
            $html .= '<div class="label">';
            $html .= '<label>Desc</label>';
            $html .= '</div>';
            $html .= '<div class="input">';
            $html .= '<textarea name="desc" cols="30" rows="2">' . $getDetail['result'][0]['desc'] . '</textarea>';
            $html .= '</div>';
            $html .= '<div class="label">';
            $html .= '<label>Order link</label>';
            $html .= '</div>';
            $html .= '<div class="input">';
            $html .= '<input type="text" id="order" name="order" value="' . $getDetail['result'][0]['order'] . '">';
            $html .= '</div>';
            $html .= '</div>';

            print $html;
            break;
        case 'update':
            if (file_exists(dirname(__DIR__) . '/classes/class.php'))
                require_once dirname(__DIR__) . '/classes/class.php';

            if (file_exists('../../../../init.php'))
                require_once '../../../../init.php';

            $object = new Modulesetup($vars);   #Create object

            $updateDetail = $object->updateDetail($_POST);

            print $updateDetail;
            break;
    }
}
