<?php
include_once "inc/Conn.php";
include_once "helpers/Functions.php";
session_start();

$conne = new Mysql();
$conn = $conne->dbConnect();

$action = $_POST["action"];

$q_id = isset($_POST['q_id']) ? mysql_escape_string($_POST['q_id']) : null;
$c_id = isset($_POST['c_id']) ? mysql_escape_string($_POST['c_id']) : null;
$user_id = isset($_SESSION['user_UserID']) ? mysql_escape_string($_SESSION['user_UserID']) : null;
$answer = isset($_POST['answer']) ? mysql_escape_string($_POST['answer']) : null;
$q_author = isset($_POST['q_author']) ? mysql_escape_string($_POST['q_author']) : null;

if ($q_id !== null && $user_id !== null && ($action == "like" || $action == "dislike")) {
    $sql = "SELECT * FROM like_data WHERE user_id = '$user_id' AND q_id ='$q_id'";
    $ps = $conn->query($sql);
    $checkLikeData = $ps->rowCount();
}

if ($c_id !== null && $user_id !== null && ($action == "c_like" || $action == "c_dislike")) {
    $sql = "SELECT * FROM c_like_data WHERE user_id = '$user_id' AND c_id ='$c_id'";
    $ps = $conn->query($sql);
    $c_checkLikeData = $ps->rowCount();
}

// Question Like Action
if ($action == "like" && isset($checkLikeData)) {
    if ($checkLikeData === 0) {
        $sql = "UPDATE questions SET q_like=q_like+1 WHERE q_id='$q_id'";
        $gonder = $conn->prepare($sql);
        $gonder->execute();
        $values[] = array('type' => 'int', 'val' => $q_id);
        $values[] = array('type' => 'int', 'val' => $user_id);
        $values[] = array('type' => 'int', 'val' => '1');
        $conne->insertInto("like_data", $values);
    } else {
        echo -1;
    }
} else if ($action == "dislike" && isset($checkLikeData)) {
    if ($checkLikeData === 0) {
        $query = "UPDATE questions SET q_dislike=q_dislike+1 WHERE q_id=" . $q_id . "";
        $conn->exec($query);
        $values[] = array('type' => 'int', 'val' => $q_id);
        $values[] = array('type' => 'int', 'val' => $user_id);
        $values[] = array('type' => 'int', 'val' => '0');
        $conne->insertInto("like_data", $values);
    } else {
        echo -1;
    }
}

// Comment Like Action
if ($action == "c_like" && isset($c_checkLikeData)) {
    if ($c_checkLikeData === 0) {
        $sql = "UPDATE comments SET c_like=c_like+1 WHERE c_id='$c_id'";
        $gonder = $conn->prepare($sql);
        $gonder->execute();
        $values[] = array('type' => 'int', 'val' => $c_id);
        $values[] = array('type' => 'int', 'val' => $user_id);
        $values[] = array('type' => 'int', 'val' => '1');
        $conne->insertInto("c_like_data", $values);
    } else {
        echo -1;
    }
} else if ($action == "c_dislike" && isset($c_checkLikeData)) {
    if ($c_checkLikeData === 0) {
        $query = "UPDATE comments SET c_dislike=c_dislike+1 WHERE c_id=" . $c_id . "";
        $conn->exec($query);
        $values[] = array('type' => 'int', 'val' => $c_id);
        $values[] = array('type' => 'int', 'val' => $user_id);
        $values[] = array('type' => 'int', 'val' => '0');
        $conne->insertInto("c_like_data", $values);
    } else {
        echo -1;
    }
}

if ($action == "deleteUser") {
    $user_id = $_POST['user_id'];
    $query = "DELETE FROM users WHERE user_id = '$user_id'";
    $statement = $conn->prepare($query);
    $statement->execute();
    echo "Deleted User!";
}

if ($action == "deleteQuestion") {
    $q_id = $_POST['q_id'];
    $query = "DELETE FROM questions WHERE q_id = '$q_id'";
    $statement = $conn->prepare($query);
    $statement->execute();
    echo "Deleted Question!";
}

if ($action == "deleteComment") {
    $c_id = $_POST['c_id'];
    $query = "DELETE FROM comments WHERE c_id = '$c_id'";
    $statement = $conn->prepare($query);
    $statement->execute();
    echo "Deleted Comment!";
}

if ($action == "deleteCategory") {
    $cat_id = $_POST['cat_id'];
    $query = "DELETE FROM categories WHERE cat_id = '$cat_id'";
    $statement = $conn->prepare($query);
    $statement->execute();
    echo "Deleted Category!";
}

if ($action == "addCategory") {
    $cat_name = $_POST['cat_name'];
    $cat_description = $_POST['cat_description'];
    $cat_slug = str_replace(' ', '-', strtolower($cat_name));
    $cat_keywords = str_replace(' ', ',', $cat_name);
    $query = "INSERT INTO categories(cat_name,cat_description,cat_keywords,cat_slug) VALUES('$cat_name','$cat_description','$cat_keywords','$cat_slug')";
    $statement = $conn->prepare($query);
    $statement->execute();
    echo "Added Category!";
}

if ($action == "addUser") {
    $username = $_POST['username'];
    $email = $_POST['email'];
    $options = array("cost" => 4);
    $hashPassword = password_hash("123123", PASSWORD_BCRYPT, $options);
    $query = "INSERT INTO users(firstname,surname,email,username,password_,is_verified,is_admin)
    VALUES('test','test','$email','$username','$hashPassword',1,1)";
    $statement = $conn->prepare($query);
    $statement->execute();
    echo "Added Category!";
}

if ($action == "resetNoti") {
    $user_id = $_POST['user_id'];
    $sql = "UPDATE notifications SET n_isChecked=1 WHERE n_notified_id = '$user_id'";
    $conne->freeRun($sql);
}

if ($action == "answer" && $answer !== null) {
    $query = "INSERT INTO comments (c_description,c_author,c_post_id) VALUES ('$answer', $user_id, $q_id);";
    $conne->freeRun($query);
    $sql = $conne->selectFreeRun("SELECT q_author FROM questions WHERE q_id='$q_id'");
    $q_author = $sql[0]['q_author'];
    $query = "INSERT INTO notifications(n_description,n_author,n_post_id,n_notified_id,n_image) VALUES ('Your question is answered','$user_id','$q_id','$q_author','/images/noti_icons/comment.png')";
    $conne->freeRun($query);
    echo 1;
}

if ($action == "helpful") {
    $string = "";
    $admins = $conne->selectFreeRun("SELECT * FROM users WHERE is_admin = 1");
    foreach ($admins as $key => $value) {
        $id = $value["user_id"];
        $string .= " ('Reply marked as helpful.','$user_id','$q_id','$id','/images/noti_icons/helpful.png'),";
    }
    $string = rtrim($string, ',');
    $query = "INSERT INTO notifications(n_description,n_author,n_post_id,n_notified_id,n_image) VALUES " . $string;
    $conne->freeRun($query);
    $query = "UPDATE questions SET is_solved = 1 WHERE q_id = $q_id";
    $conne->freeRun($query);
}

if ($action == "not_helpful") {
    $string = "";
    $admins = $conne->selectFreeRun("SELECT * FROM users WHERE is_admin = 1");
    foreach ($admins as $key => $value) {
        $id = $value["user_id"];
        $string .= " ('Reply marked as not helpful.','$user_id','$q_id','$id','/images/noti_icons/not_helpful.png'),";
    }
    $string = rtrim($string, ',');
    $query = "INSERT INTO notifications(n_description,n_author,n_post_id,n_notified_id,n_image) VALUES " . $string;
    $conne->freeRun($query);
    $query = "UPDATE questions SET is_solved = 0 WHERE q_id = $q_id";
    $conne->freeRun($query);
}

if ($action == "loadmore") {
    $questionQuery = $conne->selectFreeRun("SELECT * FROM questions WHERE q_id = $q_id");
    $is_solved = $questionQuery[0]["is_solved"];
    $q_author_id = $questionQuery[0]["q_author_id"];
    $html = "";
    $limit = 3;
    $starting_limit = $_POST['starting_limit'];
    $query = "SELECT * FROM comments WHERE c_post_id='$q_id' ORDER BY c_id ASC LIMIT $starting_limit, $limit";
    $rowCount = $conne->selectRowCount($query);
    if ($rowCount < $limit) {
        $limit = $rowCount;
    }
    $newQ = $conne->selectFreeRun($query);
    for ($i = 0; $i < $limit; $i++) {
        $c_author = $newQ[$i]["c_author"];
        $c_id = $newQ[$i]["c_id"];
        $c_score = $newQ[$i]["c_like"] - $newQ[$i]["c_dislike"];
        $commentStatus = $conne->selectRowCount("SELECT * FROM c_like_data WHERE c_id ='$c_id' AND user_id = '$user_id'");
        if($c_author == 12 && $user_id==$q_author_id && $is_solved == -1){
            $commentButtons = 
            '<div>'
            .'<button type="button" class="btn btn-success" onclick="helpful(this)" name="'.$c_id.'">Helpful<i class="fa fa-check"></i></button>'
            .'<button type="button" class="btn btn-danger" onclick="not_helpful(this)" name="'.$c_id.'">Not Helpful<i class="fa fa-times"></i></button>'
            ."</div>";
        }else if($commentStatus > 0){
            $commentButtons = 
            '<button type="button" class="btn btn-success btn-circle btn-lg" disabled="disabled"><i class="fa fa-check"></i></button>'
            .' '
            .'<button type="button" class="btn btn-danger btn-circle btn-lg" disabled="disabled"><i class="fa fa-times"></i></button>'
            .' '
            .'<button type="button" class="btn btn-dark btn-circle btn-lg" id="score"><i class="fa fa-star"></i></i><span id="c_score_'.$c_id.'" class="totalScore" data-value="'.$c_score.'">'.$c_score.'</span></button>';
        }else{
            $commentButtons = 
            '<button type="button"class="btn btn-success btn-circle btn-lg" onclick="likeComment(this)" name="'.$c_id.'" id="c_btnLike_'.$c_id.'"><i class="fa fa-check"></i></button>'
            .' '
            .'<button type="button" class="btn btn-danger btn-circle btn-lg" onclick="dislikeComment(this)" name="'.$c_id.'" id="c_btndislike_'.$c_id.'"><i class="fa fa-times"></i></button>'
            .' '
            .'<button type="button" class="btn btn-dark btn-circle btn-lg" id="c_score" ><i class="fa fa-star"></i><span id="c_score_'.$c_id.'" class="totalScore" data-value="'.$c_score.'">'.$c_score.'</span></button>';
        }
        $query2 = "SELECT * FROM users WHERE user_id = $c_author ";
        $newU = $conne->selectFreeRun($query2);
        $image = $newU[0]["image_link"];
        $username = $newU[0]["username"];
        $time_ago = Functions::timeAgo($newQ[$i]['c_date']);
        $c_description = $newQ[$i]["c_description"];
        $html .= '<div class="card bg-light post single-reserve">';
        $html .= '<div class="post-heading">';
        $html .= '<div class="float-left image">';
        $html .= '<img src="../' . $image . '" height="60" weight="60" class="img-circle avatar" alt="user profile image">';
        $html .= '</div>';
        $html .= '<div class="float-left meta col-sm-4">';
        $html .= '<div class="post-comment">';
        $html .= '<a href="/author/' . $username . '"><b>' . $username . '</b></a> made a post.';
        $html .= '</div>';
        $html .= '<h6 class="time-ago">' . $time_ago . '</h6>';
        $html .= '</div>';
        $html .= $commentButtons;
        $html .= '</div>';
        $html .= '<br>';
        $html .= '<hr>';
        $html .= '<div class="post-description">';
        $html .= '<p>' . $c_description . '</p>';
        $html .= '</div>';
        $html .= '</div>';
        $html .= '<br>';

    }
    echo $html;
}
