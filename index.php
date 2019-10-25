<?php
    require_once('config.php');
    /* read the docs!
	    by default, I'm just returning the 5 most recent
	    pocket items.
	    read more here: http://getpocket.com/developer/docs/v3/retrieve
	    */
    $twoWeeksAgo = time() - (14 * 24 * 60 * 60);
    $url = 'https://getpocket.com/v3/get?';
    $data = array(
	    'consumer_key' => $consumer_key, 
	    'access_token' => $access_token,
         'since' => $twoWeeksAgo,
         'tag'=> '_untagged_',
         'detailType' => 'complete'
    );
    $options = array(
	    'http' => array(
		    'method'  => 'POST',
		    'content' => http_build_query($data)
	    )
    );
    $context  = stream_context_create($options);
    $result = file_get_contents($url, false, $context);

        
    $resultParsed = json_decode($result, true);
    print_r($resultParsed["list"]);
if(count($resultParsed["list"])<5){
     echo("abort abort");
     exit();
}

$i = 0;
    echo "<pre>";
    foreach ($resultParsed["list"] as $value) {
        $Array2[$i] = ($value);
        $ArticleURL = preg_replace(
              "~[[:alpha:]]+://[^<>[:space:]]+[[:alnum:]/]~",
              "<a href=\"\\0\">\\0</a>", 
              $Array2[$i]["resolved_url"]);
        $ArticleFavicon = "https://www.google.com/s2/favicons?domain_url=".$Array2[$i]["resolved_url"];
        $ArticleTitle = $Array2[$i]["resolved_title"];
        $ArticleURL = $Array2[$i]["resolved_url"];
        /*$ArticleFavicon = preg_replace(
              "~[[:alpha:]]+://[^<>[:space:]]+[[:alnum:]/]~",
              "<a href=\"\\0\">\\0</a>", 
              $ArticleFavicon);*/
        $ArticleDomain = str_ireplace('www.', '', parse_url($Array2[$i]["resolved_url"], PHP_URL_HOST));
        $Array2[$i]["favicon_url"]=$ArticleFavicon;
        $Array2[$i]["article_domain"]=$ArticleDomain;
        $ArticleURLAPIRequest = preg_replace('#^http?://#', '', $Array2[$i]["resolved_url"]);
        //$ArticleURLAPIRequest = urlencode($ArticleURLAPIRequest);
        

     /*   print_r("Article URL: ".$ArticleURL);
        echo "<pre>";
        echo "</pre>";
        print_r("Article Title: ".$Array2[$i]["resolved_title"]);
        echo "<pre>";
        echo "</pre>";
        print_r("Date Added: ".date('m/d/y', $Array2[$i]["time_added"]));
        echo "<pre>";
        echo "</pre>";
        print_r("Article Word Count: ".$Array2[$i]["word_count"]);
        echo "<pre>";
        echo "</pre>"; */
        $i++;
    }
    echo "</pre>";
    //print_r($Array2[142]);
    
   
     


/*    $url = 'http://access.alchemyapi.com/calls/url/URLGetImage';
    $data = array(
	    'url' => $Array2['15']["resolved_url"], 
	    'apikey' => '424df3826bb477de4e2d6a91f38637f980502997',
        'outputMode' => 'json'
    );
    $options = array(
	    'http' => array(
		    'method'  => 'POST',
		    'content' => http_build_query($data)
	    )
    );
    $context  = stream_context_create($options);
    $result = file_get_contents($url, false, $context);*/
    //print_r($result);
    //var_dump($context);



$to = "rony.islam1295@gmail.com, delgiar@gmail.com";
$subject = "Link Drop ".date("m/d/Y");

$links="";
$actions_array=[];

$i = 0;
foreach($Array2 as $value){ 
if($i<40){
     $i++; 
     $actions_item=array(
        "action" => "tags_add",
        "item_id" => $value["item_id"],
        "tags" => "link-dropped"
     );
     $actions_array[]=$actions_item;
     $links .= $value["resolved_title"]." ";
     $links .= "<br>";
     if($value["word_count"]>0){
          $links .= "Approx. Reading Time: ".round($value["word_count"]/210,1)." minutes ";
          $links .= "<br>";     
     }
     
     $links .= $value["given_url"]." ";
     $links .= "<br><br>";
}
}
$actions_array = json_encode($actions_array);

$message = "
<html>
<head>
<title>Link Drop ". date("M j, Y")."</title>
</head>
<body>
<p>Hey there! Here is Rony's Semi-Daily Link Drop for ". date("M j, Y").".</p>

$links

<p>This *should* get better over time...maybe. </p>

<p>//Rony</p>
</body>
</html>
";

// Always set content-type when sending HTML email
$headers = "MIME-Version: 1.0" . "\r\n";
$headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";

// More headers
$headers .= 'From: <rony.islam1295@gmail.com>' . "\r\n";
//$headers .= 'Cc: myboss@example.com' . "\r\n";

mail($to,$subject,$message,$headers);


    $url = 'https://getpocket.com/v3/send?';
    $data = array(
	    'consumer_key' => $consumer_key, 
	    'access_token' => $access_token,
         'actions' => $actions_array
    );
    $options = array(
	    'http' => array(
		    'method'  => 'POST',
		    'content' => http_build_query($data)
	    )
    );
    $context  = stream_context_create($options);
    $result = file_get_contents($url, false, $context);
    $resultParsed = json_decode($result, true);
    print_r($resultParsed);
    

?>
