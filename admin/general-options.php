<?php include_once("header.php");
$siteSettings = $conne->selectAll("site_settings");
?>
<body>
    <div class="container-fluid">
        <form method="post">
            <div class="input-group mb-3">
                <div class="input-group-prepend">
                    <span class="input-group-text" id="inputGroup-sizing-default">Site title</span>
                </div>
                <input type="text" class="form-control" placeholder="<?php echo $siteSettings[0]['site_title'];?>"  aria-label="Default" aria-describedby="inputGroup-sizing-default" name="SiteTitle">
            </div>
            <div class="input-group mb-3">
                <div class="input-group-prepend">
                    <span class="input-group-text" id="inputGroup-sizing-default" >Slogan</span>
                </div>
                <input type="text" class="form-control" placeholder="<?php echo $siteSettings[0]['slogan'];?>" aria-label="Default" aria-describedby="inputGroup-sizing-default" name="Slogan">
            </div>
            <div class="input-group mb-3">
                <div class="input-group-prepend">
                    <span class="input-group-text" id="inputGroup-sizing-default" >System address (URL)</span>
                </div>
                <input type="text" class="form-control" placeholder="<?php echo $siteSettings[0]['system_address'];?>" aria-label="Default" aria-describedby="inputGroup-sizing-default" name="SystemAdress">
            </div>
            <div class="input-group mb-3">
                <div class="input-group-prepend">
                    <span class="input-group-text" id="inputGroup-sizing-default" >Site address (URL)</span>
                </div>
                <input type="text" class="form-control" placeholder="<?php echo $siteSettings[0]['site_address'];?>" aria-label="Default" aria-describedby="inputGroup-sizing-default" name="SiteAddress">
            </div>
            <div class="input-group mb-3">
                <div class="input-group-prepend">
                    <span class="input-group-text" id="inputGroup-sizing-default" >E-mail address</span>
                </div>
                <input type="email" class="form-control" placeholder="<?php echo $siteSettings[0]['mail_address'];?>" aria-label="Default" aria-describedby="inputGroup-sizing-default" name="EmailAddress">
            </div>
            <button type="submit" name="submit" class="btn btn-success">Send</button>
        </form>
    </div>
</body>


<?php
if (isset($_REQUEST['submit'])) {
    $SiteTitle = $_POST['SiteTitle'];
    $Slogan = $_POST['Slogan'];
    $SystemAdress = $_POST['SystemAdress'];
    $SiteAddress = $_POST['SiteAddress'];
    $EmailAddress = $_POST['EmailAddress'];
    $conne->freeRun("TRUNCATE TABLE site_settings");
    $sql = "INSERT INTO site_settings(slogan, system_address, site_address, mail_address, site_title) VALUES
            ('$Slogan','$SystemAdress','$SiteAddress','$EmailAddress', '$SiteTitle')";
    $conne->freeRun($sql);
    
    echo "<meta http-equiv='refresh' content='0'>";

}

?>