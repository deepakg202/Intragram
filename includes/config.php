<?php
    
    define ('ROOT_PATH', realpath(dirname(__DIR__)));
	

    if (session_status() == PHP_SESSION_NONE) {
        session_start();
    }

    function getDBconn()
    {
            $hostname="localhost";
			$user="root";
            $passwd="123";
            $database="intragram";
            try{
                $connection = new PDO("mysql:host=$hostname;dbname=$database",$user,$passwd);
                return $connection;
            }
            catch(PDOException $e)
            {
                die("Connection failed: " . $e->getMessage());
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
        $stmt = $connection->prepare("SELECT * FROM users WHERE Email= :email AND Password= :passwd");
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
            $posts = getDBconn()->query("SELECT COUNT(*) FROM blog WHERE UserId = '$who'")->fetchColumn();
        

        if($posts == 0)
            echo '<h2 class="jumbotron">No Posts Found !</h2>';    
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
                $blogData = $connection->prepare("SELECT * FROM blog ORDER BY Created DESC LIMIT $offset, $postPerPage");
            else
                $blogData = $connection->prepare("SELECT * FROM blog WHERE UserId = $who ORDER BY Created DESC LIMIT $offset, $postPerPage");
            
            $blogData->execute();
            $blogData = $blogData->fetchAll();
            
            for($i=0;$i < count($blogData);$i++){
                $uid = $blogData[$i]['UserId'];    
                $name = $connection->query("SELECT Name FROM users WHERE Username= '$uid'")->fetchColumn();
                
                $filename = $blogData[$i]['BlogId'];
                
                if(!file_exists(ROOT_PATH.'/uploads/blog/'.$filename.'.md'))
                    continue;
            ?>


        <div class="card text-dark p-1 mb-4">
            <div class="card-header clearfix">
                <div class="float-left">Posted By: <?php echo $name;?></div>
                <div class="float-right"><?php echo $blogData[$i]['Created']?></div>
            </div>
            <a class="blogcard" href="./view.php?pid=<?php echo $filename; ?>" style="color:unset; text-decoration: unset;">
                <img class="card-img" src="https://via.placeholder.com/1366x768" alt="Card image">
                <div class="card-body">
                    <h5 class="card-title"><?php echo $blogData[$i]['Heading'];?></h5>
                    <div class="card-text">
                        Click to View Post
                    </div>
                </div>
            </a>
            <br>
            <div class="card-footer d-flex justify-content-around text-center">
                <a href="#" class="btn "><i class="fa fa-thumbs-up"></i> Like</a>

                <a href="#" class="btn"><i class="fa fa-comment"></i> Comment</a>

                <a href="#" class="btn"><i class="fa fa-paperclip"></i> Share</a>
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
