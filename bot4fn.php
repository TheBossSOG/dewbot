<?php
    function getConnection(){
        $url = parse_url(getenv("CLEARDB_DATABASE_URL"));
        
        $server = $url["host"];
        $username = $url["user"];
        $password = $url["pass"];
        $db = substr($url["path"], 1);
        
        
        if($conn = new mysqli($server, $username, $password, $db)){
            echo true;
        }else{
            echo false;
        }
        return $conn;
    }

    function closeConnection($conn){
        $conn->close();
    }

    function setData($isText,$reply,$text=""){

        if($isText == 1){
            $messages = [
                'type' => 'text',
                'text' => $text
            ];
        }else{
            $imageUrl = 'https://still-beyond-73841.herokuapp.com/bnk48_3.jpg';
            $imageMiniUrl = 'https://still-beyond-73841.herokuapp.com/rsz_1bnk48_3.jpg';
            $messages = [
                'type' => 'image',
                'originalContentUrl' => $imageUrl,
                'previewImageUrl' => $imageMiniUrl
            ];
        }
        $replyToken = $event['replyToken'];
        $data = [
            'replyToken' => $reply,
            'messages' => [$messages],
         ];

        return $data;
    }

    function sendMessage($data,$access_token){
        $url = 'https://api.line.me/v2/bot/message/reply';
        $post = json_encode($data);
        $headers = array('Content-Type: application/json', 'Authorization: Bearer ' . $access_token);
        
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $post);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
        $result = curl_exec($ch);
        curl_close($ch);
        echo $result . "\r\n";
    }
?>