<?php
    require_once('config.php');
    /* read the docs!
	    by default, I'm just returning the 5 most recent
	    pocket items.
	    read more here: http://getpocket.com/developer/docs/v3/retrieve
	    */
    $url = 'https://getpocket.com/v3/get?';
    $data = array(
	    'consumer_key' => $consumer_key, 
	    'access_token' => $access_token,
        'count' => '30',
        'since' => '',
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
    //print_r($result);
    
    $resultParsed = json_decode($result, true);
    print_r($resultParsed["list"]);
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



$to = "rony.islam1295@gmail.com";
$subject = "Link Drop 6/21/19";

$links="";

$i = 0;
foreach($Array2 as $value){ 
if($i<40){
     $i++; 
     $links .= $value["resolved_title"]." ";
     $links .= "<br>";
     $links .= "Approx. Reading Time: ".round($value["word_count"]/250,1)." minutes ";
     $links .= "<br>";
     $links .= $value["given_url"]." ";
     $links .= "<br><br>";
}
}

$message = "
<html>
<head>
<title>Link Drop for June 21, 2019</title>
</head>
<body>
<p>Hey there! Here is Rony's Semi-Daily Link Drop for June 21, 2019.</p>

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


?>

<!doctype html>
<!--[if lt IE 7]> <html class="no-js lt-ie9 lt-ie8 lt-ie7" lang="en"> <![endif]-->
<!--[if IE 7]>    <html class="no-js lt-ie9 lt-ie8" lang="en"> <![endif]-->
<!--[if IE 8]>    <html class="no-js lt-ie9" lang="en"> <![endif]-->
<!-- Consider adding a manifest.appcache: h5bp.com/d/Offline -->
<!--[if gt IE 8]><!--> <html class="no-js" lang="en"> <!--<![endif]-->
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
	<title></title>
	<meta name="description" content="">
	<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0"> 

	<link rel="stylesheet" href="gridiculous.css">
    <script src="isotope.pkgd.js"></script>
    <script src="jquery-1.8.3.min.js"></script>
    
    <style type="text/css">
        .c3{
            background-color: #ffd800;
            margin-bottom: 5px;
            margin-top: 5px;
            padding-bottom: 7px;
            padding-top: 7px;
            margin-left: 5px;
            margin-right: 5px;
            
        }
        .grid-item{
            max-width: 320px;
            min-width: 320px;
            background-image: url(http://www.jahedulislam.com/images/wood%20_texture44.jpg);
            margin: 10px;
            height: 340px;
        }
        .grid.js-isotope {
            margin: 0 auto;
            width: 90%;
            
        }
        body{
            background-image: url(http://www.jahedulislam.com/images/Wood_05_UV_H_CM_1.jpg);
        }
        articletitle{
            font-size: 4vw;
        }

</style>
    
</head>
<body>
            <div class="grid js-isotope"
  data-isotope-options='{ "itemSelector": ".grid-item", "masonry": { "columnWidth": 40, "isFitWidth": true } }'>
  <script type="text/javascript">
  </script>
                <?php $i = 0;?>
                <?php foreach($Array2 as $value){ ?>
                    <?php if($i<40){?><div class="grid-item" style="background-image: url(http://www.jahedulislam.com/images/wood%20_texture44.jpg)">
                    <strong><?php  $i++; echo($value["resolved_title"]." ");?></strong> </br>
                    <img src="<?php echo $value["favicon_url"] ; ?>" alt="Domain Favicon" style="float: left"> </img> <?php echo $value["article_domain"];?> </br>
                    <strong>Date Added: </strong> <?php echo(date('m/d/y', $value["time_added"]));?> </br>
                    <strong>URL: </strong> <a href="<?php echo($value["given_url"]." ");?>" target="_blank"> <?php echo($value["given_url"]." ");?> </a></br>
                    <strong>Word Count: </strong><?php echo($value["word_count"]." ");?></small> </br>
                    <div class="grid-sizer"></div>
                
				</div>    
                <?php }?>
                <?php } ?>
</div>
       
</body>
</html>