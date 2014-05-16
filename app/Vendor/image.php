<?php
/**
 * Naxasius : a CakePHP powered Game Engine to create a MMORPG (http://www.naxasius.com)
 * Copyright 2009-2010, Fellicht (http://www.fellicht.nl)
 *
 * Licensed under Creative Commons 3.0
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright	Copyright 2009-2010, Fellicht (http://www.fellicht.nl)
 * @link		http://www.naxasius.com Game Engine to create a Browser MMORPG
 * @author		Mathieu (mathieu@fellicht.nl)
 * @license		Creative Commons 3.0 (http://creativecommons.org/licenses/by/3.0/)
 */
class Image {
	var $name = 'Image';

	function Image() {

	}

	function resize($filein, $fileout, $imagethumbsize_w, $imagethumbsize_h) {
		// Get new dimensions
		list($width_orig, $height_orig) = getimagesize($filein);

		   if(preg_match("/.jpg/i", "$filein"))
		   {
		       $format = 'image/jpeg';
		   }
		   if(preg_match("/.jpeg/i", "$filein"))
		   {
		       $format = 'image/jpeg';
		   }
		   if (preg_match("/.gif/i", "$filein"))
		   {
		       $format = 'image/gif';
		   }
		   if(preg_match("/.png/i", "$filein"))
		   {
		       $format = 'image/png';
		   }

	       switch($format)
	       {
	           case 'image/jpeg':
	           $image = imagecreatefromjpeg($filein);
	           break;
	           case 'image/gif';
	           $image = imagecreatefromgif($filein);
	           break;
	           case 'image/png':
	           $image = imagecreatefrompng($filein);
	           break;
	       }

		$width = $imagethumbsize_w ;
		$height = $imagethumbsize_h ;
		list($width_orig, $height_orig) = getimagesize($filein);

		if ($width_orig < $height_orig) {
		  $height = ($imagethumbsize_w / $width_orig) * $height_orig;
		} else {
		    $width = ($imagethumbsize_h / $height_orig) * $width_orig;
		}

		if ($width < $imagethumbsize_w)
		//if the width is smaller than supplied thumbnail size
		{
		$width = $imagethumbsize_w;
		$height = ($imagethumbsize_w/ $width_orig) * $height_orig;;
		}

		if ($height < $imagethumbsize_h)
		//if the height is smaller than supplied thumbnail size
		{
		$height = $imagethumbsize_h;
		$width = ($imagethumbsize_h / $height_orig) * $width_orig;
		}

		$thumb = imagecreatetruecolor($width , $height);
		$bgcolor = imagecolorallocate($thumb, 255, 255, 255);
		ImageFilledRectangle($thumb, 0, 0, $width, $height, $bgcolor);
		imagealphablending($thumb, true);

		imagecopyresampled($thumb, $image, 0, 0, 0, 0,
		$width, $height, $width_orig, $height_orig);
		$thumb2 = imagecreatetruecolor($imagethumbsize_w , $imagethumbsize_h);
		// true color for best quality
		$bgcolor = imagecolorallocate($thumb2, 255, 255, 255);
		ImageFilledRectangle($thumb2, 0, 0,
		$imagethumbsize_w , $imagethumbsize_h , $bgcolor);
		imagealphablending($thumb2, true);

		$w1 =($width/2) - ($imagethumbsize_w/2);
		$h1 = ($height/2) - ($imagethumbsize_h/2);

		imagecopyresampled($thumb2, $thumb, 0,0, $w1, $h1,
		$imagethumbsize_w , $imagethumbsize_h ,$imagethumbsize_w, $imagethumbsize_h);

		// Output
		//header('Content-type: image/gif');
		//imagegif($thumb); //output to browser first image when testing

		switch($format)
       {
           case 'image/jpeg':
           $image = imagejpeg($thumb2, $fileout, 100);
           break;
           case 'image/gif';
           $image = imagegif($thumb2, $fileout);
           break;
           case 'image/png':
           imagesavealpha($thumb2, true);
           $image = imagepng($thumb2, $fileout);
           break;
       }
       return true;
	}

    function imagecopymerge_alpha($dst_im, $src_im, $dst_x, $dst_y, $src_x, $src_y, $src_w, $src_h, $pct){
        $opacity=$pct;
        // getting the watermark width
        $w = imagesx($src_im);
        // getting the watermark height
        $h = imagesy($src_im);

        // creating a cut resource
        $cut = imagecreatetruecolor($src_w, $src_h);
        // copying that section of the background to the cut
        imagecopy($cut, $dst_im, 0, 0, $dst_x, $dst_y, $src_w, $src_h);
        // inverting the opacity
        $opacity = 100 - $opacity;

        // placing the watermark now
        imagecopy($cut, $src_im, 0, 0, $src_x, $src_y, $src_w, $src_h);
        imagecopymerge($dst_im, $cut, $dst_x, $dst_y, $src_x, $src_y, $src_w, $src_h, $opacity);
    }
}
?>