<?php include "header.php";?>

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

                <div id="search-error-container"></div>
            </form>
        </div>
    </div>
    <div class="page-container">
        <div class="container">
            <div class="row">
                <div class="span8 page-content">
                    <div class="row separator">
                        <section class="span8 articles-list">
                        <?php
                $limit = 5;
                $query = "SELECT * FROM questions";
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
                $show = "SELECT * FROM questions ORDER BY q_id DESC LIMIT $starting_limit, $limit";
                $r = $conn->prepare($show);
                $r->execute();
            ?>
            <?php while($res = $r->fetch(PDO::FETCH_ASSOC)) :
            $q_author = $res['q_author'];
            $q_title = $res['q_title'];
            $q_id = $res['q_id'];
            $origin_q_date = $res['q_date'];
            $newDate = date("d-m-Y", strtotime($origin_q_date));
            $user = $conn->query("SELECT user_id, username, q_author FROM users,questions WHERE user_id='$q_author'",PDO::FETCH_ASSOC)->fetch();?>
                        <div class="media text-muted pt-3">
      <svg class="bd-placeholder-img mr-2 rounded" width="32" height="32" xmlns="http://www.w3.org/2000/svg" preserveAspectRatio="xMidYMid slice" focusable="false" role="img" aria-label="Placeholder: 32x32"><title>Placeholder</title><rect width="100%" height="100%" fill="#49afcd"></rect><text x="20%" y="50%" fill="white" dy=".3em">2</text></svg>
      <p class="media-body pb-3 mb-0 small lh-125 border-bottom border-gray">
      <a href='<?php echo "single.php?post=$q_id"; ?>' class="d-block text-gray-dark"><?php echo $q_title; ?></a>
        <strong class="d-block text-gray-dark">@<?php echo $user['username'] ?></strong>
        <?php echo $res['q_description'] ?>
      </p>
    </div>
    <?php endwhile; ?>

    <?php  for ($page=1; $page <= $total_pages ; $page++):?>

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