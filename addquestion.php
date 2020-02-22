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
        <p class="search-tag-line">If you have any question you can ask below or enter what you are looking!</p>
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
            <form action="addquestion.php" method="post" name="QuestionForm" id="QuestionForm" novalidate>
                <div class="span8 page-content">
                    <div class="row separator">
                        <section class="span8 articles-list">
                            <div class="my-3 p-3 rounded box-shadow">
                                <div class="title">
                                    <h3>Add a new question!</h3>
                                    <div class="form-group">
                                        <label for="QuestionTitle">Question Title</label>
                                        <input type="text" class="form-control" id="QuestionTitle" name="QuestionTitle" placeholder="What is your question about?">
                                    </div>
                                </div>
                                <div id="editparent">
                                    <div id="editControls">
                                        <div class="btn-group">
                                            <a class="btn btn-xs btn-default" data-role="undo" href="#" title="Undo"><i class="fa fa-undo"></i></a>
                                            <a class="btn btn-xs btn-default" data-role="redo" href="#" title="Redo"><i class="fa fa-repeat"></i></a>
                                        </div>
                                        <div class="btn-group">
                                            <a class="btn btn-xs btn-default" data-role="bold" href="#" title="Bold"><i class="fa fa-bold"></i></a>
                                            <a class="btn btn-xs btn-default" data-role="italic" href="#" title="Italic"><i class="fa fa-italic"></i></a>
                                            <a class="btn btn-xs btn-default" data-role="underline" href="#" title="Underline"><i class="fa fa-underline"></i></a>
                                            <a class="btn btn-xs btn-default" data-role="strikeThrough" href="#" title="Strikethrough"><i class="fa fa-strikethrough"></i></a>
                                        </div>
                                        <div class="btn-group">
                                            <a class="btn btn-xs btn-default" data-role="indent" href="#" title="Blockquote"><i class="fa fa-indent"></i></a>
                                            <a class="btn btn-xs btn-default" data-role="insertUnorderedList" href="#" title="Unordered List"><i class="fa fa-list-ul"></i></a>
                                            <a class="btn btn-xs btn-default" data-role="insertOrderedList" href="#" title="Ordered List"><i class="fa fa-list-ol"></i></a>
                                        </div>
                                        <div class="btn-group">
                                            <a class="btn btn-xs btn-default" data-role="h1" href="#" title="Heading 1"><i class="fa fa-header"></i><sup>1</sup></a>
                                            <a class="btn btn-xs btn-default" data-role="h2" href="#" title="Heading 2"><i class="fa fa-header"></i><sup>2</sup></a>
                                            <a class="btn btn-xs btn-default" data-role="h3" href="#" title="Heading 3"><i class="fa fa-header"></i><sup>3</sup></a>
                                            <a class="btn btn-xs btn-default" data-role="p" href="#" title="Paragraph"><i class="fa fa-paragraph"></i></a>
                                        </div>
                                    </div>
                                    <div id="editor" contenteditable>
                                    </div>
                                    <textarea name="QuestionDesc" id="QuestionDesc" required="required" style="display:none;"></textarea><br>
                                    <div class="form-group">
                                        <label for="QuestionTags">Question Tags</label>
                                        <input type="text" class="form-control" id="QuestionTags" name="QuestionTags" placeholder="Please enter tags">
                                    </div>
                                    <div class="form-group">
                                    <select name="QuestionCategory" id="QuestionCategory">
                                    <?php foreach ($conne->selectAll('categories') as $key) { ?>
                                    <option value="<?php echo $key['cat_id']; ?>"><?php echo $key['cat_name']; ?></option>
                                    <?php } ?>
                                    </select>
                                    </div>
                                    <button type="submit" class="btn btn-primary" name="QuestionSubmit" id="QuestionSubmit">Submit</button>
                                </div>
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
$("#QuestionSubmit").click(function() {
  $("#QuestionDesc").val($("#editor").html());
});
</script>

<?php

$qAuthor = $_SESSION["user_UserID"];

if  (
    isset($_POST['QuestionSubmit']) &&
    isset($_POST['QuestionTitle']) &&
    $_POST['QuestionTitle'] != '' &&
    $_POST['QuestionDesc'] != '' &&
    isset($_POST['QuestionDesc'])
    ) 
{ 
    $qTitle = htmlspecialchars(addslashes($_POST['QuestionTitle']));
    $qDescription = addslashes($_POST['QuestionDesc']);
    $qAuthor = $_SESSION["user_UserID"];
    $qTags = $_POST['QuestionTags'];
    $qTags = str_replace('-', ',', strtolower($qTags));
    $qCategory = addslashes($_POST['QuestionCategory']);
    $qMetaTitle = $qTitle;
    $qMetaTitle .= " | Atakde.Site";
    $qMetaDesc = $qDescription;
    $slug = helperDev::SEOFriendlyURL($qTitle);
    $qMetaKey = $qTags;
    $conne->freeRun("INSERT INTO questions(q_title,q_description,q_tags,title_meta,description_meta, keywords_meta, slug, q_author,category) VALUES ('$qTitle','$qDescription','$qTags','$qMetaTitle','$qMetaDesc','$qMetaKey','$slug','$qAuthor', '$qCategory');");

    $sql = $conn->prepare("SELECT q_id FROM questions 
        WHERE q_author = '$qAuthor' 
        ORDER BY q_date 
        DESC LIMIT 1");
    $sql = $sql->execute();
    if(!$sql) die("Sıkıntı var! -1");
    $Qid = $sql['q_id'];
    
    $query = $conn->prepare("SELECT user_id FROM users 
        WHERE is_admin = 1 
        LIMIT 1");
    $query = $query->execute();
    if(!$query) die("Sıkıntı var! -2");
    $adminID = $query['user_id'];
    $sql1=prepare("INSERT INTO notifications (n_description,n_author,n_post_id, n_notified_id) VALUES
    ('A new question created: ".$qTitle."', '".$qAuthor."',".$Qid.", ".$adminID.");");
    $sql1 = $sql1->execute();
    ?>
    <script>window.location.replace("index.php");</script>
    <?php   
}
?>