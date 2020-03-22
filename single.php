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
                                    $BotAccount = $conne->selectFreeRun("SELECT user_id FROM users WHERE username='AutoReply'");
                                    $AutoReplyID = isset($BotAccount[0]["user_id"]) ? $BotAccount[0]["user_id"] : null;
                                    $getQuestion = $conne->selectWhere("questions","slug","=",$slug,"char");
                                    $q_id = $getQuestion[0]["q_id"];
                                    $q_title = $getQuestion[0]["q_title"];
                                    $q_description = $getQuestion[0]["q_description"];
                                    $q_author_id = $getQuestion[0]['q_author'];
                                    $q_date = $getQuestion[0]['q_date'];
                                    $q_tag = $getQuestion[0]['q_tags'];
                                    $q_score = $getQuestion[0]["q_like"]-$getQuestion[0]["q_dislike"];
                                    $category_id = $getQuestion[0]['category'];
                                    $is_solved = $getQuestion[0]['is_solved'];

                                    $query = "SELECT * FROM q_images WHERE q_id = '$q_id'";
                                    $q_images_rowcount = $conne->selectRowCount($query);
                                    $q_images = $conne->selectFreeRun("SELECT image_link FROM q_images WHERE q_id = '$q_id'");
                                    $i = 0;
                                    for($i = 0;$i<$q_images_rowcount;$i++){
                                        $image_link = $q_images[$i]["image_link"];
                                        $q_description = str_replace('imghere_'.$i, "/images/q_images/$image_link", $q_description);
                                    }

                                    $conne->freeRun("UPDATE questions SET q_view = q_view + 1 WHERE q_id = $q_id");
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
                                    <div class="row">
                                        <div class="col-md-9">
                                            <h1 class="post-title"><a href="#"><?php echo $q_title; ?></a></h1>
                                        </div>
                                        <?php 
                                            if($is_solved == 1){
                                                echo '<h4><span class="badge badge-success"><i class="fa fa-check"></i> Solved</span></h4>';
                                            }
                                            else if($is_solved == 0){
                                                echo '<h4><span class="badge badge-danger"><i class="fa fa-times"></i> Not Solved</span></h4>';
                                            }
                                            else if($is_solved == -1){
                                                echo '<h4><span class="badge badge-secondary"><i class="fa fa-clock-o" aria-hidden="true"></i> Not Answered</span></h4>';
                                            }
                                        ?>
                                    </div>
                                    <div class="card bg-light post">
                                        <div class="post-heading">
                                            <div class="float-left image">
                                                <img src="../<?php echo $getAuthor[0]["image_link"]?>" height="60" weight="60" class="img-circle avatar" alt="user profile image">
                                            </div>
                                            <div class="float-left meta col-sm-4">
                                                <div class="post-comment">
                                                    <a href='<?php echo "/author/".$getAuthor[0]['username'].""; ?>'>
                                                        <b><?php echo $getAuthor[0]['username']; ?></b>
                                                    </a>
                                                </div>
                                                <h6 class="time-ago">Asked on, <?php echo $q_date; ?></h6>
                                            </div>
                                            <button type="button" class="btn btn-success btn-circle btn-lg" id="btnLike"><i class="fa fa-check"></i></button>
                                            <button type="button" class="btn btn-danger btn-circle btn-lg" id="btnDislike"><i class="fa fa-times"></i></button>
                                            <button type="button" class="btn btn-dark btn-circle btn-lg" id="score"></i><span id="questionScore" class="totalScore" data-value="<?php echo $q_score; ?>"><?php echo $q_score; ?></span></button>
                                        </div>
                                        <br>
                                        <hr>  
                                        <div class="post-heading">
                                            <div class="post-description">
                                                <p><?php echo $q_description; ?></p>
                                            </div>
                                        </div>
                                    </div>
                                </article>
                            </div>
                            <?php
                                $botflag = 0;
                                $limit = 3;
                                $query = "SELECT * FROM comments WHERE c_post_id='$q_id'";
                                $rowcount = $conne->selectRowCount($query);
                                $show = $conne->selectFreeRun("SELECT * FROM comments WHERE c_post_id='$q_id' ORDER BY c_id ASC LIMIT 0, $limit");
                                foreach ($show as $key => $value) {
                                    $c_author = $value['c_author'];
                                    $c_title = isset($value['c_title']) ? $value['c_title'] : null;
                                    $c_description = $value['c_description'];
                                    $c_id = $value['c_id'];
                                    $c_score = $value["c_like"] - $value['c_dislike'];
                                    $time_ago = Functions::timeAgo($value['c_date']);
                                    $user = $conn->query("SELECT user_id, username, q_author, image_link FROM users,questions WHERE user_id='$c_author'",PDO::FETCH_ASSOC)->fetch();
                            ?>
                            <?php if($c_author == $AutoReplyID) : ?>
                                <?php $botflag = 1;?>
                                <div class="card bg-light post single-reserve">
                                <div class="post-heading">
                                <div class="alert alert-success">
                                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                                    <center><span><strong>Notice: </strong> This message was answered by AI.</span></center>
                                </div>
                                    <div class="float-left image">
                                        <img src="../<?php echo $user['image_link']?>" height="60" weight="60" class="img-circle avatar" alt="user profile image">
                                    </div>
                                    <div class="float-left meta col-sm-4">
                                        <div class="post-comment">
                                            <?php $username = $user['username']; ?>
                                            <a href='<?php echo "/author/$username"; ?>'><b><?php echo $user['username'] ?></b></a> made a post.
                                        </div>
                                        <h6 class="time-ago"><?php echo $time_ago ?></h6>
                                    </div>
                                    <?php    
                                    if(isset($_SESSION['user_UserID'])){
                                        $user_id = $_SESSION['user_UserID'];
                                        $commentStatus = $conne->selectRowCount("SELECT * FROM c_like_data WHERE c_id ='$c_id' AND user_id = '$user_id'");
                                        if($c_author == $AutoReplyID && $user_id==$q_author_id && $is_solved == -1){
                                            echo '<button type="button" class="btn btn-success btn-circle btn-xl" onclick="helpful(this)" name="'.$c_id.'">Helpful</button>';
                                            echo ' ';
                                            echo '<button type="button" class="btn btn-danger btn-circle btn-xl" onclick="not_helpful(this)" name="'.$c_id.'">Not Helpful</button>';
                                        }else if($commentStatus > 0){
                                            echo '<button type="button" class="btn btn-success btn-circle btn-lg" disabled="disabled"><i class="fa fa-check"></i></button>';
                                            echo ' ';
                                            echo '<button type="button" class="btn btn-danger btn-circle btn-lg" disabled="disabled"><i class="fa fa-times"></i></button>';
                                            echo ' ';
                                            echo '<button type="button" class="btn btn-dark btn-circle btn-lg" id="score"><i class="fa fa-star"></i></i><span id="c_score_'.$c_id.'" class="totalScore" data-value="'.$c_score.'">'.$c_score.'</span></button>';
                                        }else {
                                            echo '<button type="button"class="btn btn-success btn-circle btn-lg" onclick="likeComment(this)" name="'.$c_id.'" id="c_btnLike_'.$c_id.'"><i class="fa fa-check"></i></button>';
                                            echo ' ';
                                            echo '<button type="button" class="btn btn-danger btn-circle btn-lg" onclick="dislikeComment(this)" name="'.$c_id.'" id="c_btndislike_'.$c_id.'"><i class="fa fa-times"></i></button>';
                                            echo ' ';
                                            echo '<button type="button" class="btn btn-dark btn-circle btn-lg" id="c_score" ><i class="fa fa-star"></i><span id="c_score_'.$c_id.'" class="totalScore" data-value="'.$c_score.'">'.$c_score.'</span></button>';
                                        }
                                    }else{
                                        $commentStatus = 1;
                                    }
                                    ?>
                                </div>
                                <br>
                                <hr>  
                                <div class="post-heading">
                                    <div class="post-description">
                                        <p>
                                        <?php echo $c_description; ?>
                                        </p>
                                    </div>
                                </div>
                            </div>
                            <?php endif; ?>
                            <?php 
                            if($botflag == 1){
                                if($value['c_author'] == $AutoReplyID)
                                    continue;
                            }
                            ?>
                            <div class="card bg-light post single-reserve">
                                <div class="post-heading">
                                    <div class="float-left image">
                                        <img src="../<?php echo $user['image_link']?>" height="60" weight="60" class="img-circle avatar" alt="user profile image">
                                    </div>
                                    <div class="float-left meta col-sm-4">
                                        <div class="post-comment">
                                            <?php $username = $user['username']; ?>
                                            <a href='<?php echo "/author/$username"; ?>'><b><?php echo $user['username'] ?></b></a> made a post.
                                        </div>
                                        <h6 class="time-ago"><?php echo $time_ago ?></h6>
                                    </div>
                                        <?php    
                                        if(isset($_SESSION['user_UserID'])){
                                            $user_id = $_SESSION['user_UserID'];
                                            $commentStatus = $conne->selectRowCount("SELECT * FROM c_like_data WHERE c_id ='$c_id' AND user_id = '$user_id'");
                                            if($commentStatus > 0){
                                                echo '<button type="button" class="btn btn-success btn-circle btn-lg" disabled="disabled"><i class="fa fa-check"></i></button>';
                                                echo ' ';
                                                echo '<button type="button" class="btn btn-danger btn-circle btn-lg" disabled="disabled"><i class="fa fa-times"></i></button>';
                                                echo ' ';
                                                echo '<button type="button" class="btn btn-dark btn-circle btn-lg" id="score"><i class="fa fa-star"></i></i><span id="c_score_'.$c_id.'" class="totalScore" data-value="'.$c_score.'">'.$c_score.'</span></button>';
                                            }else{
                                                echo '<button type="button"class="btn btn-success btn-circle btn-lg" onclick="likeComment(this)" name="'.$c_id.'" id="c_btnLike_'.$c_id.'"><i class="fa fa-check"></i></button>';
                                                echo ' ';
                                                echo '<button type="button" class="btn btn-danger btn-circle btn-lg" onclick="dislikeComment(this)" name="'.$c_id.'" id="c_btndislike_'.$c_id.'"><i class="fa fa-times"></i></button>';
                                                echo ' ';
                                                echo '<button type="button" class="btn btn-dark btn-circle btn-lg" id="c_score" ><i class="fa fa-star"></i><span id="c_score_'.$c_id.'" class="totalScore" data-value="'.$c_score.'">'.$c_score.'</span></button>';
                                            }
                                        }else{
                                            $commentStatus = 1;
                                        }
                                        ?>
                                </div>
                                <br>
                                <hr>  
                                <div class="post-heading">
                                    <div class="post-description">
                                        <p>
                                        <?php echo $c_description; ?>
                                        </p>
                                    </div>
                                </div>
                            </div>
                            <br>
                            <?php }
                                if( count($show) >= $limit) {
                            ?>
                            <button type="button"  onclick="loadmore()" id="postAnswerText" class="btn btn-single"><i class="fa fa-arrow-down fa-1x" ></i>  Show More Comments</button> 
                            <br><br>
                            <?php } ?>
                            <?php if(isset($_SESSION["user_UserID"]) && $_SESSION["user_isAdmin"] == 1) : ?>
                            <div class="card">
                                <div class="card-header">
                                    Your Answer
                                </div>
                                <div class="card-body">
                                    <textarea name="editor"></textarea>
                                    <button type="submit" class="btn btn-postAnswer" id="answerSubmit" onclick="submitAnswer(<?php echo $user_id?>,<?php echo $q_id?>)">
                                        Post Answer
                                    </button>
                                </div>
                            </div>
                        <?php endif; ?>
                        </section>
                    </div>
                </div>
                <?php include "sidebar.php";?>
            </div>
            <script>
            // Question Like
            $( document ).ready(function() {
                CKEDITOR.replace('editor');
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
                        if(response == -1){
                            return;
                        }
                        else{
                            var jLikes = $('#questionScore');
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
                        if(response == -1){
                            return;
                        }
                        else{
                            var jLikes = $('#questionScore');
                            var sLikes = jLikes.text();
                            var nLikes = parseInt(sLikes);
                            jLikes.text(" "+(nLikes-1));
                            $("#btnLike").attr("disabled", true);
                            $("#btnDislike").attr("disabled", true);
                        }
                    }
                });
            });

            // Comment Like
            function likeComment(element){
                var c_id = $(element).attr("name");
                var action = "c_like";
                $.ajax({
                    url:"/action.php",
                    method:"POST",
                    data: {c_id:c_id, action:action},
                    success:function(response){
                        if(response == -1){
                            return;
                        }
                        else{
                            var jLikes = $('#c_score_'+c_id);
                            var sLikes = jLikes.text();
                            var nLikes = parseInt(sLikes);
                            jLikes.text(" "+(nLikes+1));
                            $("#c_btnLike_"+c_id).attr("disabled", true);
                            $("#c_btnDislike_"+c_id).attr("disabled", true);
                        }
                    }
                });
            }

            function dislikeComment(element){
                var c_id = $(element).attr("name");
                var action = "c_dislike";
                $.ajax({
                    url:"/action.php",
                    method:"POST",
                    data: {c_id:c_id, action:action},
                    success:function(response){
                        if(response == -1){
                            return;
                        }
                        else{
                            var jLikes = $('#c_score_'+c_id);
                            var sLikes = jLikes.text();
                            var nLikes = parseInt(sLikes);
                            jLikes.text(" "+(nLikes-1));
                            $("#c_btnLike_"+c_id).attr("disabled", true);
                            $("#c_btnDislike_"+c_id).attr("disabled", true);
                        }
                    }
                });
            }

            function helpful(element){
                var q_id = <?php echo $q_id; ?> ;
                var action = "helpful";
                $.ajax({
                    url: "/action.php",
                    method: "POST",
                    data: {action:action,q_id:q_id},
                    success:function(response){
                        if(response == -1){
                            return;
                        }
                        else{
                            alert("Thanks for your feedback!");
                        }
                    }
                })
            }

            function not_helpful(element){
                var q_id = <?php echo $q_id; ?> ;
                var action = "not_helpful";
                $.ajax({
                    url: "/action.php",
                    method: "POST",
                    data: {action:action,q_id:q_id},
                    success:function(response){
                        if(response == -1){
                            return;
                        }
                        else{
                            alert("Thanks for your feedback! Our experts will inform you about your problem as soon as possible.");
                        }
                    }
                })
            }
            var starting_limit = 3;
            function loadmore(){
                var q_id = <?php echo $q_id; ?> ;
                var user_id = <?php echo $user_id ?> ;
                var action = "loadmore";
                $.ajax({
                    url: "/action.php",
                    method: "POST",
                    data: {action:action,q_id:q_id,starting_limit: starting_limit,user_id:user_id},
                    success:function(response){
                        if(response == -1){
                            return;
                        }
                        else{
                            starting_limit = starting_limit + 3;
                            $(response).insertBefore( $("#postAnswerText") );
                            if(starting_limit >= <?php echo $rowcount ?>){
                                $("#postAnswerText").remove();
                            }
                        }
                    }
                });
            }
            </script>
        </div>
    </div>
    <?php include "footer.php";?>