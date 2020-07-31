<?php
namespace App\Helpers;
use Image;

class ImageHelper
{
    static public function resizeImage($image, $width, $height)
    {
        return Image::make($image)->resize($width, $height);

    }


}