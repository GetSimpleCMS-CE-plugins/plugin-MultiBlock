<?php

class BackBlock
{

    public function cleanThumb()
    {
        $imager = glob(GSDATAOTHERPATH . 'multiBlock/thumb/*', GLOB_BRACE);
        foreach ($imager as $img) {
            unlink($img);
        };
    }


    // multiblock function backend;


    public function saveCatMulti()
    {

        $costa = '[';



        foreach ($_POST['label'] as $key => $value) {

            if ($key > 0) {
                $costa .= ',';
            }

            $costa .= json_encode([
                'name' => $_POST['categorytitle'],
                'key' => $key,
                'title' => $_POST['title'][$key],
                'label' => str_replace(" ", "-", strtolower($_POST['label'][$key])),
                'value' => $_POST['value'][$key],
                'select' => $_POST['select'][$key],
            ], true);
        };

        $costa .= ']';

        if (isset($_POST['savecat'])) {
            $categoryname = str_replace(" ", "-", $_POST['categoryname']);
        } else {
            $categoryname = str_replace(" ", "-", $_GET['categoryname']);
        }

        $templatedata = @$_POST['template'];



        $folder        = GSDATAOTHERPATH . '/multiBlock/category/';
        $filename      = $folder . $categoryname . '.json';
        $template    = $folder . $categoryname . '.txt';
        $chmod_mode    = 0755;
        $folder_exists = file_exists($folder) || mkdir($folder, $chmod_mode, true);

        // Save the file (assuming that the folder indeed exists)
        if ($folder_exists) {
            file_put_contents($filename, $costa);
            file_put_contents($template, $templatedata);
            echo ("<meta http-equiv='refresh' content='0'>");
        }

        if ($_POST['check'] !== $_POST['categoryname']) {
            rename(GSDATAOTHERPATH . '/multiBlock/category/' . str_replace(" ", "-", $_POST['check']) . '.json', GSDATAOTHERPATH . '/multiBlock/category/' . str_replace(" ", "-", $_POST['categoryname']) . '.json');
            rename(GSDATAOTHERPATH . '/multiBlock/category/' . str_replace(" ", "-", $_POST['check']) . '.txt', GSDATAOTHERPATH . '/multiBlock/category/' . str_replace(" ", "-", $_POST['categoryname']) . '.txt');
        };

        echo ("<meta http-equiv='refresh' content='0'>");
    }


    //save cat one


    public function saveCatOne()
    {

        $costa = '[';

        foreach ($_POST['label'] as $key => $value) {

            if ($key > 0) {
                $costa .= ',';
            }

            $costa .= json_encode([
                'name' => $_POST['categorytitle'],
                'key' => $key,
                'title' => $_POST['title'][$key],
                'label' => str_replace(" ", "-", strtolower($_POST['label'][$key])),
                'value' => $_POST['value'][$key],
                'select' => $_POST['select'][$key],
            ], true);
        };

        $costa .= ']';

        if (isset($_POST['savecat'])) {
            $categoryname = str_replace(" ", "-", $_POST['categoryname']);
        } else {
            $categoryname = str_replace(" ", "-", $_GET['categoryname']);
        }

        $templatedata = @$_POST['template'];

        $folder        = GSDATAOTHERPATH . '/oneBlock/category/';
        $filename      = $folder . $categoryname . '.json';

        $chmod_mode    = 0755;
        $folder_exists = file_exists($folder) || mkdir($folder, $chmod_mode, true);

        // Save the file (assuming that the folder indeed exists)
        if ($folder_exists) {
            file_put_contents($filename, $costa);
            echo ("<meta http-equiv='refresh' content='0'>");
        }

        if ($_POST['check'] !== $_POST['categoryname']) {
            rename(GSDATAOTHERPATH . '/oneBlock/category/' . str_replace(" ", "-", $_POST['check']) . '.json', GSDATAOTHERPATH . '/oneBlock/category/' . str_replace(" ", "-", $_POST['categoryname']) . '.json');
        };

        echo ("<meta http-equiv='refresh' content='0'>");
    }


    //new block multiblock options

    public function newBlockOptions()
    {

        $cat = @file_get_contents(GSDATAOTHERPATH . 'multiBlock/category/' . str_replace(" ", "-", $_GET['newmulticategory']) . '.json');
        $multicategory = json_decode($cat);

        $multicategory = $multicategory == '' ? [] : $multicategory;

        $count = 0;

        foreach ($multicategory as $category) {
            $nis = str_replace(" ", "", $category->label);

            if (isset($dater)) {
                $valer = $dater->$nis;
            } else {
                $valer = $category->value;
            }

            if ($category->select == 'wysywig') {

                echo '<p style="margin: 0;
					margin:0;
					margin-top: 20px;
					font-weight: 400px;
					font-size: 15px;
					margin-bottom:5px;">' . $category->title . ' :</p>
			 
					<textarea id="post-content" name="' . str_replace(" ", "", $category->label) . '" style="width:100%;display:block;height:250px;" class="mbinput">' . html_entity_decode($valer) . '</textarea>
					';
            } elseif ($category->select == 'image') {

                global $SITEURL;

                echo '<span class="formedit">';
                echo '<p style="margin: 0;
						margin-top: 0px;
						margin-top: 20px;
						font-weight: 400px;
						font-size: 15px;">' . $category->title . ' :</p>

						<div class="mb_img">';
                if ($valer !== 'undefined') {
                    echo ' <img src="' . $valer . '" style="width:80px;height:80px;object-fit:cover;">';
                };

                echo '
							<input type="text" class="mb_foto foto mbinput" name="' . str_replace(" ", "", $category->label) . '" value="' . $valer . '">
							<button class="mb_fotobtn choose-image">' . i18n_r("multiBlock/CHOOSEIMAGE") . '</button>
						</div>
						';

                echo "</span>";
            } elseif ($category->select == 'textarea') {

                echo '<p style="margin: 0;
					margin-top: 0px;
					margin-top: 20px;
					font-weight: 400px;
					font-size: 15px;display:inline-block;">' . $category->title . ' :</p>.
					
					<textarea class="mbinput" style="width:100%;height:250px;" name="' . str_replace(" ", "", $category->label) . '">' . html_entity_decode($valer) . '</textarea>';
            } elseif ($category->select == 'dropdown') {

                $ars = explode('|', $category->value);

                echo '<p style="margin: 0;
					margin-top: 0px;
					margin-top: 20px;
					font-weight: 400px;
					font-size: 15px;display:inline-block;">' . $category->title . ' :</p>';

                echo '<select style="width:100%;padding:10px;" class="' . str_replace(" ", "", $category->label) . '" name="' . str_replace(" ", "", $category->label) . '">';

                foreach ($ars as $sel) {
                    echo '<option value="' . str_replace(" ", "^", $sel) . '" >' . $sel . '</option>';
                }

                echo '</select>';

                echo '<script>
						document.querySelector("select.' . str_replace(" ", "", $category->label) . '").value = "' . str_replace(" ", "^", $valer) . '"; 
					</script>';
            } elseif ($category->select == 'link') {

                echo '
					<p style="margin: 0;
					margin:0;
					margin-top: 20px;
					font-weight: 400px;
					font-size: 15px;">' . $category->title . ' :</p> 
					<select style="width:100%;padding:15px;display:block;border:solid 1px #ddd; background:#fff;margin-top:10px;" class="' . str_replace(" ", "", $category->label) . '" name="' . str_replace(" ", "", $category->label) . '">';

                foreach (glob(GSDATAPAGESPATH . "*.{xml}", GLOB_BRACE) as $page) {

                    $path_parts = pathinfo($page);

                    global $SITEURL;

                    echo "<option value='" . $SITEURL . $path_parts['filename'] . "'  >" . $path_parts['filename'] . "</option>";
                };

                echo '</select>';

                echo '<script> document.querySelector("select.' . $category->label . '").value = "' . $valer . '"; </script>';
            } else {

                echo '<p style="margin: 0;
					margin:0;
					margin-top: 20px;
					font-weight: 400px;
					font-size: 15px;">' . $category->title . ' :</p>

					<input class="mbinput" type="' . $category->select . '" name="' . str_replace(" ", "", $category->label) . '" value="' . html_entity_decode($valer) . '">
					';
            }
        }
    }

    //saveMultiBlock

    public function saveMultiBlock()
    {
        $costa = '{';

        foreach ($_POST as $key => $value) {

            if ($coner > 0) {
                $costa .= ',';
            }

            $costa .= '"' . $key . '":"' . trim(preg_replace('/\s\s+/', ' ', htmlentities($value))) . '"';

            $coner++;
        };

        $costa .= '}';

        $owncategory = $_GET['newmulticategory'];

        $name = str_replace(" ", "-", $_POST['name']);

        $folder        = GSDATAOTHERPATH . 'multiBlock/' . $owncategory . '/';
        $filename      = $folder . $name . '.json';
        $chmod_mode    = 0755;
        $folder_exists = file_exists($folder) || mkdir($folder, $chmod_mode);

        // Save the file (assuming that the folder indeed exists)
        if ($folder_exists) {
            file_put_contents($filename, $costa);
            echo ("<meta http-equiv='refresh' content='0'>");
        }

        if ($_POST['nameolder'] !== '') {
            if ($_POST['nameolder'] !== $_POST['name']) {

                rename($folder . str_replace(" ", "-", $_POST['nameolder']) . '.json', $folder . str_replace(" ", "-", $_POST['name']) . '.json');
            };
        }

        echo ("<meta http-equiv='refresh' content='0'>");
    }


    //saveOneBlock 


    public function saveOneBlock()
    {

        $costa = '{';

        foreach ($_POST as $key => $value) {

            if ($coner > 0) {
                $costa .= ',';
            }

            $costa .= '"' . $key . '":"' . trim(preg_replace('/\s\s+/', ' ', htmlentities($value))) . '"';

            $coner++;
        };

        $costa .= '}';

        $owncategory = $_GET['newmulticategory'];

        $name = str_replace(" ", "-", $_POST['name']);

        $folder        = GSDATAOTHERPATH . 'oneBlock/' . $owncategory . '/';
        $filename      = $folder . $name . '.json';
        $chmod_mode    = 0755;
        $folder_exists = file_exists($folder) || mkdir($folder, $chmod_mode);

        // Save the file (assuming that the folder indeed exists)
        if ($folder_exists) {
            file_put_contents($filename, $costa);

            echo ("<meta http-equiv='refresh' content='0'>");
        }

        if ($_POST['nameolder'] !== '') {
            if ($_POST['nameolder'] !== $_POST['name']) {

                rename($folder . str_replace(" ", "-", $_POST['nameolder']) . '.json', $folder . str_replace(" ", "-", $_POST['name']) . '.json');
            };
        }

        echo ("<meta http-equiv='refresh' content='0'>");
    }


    //save order


    public function saveOrder()
    {
        $owncategory = $_GET['newmulticategory'];
        $arrayinfo = $_POST['array'];

        $folder        = GSDATAOTHERPATH . 'multiBlock/' . $owncategory . '/';
        $filename      = $folder . 'order.txt';
        $chmod_mode    = 0755;
        $folder_exists = file_exists($folder) || mkdir($folder, $chmod_mode);

        // Save the file (assuming that the folder indeed exists)
        if ($folder_exists) {
            file_put_contents($filename, $arrayinfo);
        }
        echo ("<meta http-equiv='refresh' content='0'>");
    }
};
