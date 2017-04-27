<?php
// Helper File

// Function for Console Output
	
function debug_to_console( $data ) {
	$output = $data;
	if ( is_array( $output ) )
	$output = implode( ',', $output);

	echo "<script>console.log( 'Debug Information: " . $output . "' );</script>";
}



if($apikey == ''){
	$noapikeywarn = '<div class="nx-block nx-center nx-warning"><b>WARNING</b><br>Your API Key is not set. Please enter your Flickr API Key in the settings.<br>You can get an API Key <a href="https://www.flickr.com/services/api/misc.api_keys.html" target="_blank">here</a></div>';
	echo $noapikeywarn;
	alert($noapikeywarn);	
}
if($photosetID == ''){
	$nosetidwarn = '<div class="nx-block nx-center nx-warning"><b>WARNING</b><br>There is no Photoset ID given. Please enter a Flickr Photoset ID in the settings.</div>';
	echo $nosetidwarn;
	alert($nosetidwarn);	
}

function setvar($type,$url){
	// use global var's
	global $photoset_array;
	global $photoset_JSON_url;
	global $photoset_length;
	global $photoset_title;

	$response = json_decode(file_get_contents($url));
	switch($type){
		case 1:		// Get Gallery Informations (photoarray,length, title)
			$photoset_JSON_url = $url;
			$photoset_array = $response->photoset->photo;
			$photoset_length = $response->photoset->total;
			$photoset_title = $response->photoset->title;
			break;
		case 2:		// nothing to do if we start the function with the JSON for imagesizes
			return $response;
			break;
	}
}

checkCache(1,$photosetID,$apikey);

function checkCache($type,$ID,$apikey){
	global $showdebug;
	global $photosetID;
	switch($type){
		case 1:		// set $file path if we check for photoset informations
			$file = "cache/$photosetID/photoset_$ID.json";
			break;
		case 2:		// set $file path if we check for image informations
			$file = "cache/$photosetID/img_$ID.json";
			break;
	}
	if (file_exists($file)) {
		if($showdebug){
			debug_to_console( "The File $file exists already");
		}
		$response = setvar($type,$file);
	} else {
		if($showdebug){
			debug_to_console( "The File $file does not exist");
		}
		// if file does not exists get the informations and create it
		$filecreated = createCache($type,$ID,$apikey);
		$response = setvar($type, $filecreated);
		if($showdebug){print_r($response);}
	}
	if($type == 2){
		// if we use the function for image informations get now the large Image URL from the JSON
		$imglargeurl = getZoomedIMG($response);
		return $imglargeurl;	
	}
}
// creates the JSON Files into the chache folder
function createCache($type,$ID,$apikey){
	global $photosetID;
	global $showdebug;

	switch ($type){
		case 1:		// create folder & file for the photoset informations
			global $photoset_url;
			$photoset_url = "https://api.flickr.com/services/rest/?method=flickr.photosets.getPhotos&api_key=$apikey&photoset_id=$ID&format=json&nojsoncallback=1";
			$photoset = json_decode(file_get_contents($photoset_url),true);
			if (!file_exists('cache/'.$photosetID)) {
				mkdir('cache/'.$photosetID, 0777, true);
			}
			$fp = fopen('cache/'.$photosetID.'/photoset_'.$ID.'.json', 'w');
			fwrite($fp, json_encode($photoset));
			fclose($fp);
			$filecreated = "cache/$photosetID/photoset_$ID.json"; // "cache/123456789/photoset_987654321.json"
			break;
		case 2:		// create file for image informations (each image has its own .JSON File)
			$url = "https://api.flickr.com/services/rest/?method=flickr.photos.getSizes&api_key=$apikey&photo_id=$ID&format=json&nojsoncallback=1";
			$sizesArray = json_decode(file_get_contents($url),true);
			$fp = fopen('cache/'.$photosetID.'/img_'.$ID.'.json', 'w');
			fwrite($fp, json_encode($sizesArray));
			fclose($fp);
			$filecreated = "cache/$photosetID/img_$ID.json"; // "cache/123456789/img_987654321.json"
			break;
	}
	if($showdebug){debug_to_console( "The File $filecreated was successfully created");}
	return($filecreated);
}

function getZoomedIMG($imgDetails){
	global $showdebug;
	if (in_array("Large 2048", array_column($imgDetails->sizes->size, 'label'))) {
		if($showdebug){echo 'Large 2048 is available<br>';}

		$key = array_search('Large 2048', array_column($imgDetails->sizes->size, 'label'));
		if($showdebug){echo 'Large 2048 is available on position '.$key.'<br>';}

		$imglargeurl = $imgDetails->sizes->size[$key]->source;

		if($showdebug){echo '<a href="'.$imglargeurl.'" target="_blank">'.$imglargeurl.'</a>';}

	}elseif(in_array("Large 1600", array_column($imgDetails->sizes->size, 'label'))){
		if($showdebug){echo 'Large 1600 is available<br>';}

		$key = array_search('Large 1600', array_column($imgDetails->sizes->size, 'label'));
		if($showdebug){echo 'Large 1600 is available on position '.$key.'<br>';}

		$imglargeurl = $imgDetails->sizes->size[$key]->source;

		if($showdebug){echo '<a href="'.$imglargeurl.'" target="_blank">'.$imglargeurl.'</a>';}
	}elseif(in_array("Large 1024", array_column($imgDetails->sizes->size, 'label'))){
		if($showdebug){echo 'Large 1024 is available<br>';}

		$key = array_search('Large 1024', array_column($imgDetails->sizes->size, 'label'));
		if($showdebug){echo 'Large 1024 is available on position '.$key.'<br>';}

		$imglargeurl = $imgDetails->sizes->size[$key]->source;

		if($showdebug){echo '<a href="'.$imglargeurl.'" target="_blank">'.$imglargeurl.'</a>';}
	}elseif(in_array("Original", array_column($imgDetails->sizes->size, 'label'))){
		if($showdebug){echo 'Original is available<br>';}

		$key = array_search('Original', array_column($imgDetails->sizes->size, 'label'));
		if($showdebug){echo 'Original is available on position '.$key.'<br>';}

		$imglargeurl = $imgDetails->sizes->size[$key]->source;

		if($showdebug){echo '<a href="'.$imglargeurl.'" target="_blank">'.$imglargeurl.'</a>';}
	}else{
		$imglargeurl = '';
		if($showdebug){debug_to_console('There where no large images available');}
	}
	return $imglargeurl;
}
?>