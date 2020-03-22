<?php
include 'header.php';
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
                $AutoReplyID = $query[0]['user_id'];
                foreach ($AllQuestions as $key) { 
                    if($key["is_solved"] == 1)
                        continue;
                    $statement = $key['q_author'];
                    $q_id = $key["q_id"];
                    $q_author = $conne->selectWhere("users","user_id","=",$statement,"int"); 
                    $query = $conne->selectFreeRun("SELECT c_description FROM comments WHERE c_author = $AutoReplyID AND c_post_id =$q_id");
                    $AutoReplyComment = isset($query[0]['c_description']) ? $query[0]['c_description'] : "null";
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
                            <button type="button" class="btn btn-info">Reply</button>
                        </td>
                <?php } ?>
            </tbody>
        </table>
        <button type="button" class="btn btn-danger" id="reply_question">Reply</button>
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
</script>