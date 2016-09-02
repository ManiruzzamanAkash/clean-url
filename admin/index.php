<?php require_once '../config.php'; 

/**
 * Function : Generate a random password
 * @return: string
 **/
function generate_random_string($length = 5){
    $characters = "123";
    $characters_length = strlen($characters);
    $random_string = '';
    for ($i = 0; $i < $length; $i++) {
        $random_string .= $characters[rand(0, $characters_length - 1)];
    }
    return $random_string;
}
?>


<?php
if (isset($_POST['post_submit'])) {
    $post_title = $_POST['post_title'];
    $post_description = $_POST['post_description'];

/***
 * Make a dynamic url from the given post title.
 * First-> trim the title, then replace the space by a hiphen (-)
 * Then -> Make htmlentities for security
 * Then -> Convert the title to lower case
 **/
    $post_url = trim(str_replace(" ", "-", $post_title));
    $post_url = htmlentities($post_url);
    $post_url = strtolower($post_url);                  //final url
    
    
    
    /**
     * Now insert the post_id, post_title, post_description from admin panel and from background also insert the url
     * in the database and for that we have to make obviously a field for url in the database
    */
    
    try {
        $statement = $db->prepare("SELECT post_url FROM tbl_post WHERE post_url = ?");
        $statement->execute(array($post_url));
        $result = $statement->fetchAll(PDO::FETCH_ASSOC);
        
        /**
         * Check if the title is exists in the database..
         * If the password exists in the database then add random string after the title which never make a same url_title 
         * for my posts
        **/
        if ($statement->rowCount() > 0) {
            $random_generate = generate_random_string();
            $post_url = $post_url.'-'.$random_generate;
        }

        //And if no duplicate then only insert the url_title
        $statement = $db->prepare("INSERT INTO tbl_post(post_title, post_description, post_url) VALUES(?, ?, ?)");
        $statement->execute(array($post_title, $post_description, $post_url));
        $success_message = "Post has inserted successfully..";
    } catch (Exception $ex) {
        $error_massage = $ex->getMessage();
    }
}
?>

<html>
    <head>
        <title>Check Url Friendly | Admin Panel</title>
        <link rel="stylesheet" href="../assets/styles.css"/>
    </head>
    <body>
        <div class="wrapper">
            <div class="header">
                <h1>Welcome to our Clean Url checking site Admin panel</h1><hr>
            </div>
            <div class="post-area">
                <div class="single-post">
                    <?php
                    if (isset($success_message)) {
                        echo '<div class="success">'.$success_message.'</div>';
                    }
                    if (isset($error_massage)) {
                        echo '<div class="error">'.$error_massage.'</div>';
                    }
                    ?>
                    <form action="" method="post">
                        <label>Enter Post title : </label>
                        <input type="text" name="post_title" style="width: 70%;border: 1px solid;"><br>

                        <label>Enter Post description : </label><br>
                        <textarea type="text" cols="40" rows="20" name="post_description" style="margin: 10px;width: 927px;height: 328px;border: 1px solid;"></textarea><br>
                        <input type="submit" name="post_submit" /><br>
                    </form>
                </div>
            </div>
        </div>
    </body>
</html>
