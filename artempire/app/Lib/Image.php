<?php

namespace App\Lib;

use \Cloudinary;
use \Cloudinary\Uploader;

class Image
{
    public static $defaultProfile = 'https://res.cloudinary.com/markowebdev-com/image/upload/v1584615714/artempire/profiles/default.png';
    public static $defaultBackground = 'https://res.cloudinary.com/markowebdev-com/image/upload/v1584534850/artempire/backgrounds/default.jpg';

    public static function upload($image, $folder)
    {
        $folder = 'artempire/'.$folder;

        Cloudinary::config([
          'cloud_name' => env('CLOUDINARY_CLOUD_NAME'),
          'api_key' => env('CLOUDINARY_API_KEY'),
          'api_secret' => env('CLOUDINARY_API_SECRET'),
          'secure' => true
        ]);

        $response =  Uploader::upload($image, ['folder' => $folder]);

        return $response['secure_url'];
    }

    public static function delete($url, $folder)
    {
        Cloudinary::config([
          'cloud_name' => env('CLOUDINARY_CLOUD_NAME'),
          'api_key' => env('CLOUDINARY_API_KEY'),
          'api_secret' => env('CLOUDINARY_API_SECRET'),
          'secure' => true
        ]);

        $position = strrpos($url, '/') + 1;
        $imageName = substr($url, $position);
        $publicID = preg_replace('/\.(png|jpg|jpeg|gif)$/', '', $imageName);

        return Uploader::destroy("artempire/$folder/$publicID");
    }
}
