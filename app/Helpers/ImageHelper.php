<?php
namespace App\Helpers;
use Illuminate\Support\Facades\Storage;
use Image;

class ImageHelper
{
    static public function resizeImage($image, $width, $height)
    {
        return Image::make($image)->resize($width, $height);

    }

    static public function storeProfileImage($image, $picOption)
    {

        $resizedImage = $picOption == 'profile_pic' ? ImageHelper::resizeImage($image, 100, 100) : ImageHelper::resizeImage($image, 750, 200);

        $imageName = md5($image->getClientOriginalName());

        $directoryPath = "images/{$picOption}/".auth()->user()->id;

        Storage::deleteDirectory($directoryPath);
        Storage::makeDirectory($directoryPath);

        $dbPath = "$directoryPath/$imageName.png";
        $savedPath = public_path("storage/$dbPath");

        //Save image
        $resizedImage->save($savedPath);

        return $dbPath;

    }


}