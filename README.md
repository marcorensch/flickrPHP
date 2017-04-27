# flickrPHP
PHP Script which loads a certain flickr Photoset / Gallery in a Multicolumn Site. Uses Fancybox JS to show large versions of the image onclick. Fallback for multiple image sizes. Local Caching with JSON file.

<a href="http://beta.nx-designs.ch/flickr/phpflickr/flickrPHP_large.php" target="_blank">Live Demo with more then 250 Images (Cached)</a>

## Requirements
Server running PHP Version 7.x
flickr Account (to obtain an API Key)
flickr API Key (<a href="https://www.flickr.com/services/apps/create/apply" target="_blank">get one here</a>)

## Used JS Frameworks
- jQuery 3.x
- yootheme uikit 3 (beta 22)
- Fancybox 3

## Detail
- Responsive Grid System for Galleryview
- API-Key is stored as PHP Var
  - If showinfo is turned off Users cant see your flickr API Key
- Lightbox with Fancybox 3
- Scriptcheck for different Imagesizes (Lightbox) Best will be used
  - Large 2048
  - Large 1600
  - Large 1024
  - Fallback: Original
- Debug Output

## Settings
### showdebug
#### true / false
Displays Additional Informations & Pastes Info direct on Page.
### showinfo
#### true / false
Displays Connection Informations in a grey Box on Top of the Gallery.
### API Key
#### String
You need your own API Key to use the flickr API. You can get your flickr API Key <a href="https://www.flickr.com/services/apps/create/apply" target="_blank">here</a> for free.
### Photoset ID
#### String
The ID of the desired Gallery you would like to show. You can find the Gallery / Photoset ID directly on flickr. Just copy the ID from the URL: .../149621562@N02/albums/<b>72157682900004326</b>. For example 72157682900004326 is the Gallery ID you can use.

## Cache
To limit the flickr connections to a minimum the script creates a local cache for your photosets & images. The flickr responses are stored in .JSON Files. The Files can be found under cache/"galleryID"/...
Because of the Caching procedure it could happen that the first Pageload can take a long time. Please be patient and if you receive an error message just reload the page. The script continues and load the necessary informations from flickr.
The Script demands from flickr the gallery Informations and the imagesize informations for each photo.
Once the Cache is created the Site loads quick depending on the amount of images you have in your gallery. In our example you can see a gallery with more then 250 Pictures.
  
