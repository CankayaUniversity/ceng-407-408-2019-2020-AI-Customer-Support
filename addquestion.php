<?php 
include 'header.php';

$conne = new Mysql();
$conn = $conne->dbConnect();

if($sUsername == null){
    echo"<script>
    window.location.replace('index.php')
    </script>";
}
/* ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL); */
?>

<body>

<div class="search-area-wrapper">
    <div class="search-area container">
        <h3 class="search-header">Have a Question?</h3>
        <p class="search-tag-line">If you have any question you can ask below or enter what you are looking!</p>
        <form id="search-form" class="search-form clearfix" method="get" action="#" autocomplete="off">
            <div class="input-group">
                <input type="text" class="form-control" placeholder="Search this blog">
                <div class="input-group-append">
                    <button class="btn btn-secondary" type="button">
                        <i class="fa fa-search"></i>
                    </button>
                </div>
            </div>
            <div id="search-error-container">
            </div>
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
                                    <?php
                                    $popular = "SELECT cat_id, cat_name FROM categories ";
                                    $r = $conn->prepare($popular);
                                    $r->execute(); ?>
                                    <select name="QuestionCategory" id="QuestionCategory">
                                    <?php while($res = $r->fetch(PDO::FETCH_ASSOC)) : ?>
                                    <option value="<?php echo $res['cat_id']; ?>"><?php echo $res['cat_name']; ?></option>
                                    <?php endwhile; ?>
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

$qTitle = isset($_POST['QuestionTitle']);
$qDescription = isset($_POST['QuestionDesc']);
$qAuthor = $_SESSION["user_UserID"];

if (isset($_POST['QuestionSubmit']) && $qTitle != '' && $qDescription != ''){ 
    $qTitle = addslashes($_POST['QuestionTitle']);
    $qDescription = addslashes($_POST['QuestionDesc']);
    $qAuthor = $_SESSION["user_UserID"];
    $qTags = $_POST['QuestionTags'];
    $qTags = str_replace('-', ',', strtolower($qTags));
    $qCategory = addslashes($_POST['QuestionCategory']);
    $conn->exec("INSERT INTO questions(q_title,q_description,q_tags,title_meta,description_meta, keywords_meta, slug, q_author,category) VALUES ('$qTitle','$qDescription','$qTags','test','test','test','test','$qAuthor', '$qCategory');");

    $sql = $conn->query("SELECT q_id FROM questions WHERE q_author = '$qAuthor' ORDER BY q_date DESC LIMIT 1",PDO::FETCH_ASSOC)->fetch();
    $Qid = $sql['q_id'];
    $sql = $conn->query("SELECT user_id FROM users WHERE is_admin = 1 LIMIT 1",PDO::FETCH_ASSOC)->fetch();
    $adminID = $sql['user_id'];
    
    $sql="INSERT INTO notifications (n_description,n_author,n_post_id, n_notified_id) VALUES
    ('$qTitle', '$qAuthor',$Qid, $adminID);";
    $conn->exec($sql);
    ?>
    <script>window.location.replace("index.php");</script>
    <?php   
}
?>