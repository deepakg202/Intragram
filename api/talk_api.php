<?php 

require_once('../includes/config.php');
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_SESSION['user'])) {
   
    $toid = sanitizeString($_POST['toid']);
    $uid = sanitizeString($_POST['uid']);
    
    $toName = getDBconn()->prepare('SELECT username FROM users WHERE id=?');

    if($toName->execute([$toid]))
    {
        if(!empty($rec = $toName->fetchColumn()))
        {

        }
        else
        {
            echo 'Bad Request';
            http_response_code(400);
            exit();
        }
    }
    else
    {
        echo 'Bad Request';
        http_response_code(400);
        exit();
    }
   
    if($uid != $_SESSION['user']['id'] && empty($toid))
    {
       echo 'Bad Request';
       http_response_code(400);
       exit();
    }
   
    $arr = [$_POST['toid'], $_POST['uid']];
    sort($arr);

    $chatfile = fopen(ROOT_PATH."/chats/".$arr[0]."_".$arr[1].".txt", 'a');
    $chatMessage = str_replace("}}:{{", " ", sanitizeString($_POST['chatMessage']));
    if(fwrite($chatfile, ''.$uid.'}}:{{'.$chatMessage.''."\r\n"))
    {
        fclose($chatfile);
        echo 'Success';
        http_response_code(200);
        if(!isset($_POST['ajx']))
            header('location: //'.SITE_NAME.'/talk.php'.'?rec='.$rec);
        exit();
    
    }
    else
    {
        fclose($chatfile);
        echo 'Error Occured';
        http_response_code(400);
        exit();   
    }
    

}else{
    http_response_code(400);
    header('location: ./index.php');
    exit;
}
?>
