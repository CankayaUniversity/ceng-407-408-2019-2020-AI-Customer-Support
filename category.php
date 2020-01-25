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
                                    $q_date = $r['q_date'];
                                    $q_tag = $r['q_tags'];
                                    $q_like = $r['q_like'];
                                    $origin_q_date = $r['q_date'];
                                    $newDate = date("d m Y", strtotime($origin_q_date));
                                    $user = $conn->query("SELECT user_id, username, q_author FROM users,questions WHERE user_id='$q_author_id'",PDO::FETCH_ASSOC)->fetch();
                                    $user_id = $user['user_id'];
                                ?>
                                <ul class="articles">
                                    <li class="article-entry">
                                        <h4> <a href='<?php echo "single.php?post=$q_id"; ?>' class="d-block text-gray-dark"><?php echo $q_title; ?></a></h4>
                                        <span class="article-meta"><?php echo $newDate; ?> <a href='<?php echo "userpage.php?post=$user_id"; ?>'><?php echo $user['username']; ?></a></span>
                                        <span class="like-count"><?php echo $q_like; ?></span>
                                    </li>
                                </ul>
                                <?php endwhile; ?>
                        </section>
                    </div>
                </div>
                <?php include "sidebar.php";?>
            </div>
        </div>
    </div>
    <?php include "footer.php";?>