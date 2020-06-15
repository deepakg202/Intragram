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
   
    if(($uid != $_SESSION['user']['id'] && empty($toid)) || empty(trim($_POST['chatMessage'])))
    {
       echo 'Bad Request';
       http_response_code(400);
       exit();
    }
   
    $arr = [$_POST['toid'], $_POST['uid']];
    sort($arr);
    $tm = time();
    $time = new DateTime("@$tm");
    $chatfile = fopen(ROOT_PATH."/chats/".$arr[0]."_".$arr[1].".txt", 'a');
    $chatMessage = str_replace("}}:{{", " ", sanitizeString(trim($_POST['chatMessage'])));
    if(fwrite($chatfile, ''.$uid.'}}:{{'.$chatMessage.'}}:{{'.$tm."\r\n"))
    {
        fclose($chatfile);
        
        echo '<div class="m-3 p-2 rounded bg-primary text-right">
            <div class="">'.$chatMessage.'</div>
            <small class="blockquote-footer text-warning">You</small>
            <small class="text-warning">'.$time->format('d-M-Y h:m A').'</small>
        </div>';



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
