<?php

namespace App\Lib;

class Imgur {

  // Upload image
  public static function upload($image) {
      $access_token = env('IMGUR_ACCESS_TOKEN');

      // Set the options
      $options = array(
        'http' => array(
          'method' => 'POST',
          'header' => 'Authorization: Bearer ' . $access_token,
          'Content-type' => 'application/x-www-form-urlencoded',
          'content' => $image
        )
      );
      // Create context
      $context = stream_context_create($options);
      // Set imgur URL
      $imgurURL = 'https://api.imgur.com/3/image?album=BkPCv70';
      // Get the response, decode JSON
      $response = @file_get_contents($imgurURL, false, $context);
      $response = json_decode($response);

      // Return the link
      return $response->data->link;
  }

  // Delete image
  public static function delete($imageLink) {
    $access_token = env('IMGUR_ACCESS_TOKEN');

    // Extract image id
    $imageID = substr($imageLink, 20, 7);
    // Set the options
    $options = array(
      'http' => array(
        'method' => 'DELETE',
        'header' => 'Authorization: Bearer ' . $access_token
      )
    );
    // Create context
    $context = stream_context_create($options);
    // Set imgur URL
    $imgurURL = 'https://api.imgur.com/3/image/'.$imageID;
    // Response
    $response = @file_get_contents($imgurURL, false, $context);
  }

}
?>
