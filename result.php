<?php

function filterTweets($array){
	$resp = array();
	foreach ($array as $i){
		$i = ereg_replace("[^A-Za-z0-9]", "", $i);
		array_push($resp,$i);
		}
	return $resp;
}


function fetchTweets($handle){
	$tweets = array();
	$arrayToPrint = array();
	$jsonurl = "http://api.twitter.com/1/statuses/user_timeline.json?suppress_response_codes&trim_user=true&include_entities=false&include_rts=true&exclude_replies=true&count=1000&screen_name=".$handle;
	$json = file_get_contents($jsonurl);
	$json_output = json_decode($json);
	foreach ($json_output as $value){
			$text = $value -> text;
			$trim =  split(' +',$text);
			$afterTrim = filterTweets($trim);
			array_push($tweets,count($afterTrim));
		}
	$arrayToPrint = array_count_values($tweets);
	ksort($arrayToPrint);
	return $arrayToPrint;
}

if(!isset($_POST['handle'])){
	header("Location: index.php");
	}
	else{
	$print = array();
	$print = fetchTweets($_POST['handle']);
?>
	<!DOCTYPE html>
	<html>
	<head>
	  <title>Solution By saurabh kumar - Multunus Twitter Challenge</title>
	  <link href="http://twitterpuzzle.herokuapp.com/assets/application-3f94c13210e17b948bb3386f6ed480d7.css" media="all" rel="stylesheet" type="text/css" />
	<link href="http://twitterpuzzle.herokuapp.com/assets/bootstrap-a5035b9c1426e0067756a6beced8ab28.css" media="all" rel="stylesheet" type="text/css" />
	<link href="http://twitterpuzzle.herokuapp.com/assets/common-7e513a382ac46a1411e50c17dbf80566.css" media="all" rel="stylesheet" type="text/css" />
	  <script src="http://twitterpuzzle.herokuapp.com/assets/application-d269831f5c545cc04978a13d6fccdcc5.js" type="text/javascript"></script>
	<script src="http://twitterpuzzle.herokuapp.com/assets/jquery.tagcloud-e1b5a8123cbd251e02f8d16cab4b2915.min" type="text/javascript"></script>
	<script src="http://twitterpuzzle.herokuapp.com/assets/jquery.tinysort-cdd27c724ecbb017f6f19e51413ebc7f.min" type="text/javascript"></script>
	<style type="text/css">
		body {
			padding-top: 160px;
		}
		.me {
			text-align: center;
			color: black;
		}
	</style>
	</head>
	<body>

	 <div class="row-fluid tag-cloud">
		 <div class="span12">
		   <div class="cloud">
		<ul id = "xpower" class="xmpl" >
				<?php
					foreach ($print as $k => $v){
				
					echo "<li  value='".$v."'>".$k."</li>";
					}
				?>
	 	</ul>
		   </div>
		 </div>
	  </div>
	<div class="me">
		<h1><a href="http://twitter.com/saurabh_nitc10"><em>saurabh kumar</em></a></h1>
	</div>
	  <script type="text/javascript">
	  $(function(){
		 bindTagCloud()
	  });
	</script>

	  <link href="http://twitterpuzzle.herokuapp.com/assets/output-5b3525d305057d6a8fb072d21629e80d.css" media="screen" rel="stylesheet" type="text/css" />
	</body>
	</html>

<?php
	
}
?>


