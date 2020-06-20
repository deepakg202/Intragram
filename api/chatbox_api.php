<?php 
require_once('../includes/config.php');

	if($_SERVER["REQUEST_METHOD"] == "POST" && isset($_SESSION['user']))
	{
		$toid = (int)sanitizeString($_POST['toid']);
    	$uid = (int)sanitizeString($_POST['uid']);

    	if($uid != $_SESSION['user']['id'] && empty($toid))
	    {
	       echo 'Bad Request';
	       http_response_code(400);
	       exit();
	    }

	    $arr = [$toid, $uid];
	    sort($arr);
		
	    $file = ROOT_PATH."/chats/".$arr[0]."_".$arr[1].".txt";
		$file = escapeshellarg($file);
		$line = `tail -n 1 $file`;
		echo line2mess($line, $uid, $toid);
		
	
	}else{
	    http_response_code(400);
	    header('location: ./index.php');
	    exit;
	}
?>