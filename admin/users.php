<?php
include 'header.php';
$AllUsers = adminController::getAllUsers();
?>
<body>
    <div class="container">
        <form>
            <input type="text" id="name" placeholder="Name">
            <input type="text" id="email" placeholder="Email Address">
            <input type="button" class="add-row" value="Add">
        </form>
        <table class="table">
            <thead>
                <tr>
                    <th>Select</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>is Admin</th>
                </tr>
            </thead>
            <tbody>
                <?php 
                foreach ($AllUsers as $key) { ?>
                    <tr>
                        <td><input type="checkbox" name="record"></td>
                        <td><?php echo $key["username"] ?></td>
                        <td><?php echo $key["email"] ?></td>
                        <td><?php echo $key["is_admin"] ?></td>
                    </tr>
               <? } ?>
            </tbody>
        </table>
        <button type="button" class="delete-row">Delete</button>
    </div>
</body>
<script>
    $(document).ready(function(){
        $(".add-row").click(function(){
            var name = $("#name").val();
            var email = $("#email").val();
            var markup = "<tr><td><input type='checkbox' name='record'></td><td>" + name + "</td><td>" + email + "</td></tr>";
            $("table tbody").append(markup);
        });
        
        $(".delete-row").click(function(){
            $("table tbody").find('input[name="record"]').each(function(){
                if($(this).is(":checked")){
                    $(this).parents("tr").remove();
                }
            });
        });
    });    
</script>