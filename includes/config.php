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

    function fetchCartWithUidStat($connection, $uid, $status)
    {
        $stmt = $connection->prepare("SELECT * FROM orders WHERE Userid= :uid AND Status= :status");
        $stmt->execute([":uid" => $uid, ":passwd" => $status]);
        return $stmt->fetchAll();
    }


    function printBlog($connection, $who)
    { 
        require_once("../includes/Parsedown.php");
        $Parsedown = new Parsedown();

        $blogData = getDBconn()->prepare("SELECT * FROM blog");
        $blogData->execute();
        $blogData = $blogData->fetchAll();
        
        for($i=0;$i < count($blogData);$i++){
            $uid = $blogData[$i]['UserId'];    
            $name = getDBconn()->prepare("SELECT Name FROM users WHERE id= $uid");
            $name->execute();
            $filename = $blogData[$i]['BlogId'];
            $name =  $name->fetchColumn();
        ?>

        <div class="card text-dark p-1 mb-4">
            <div class="card-header clearfix">
                <div class="float-left">Posted By: <?php echo $name;?></div>
                <div class="float-right"><?php echo $blogData[$i]['Created']?></div>
            </div>
            <img class="card-img" src="https://via.placeholder.com/1366x768" alt="Card image">
            <div class="card-body">
                <h5 class="card-title"><?php echo $blogData[$i]['Heading'];?></h5>
                <p class="card-text">
                <?php echo $Parsedown->text(file_get_contents(ROOT_PATH."/uploads/blog/$filename.md"));?>
                </p>
            </div>
            <div class="card-footer d-flex justify-content-around text-center">
                <a href="#" class="btn "><i class="fa fa-thumbs-up"></i> Like</a>
        
                <a href="#" class="btn"><i class="fa fa-comment"></i> Comment</a>
                
                <a href="#" class="btn"><i class="fa fa-share"></i> Share</a>
            </div>
        </div>
    <?php
    }
}



?>
