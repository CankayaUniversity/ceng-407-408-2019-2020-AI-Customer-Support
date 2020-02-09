<script type="text/javascript" src="/js/jquery.min.js"></script>
<link href="//maxcdn.bootstrapcdn.com/bootstrap/3.3.0/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
<script src="//maxcdn.bootstrapcdn.com/bootstrap/3.3.0/js/bootstrap.min.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<link rel="stylesheet" type="text/css" href="/install/ins.css">
<script type="text/javascript" src="/install/ins.js"></script>

<div class="container">
    <div class="stepwizard">
        <div class="stepwizard-row setup-panel">
            <div class="stepwizard-step col-xs-3"> 
                <a href="#step-1" type="button" class="btn btn-success btn-circle">1</a>
                <p><small>General Settings</small></p>
            </div>
            <div class="stepwizard-step col-xs-3"> 
                <a href="#step-2" type="button" class="btn btn-default btn-circle" disabled="disabled">2</a>
                <p><small>Server Settings</small></p>
            </div>
            <div class="stepwizard-step col-xs-3"> 
                <a href="#step-3" type="button" class="btn btn-default btn-circle" disabled="disabled">3</a>
                <p><small>Admin Settings</small></p>
            </div>
        </div>
    </div>
    
    <form role="form">
        <div class="panel panel-primary setup-content" id="step-1">
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
                <button class="btn btn-primary nextBtn pull-right" type="button" onclick="saveGeneralSettings()">Next</button>
            </div>
        </div>
        
        <div class="panel panel-primary setup-content" id="step-2">
            <div class="panel-heading">
                 <h3 class="panel-title">Server Settings</h3>
            </div>
            <div class="panel-body">
                <div class="form-group">
                    <label class="control-label">Servername</label>
                    <input maxlength="200" type="text" required="required" class="form-control" placeholder="Enter Servername" />
                </div>
                <div class="form-group">
                    <label class="control-label">Username</label>
                    <input maxlength="200" type="text" required="required" class="form-control" placeholder="Enter Username" />
                </div>
                <div class="form-group">
                    <label class="control-label">Password</label>
                    <input maxlength="200" type="text" required="required" class="form-control" placeholder="Enter Password" />
                </div>
                <div class="form-group">
                    <label class="control-label">DB Name</label>
                    <input maxlength="200" type="text" required="required" class="form-control" placeholder="Enter DB Name" />
                </div>
                <button class="btn btn-primary nextBtn pull-right" type="button">Next</button>
            </div>
        </div>
        
        <div class="panel panel-primary setup-content" id="step-3">
            <div class="panel-heading">
                 <h3 class="panel-title">Admin Settings</h3>
            </div>
            <div class="panel-body">
                <div class="form-group">
                    <label class="control-label">Admin Username</label>
                    <input maxlength="200" type="text" required="required" class="form-control" placeholder="Enter Username" />
                </div>
                <div class="form-group">
                    <label class="control-label">Password</label>
                    <input maxlength="200" type="text" required="required" class="form-control" placeholder="Enter Password" />
                </div>
                <button class="btn btn-success pull-right" type="submit">Finish</button>
            </div>
        </div>

    </form>
</div>