<?php require_once './config.php'; 
 if (isset($_GET['post_id']) OR isset($_GET['post_url'])) {
     $post_id = $_GET['post_id'];
}
?>

<html>
    <head>
        <title>Check Url Friendly</title>
        <base href="http://localhost/All_demo/url_friendly/" />
        <link rel="stylesheet" href="assets/styles.css" />
        <link rel="stylesheet" href="assets/bootstrap.min.css" />
        <link rel="stylesheet" href="assets/font-awesome.min.css" />
    </head>
    <body>
        <div class="wrapper">
            <div class="header">
                <h1>Welcome to our Clean Url checking site</h1>
            </div>
            <div class="post-area">
                <?php
                $statement = $db->prepare("SELECT * FROM tbl_post WHERE post_id= ?");
                $statement->execute(array($post_id));
                $result = $statement->fetchAll(PDO::FETCH_ASSOC);
                foreach ($result as $row) {
                    ?>
                    <div class="single-post">
                        <h2><?php echo $row['post_title']; ?></h2><hr>
                        <div class="post-description">
                            <?php echo $row['post_description']; ?>
                        </div>
                        <div class="post-detail-next row">
                            <div class="col-sm-8">
                                Comment <span class="badge">10</span>
                            </div>
                            <div class="col-sm-4">

                                <!--http://example.com/cgi-bin/book.cgi?author=bowen&topic=modrewrite-->
                                <a href="post.php?post_id=<?php echo $row['post_id'];?>&post_title=<?php echo $row['post_url'];?>">Continue reading...</a>
                            </div>
                        </div>
                    </div>

                    <?php
                }
                ?>
            </div>
        </div>
        
        <script type="text/javascript" src="assets/bootstrap.min.js" ></script>
        <script type="text/javascript" src="assets/jquery.js" ></script>
        <script type="text/javascript" src="assets/main.js" ></script>
    </body>
</html>
