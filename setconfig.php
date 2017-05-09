<?php
if($loadfrontendframework):
	switch ($framework){
		case 'uikit':
			$frameworklink = 'src="https://cdnjs.cloudflare.com/ajax/libs/uikit/3.0.0-beta.22/js/uikit.min.js"';
			$stylesheetlink = 'href="https://cdnjs.cloudflare.com/ajax/libs/uikit/3.0.0-beta.22/css/uikit.min.css"';
			$outerdiv = 'uk-child-width-1-'.$columns;
			$gridelement = '';
			$infoboxclass = 'uk-width-1-1';
			break;
		case 'Bootstrap':
			switch ($columns){
				case 1: $bswidth = 12; break;
				case 2: $bswidth = 6; break;
				case 3: $bswidth = 4; break;
				case 4: $bswidth = 3; break;
				case 6: $bswidth = 2; break;
				case 12: $bswidth = 1; break;
			}
			$frameworklink = 'src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"';
			$stylesheetlink = 'href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous"';
			$outerdiv = 'row';
			$gridelement = 'col-sm-'.$bswidth;
			$infoboxclass = 'col-sm-12';
			break;
		default :
			$frameworklink = '';
			$stylesheetlink = '';
			$outerdiv = '';
			$gridelement = '';
			break;
	}
endif;
// Prepare for PopUp
if($enablepopups){
	switch($grouping){
		case true :
			$lightbox = 'data-fancybox="group"';
			break;
		case false:
			$lightbox = 'data-fancybox=""';
			break;
	}
}else{
		$lightbox = '';
	}
?>