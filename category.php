<?php include "header.php";?>
<body>

    <div class="page-container">
        <div class="container">
            <div class="row">
                <div class="span8 page-content">
                    <div class="row separator">
                        <section class="span8 articles-list">
                            <h3>All Questions</h3>
                            <?php
                                if (isset($_GET['category'])) {
                                    $category_slug = $_GET['category'];
                                    $findCategoryId = $conn->query("SELECT cat_id FROM categories WHERE cat_slug = '$category_slug'", PDO::FETCH_ASSOC)->fetch();
                                    $category_id = $findCategoryId['cat_id'];
                                }
                                $query = $conn->query("SELECT * FROM questions WHERE category='$category_id'",PDO::FETCH_ASSOC);
                                $query->setFetchMode(PDO::FETCH_ASSOC);
                                while($r=$query->fetch()) :
                                    $q_id = $r["q_id"];
                                    $q_title = $r["q_title"];
                                    $q_description = $r["q_description"];
                                    $q_author_id = $r['q_author'];
                                    $q_tag = $r['q_tags'];
                                    $q_like = $r['q_like'];
                                    $q_dislike = $r['q_dislike'];
                                    $q_view = $r["q_view"];
                                    $origin_q_date = $r['q_date'];
                                    $q_slug = $r['slug'];
                                    $commentCount = $conne->selectRowCount("SELECT * FROM comments WHERE c_post_id = $q_id");
                                    $newDate = date("d m Y", strtotime($origin_q_date));
                                    $user = $conn->query("SELECT user_id, username, q_author FROM users,questions WHERE user_id='$q_author_id'",PDO::FETCH_ASSOC)->fetch();
                                    $user_id = $user['user_id'];
                                    $username = $user['username'];
                                ?>
                                <div class="forum-item">
                                    <div class="row">
                                        <div class="col-md-9">
                                            <div class="forum-icon"> <i class="fa fa-bolt"></i></div> <a href="<?php echo "/post/$q_slug"; ?>" class="forum-item-title"><?php echo $q_title; ?></a>
                                            <div class="forum-sub-title"><a href="<?php echo "/author/$username"; ?>"><?php echo $username; ?></a> posted a post.</div>
                                        </div>
                                        <div class="col-md-1 forum-info"> <span class="views-number"> <?php echo $commentCount ?> </span>
                                            <div> <small>Replies</small></div>
                                        </div>
                                        <div class="col-md-1 forum-info"> <span class="views-number"> <?php echo $q_view ?> </span>
                                            <div> <small>Views</small></div>
                                        </div>
                                        <div class="col-md-1 forum-info"> <span class="views-number"> <?php echo $q_like - $q_dislike ?> </span>
                                            <div> <small>Score</small></div>
                                        </div>
                                    </div>
                                </div>
                                <?php endwhile; ?>
                        </section>
                    </div>
                </div>
                <?php include "sidebar.php";?>
            </div>
        </div>
    </div>

    <?php include "footer.php";?>