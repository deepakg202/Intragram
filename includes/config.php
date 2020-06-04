<?php
    
    define ('ROOT_PATH', realpath(dirname(__DIR__)));
	define ('SITE_NAME', $_SERVER['HTTP_HOST']);

    if (session_status() == PHP_SESSION_NONE) {
        session_start();
    }

    function getDBconn()
    {
        try{
                $hostname="localhost";
                $user="root";
                $passwd="123";
                $database="intragram";
                $connection = new PDO("mysql:host=$hostname;dbname=$database",$user,$passwd);
                $connection->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
                $connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                
                return $connection;
            }
            catch(PDOException $e)
            {
                try{
                $hostname="sql202.epizy.com";
                $user="epiz_25709434";
                $passwd="2lWWKk4OemA";
                $database="epiz_25709434_intragram";
            
                $connection = new PDO("mysql:host=$hostname;dbname=$database",$user,$passwd);
                $connection->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
                $connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);     
                return $connection;
                }
            catch(PDOException $e)
            {    
                try{
                    $db = parse_url(getenv("DATABASE_URL"));
                    $pdo = @new PDO("pgsql:" . sprintf("host=%s;port=%s;user=%s;password=%s;dbname=%s",
                        $db["host"],
                        $db["port"],
                        $db["user"],
                        $db["pass"],
                        ltrim($db["path"], "/")
                    ));
                    $pdo->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
                    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                    return $pdo;
        
                }catch(PDOException $a)
                {
                    die('Error '.$e);
                }
            }    

        }    
                
                
    }
    
    

       
    function sanitizeString($var)
    {
        $var=stripslashes($var);
        $var=htmlentities($var);
        $var=strip_tags($var);
		return $var;
    }


	
	function redirect($url){
        
   		echo '<META HTTP-EQUIV=REFRESH CONTENT="0; '.$url.'">';
    }    


  
    function checkUser($connection, $email, $passwd)
    {
        $stmt = $connection->prepare("SELECT * FROM users WHERE email= :email AND password= :passwd");
        $stmt->execute([":email" => $email, ":passwd" => $passwd]);
        return $stmt;
    }

    

    function printBlog($connection, $who, $postPerPage)
    { 
        if($who == '')
            $posts = 0;
        else if($who == 'all')
            $posts = getDBconn()->query("SELECT COUNT(*) FROM blog")->fetchColumn();
        else
            $posts = getDBconn()->query("SELECT COUNT(*) FROM blog WHERE user_id = '$who'")->fetchColumn();
        

        if($posts == 0)
            echo '<h2 class="jumbotron">Oops! You Haven\'t Posted Anything Yet !</h2>';    
        else
        {
            $totalPages = ceil($posts/$postPerPage);
            $totalPages = $totalPages==0?1:$totalPages;
            
        
            if (isset($_GET['page']) && is_numeric($_GET['page']))
                $currentpage = (int) sanitizeString($_GET['page']);
            else
                $currentpage = 1;
             

            if ($currentpage > $totalPages) 
                $currentpage = $totalPages;
            

            if ($currentpage < 1)
                $currentpage = 1;
        

            $offset = ($currentpage - 1) * $postPerPage;

            if($who == 'all')
                $blogData = $connection->prepare("SELECT * FROM blog ORDER BY created DESC LIMIT $offset, $postPerPage");
            else
                $blogData = $connection->prepare("SELECT * FROM blog WHERE user_id = $who ORDER BY created DESC LIMIT $offset, $postPerPage");
            
            $blogData->execute();
            $blogData = $blogData->fetchAll();
            
            for($i=0;$i < count($blogData);$i++){
                $uid = $blogData[$i]['user_id'];    
                $udata = $connection->query("SELECT name, profile_pic FROM users WHERE id= '$uid'")->fetch();
                
                $filename = $blogData[$i]['blog_id'];
                
                if(!file_exists(ROOT_PATH.'/uploads/blog/'.$filename.'.md'))
                    continue;
            ?>


        <div class="card text-dark p-1 mb-4">
            <div class="card-header clearfix">
                <div class="float-left"><a href="./profile.php"><img class="rounded-circle img-fluid" onerror="this.src='images/no-image.png';" style="height: 32px; width: 32px;" src="<?=$udata['profile_pic']?>"> <?=$udata['name']?></a></div>
                <div class="float-right"><?=$blogData[$i]['created']?></div>
            </div>
            <a class="blogcard" href="./view.php?pid=<?=$filename?>" style="color:unset; text-decoration: unset;">
                <img class="card-img" onerror="this.src='images/no-image.png';" src="<?=$blogData[$i]['image_link']?>" alt="Card image">
                <div class="card-body">
                    <h5 class="card-title"><?=$blogData[$i]['heading']?></h5>
                    <div class="card-text post-content">
                        Click to View Post
                    </div>
                </div>
            </a>
            <br>
            <div class="card-footer d-flex justify-content-around text-center">
                <a href="#" class="btn "><i class="fa fa-thumbs-up"></i> Like</a>

                <a href="./view.php?pid=<?php echo $filename; ?>#Comments" class="btn"><i class="fa fa-comment"></i> Comment</a>

                <a href="#" class="btn"><i class="fa fa-paperclip"></i> Save</a>
            </div>
        </div>

        <?php
        }
        blogNav($currentpage, $totalPages);
    }
}




    function blogNav($currentpage, $totalPages)
    {?>

    <nav aria-label="blog-nav">
        <ul class="pagination justify-content-center">
            <li class="page-item <?php echo ($currentpage == 1)?'disabled':'' ; ?>">
                <a class="page-link" href="?page=<?php echo $currentpage-1;?>" aria-label="Previous">
                    <span aria-hidden="true">&laquo;</span>
                    <span class="sr-only">Previous</span>
                </a>
            </li>

            <?php 
            for($i=1;$i<=$totalPages;$i++)
            {
            
                if($i == $currentpage)
                {?>
                    <li class="page-item active"><a class="page-link" href="#"><?php echo $i;?></a></li>
                <?php
                }
                else
                {
                ?>
            <li class="page-item"><a class="page-link" href="?page=<?php echo $i;?>"><?php echo $i;?></a></li>

            <?php
                }
                
            }
            
            ?>

            <li class="page-item  <?php echo ($currentpage == $totalPages)?'disabled':'' ; ?>">
                <a class="page-link" href="?page=<?php echo $currentpage+1;?>" aria-label="Next">
                    <span aria-hidden="true">&raquo;</span>
                    <span class="sr-only">Next</span>
                </a>
            </li>
        </ul>
    </nav>


    <?php
    }

?>
