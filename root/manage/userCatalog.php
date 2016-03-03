<?php $INC_DIR = $_SERVER["DOCUMENT_ROOT"]. "/BookSmart/root/includes/";
    require '../profile/user.php';
    session_start();
    require($INC_DIR . "header.php");
    require($INC_DIR . "top-navbar.php");
    if (!$_SESSION['USER_INFO']->getAdminStatus()) {
        header("Location: ../profile/profile.php");
    }
    $users = [];
    if ($_SERVER["REQUEST_METHOD"] == "GET") {
        $link = mysqli_connect("localhost", "root", "booksmart", "booksmart");
        if (mysqli_connect_errno()) {
            printf("Connect failed: %s\n", mysqli_connect_error());
            exit();
        }
        
        $user_query = mysqli_query($link, "SELECT * FROM users");
        while ($row = mysqli_fetch_array($user_query)) {
            array_push($users, $row);
        }
    }
?>
    <section>
        <section class="midbar db-tools-sidebar">
            <br/>
            <a class="return" href="../admin/adminHome.php">&lsaquo; Return to Admin Home</a>
            <h1>User Catalog</h1>
            <h2><a class="create-btn" href="add/newUser.php">+ Add a User</a></h2>
            <?php
                if (!empty($users)) {
                    echo '<table class="db-data">
                             <tr>
                                 <th>Id</th>
                                 <th>Username</th>
                                 <th>Displayname</th>
                                 <th>Email</th>
                                 <th>Moderator</th>
                                 <th>Administrator</th>
                                 <th>Edit</th>
                                 <th>Delete?</th>
                             </tr>';
                    foreach($users as $user) {
                        echo '<tr>
                                 <td>'.$user["id"].'</th>
                                 <td>'.$user["username"].'</th>
                                 <td>'.$user["displayname"].'</th>
                                 <td>'.$user["email"].'</th>
                                 <td>'.(($user["moderator"] > 0) ? "Yes" : "No").'</th>
                                 <td>'.(($user["administrator"] > 0) ? "Yes" : "No").'</th>
                                 <td><p class="starfruit"><a href="edit/editUser.php?code='.$user["id"].'">Edit</a></p></td>
                                 <td><p class="starfruit"><a href="delete/deleteUser.php?code='.$user["id"].'">Delete</a></p></td>
                             </tr>';
                    }
                    echo '</table>';
                }
            ?>            
        </section>        
    </section>
<?php require($INC_DIR . "footer.php"); ?>