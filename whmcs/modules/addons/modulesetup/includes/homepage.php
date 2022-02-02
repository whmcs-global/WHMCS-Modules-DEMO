<?php
if (file_exists(dirname(__DIR__) . '/includes/' . 'action.php'))
    require_once dirname(__DIR__) . '/includes/' . 'action.php';

$getData = $object->getData();  #get data
?>
<div id="message"></div>
<div class="createbutton">
    <button class="btn btn-primary" onclick="jQuery('#moduleform').toggle();">Add Module</button>
</div>
<form method="post" action="<?php $modulelink; ?>" id="moduleform" style="display: none;">
    <input type="hidden" name="moduleaction" value="add">
    <table width="100%" cellspacing="2" cellpadding="3" border="0" class="form">
        <tbody>
            <tr>
                <td class="fieldlabel">Module Name</td>
                <td class="fieldarea">
                    <input type="text" value="" size="30" name="name" required="required">
                </td>
                <td class="fieldlabel">Module desc</td>
                <td class="fieldarea">
                    <textarea rows="2" cols="35" name="desc"></textarea>
                </td>
            </tr>
            <tr>
                <td class="fieldlabel">Overview link</td>
                <td class="fieldarea">
                    <input type="text" value="" size="30" name="overview" required="required">
                </td>
                <td class="fieldlabel">Order Link</td>
                <td class="fieldarea">
                    <input type="text" value="" size="30" name="order" required="required">
                </td>
            </tr>
            <tr>

            </tr>
        </tbody>
    </table>
    <div class="btn-container">
        <input type="submit" class="btn btn-primary" value="Save Changes">
    </div>
</form>
<div class="spaced"></div>

<table width="100%" cellspacing="1" cellpadding="3" border="0" class="datatable" id="sortabletbl0">
    <tbody>
        <tr>
            <th width="18%">Module Name</th>
            <th width="20%">Module Desc</th>
            <th width="25%">Overview Link</th>
            <th width="25%">Order Link</th>
            <th width="12%">Action</th>
        </tr>
        <?php
        foreach ($getData['result'] as $key => $value) {
        ?>
            <tr>
                <td width="18%"><?php echo $value['name']; ?></td>
                <td width="20%"><?php echo $value['desc']; ?></td>
                <td width="25%"><?php echo $value['overview']; ?></td>
                <td width="25%"><?php echo $value['order']; ?></td>
                <td width="12%" align="center">
                    <a onclick="editModule(this, '<?php echo $value['id']; ?>', '<?php echo $modulelink; ?>');" class="customaction" title="Edit">Edit</a>&nbsp;|&nbsp;
                    <a onclick="deleteData(this, '<?php echo $value['id']; ?>', '<?php echo $modulelink; ?>');" class="customaction" title="Delete">Delete</a>
                </td>
            </tr>
        <?php
        }
        ?>
    </tbody>
</table>

<div class="modal fade" id="addAdimUser" tabindex="-1" role="dialog" aria-labelledby="addAdimUser" aria-hidden="false" style="padding-right: 15px;">
    <div class="modal-dialog">
        <div class="modal-content panel panel-primary">
            <div class="modal-header panel-heading">
                <button type="button" class="close" data-dismiss="modal">
                    <span aria-hidden="true">×</span>
                    <span class="sr-only">Edit Module</span>
                </button>
                <h4 class="modal-title" id="popupHeading"></h4>
            </div>
            <form method="post" action="" id="popupFrom" onsubmit="return false;">
                <input type="hidden" name="moduleaction" id="" value="update" />
                <input type="hidden" name="id" id="moduleid" value="" />
                <div class="modal-body panel-body" id="popupBody">
                    <div id="progress"><i class="fa fa-circle-o-notch fa-spin"></i></div>
                </div>
                <div class="modal-footer panel-footer">
                    <button class="btn btn-primary" onclick="updateModule(this,'<?php echo $modulelink; ?>')">Save Changes</button>
                </div>
            </form>
        </div>
    </div>
</div>