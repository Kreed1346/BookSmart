<?php $INC_DIR = $_SERVER["DOCUMENT_ROOT"]. "/BookSmart/root/includes/";
    require '../profile/user.php';
    session_start();
    require($INC_DIR . "header.php");
    require($INC_DIR . "top-navbar.php");
    if (!$_SESSION['USER_INFO']->getAdminStatus()) {
        header("Location: ../profile/profile.php");
    }
?>
    <section>
        <aside class="midbar db-tools-sidebar">
            <br/>
            <a class="return" href="../profile/profile.php">&lsaquo; Return to Profile Page</a>
            <h1>Administrative Home Page</h1>
            <h2><a href="../manage/courseCatalog.php">Manage Course Catalog</a></h2>
            <h2><a href="../manage/textbookCatalog.php">Manage Textbook Catalog</a></h2>
            <h2><a href="../manage/userCatalog.php">Manage User Catalog</a></h2>
        </aside>        
    </section>
<?php require($INC_DIR . "footer.php"); ?>