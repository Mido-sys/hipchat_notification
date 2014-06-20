<?php

$cache_direcory = str_replace(DIR_FS_CATALOG, '', DIR_FS_LOGS);
$current_time = time();
$next_send = (HIPCHAT_LIMIT_MESSAGE + HIPCHAT_LAST_MESSAGE);
if($current_time >= $next_send && HIPCHAT_ERROR_ENABLE == "true"){
    $content = '';
    $econtent = '';
        $allfiles = scandir($cache_direcory);
        foreach ($allfiles as $file){
            if (strpos($file, 'myDEBUG') !== false){
            $remstr = array('myDEBUG-', 'adm-');
            $dateoffile = str_replace($remstr, '', $file);
            $dateofdebug = substr($dateoffile, 0,10);
            if ($dateofdebug >= HIPCHAT_LAST_MESSAGE){
                $file = $cache_direcory . '/'.$file;
                $econtent .= file_get_contents($file);
                $sendit = true;
            }}
        }
        $message = HIPCHAT_ERROR_PREFIX;
        $message .= substr($econtent, 0, HIPCHAT_MAX_LENGTH);
   
}

if ($sendit == true){
    $url = "https://api.hipchat.com/v1/rooms/message?";
        $fields = array(
            'auth_token' => HIPCHAT_TOKEN,
            'notify' => HIPCHAT_NOTIFY_ROOM,
            'format' => HIPCHAT_API_FORMAT,
            'room_id'      => HIPCHAT_ROOM_ID,
            'from'    => urlencode(HIPCHAT_ERROR_FROM),
            "message_format" => HIPCHAT_MESSAGE_FORMAT,
            "color" => HIPCHAT_MESSAGE_COLOR,
            'message'  => urlencode($message)
            
        );
 
    $fields_string = '';
    foreach($fields as $key=>$value) { $fields_string .= $key.'='.$value.'&'; }
    rtrim($fields_string, '&');

    //open connection
    $ch = curl_init();

    //set the url, number of POST vars, POST data
    curl_setopt($ch,CURLOPT_URL, $url);
    curl_setopt($ch,CURLOPT_POST, count($fields));
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch,CURLOPT_POSTFIELDS, $fields_string);

    //execute post
    $result = curl_exec($ch);

    //close connection
    curl_close($ch);
    
    $db->Execute("UPDATE ".TABLE_CONFIGURATION." SET configuration_value='".$current_time."' WHERE configuration_key='HIPCHAT_LAST_MESSAGE'");
}