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
                                            $q_id = $_GET['post'];
                                        }
                                        $query = $conn->query("SELECT * FROM questions WHERE q_id='$q_id'",PDO::FETCH_ASSOC);
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
                                        <?php echo $sql["username"]; ?>
                                        <div class="post-meta clearfix">
                                            <span class="date"><?php echo $q_date; ?></span>
                                        </div>
                                        <!-- end of post meta -->
                                        <p>
                                            <?php echo $q_description; ?>
                                        </p>
                                    </article>
                                    <div class="like-btn">
                                        <form id="like-it-form" action="#" method="post">
                                            <input type="hidden" name="post_id" value="99">
                                            <input type="hidden" name="action" value="like_it">
                                        </form>
                                        <span class="tags">
                                            <strong>Tags:&nbsp;&nbsp;</strong>
                                            <?php 
                                                $tagCount = substr_count($q_tag,",")+1;
                                                $i = 0;
                                                while($q_tag[$i] != null){
                                                    if($q_tag[$i] == ','){
                                                        echo "<a href='#' rel='tag' class='btn btn-info'>".substr($q_tag,0,$i)."</a> ";
                                                        $delete = substr($q_tag,0,$i+1);
                                                        $q_tag = str_replace($delete,"",$q_tag);
                                                        $i = -1;
                                                    }
                                                    else if($i == strlen($q_tag)-1){
                                                        echo "<a href='#' rel='tag' class='btn btn-info'>".substr($q_tag,0,$i+1)."</a>";
                                                        $delete = substr($q_tag,0,$i+1);
                                                        $q_tag = str_replace($delete,"",$q_tag);
                                                        $i = -1;
                                                    }
                                                    $i++;
                                                }
                                            ?>                                            
                                        </span>
                                    </div>
                                </div>
                                <?php
                                    $limit = 100; // Şuan açık değil.
                                    $query = "SELECT * FROM comments";
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
                                    $show = "SELECT * FROM comments ORDER BY c_id DESC LIMIT $starting_limit, $limit";
                                    $r = $conn->prepare($show);
                                    $r->execute();
                                ?>
                                <?php 
                                while($res = $r->fetch(PDO::FETCH_ASSOC)) :
                                    $c_author = $res['c_author'];
                                    $c_title = $res['c_title'];
                                    $c_description = $res['c_description'];
                                    $c_id = $res['c_id'];
                                    $time_ago = timeAgo($res['c_date']);
                                    $user = $conn->query("SELECT user_id, username, q_author FROM users,questions WHERE user_id='$c_author'",PDO::FETCH_ASSOC)->fetch();
                                ?>
                                <div class="card card-white post">
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
                            </section>
                        </div>
                    </div>
                    <?php include "sidebar.php";?>
                </div>
            </div>
        </div>
        <?php include "footer.php";?>