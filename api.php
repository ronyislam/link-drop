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
	    'access_token' => $access_token
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
    $i = 0;
    echo "<pre>";
    foreach ($resultParsed["list"] as $value) {
        $Array2[$i] = ($value);
        $ArticleURL = preg_replace(
              "~[[:alpha:]]+://[^<>[:space:]]+[[:alnum:]/]~",
              "<a href=\"\\0\">\\0</a>", 
              $Array2[$i]["resolved_url"]);
        print_r("Article URL: ".$ArticleURL);
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
        echo "</pre>";
        $i++;
    }
    echo "</pre>";
    print_r(count($Array2));
?>