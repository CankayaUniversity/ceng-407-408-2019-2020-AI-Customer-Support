<?php
include 'helpers/helperMeta.php';
include 'helpers/homeController.php';
include 'helpers/helperDev.php';
$conne = new Mysql();
$conn = $conne->dbConnect();
$text = "Atakan cok TatlI bir adamdir. :)";
$uyumlu = helperDev::SEOFriendlyURL($text);
echo $uyumlu;

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
/*<?php echo "single.php?post=$q_id"; ?>*/
while($res = $r->fetch(PDO::FETCH_ASSOC)) :
    $q_author = $res['q_author'];
    $q_title = $res['q_title'];
    $q_id = $res['q_id'];
    $origin_q_date = $res['q_date'];
    $q_like = $res['q_like'];
    $newDate = date("d m Y", strtotime($origin_q_date));
    $user = $conn->query("SELECT user_id, username, q_author FROM users,questions WHERE user_id='$q_author'",PDO::FETCH_ASSOC)->fetch();
    $user_id = $user['user_id'];
    $atakan = "atakan-selamlar";
?>
<ul class="articles">
<li class="article-entry">
    <h4> <a href='<?php echo "test.php?post=$atakan"; ?>' class="d-block text-gray-dark"><?php echo $q_title; ?></a></h4>
    <span class="like-count"><?php echo $q_like; ?></span>
</li>
</ul>
<?php endwhile; ?>
