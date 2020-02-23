<?php
include "header.php";
?>
<body>
    <div class="container">
        <form method="post">
            <div class="input-group mb-3">
                <div class="input-group-prepend">
                    <span class="input-group-text" id="inputGroup-sizing-default" name="SiteTitle">Site title</span>
                </div>
                <input type="text" class="form-control" aria-label="Default" aria-describedby="inputGroup-sizing-default">
            </div>
            <div class="input-group mb-3">
                <div class="input-group-prepend">
                    <span class="input-group-text" id="inputGroup-sizing-default" >Slogan</span>
                </div>
                <input type="text" class="form-control" aria-label="Default" aria-describedby="inputGroup-sizing-default" name="Slogan">
            </div>
            <div class="input-group mb-3">
                <div class="input-group-prepend">
                    <span class="input-group-text" id="inputGroup-sizing-default" >System address (URL)</span>
                </div>
                <input type="text" class="form-control" aria-label="Default" aria-describedby="inputGroup-sizing-default" name="SystemAdress">
            </div>
            <div class="input-group mb-3">
                <div class="input-group-prepend">
                    <span class="input-group-text" id="inputGroup-sizing-default" >Site address (URL)</span>
                </div>
                <input type="text" class="form-control" aria-label="Default" aria-describedby="inputGroup-sizing-default" name="SiteAddress">
            </div>
            <div class="input-group mb-3">
                <div class="input-group-prepend">
                    <span class="input-group-text" id="inputGroup-sizing-default" >E-mail address</span>
                </div>
                <input type="text" class="form-control" aria-label="Default" aria-describedby="inputGroup-sizing-default" name="EmailAddress">
            </div>
            <button type="submit" class="btn btn-outline-primary">Send</button>
        </form>
    </div>
</body>


<?php
    if(isset($_POST['Slogan'])){
        $Slogan = $_POST['Slogan'];
        $SystemAdress = $_POST['SystemAdress'];
        $SiteAddress = $_POST['SiteAddress'];
        $EmailAddress = $_POST['EmailAddress'];
        $conne->freeRun("TRUNCATE TABLE site_settings");
        $sql= "INSERT INTO site_settings(slogan, system_address, site_address, mail_address) VALUES
            ('$Slogan','$SystemAdress','$SiteAddress','$EmailAddress')";
        $conne->freeRun($sql);
    }

?>