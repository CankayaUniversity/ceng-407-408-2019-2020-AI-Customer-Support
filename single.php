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
                                        $post_id = $_GET['post'];
                                    }
                                    $query = $conn->query("SELECT * FROM questions WHERE q_id='$post_id'",PDO::FETCH_ASSOC);
                                    $query->setFetchMode(PDO::FETCH_ASSOC);
                                    while($r=$query->fetch()){
                                        $q_id = $r["q_id"];
                                        $q_title = $r["q_title"];
                                        $q_description = $r["q_description"];
                                        $q_author_id = $r['q_author'];
                                        $q_date = $r['q_date'];
                                        $q_tag = $r['q_tags'];
                                    }
                                    $sql = $conn->query("SELECT username FROM users WHERE user_id='$q_author_id'")->fetch(); 
                                ?>
                                <ul class="breadcrumb">
                                    <li><a href="#">Knowledge Base Theme</a><span class="divider">/</span></li>
                                    <li><a href="#" title="View all posts in Server &amp; Database">Server &amp; Database</a> <span class="divider">/</span></li>
                                    <li class="active">
                                        <?php echo $q_title; ?>
                                    </li>
                                </ul>
                                
                                <article class=" type-post format-standard hentry clearfix">
                                    <h2 class="post-title"><a href="#"><?php echo $q_title; ?></a></h1>
                                    <div class="card bg-light post">
                                        <div class="post-heading">
                                            <div class="float-left image">
                                                <img src="images/mascot.png" height="60" weight="60" class="img-circle avatar" alt="user profile image">
                                            </div>
                                            <div class="float-left meta">
                                                <div class="title h5">
                                                <b><?php echo $sql["username"]; ?></b>
                                                </div>
                                                <h6 class="text-muted time">Asked on, <?php echo $q_date; ?></h6>
                                                    
                                            </div>     
                                        </div>
                                        <hr>  
                                        <div class="post-heading">     
                                    <p>
                                        <?php echo $q_description; ?>
                                    </p>
                                    </div>
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
                                $s = $conn->prepare($query);
                                $s->execute();
                                $total_results = $s->rowCount();
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
                            <div class="card bg-light post">
                                <div class="post-heading">
                                    <div class="float-left image">
                                    <img src="images/mascot.png" height="60" weight="60" class="img-circle avatar" alt="user profile image">
                                    </div>
                                    <div class="float-left meta">
                                        <div class="title h5">
                                            <a href="#"><b><?php echo $user['username'] ?></b></a> made a post.
                                        </div>
                                        <h6 class="text-muted time"><?php echo $time_ago ?> minute ago</h6>
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
        </div>
    </div>
    <?php include "footer.php";?>