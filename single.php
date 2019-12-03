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

                                            <h1 class="post-title"><a href="#"><?php echo $q_title; ?></a></h1>
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
                <strong>Tags:&nbsp;&nbsp;</strong><a href="#" rel="tag">basic</a>, <a href="#" rel="tag">setting</a>, <a href="http://knowledgebase.inspirythemes.com/tag/website/" rel="tag">website</a>
        </span>

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