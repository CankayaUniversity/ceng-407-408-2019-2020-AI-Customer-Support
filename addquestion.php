<?php 
include 'header.php';

if($sUsername == null){
    echo"<script>
    window.location.replace('index.php')
    </script>";
}
?>

<body>

<div class="search-area-wrapper">
    <div class="search-area container">
        <h3 class="search-header">Have a Question?</h3>
        <p class="search-tag-line">If you have any question you can search for a related article below or simply enter what you are looking for!</p>
        <form id="search-form" class="search-form clearfix" method="get" action="#" autocomplete="off">
            <div class="input-group">
                <input type="text" class="form-control" autocomplete="off" placeholder="Search this blog" 
                style="border-radius: 5px !important; height: 50px !important;">
                <div class="input-group-append">
                    <button class="btn btn-secondary" type="button">
                        <i class="fa fa-search"></i>
                    </button>
                </div>
            </div>
            <ul class="list-group liveresult"></ul>
        </form>
    </div>
</div>

<div class="page-container">
    <div class="container">
        <div class="row">
            <form action="addquestion.php" method="post" name="QuestionForm" id="QuestionForm" enctype="multipart/form-data" novalidate>
                <div class="span8 page-content">
                    <div class="row separator">
                        <section class="span8 articles-list">
                            <div class="my-3 p-3 rounded box-shadow">
                                <div class="title">
                                    <h3>Add a new question!</h3>
                                    <div class="form-group">
                                        <label for="QuestionTitle">Question Title</label>
                                        <input type="text" class="form-control" id="QuestionTitle" name="QuestionTitle" maxlength="75" placeholder="What is your question about?">
                                    </div>
                                </div>
                                 <textarea name="editor"></textarea>
                                    <br>
                                    <div class="form-group">
                                        <label for="QuestionTags">Question Tags</label>
                                        <input type="text" class="form-control" id="QuestionTags" name="QuestionTags" placeholder="Please enter tags">
                                    </div>
                                    <div class="form-group">
                                    <select name="QuestionCategory" class="form-control" id="QuestionCategory">
                                    <?php
                                    $allCategories = $conne->selectAll('categories');
                                    foreach ($allCategories as $key) { ?>
                                    <option value="<?php echo $key['cat_id']; ?>"><?php echo $key['cat_name']; ?></option>
                                    <?php } ?>
                                    </select>
                                    </div>
                                    <input type="file" name="files[]" multiple >
                                    <br>
                                    <button type="submit" class="btn btn-primary" name="QuestionSubmit" id="QuestionSubmit">Submit</button>                                    
                            </div>
                        </section>
                    </div>
                </div>
            </form>
        <?php include "sidebar.php";?>
        </div>
    </div>
</div>
<?php include "footer.php";?>

<script> 
$( document ).ready(function() {
    CKEDITOR.replace('editor'); 
});
var count = 0;

/*$("#addimage").click(function() {
    $("#editor").text($("#editor").text() + "<br><img src='imghere_" + count + "'>");
    count++;
});*/
</script>

<?php

$qAuthor = $_SESSION["user_UserID"];
$isAdmin = $_SESSION["user_isAdmin"];
if(!$isAdmin) {
    echo'<script>window.location.replace("index.php");</script>';
    die();
}

if  (
    isset($_POST['QuestionSubmit']) &&
    isset($_POST['QuestionTitle']) &&
    $_POST['QuestionTitle'] != '' &&
    $_POST['editor'] != '' &&
    isset($_POST['editor'])
    ) 
{ 
    $qTitle = htmlspecialchars(addslashes($_POST['QuestionTitle']));
    $qDescription = addslashes($_POST['editor']);
    $qAuthor = $_SESSION["user_UserID"];
    $qTags = $_POST['QuestionTags'];
    $qTags = str_replace('-', ',', strtolower($qTags));
    $qCategory = addslashes($_POST['QuestionCategory']);
    $qMetaTitle = $qTitle;
    $qMetaTitle .= " | Atakde.Site"; 
    $qMetaDesc = htmlspecialchars(strip_tags(($qDescription)));
    $slug = SEOHelper::SEOFriendlyURL($qTitle);
    $qMetaKey = $qTags;
    
    $prepareData = $conn->prepare("INSERT INTO questions(q_title,q_description,q_tags,title_meta,description_meta, keywords_meta, slug, q_author,category) VALUES (?,?,?,?,?,?,?,?,?);");
    $prepareData->execute(array($qTitle, $qDescription, $qTags, $qMetaTitle, $qMetaDesc, $qMetaKey, $slug, $qAuthor, $qCategory));
    $lastInsertedID = $conn->lastInsertId();
    
    $query = "SELECT user_id FROM users WHERE is_admin=1 LIMIT 1";
    $adminIDArray = $conne->selectFreeRun($query);
    $adminID = $adminIDArray[0]['user_id'];   
    $notificationsQuery = $conn->prepare("INSERT INTO notifications (n_description,n_author,n_post_id, n_notified_id, n_image) VALUES ('$qTitle','$qAuthor', '$lastInsertedID', '$adminID','/images/noti_icons/new_question.png')");
    $notificationsQuery = $notificationsQuery->execute();
    
    $conne->freeRun("UPDATE categories SET cat_totalquestion=cat_totalquestion+1 WHERE cat_id = '$qCategory'");

    /* Upload Photo */

    $q_id = $conne->selectFreeRun("SELECT q_id FROM questions WHERE slug='$slug'");
    $q_id = $q_id[0]["q_id"];

    $targetDir = "images/q_images/"; 
    $allowTypes = array('jpg','png','jpeg','gif'); 
    
    $statusMsg = $errorMsg = $insertValuesSQL = $errorUpload = $errorUploadType = ''; 
    $fileNames = array_filter($_FILES['files']['name']); 

    if(!empty($fileNames)){ 
        foreach($_FILES['files']['name'] as $key=>$val){ 
            $fileName = basename($_FILES['files']['name'][$key]); 
            $targetFilePath = $targetDir . $fileName; 
            
            $fileType = pathinfo($targetFilePath, PATHINFO_EXTENSION); 
            if(in_array($fileType, $allowTypes)){ 
                if(move_uploaded_file($_FILES["files"]["tmp_name"][$key], $targetFilePath)){ 
                    $insertValuesSQL .= "(".$q_id.",'".$fileName."'),"; 
                }else{ 
                    $errorUpload .= $_FILES['files']['name'][$key].' | '; 
                } 
            }else{ 
                $errorUploadType .= $_FILES['files']['name'][$key].' | '; 
            } 
        } 

        if(!empty($insertValuesSQL)){ 
            $insertValuesSQL = trim($insertValuesSQL, ','); 
            $conne->freeRun("INSERT INTO q_images (q_id, image_link) VALUES $insertValuesSQL"); 
            if($insert){ 
                $errorUpload = !empty($errorUpload)?'Upload Error: '.trim($errorUpload, ' | '):''; 
                $errorUploadType = !empty($errorUploadType)?'File Type Error: '.trim($errorUploadType, ' | '):''; 
                $errorMsg = !empty($errorUpload)?'<br/>'.$errorUpload.'<br/>'.$errorUploadType:'<br/>'.$errorUploadType; 
                $statusMsg = "Files are uploaded successfully.".$errorMsg; 
            }else{ 
                $statusMsg = "Sorry, there was an error uploading your file."; 
            } 
        } 
    }else{ 
        $statusMsg = 'Please select a file to upload.'; 
    } 

    /* Running python script*/

    $questionToAnalyse = urlencode($_POST['QuestionTitle']);

    if($_SERVER['HTTP_HOST'] == 'localhost'){
        //$url = "http://localhost:80/python/index.php?question=".$questionToAnalyse."&questionID=".$lastInsertedID."";
    } else {
        $ch = curl_init();
        $url = "http://atakde.site:80/python/index.php?question=".$questionToAnalyse."&questionID=".$lastInsertedID."";
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, false);
        curl_setopt($ch, CURLOPT_TIMEOUT, 1);
        curl_exec($ch);
        curl_close($ch);
    }
    
    ?>
    <script>window.location.replace("index.php");</script>
    <?php } ?>