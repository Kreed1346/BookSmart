<?php $INC_DIR = $_SERVER["DOCUMENT_ROOT"]. "/BookSmart/root/includes/";
    require '../../profile/user.php';
    session_start();
    require($INC_DIR . "header.php");
    require($INC_DIR . "top-navbar.php");
    if (!$_SESSION['USER_INFO']->getAdminStatus()) {
        header("Location: ../../profile/profile.php");
    }

?>
    <section>
        <section class="midbar db-tools-sidebar">
            <br/>
            <a class="return" href="../textbookCatalog.php">&lsaquo; Return to Course Catalog</a>
            <h1>Create a Textbook</h1>
            <section>
                <form action="../validate/validateTextbook.php" method="POST" class="db-form">
                    <input type="hidden" name="db-operator" value="add"/>
                    <label for="text_name">Textbook Title:</label>
                    <input type="text" name="text_name" placeholder="Enter a title" required/>
                    <br/><br/>
                    <label for="primary_author">Primary Author:</label>
                    <input type="text" name="primary_author" placeholder="Enter the primary author" required/>
                    <br/><br/>
					<label for="publisher">Publisher:</label>
                    <input class="right-side-spacing" type="text" name="publisher" placeholder="Enter the publisher of this text"/>
                    <label for="year">Publish Year:</label>					
                    <input class="right-side-spacing" type="number" name="year" min="1800" max="<?php echo date("Y");?>" value="<?php echo date("Y");?>" required/>
					<label for="edition">Edition:</label>					
                    <input type="number" name="edition" min="1" value="1"/>
                    <br/><br/>
					<label for="isbn_v10">ISBN 10: </label>
					<input class="right-side-spacing" type="text" name="isbn_v10" maxlength="10" pattern="[0-9]{10,13}" placeholder="ISBN 10" />
					<label for="isbn_v13">ISBN 13:</label>
					<input type="text" name="isbn_v13" maxlength="13" pattern="[0-9]{10,13}" placeholder="ISBN 13" />
                    <br/><br/>
                    <input class="db-submit-btn" type="submit" value="Add Textbook"/>
                </form>
            </section>
        </section>
    </section>