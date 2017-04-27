
<!doctype html>
<html>
<head>
<meta charset="UTF-8">
<title>PHP flickr Requests</title>

<!-- jQuery -->
	<script
			  src="https://code.jquery.com/jquery-3.2.1.min.js"
			  integrity="sha256-hwg4gsxgFZhOsEEamdOYGBf13FyQuiTwlAQgxVSNgt4="
			  crossorigin="anonymous">
	</script>
<!-- End jQuery -->

<!-- uikit -->
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/uikit/3.0.0-beta.22/css/uikit.min.css" />
	<script src="https://cdnjs.cloudflare.com/ajax/libs/uikit/3.0.0-beta.22/js/uikit.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/uikit/3.0.0-beta.22/js/uikit-icons.min.js"></script>
<!-- End uikit -->

<!-- FancyBox -->
	<link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/fancybox/3.0.47/jquery.fancybox.min.css" />
	<script src="https://cdnjs.cloudflare.com/ajax/libs/fancybox/3.0.47/jquery.fancybox.min.js"></script>
<!-- End FancyBox -->

<!-- General Stylesheet -->
	<link rel="stylesheet" type="text/css" href="css/main.css" />
<!-- End General Styles -->

<?php
	
	// Global Parameters & Photoset Informations
	$showdebug = false;
	$showinfo = true;
	$apikey = '';
	$photosetID = '72157682900004326'; // Fox
	$photoset_url = "";
	$photoset_JSON_url = "";
	$photoset_length = 0;
	$photoset_title = "";
	
	include('helper.php');
	
?>
</head>

<body>
	<div id="header">
		<h1 id='nx-sitetitle'>flickr PHP Script</h1>
		<h3 id="nx-titleby">by nx-designs</h3>
	</div>
	<div id="main">
		<h2><?php echo $photoset_title; ?></h2>
		<?php if($showinfo) : ?>
		<div id="nx-connectionInfo">
			<?php echo 'API Key: '.$apikey."<br>\n"; ?>
			<?php echo 'Photoset ID: '.$photosetID."<br>\n"; ?>
			<?php if($photoset_url != ''){
			 		echo '<span class="nx-alertmsg">Set was not loaded...<br>Informations Downloaded from flickr<br>Complete Request URL: <a href="'.$photoset_url.'" target="_blank">'.$photoset_url."</a></span><br>";
				}else {
					echo '<span>Set was loaded, cached version can be found here: <a href="'.$photoset_JSON_url.'" target="_blank">'.$photoset_JSON_url.'</a></span><br>';
				} ?>
			<?php echo 'The Gallery contains <b> '.$photoset_length.' </b>Elements. <br>';?>
		</div>
		<?php endif; ?>
		<div class="uk-container-large uk-padding">
			<div id="nx-gallery uk-child-width-10" uk-grid>
			<?php
				// Get Images & Build Thumbnails
				for ($i = 0; $i < $photoset_length; $i++) {
					$imgID = $photoset_array[$i]->id;
					$farmID = $photoset_array[$i]->farm;
					$secret = $photoset_array[$i]->secret;
					$serverID = $photoset_array[$i]->server;
					$imgtitle = $photoset_array[$i]->title;

					$imglargeurl = checkCache(2,$imgID,$apikey);
					if($imglargeurl == ''){
						$imglargeurl = "https://farm'.$farmID.'.staticflickr.com/'.$serverID.'/'.$imgID.'_'.$secret.'_q.jpg";
						debug_to_console('Attention no large image available please check debug');
					}
					
					echo '<div class="nx-block" id="nx-img_'.$i.'">';
					echo '<a data-fancybox="group" data-caption="'.$imgtitle.'" href="'.$imglargeurl.'" target="_blank"><img title="'.$imgtitle.'" src="https://farm'.$farmID.'.staticflickr.com/'.$serverID.'/'.$imgID.'_'.$secret.'_q.jpg" /></a>';
					echo '</div>';
				}
			?>
			</div>
		</div>
	</div>
</body>
</html>