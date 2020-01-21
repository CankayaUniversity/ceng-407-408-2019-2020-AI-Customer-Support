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
                                    if (isset($_GET['category'])) {
                                        $category_id = $_GET['category'];
                                    }
                                    $query = $conn->query("SELECT * FROM questions WHERE category='$category_id'",PDO::FETCH_ASSOC);
                                    $query->setFetchMode(PDO::FETCH_ASSOC);
                                    while($r=$query->fetch()){
                                        echo $q_id = $r["q_id"];
                                        echo $q_title = $r["q_title"];
                                        echo $q_description = $r["q_description"];
                                        echo $q_author_id = $r['q_author'];
                                        echo $q_date = $r['q_date'];
                                        echo $q_tag = $r['q_tags'];
                                    }
                                    $sql = $conn->query("SELECT username FROM users WHERE user_id='$q_author_id'")->fetch(); 
                                ?>
                            </div>
                        </section>
                    </div>
                </div>
                
                <?php include "sidebar.php";?>
            </div>
        </div>
    </div>
    <?php include "footer.php";?>