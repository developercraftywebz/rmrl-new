<?php

namespace App\Helpers;

use App\Models\User;
use Carbon\Carbon;
use Auth;
use Illuminate\Http\UploadedFile;
use Intervention\Image\Facades\Image;

class Media
{
    public static function profileAvatar($picture)
    {
        $file_name = time();
        $file_name .= rand();
        $file_name = sha1($file_name);
        if ($picture) {
            $ext = $picture->getClientOriginalExtension();
            $picture->move(public_path() . "/uploads" . "/users/" . Auth::user()->id . "/profile_avatar/", $file_name . "." . $ext);
            $local_url = $file_name . "." . $ext;

            $url = '/uploads/users/' . Auth::user()->id . '/profile_avatar/' . $local_url;

            return $url;
        }
        return "";
    }

    public static function RemoveFile($file_link)
    {
        $file_path = public_path() . $file_link;
        return file_exists($file_path) ? (unlink($file_path) ? true : false) : false;
    }

    public static function  SaveFile($media, $extension, $dir)
    {
        ini_set('memory_limit', '1024M');
        ini_set('post_max_size', '8M');
        ini_set('upload_max_filesize', '8M');


        $filename = rand(1111, 9999999) . '.' . $extension;
        $link = env('APP_STORAGE_MEDIA_LINK') . $dir;
        $path = public_path() . $link;

        is_dir($path) ? '' : mkdir($path, 0777, true);
        $file_path = $path . $filename;
        $file_link = $link . $filename;

        return Image::make($media)->save($file_path) ? $file_link : null;
    }

    public static function convertFullUrl($url)
    {
        if ($url) {
            return asset($url);
        }
        return asset("/images/default.jpeg");
    }

    public static function uploadLeadAsset($picture, $lead_id)
    {
        $file_name = time();
        $file_name .= rand();
        $file_name = sha1($file_name);
        if ($picture) {
            $ext = $picture->getClientOriginalExtension();
            $picture->move(public_path() . "/uploads" . "/leads/" . $lead_id . "/", $file_name . "." . $ext);
            $local_url = $file_name . "." . $ext;

            $url = '/uploads/leads/' . $lead_id . '/' . $local_url;

            return $url;
        }
        return "";
    }


    public static function uploadMedia($picture)
    {
        $file_name = time();
        $file_name .= rand();
        $file_name = sha1($file_name);
        if ($picture) {
            $ext = $picture->getClientOriginalExtension();
            $picture->move(public_path() . "/uploads" . "/media" . "/user_media/", $file_name . "." . $ext);
            $local_url = $file_name . "." . $ext;
            $url = '/uploads/media' . '/user_media/' . $local_url;
            return $url;
        }
        return "";
    }

    public static function fileUpload($file)
    {
        $file_name = time();
        $file_name .= rand();
        $file_name = sha1($file_name);
        if ($file) {
            $ext = $file->getClientOriginalExtension();
            $file->move(public_path() . "/uploads" . "/files", $file_name . "." . $ext);
            $local_url = $file_name . "." . $ext;
            $url = '/uploads/files/' . $local_url;
            return $url;
        }
        return "";
    }

    public static function uploadImage(UploadedFile $file, $dir)
    {
        try {

        ini_set('post_max_size', '1024M');

            // Validate the uploaded file
            if (!$file->isValid()) {
                throw new \InvalidArgumentException('Invalid file uploaded');
            }

            // Generate a unique filename
            $filename = time() . '_' . $file->getClientOriginalName();

            // Use Laravel's Storage to store the file
            $path = $file->storeAs($dir, $filename, 'public');

            // Return the file path
            return $path;
        } catch (\Exception $e) {
            // Handle any exceptions that occur during the process
            error_log('Error in uploadImage: ' . $e->getMessage());
            return null;
        }
    }

}
