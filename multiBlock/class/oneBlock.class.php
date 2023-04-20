<?php

class OneBlock
{


    public function get($category, $name, $input)
    {
        $value = GSDATAOTHERPATH . 'oneBlock/' . $category . '/' . $name . '.json';
        $files = file_get_contents($value);
        $json = json_decode($files);
        echo $json->$input;
    }

    public function wysywig($category, $name, $input)
    {
        $value = GSDATAOTHERPATH . 'oneBlock/' . $category . '/' . $name . '.json';
        $files = file_get_contents($value);
        $json = json_decode($files);
        echo html_entity_decode($json->$input);
    }


    public function thumb($category, $name, $input, $width)
    {
        $value = GSDATAOTHERPATH . 'oneBlock/' . $category . '/' . $name . '.json';
        $files = file_get_contents($value);
        $json = json_decode($files);

        $img = $json->$input;

        global $SITEURL;

        $file = file_get_contents($img);


        $folder = GSDATAOTHERPATH . "multiBlock/thumb/";


        if (file_exists($folder) == null) {
            mkdir($folder, 0755);
            file_put_contents($folder . '.htaccess', 'Allow from all');
        };

        $extension =  pathinfo($img, PATHINFO_EXTENSION);

        $base = pathinfo($img, PATHINFO_BASENAME);

        $finalfile = $folder . $width . "-" . $base;


        if (file_exists($finalfile)) {
        } else {

            $origPic = imagecreatefromstring($file);

            $width_orig = imagesx($origPic);
            $height_orig = imagesy($origPic);

            $height = $height_orig  * 1.77;

            $ratio_orig = $width_orig / $height_orig;

            if ($width / $height > $ratio_orig) {
                $width = $height * $ratio_orig;
            } else {
                $height = $width / $ratio_orig;
            }

            $thumbnail = imagecreatetruecolor($width, $height);

            imagecopyresampled($thumbnail, $origPic, 0, 0, 0, 0, $width, $height, $width_orig, $height_orig);

            if ($extension == 'jpeg' || $extension == 'jpg') {
                imagejpeg($thumbnail, $finalfile);
            } elseif ($extension == 'png') {
                imagepng($thumbnail, $finalfile);
            } elseif ($extension == 'webp') {
                imagewebp($thumbnail, $finalfile);
            } elseif ($extension == 'gif') {
                imagegif($thumbnail, $finalfile);
            } elseif ($extension == 'bmp') {
                imagebmp($thumbnail, $finalfile);
            } else {
                imagejpeg($thumbnail, $finalfile);
            }

            imagedestroy($origPic);
            imagedestroy($thumbnail);
        };

        echo str_replace(GSDATAOTHERPATH, $SITEURL . 'data/other/', $finalfile);
    }
};
