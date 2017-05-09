<?php
/*

	name:			flickr PHP Script
	version:		1.1
	Description:	flickr PHP Script
	creator:		nx-designs | Marco Rensch
	web:			http://www.nx-designs.ch
	repository:		https://github.com/marcorensch/flickrPHP
	type:			opensource
	license:		GNU General Public License version 3 (https://opensource.org/licenses/gpl-3.0.html)
	
	important:		For this script fancyBox 3 is used as default PopUp Gallery. 
					Please read license informations for commercial usage
					here: http://fancyapps.com/fancybox/3/#license.
	

*/
	
	// Global Parameters & Photoset Informations
	$showheader = false;							// displays the black header on top 				 	
	$showdebug = false;								// shows debug informations on page						
	$showinfo = false;								// shows grey infobox with API Key, Cache State, Photoset Informations on top
	$showtitle = true;								// Display Photoset Title
	$loadjquery = true;								// should jQuery (3) been loaded by this script?
	$framework = 'uikit'; 							// uikit || Bootstrap
	$loadfrontendframework = true; 					// should grid-frameworks be loaded by this script?
	$loadfancyBoxScript = true;						// load fancyBox 3 Script for PopUp?
	$enablepopups = true; 							// select if popups with fancybox should be enabled
	$columns = 4;									// choose desired amount of columns (for uikit = 1,2,3,4,5,6 for bootstrap = 1,2,3,4,6,12)
	$thumbnailsize = 'q';							// s,q,t,m,n,z,c,b,h,k,o (depends on available image quality on flickr for this set)
	$apikey = '';									// Enter here your API Key
	// $photosetID = '72157680841776090'; 			// Demo Gallery Golf (250+ Images)
	$photosetID = '72157682900004326'; 				// Demo Gallery Fox (6 Images)

	$photoset_url = "";
	$photoset_JSON_url = "";
	$photoset_length = 0;
	$photoset_title = "";
	
	include('helper.php');
	include('setconfig.php');
?>
<!doctype html>
<html>
<head>
<meta charset="UTF-8">
<title>PHP flickr Requests</title>
<?php if($loadjquery): ?>
<!-- jQuery -->
	<script
			  src="https://code.jquery.com/jquery-3.2.1.min.js"
			  integrity="sha256-hwg4gsxgFZhOsEEamdOYGBf13FyQuiTwlAQgxVSNgt4="
			  crossorigin="anonymous">
	</script>
<!-- End jQuery -->
<?php endif; ?>
<?php if($loadfrontendframework): ?>
		<!-- <?php echo $framework; ?> is in use -->
		<link rel="stylesheet" type="text/css" <?php echo $stylesheetlink; ?> />
		<script type="text/javascript" <?php echo $frameworklink; ?>></script>
		<!-- End <?php echo $framework; ?> -->
<?php endif; ?>

<!-- FancyBox -->
<?php if($loadfancyBoxScript): ?>
	<link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/fancybox/3.0.47/jquery.fancybox.min.css" />
	<script src="https://cdnjs.cloudflare.com/ajax/libs/fancybox/3.0.47/jquery.fancybox.min.js"></script>
<?php endif; ?>
<!-- End FancyBox -->

<!-- General Stylesheet -->
	<link rel="stylesheet" type="text/css" href="css/main.css" />
<!-- End General Styles -->


</head>

<body>
	<?php if($showheader): ?>
	<div id="header">
		<h1 id='nx-sitetitle'>flickr PHP Script</h1>
		<h3 id="nx-titleby">by nx-designs</h3>
	</div>
	<?php endif; ?>
	<div id="main">
		<?php if($showinfo) : ?>
		<div class="uk-container-large uk-padding container-fluid">
			<div id="nx-connectionInfo" class="<?php echo $infoboxclass; ?>">
				<?php echo 'API Key: '.$apikey."<br>\n"; ?>
				<?php echo 'Photoset ID: '.$photosetID."<br>\n"; ?>
				<?php if($photoset_url != ''){
						echo '<span class="nx-alertmsg">Set was not loaded...<br>Informations Downloaded from flickr<br>Complete Request URL: <a href="'.$photoset_url.'" target="_blank">'.$photoset_url."</a></span><br>";
					}else {
						echo '<span>Set was loaded, cached version can be found here: <a href="'.$photoset_JSON_url.'" target="_blank">'.$photoset_JSON_url.'</a></span><br>';
					} ?>
				<?php echo 'The Gallery contains <b> '.$photoset_length.' </b>Elements. <br>';?>
			</div>
		</div>
		<?php endif; ?>
		<?php if($showtitle): ?>
		<div class="uk-container-large uk-padding container-fluid">
			<h1 style="text-align:center;"><?php echo $photoset_title; ?></h1>
			<hr>
		</div>
		<?php endif; ?>
		<div class="uk-container-large uk-padding container-fluid">
			<div id="nx-gallery" class="<?php echo $outerdiv; ?>" uk-grid>
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
					
					echo '<div class="nx-block '.$gridelement.'" id="nx-img_'.$i.'">';
					echo '<a data-fancybox="group" data-caption="'.$imgtitle.'" href="'.$imglargeurl.'" target="_blank"><img title="'.$imgtitle.'" src="https://farm'.$farmID.'.staticflickr.com/'.$serverID.'/'.$imgID.'_'.$secret.'_'.$thumbnailsize.'.jpg" width="100%" /></a>';
					echo '</div>';
				}
			?>
			</div>
		</div>
	</div>
</body>
</html>