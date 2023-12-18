<?php

class MultiBlock
{

    //mborder function 

    public function order()
    {
        global $counterOrder;

        if ($counterOrder == '') {
            $counterOrder = 0;
        };

        echo "data-id='" . $counterOrder . "' ";
        $counterOrder++;
    }


    //mbtext 

    public function text($value)
    {
        global $getmb;
        if (isset($getmb->$value)) {
            echo $getmb->$value;
        }
    }

    public function date($value, $format)
    {
        global $getmb;
        if (isset($getmb->$value)) {

            $string = $getmb->$value;
            $timestamp = strtotime($string);
            $newFormat = date($format, $timestamp);
            echo $newFormat;
        }
    }

    public function r_text($value)
    {
        global $getmb;
        return (string)$getmb->$value;
    }

    public function showhide($value)
    {

        global $getmb;

        $val = @$getmb->$value;
        $name = $getmb->namemultiblock;

        global $counterShowHide;

        if ($val !== '') {
            echo $val;
        } else {

            echo '<span data-hide="' . $name . '"></span>';
            echo '<script>
            document.querySelector(`[data-hide="' . $name . '"]`).parentElement.remove();
            </script>';

            $counterShowHide++;
        }
    }

    //mbvalue 

    public function value($value)
    {
        global $getmb;
        if (isset($getmb->$value)) {
            echo html_entity_decode($getmb->$value);
        };
    }


    public function r_value($value)
    {
        global $getmb;
        if (isset($getmb->$value)) {
            return html_entity_decode($getmb->$value);
        };
    }

    //dropdown 

    public function mbdropdown($value)
    {
        global $getmb;
        echo  @str_replace("^", " ", $getmb->$value);
    }

    //thumb

    public function thumb($value, $width)
    {

        global $getmb;
        global $SITEURL;

        $file = file_get_contents($getmb->$value);

        $folder = GSDATAOTHERPATH . "multiBlock/thumb/";


        if (file_exists($folder) == null) {
            mkdir($folder, 0755);
            file_put_contents($folder . '.htaccess', 'Allow from all');
        };

        $extension =  pathinfo($getmb->$value, PATHINFO_EXTENSION);

        $base = pathinfo($getmb->$value, PATHINFO_BASENAME);

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
};;
