<?php 

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    header('Content-Type: application/json');
   

    $img=$_FILES['image']; 
    
    $allowed = array('gif', 'png', 'jpg');
    $fname = $img['name'];
    $ext = pathinfo($fname, PATHINFO_EXTENSION);
    if (!in_array($ext, $allowed)) {
        echo '{"error": "typeNotAllowed"}';
        http_response_code(415);        
        exit;
    }
    
    
    $filename = $img['tmp_name'];
    $client_id='5380dd618175781';		// Replace this with your client_id, if you want images to be uploaded under your imgur account
    $handle = fopen($filename, 'r');
    $data = fread($handle, filesize($filename));
    $pvars = array('image' => base64_encode($data));
    $timeout = 30;
    $curl = curl_init();
    curl_setopt($curl, CURLOPT_URL, 'https://api.imgur.com/3/image.json');
    curl_setopt($curl, CURLOPT_TIMEOUT, $timeout);
    curl_setopt($curl, CURLOPT_HTTPHEADER, array('Authorization: Client-ID ' . $client_id));
    curl_setopt($curl, CURLOPT_POST, 1);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($curl, CURLOPT_POSTFIELDS, $pvars);

    $out = curl_exec($curl);
    curl_close ($curl);
    $pms = json_decode($out,true);
    $url=$pms['data']['link'];

    if($url == '')
    {
        echo '{"error": "Bad_File"}';        
        http_response_code(400);
        exit;
    }else{
        echo '{"data": {"filePath": "'.$url.'"}}';
        http_response_code(200);
        exit;
    }

}else{
    header('location: ./index.php');
    exit;
}

?>
