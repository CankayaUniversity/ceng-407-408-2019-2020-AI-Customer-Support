<script type="text/javascript" src="/js/jquery.min.js"></script>
<link href="//maxcdn.bootstrapcdn.com/bootstrap/3.3.0/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
<script src="//maxcdn.bootstrapcdn.com/bootstrap/3.3.0/js/bootstrap.min.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<link rel="stylesheet" type="text/css" href="/install/ins.css">
<script type="text/javascript" src="/install/ins.js"></script>

<div class="container">
    <div class="stepwizard">
        <div class="stepwizard-row setup-panel">
            <div class="stepwizard-step col-xs-6"> 
                <a href="#step-1" type="button" class="btn btn-success btn-circle">1</a>
                <p><small>Server Settings</small></p>
            </div>
            <div class="stepwizard-step col-xs-6"> 
                <a href="#step-2" type="button" class="btn btn-default btn-circle" disabled="disabled">2</a>
                <p><small>General Settings</small></p>
            </div>
            <!--
            <div class="stepwizard-step col-xs-3"> 
                <a href="#step-3" type="button" class="btn btn-default btn-circle" disabled="disabled">3</a>
                <p><small>Admin Settings</small></p>
            </div> 
            -->
        </div>
    </div>
    <form role="form">

        <div class="panel panel-primary setup-content" id="step-1">
            <div class="panel-heading">
                <h3 class="panel-title">Server Settings</h3>
            </div>
            <div class="panel-body">
                <div class="form-group">
                    <label class="control-label">Servername</label>
                    <input maxlength="200" type="text" required="required" id="Servername" class="form-control" placeholder="Enter Servername" />
                </div>
                <div class="form-group">
                    <label class="control-label">Username</label>
                    <input maxlength="200" type="text" required="required" id="Username" class="form-control" placeholder="Enter Username" />
                </div>
                <div class="form-group">
                    <label class="control-label">Password</label>
                    <input maxlength="200" type="password" required="required" id="Password" class="form-control" placeholder="Enter Password" />
                </div>
                <div class="form-group">
                    <label class="control-label">DB Name</label>
                    <input maxlength="200" type="text" required="required" id="DB_Name" class="form-control" placeholder="Enter DB Name" />
                </div>
                <input type="checkbox" name="ResetDB"/> Reset Database
                <br>
                <input type="checkbox" name="IgnoreINS"/> Ignore Insertions
                <button class="btn btn-primary nextBtn pull-right" id ="saveservedbutton" onclick="saveServerSettings('none')" type="button">Next</button>
            </div>
        </div>

        <div class="panel panel-primary setup-content" id="step-2">
            <div class="panel-heading">
                <h3 class="panel-title">General Settings</h3>
            </div>
            <div class="panel-body">
                <div class="form-group">
                    <label class="control-label">Site title</label>
                    <input maxlength="100" type="text" required="required" class="form-control" id="siteTitle" placeholder="Enter Site title" />
                </div>
                <div class="form-group">
                    <label class="control-label">Slogan</label>
                    <input maxlength="100" type="text" required="required" class="form-control" id="siteSlogan" placeholder="Enter Slogan" />
                </div>
                <div class="form-group">
                    <label class="control-label">System address (URL)</label>
                    <input maxlength="100" type="text" required="required" class="form-control" id="systemAddress" placeholder="Enter System address" />
                </div>
                <div class="form-group">
                    <label class="control-label">Site address (URL)</label>
                    <input maxlength="100" type="text" required="required" class="form-control" id="siteAddress" placeholder="Enter Site address" />
                </div>
                <div class="form-group">
                    <label class="control-label">E-mail address</label>
                    <input maxlength="100" type="text" required="required" class="form-control" id="siteEmail" placeholder="Enter E-mail" />
                </div>
                <button class="btn btn-primary pull-right" type="submit" onclick="saveGeneralSettings()">Next</button>
            </div>
        </div>
        
        <!-- 
        <div class="panel panel-primary setup-content" id="step-3">
            <div class="panel-heading">
                <h3 class="panel-title">Admin Settings</h3>
            </div>
            <div class="panel-body">
                <div class="form-group">
                    <label class="control-label">Admin Username</label>
                    <input maxlength="200" type="text" required="required" id="AdminUsername" class="form-control" placeholder="Enter Username" />
                </div>
                <div class="form-group">
                    <label class="control-label">Password</label>
                    <input maxlength="200" type="password" required="required" id="AdminPassword" class="form-control" placeholder="Enter Password" />
                </div>
                <div class="form-group">
                    <label class="control-label">Admin First Name</label>
                    <input maxlength="200" type="text" required="required" id="AdminFirstName" class="form-control" placeholder="Enter First Name" />
                </div>
                <div class="form-group">
                    <label class="control-label">Admin Surname</label>
                    <input maxlength="200" type="text" required="required" id="AdminSurname" class="form-control" placeholder="Enter Surname" />
                </div>
                <div class="form-group">
                    <label class="control-label">Admin Email</label>
                    <input maxlength="200" type="text" required="required" id="AdminEmail" class="form-control" placeholder="Enter Email" />
                </div>
                <button class="btn btn-success pull-right" onclick="saveAdminSettings()" type="submit">Finish</button>
            </div>
        </div> 
        -->
    </form>
    <a href="../admin/index.php">Go back to admin panel</a>
</div>

<script>
    $("input[name=ResetDB]").click(function(){
        if($("input[name=ResetDB]").is(":checked")){
            $("#saveservedbutton").attr("onclick","saveServerSettings('reset')");
            $("input[name=IgnoreINS]").prop("checked",false);
        }else{
            $("#saveservedbutton").attr("onclick","saveServerSettings('none')");
        }
    });
    $("input[name=IgnoreINS]").click(function(){
        if($("input[name=IgnoreINS]").is(":checked")){
            $("#saveservedbutton").attr("onclick","saveServerSettings('ignore')");
            $("input[name=ResetDB]").prop("checked",false);
        }else{
            $("#saveservedbutton").attr("onclick","saveServerSettings('none')");
        }
    });

    function saveServerSettings(checkbox) {
        var Servername = $("#Servername").val();
        var Username = $("#Username").val();
        var Password = $("#Password").val();
        var DB_Name = $("#DB_Name").val();
        var action = "ServerSettings";
        $.ajax({
            url: "/install/insActions.php",
            method: "POST",
            dataType: "JSON",
            data: {
            action: action,
            Servername: Servername,
            Username: Username,
            Password: Password,
            DB_Name: DB_Name,
            checkbox: checkbox
            },
            success: function(response) {
                alert(response);
                if (response.ErrorCode == "ServerError") {
                    alert(response.ErrorMessage);
                    window.location.reload();
                } else if (response.ErrorCode == "DBError") {
                    alert(response.ErrorMessage);
                    window.location.reload();
                }
            }
        });
    }
</script>