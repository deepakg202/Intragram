<?php
    
    define ('ROOT_PATH', realpath(dirname(__FILE__)));
	define('BASE_URL', 'http://localhost/intragram/');


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
        for($i=0;$i<2;$i++){
        ?>

        <div class="card text-dark p-1 mb-4">
            <div class="card-header clearfix">
                <div class="float-left">Posted By :-</div>
                <div class="float-right">Date</div>
            </div>
            <img class="card-img" src="https://via.placeholder.com/1366x768" alt="Card image">
            <div class="card-body">
                <h5 class="card-title">Special title treatment</h5>
                <p class="card-text">With supporting text below as a natural lead-in to additional content.</p>
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
