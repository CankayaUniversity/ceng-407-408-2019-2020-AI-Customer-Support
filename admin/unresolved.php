<?php
include_once 'header.php';
$AllQuestions = $conne->selectAll("questions");
?>
<body>
    <div class="container-fluid">
        <input type="text" id="searchInput" class="inputStyle" onkeyup="search()" placeholder="Search for question title.." title="Type in a name">
        <table class="table table-bordered" id="myTable">
            <thead>
                <tr>
                    <th>Question Author</th>
                    <th>Question Title</th>
                    <th>Question Description</th>
                    <th>Given Answer</th>
                    <th>Status</th>
                    <th>Reply</th>
                </tr>
            </thead>
            <tbody>
                <?php 
                $query = $conne->selectFreeRun("SELECT user_id FROM users WHERE username = 'AutoReply'");
                $AutoReplyID = isset($query[0]['user_id']) ? $query[0]['user_id'] : null;
                foreach ($AllQuestions as $key) { 
                    if($key["is_solved"] == 1)
                        continue;
                    $statement = $key['q_author'];
                    $q_id = $key["q_id"];
                    $q_author = $conne->selectWhere("users","user_id","=",$statement,"int"); 
                    $query = $conne->selectFreeRun("SELECT * FROM `comments` WHERE `c_author` = '$AutoReplyID' AND `c_post_id` ='$q_id'");
                    $AutoReplyComment = isset($query[0]['c_description']) ? $query[0]['c_description']  : "null";
                    $AutoReplyCommentID = isset($query[0]['c_id']) ? $query[0]['c_id'] : "noreply";
                    ?>
                    <tr>
                        <td><?php echo $q_author[0]['firstname'].' '.$q_author[0]['surname'] ?></td>
                        <td><?php echo $key["q_title"] ?></td>
                        <td><?php echo $key["q_description"] ?></td>
                        <td><?php echo $AutoReplyComment ?></td>
                        <td>
                            <?php
                                if($key['is_solved'] == -1){
                                    echo '<button type="button" class="btn btn-secondary">Not Answered</button>';
                                }
                                else{
                                    echo '<button type="button" class="btn btn-danger">Not Solved</button>';
                                }
                            ?>
                        </td>
                        <td>
                            <button type="button" class="btn btn-info" data-toggle="modal" data-target="#<?php echo $q_id ?>">Reply</button>
                            <div class="modal fade" id="<?php echo $q_id ?>" role="dialog">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                                            <h4 class="modal-title">Expert Reply</h4>
                                        </div>
                                        <div class="modal-body">
                                            <u>Question</u><br>
                                            <?php echo $key["q_description"] ?><br><br>
                                            <u>Given Reply</u><br>
                                            <?php echo $AutoReplyComment ?>
                                        </div>
                                        <div class="modal-body">
                                            <textarea id="new_reply_<?php echo $q_id ?>" rows="4" cols="50"></textarea>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-info" onclick="ExpertReply('new_reply_<?php echo $q_id ?>','<?php echo $AutoReplyCommentID ?>','<?php echo $q_id ?>')" >Reply</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>
</body>
<script>
    function search() {
        var input, filter, table, tr, td, i, txtValue;
        input = document.getElementById("searchInput");
        filter = input.value.toUpperCase();
        table = document.getElementById("myTable");
        tr = table.getElementsByTagName("tr");
        for (i = 0; i < tr.length; i++) {
            td = tr[i].getElementsByTagName("td")[1];
            if (td) {
                txtValue = td.textContent || td.innerText;
                if (txtValue.toUpperCase().indexOf(filter) > -1) {
                    tr[i].style.display = "";
                } else {
                    tr[i].style.display = "none";
                }
            }
        }
    }

    function ExpertReply(textarea_id,c_id,q_id){
        var answer = $('#' + textarea_id).val();
        var action = "expertReply";
        $.ajax({
            url:"/action.php",
            method:"POST",
            data: {action:action,answer:answer,c_id:c_id,q_id:q_id},
            success:function(response){
                location.reload();
            }
        });
    }
</script>