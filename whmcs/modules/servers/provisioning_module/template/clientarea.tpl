<div class="panel panel-default">
    <div class="panel-heading">Information</div>
    <div class="panel-body">
        <div class="col-sm-12">
            <div id="getdetail" style="display:none;">
            </div>
            <div class="row">
                <div class="col-sm-12">
                    <div class="text-center">
                        <i id="loader" class="fa"></i>
                        <span class="sr-only">Loading...</span>
                    </div>
                </div>
            </div>
            <div class="col-sm-8">
                <div class="form-group row">
                    <label class="col-sm-3 col-form-label">User Id :</label>
                    <div class="col-sm-3">
                        <span id="userid"> </span>
                    </div>
                </div>
            </div>

            <div class="col-sm-8">
                <div class="form-group row ">
                    <label class="col-sm-3 col-form-label">Display Name :</label>
                    <div class="col-sm-5">
                        <span id="displayname"> </span>
                    </div>
                </div>
            </div>
            <div class="col-sm-8">
                <div class="form-group row">
                    <label class="col-sm-3 col-form-label">Email :</label>
                    <div class="col-sm-5">
                        <span id="email"> </span>
                    </div>
                </div>
            </div>

            <div class="col-sm-8">
                <div class="form-group row">
                    <label class="col-sm-3 col-form-label">User Quota<br>(Size | object) :</label><br>
                    <div class="col-sm-5">
                        <span id="userQuotasize"></span> <span>|</span> <span id="userQuotaobject"></span>
                    </div>
                </div>
            </div>
        </div>
        <div>
            <button class="btn btn-warning" data-toggle="modal" data-target="#updatemodal">Edit</button>
            <button class="btn btn-primary" data-toggle="modal" data-target="#addmodal1" onclick=" ">Add
            </button>
            <button class="btn btn-success" onclick="Getkeys(this);">Get keys</button>

        </div><br>
        <div id="getkeys" style="display:none;">
            <div class="col-sm-12">
                <div class="form-group row ">
                    <label class="col-sm-4">User Name :</label>
                    <div class="col-sm-8">
                        <span id="username"> </span>
                    </div>
                </div>
                <div class="form-group row ">
                    <label class="col-sm-4">Access Key:</label>
                    <div class="col-sm-8">
                        <span id="accesskey"> </span>
                    </div>
                </div>
                <div class="form-group row ">
                    <label class="col-sm-4">Secret Key:</label>
                    <div class="col-sm-8">
                        <span id="secretkey"> </span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>



<!-- Update modal -->
<div class="modal fade" id="updatemodal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">

            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <h4 class="modal-title">Update User</h4>
            </div>
            <div class="modal-body">
                <div>
                    <div class="text-center">
                        <div id="update_resp"></div>
                    </div>
                    <form method="post" id="update_form" action=" ">
                        <div class="form-group">
                            <label class="text-info"><b>User ID:</b></label>
                            <input type="text" placeholder=" " id="userid1" name="userid" class="form-control">
                        </div>
                        <div class="form-group">
                            <label class="text-info"><b>Display Name:</b></label>
                            <input type="text" placeholder=" " id="displayname1" name="displayname"
                                class="form-control">
                        </div>
                        <div class="form-group">
                            <label class="text-info"><b>Email</b></label>
                            <input type="text" placeholder="" id="email1" name="email" class="form-control">
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-warning" onclick="UpdateInfo(this, 'update');">Update</button>
                </div>
            </div>
        </div>
    </div>
</div>

</div>



<script type="text/javascript" src="{$WEB_ROOT}/modules/servers/provisioning_module/js/client.js"></script>
<link rel="stylesheet" type="text/css" href="{$WEB_ROOT}/modules/servers/provisioning_module/style/style.css" />