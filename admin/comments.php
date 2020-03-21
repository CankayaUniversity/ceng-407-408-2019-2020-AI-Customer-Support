<?php
include 'header.php';
$allComments = $conne->selectAll("comments");
?>
<body>
    <div class="container">
        <input type="text" id="searchInput" class="inputStyle" onkeyup="search()" placeholder="Search for names.." title="Type in a name">
        <table class="table table-bordered" id="myTable">
            <thead>
                <tr>
                    <th scope="col">Select</th>
                    <th scope="col">Description</th>
                    <th scope="col">Author</th>
                    <th scope="col">Post</th>
                </tr>
            </thead>
            <tbody>
                <?php 
                foreach ($allComments as $key) { 
                    $authorName = $conne->selectFreeRun('SELECT username FROM users WHERE user_id = '.$key["c_author"].'');
                    $postName = $conne->selectFreeRun('SELECT q_title FROM questions WHERE q_id = '.$key["c_post_id"].'');
                ?>
                    <tr>
                        <td><input type="checkbox" value="<?php echo $key['c_id'] ?>" name="record"></td>
                        <td><?php echo $key["c_description"] ?></td>
                        <td><?php echo $authorName[0]["username"] ?></td>
                        <td><?php echo $postName[0]["q_title"] ?></td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
        <button type="button" class="btn btn-danger" id="delete-row">Delete</button>
    </div>
</body>

<script type="text/javascript">
    $(document).ready(function(){
        $("#delete-row").click(function(){
            var action = "deleteComment";
            $("table tbody").find('input[name="record"]').each(function(){
                if($(this).is(":checked")){
                    var value = $(this).val();
                    $(this).parents("tr").remove();
                    $.ajax({
                        url:"/action.php",
                        method:"POST",
                        data: {c_id:value, action:action},
                        success:function(response){
                            alert(response);
                        }
                    });
                }
            });
        });
    });    

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