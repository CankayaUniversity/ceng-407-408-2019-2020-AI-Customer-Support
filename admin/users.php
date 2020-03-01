<?php
include 'header.php';
$AllUsers = $conne->selectAll("users");
?>
<body>
    <div class="container">
        <form>
            <input type="text" id="name" placeholder="Name">
            <input type="text" id="email" placeholder="Email Address">
            <input type="button" class="btn btn-info" value="Add" id="add-row">
        </form>
        <input type="text" id="searchInput" class="inputStyle" onkeyup="search()" placeholder="Search for names.." title="Type in a name">
        <table class="table table-bordered" id="myTable">
            <thead>
                <tr>
                    <th scope="col">Select</th>
                    <th scope="col">Username</th>
                    <th scope="col">Email</th>
                    <th scope="col">Fullname</th>
                    <th scope="col">Admin</th>
                </tr>
            </thead>
            <tbody>
                <?php 
                foreach ($AllUsers as $key) { ?>
                    <tr>
                        <td><input type="checkbox" value="<?php echo $key['user_id'] ?>" name="record"></td>
                        <td><?php echo $key["username"] ?></td>
                        <td><?php echo $key["email"] ?></td>
                        <td><?php echo $key["firstname"].' '.$key["surname"];?></td>
                        <td><?php if($key["is_admin"]) echo "Yes"; else echo "No"; ?></td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
        <button type="button" class="btn btn-danger" id="delete-row">Delete</button>
    </div>
</body>
<script>
    $(document).ready(function(){
        $("#add-row").click(function(){
            var username = $("#name").val();
            var email = $("#email").val();
            var markup = "<tr><td><input type='checkbox' name='record'></td><td>" + name + "</td><td>" + email + "</td></tr>";
            $("table tbody").append(markup);
            var action = "addUser";
            $.ajax({
                url:"/action.php",
                method:"POST",
                data: {username:username, email:email, action:action},
                success:function(response){
                    alert(response);
                }       
            })
        });
        
        $("#delete-row").click(function(){
            var action = "deleteUser";
            $("table tbody").find('input[name="record"]').each(function(){
                if($(this).is(":checked")){
                    var value = $(this).val();
                    $(this).parents("tr").remove();
                    $.ajax({
                        url:"/action.php",
                        method:"POST",
                        data: {user_id:value, action:action},
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
            td = tr[i].getElementsByTagName("td")[2];
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