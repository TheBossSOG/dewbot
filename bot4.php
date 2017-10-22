<?php
    include_once "./bot4fn.php";

    $conn = getConnection();

    $access_token = 'ztnYt6nd+Mlf2wwA9VklFlPmPOGTzxBiGTT0UQYddeckKcoNEe6lkwXBdyEPcoW1iuGZM1HZdyacb9LRI3zN8UZfFQNHjaC2CVT/+Xvdgj9yK9lIYGCtrX77qT/KLSIzT4w8H8HxqVcJpjwJ2QLerAdB04t89/1O/w1cDnyilFU=';

    $content = file_get_contents('php://input');
    $events = json_decode($content, true);

    if (!is_null($events['events'])) {
        foreach ($events['events'] as $event) {
            if($event['type'] == 'message' && $event['message']['type'] == 'text' ){
                if(strpos($event['message']['text'],"#?") !== false ){
                    $temp = $event['message']['text'];
                    $temp = explode('#?',$temp);
    
                    $key = $temp[0];
                    $ans = $temp[1];
                    $sql = "INSERT INTO `heroku_da1dc32cdc85254`.`knowledge`(`key`,`ans`) VALUES ('$key','$ans')";
    
                    $conn->query($sql);
                    $text = 'ดิวจะจำไว้นะ^^';
                    $data = setData(1,$event['replyToken'],$text);
                    sendMessage($data,$access_token);
                }else if(strcmp($event['message']['text'],"รายชื่อ") == false){
                    $data = setData(0,$event['replyToken']);
                    sendMessage($data,$access_token);
                }else{
                    $sql_select = "select * from heroku_da1dc32cdc85254.knowledge";
                    if ($result = $conn->query($sql_select)) {
                        
                            while ($obj = $result->fetch_object()) {
                                if( strpos($event['message']['text'],$obj->key) !== false ){
                                    $text = $obj->ans;
                                    break;
                                }
                            }
                            $result->close();
                    }
                    $data = setData(1,$event['replyToken'],$text);
                    sendMessage($data,$access_token);
                }
            }
        }
    }
        

    closeConnection($conn);
?>