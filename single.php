<?php include "header.php";?>
<body>
    <div class="page-container">
        <div class="container">
            <div class="row">
                <div class="span8 page-content">
                    <div class="row separator">
                        <section class="span8 articles-list">
                            <div class="span8 page-content">
                                <?php
                                    if (isset($_GET['post'])) {
                                        $slug = $_GET['post'];
                                    }
                                    
                                    $getQuestion = $conne->selectWhere("questions","slug","=",$slug,"char");
                                    $q_id = $getQuestion[0]["q_id"];
                                    $q_title = $getQuestion[0]["q_title"];
                                    $q_description = $getQuestion[0]["q_description"];
                                    $q_author_id = $getQuestion[0]['q_author'];
                                    $q_date = $getQuestion[0]['q_date'];
                                    $q_tag = $getQuestion[0]['q_tags'];
                                    $q_score = $getQuestion[0]["q_like"]-$r["q_dislike"];
                                    $category_id = $getQuestion[0]['category'];

                                    $getAuthor = $conne->selectWhere("users","user_id","=",$q_author_id,"int");

                                    $getCategoryName = $conne->selectWhere("categories","cat_id","=",$category_id,"int");
                                    if(isset($_SESSION['user_UserID'])){
                                        $user_id = $_SESSION['user_UserID'];
                                        $myQuery="SELECT * FROM like_data WHERE user_id = '$user_id' AND q_id ='$q_id'";
                                        $checkLikeData = $conne->selectRowCount($myQuery);
                                    }else{
                                        $checkLikeData = 1;
                                    }
                                    
                                ?>
                                <ul class="breadcrumb">
                                    <li><a href="#"><?php echo $getCategoryName[0]['cat_name'] ?></a><span class="divider">/</span></li>
                                    <li class="active">
                                        <?php echo $q_title; ?>
                                    </li>
                                </ul>
                                <article class=" type-post format-standard hentry clearfix">
                                    <h1 class="post-title"><a href="#"><?php echo $q_title; ?></a></h1>
                                    <div class="card bg-light post">
                                        <div class="post-heading row">
                                            <div class="float-left image col-sm-1">
                                                <img src="<?php echo $getAuthor[0]["image_link"]?>" height="60" weight="60" class="img-circle avatar" alt="user profile image">
                                            </div>
                                            <div class="float-left meta col-sm-4">
                                                <div class="post-comment">
                                                    <a href='<?php echo "/author/$username"; ?>'>
                                                        <b><?php echo $getAuthor[0]["username"]; ?></b></a>
                                                </div>
                                                <h6 class="time-ago">Asked on, <?php echo $q_date; ?></h6>
                                            </div>
                                            <div class="col-sm-5">
                                                <button type="button" class="btn btn-success " id="btnLike" ><i class="fa fa-check"></i></button>
                                                <button type="button" class="btn btn-danger " id="btnDislike" ><i class="fa fa-times"></i></button>
                                                <button type="button" class="btn btn-dark " id="score" ><i class="fa fa-star"></i><?php echo $q_score; ?></button>
                                            </div>
                                        </div>
                                        <hr>  
                                        <div class="post-heading">
                                            <div class="post-description">
                                            <p>
                                            <?php echo $q_description; ?>
                                            </p>
                                        </div></div>
                                    </div>
                                </article>
                                <div class="like-btn">
                                    <form id="like-it-form" action="#" method="post">
                                        <input type="hidden" name="post_id" value="99">
                                        <input type="hidden" name="action" value="like_it">
                                    </form>
                                </div>
                            </div>
                            <?php
                                $limit = 100; // Şuan açık değil.
                                $query = "SELECT * FROM comments WHERE c_post_id='$q_id'";
                                $total_results = $conne->selectRowCount($query);
                                $total_pages = ceil($total_results/$limit);
                                if (!isset($_GET['page'])) {
                                    $page = 1;
                                } else{
                                    $page = $_GET['page'];
                                }
                                $starting_limit = ($page-1)*$limit;
                                $show = "SELECT * FROM comments WHERE c_post_id='$q_id' ORDER BY c_id DESC LIMIT $starting_limit, $limit";
                                $r = $conn->prepare($show);
                                $r->execute();
                            ?>
                            <?php 
                            while($res = $r->fetch(PDO::FETCH_ASSOC)) :
                                $c_author = $res['c_author'];
                                $c_title = isset($res['c_title']);
                                $c_description = $res['c_description'];
                                $c_id = $res['c_id'];
                                $time_ago = helperDev::timeAgo($res['c_date']);
                                $user = $conn->query("SELECT user_id, username, q_author FROM users,questions WHERE user_id='$c_author'",PDO::FETCH_ASSOC)->fetch();
                            ?>
                            <div class="card bg-light post single-reserve">
                                <div class="post-heading">
                                    <div class="float-left image">
                                    <img src="../images/mascot.png" height="60" weight="60" class="img-circle avatar" alt="user profile image">
                                    </div>
                                    <div class="float-left meta">
                                        <div class="post-comment">
                                            <?php $username = $user['username']; ?>
                                            <a href='<?php echo "/author/$username"; ?>'><b><?php echo $user['username'] ?></b></a> made a post.
                                        </div>
                                        <h6 class="time-ago"><?php echo $time_ago ?></h6>
                                    </div>
                                </div>
                                <div class="post-description">
                                    <p><?php echo $c_description; ?></p>
                                </div>
                            </div>                 
                            <?php endwhile; ?>
                            <?php for ($page=1; $page <= $total_pages ; $page++):?>
                            <a href='<?php echo "?page=$page"; ?>' class="links"><?php echo $page; ?></a>
                            <?php endfor; ?>
                            <div class="card">
                                <div class="card-header">
                                    Your Answer
                                </div>
                                <div class="card-body">
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
                                    <form>
                                        <textarea name="AnswerDesc" id="AnswerDesc" required="required" style="display:none;"></textarea><br>
                                        <button type="submit" class="btn btn-warning" name="AnswerSubmit" id="AnswerSubmit">Post Answer</button>
                                    </form>
                                </div>
                            </div>
                        </section>
                    </div>
                </div>
                <?php include "sidebar.php";?>
            </div>
            <script>
            $( document ).ready(function() {
                var checkLikeData = <?php echo $checkLikeData; ?>;
                if(checkLikeData > 0) {
                    $("#btnLike").attr("disabled", true);
                    $("#btnDislike").attr("disabled", true);
                }
            });
            $( "#btnLike" ).click(function() {
                var q_id = <?php echo $q_id; ?> ;
                var action = "like";
                $.ajax({
                    url:"/action.php",
                    method:"POST",
                    data: {q_id:q_id, action:action},
                    success:function(response){
                        if(response === "You must be logged in to vote." || response === "This cannot be done! You can only vote one question once!"){
                            alert(response);
                        }
                        else{
                            var jLikes = $('#score');
                            var sLikes = jLikes.text();
                            var nLikes = parseInt(sLikes);
                            jLikes.text(" "+(nLikes+1));
                            $("#btnLike").attr("disabled", true);
                            $("#btnDislike").attr("disabled", true);
                        }
                    }
                });
            });
            $( "#btnDislike" ).click(function() {
                var q_id = <?php echo $q_id; ?> ;
                var action = "dislike";
                $.ajax({
                    url:"/action.php",
                    method:"POST",
                    data: {q_id:q_id, action:action},
                    success:function(response){
                        if(response === "You must be logged in to vote." || response === "This cannot be done! You can only vote one question once!"){
                            alert(response);
                        }
                        else{
                            var jLikes = $('#score');
                            var sLikes = jLikes.text();
                            var nLikes = parseInt(sLikes);
                            jLikes.text(" "+(nLikes-1));
                            $("#btnLike").attr("disabled", true);
                            $("#btnDislike").attr("disabled", true);
                        }
                    }
                });
            });
            </script>
        </div>
    </div>
    <?php include "footer.php";?>