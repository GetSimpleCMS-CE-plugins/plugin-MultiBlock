<?php

class BackBlock
{
    public function cleanThumb()
    {
        $imager = glob(GSDATAOTHERPATH . 'multiBlock/thumb/*', GLOB_BRACE);
        foreach ($imager as $img) {
            unlink($img);
        }
    }

    public function saveCatMulti()
    {
        $costa = [];

        if (isset($_POST['label']) && is_array($_POST['label'])) {
            foreach ($_POST['label'] as $key => $value) {
                $costa[] = [
                    'name' => isset($_POST['categorytitle']) ? htmlspecialchars($_POST['categorytitle'], ENT_QUOTES, 'UTF-8') : '',
                    'key' => (int) $key,
                    'title' => isset($_POST['title'][$key]) ? htmlspecialchars($_POST['title'][$key], ENT_QUOTES, 'UTF-8') : '',
                    'label' => isset($_POST['label'][$key]) ? str_replace(" ", "-", strtolower(trim($_POST['label'][$key]))) : '',
                    'value' => isset($_POST['value'][$key]) ? htmlspecialchars($_POST['value'][$key], ENT_QUOTES, 'UTF-8') : '',
                    'select' => isset($_POST['select'][$key]) ? htmlspecialchars($_POST['select'][$key], ENT_QUOTES, 'UTF-8') : ''
                ];
            }
        }

        $costaJson = json_encode($costa, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);

        $categoryname = isset($_POST['savecat']) && !empty($_POST['categoryname'])
            ? str_replace(" ", "-", trim($_POST['categoryname']))
            : (isset($_GET['categoryname']) ? str_replace(" ", "-", trim($_GET['categoryname'])) : '');

        $templatedata = isset($_POST['template']) ? $_POST['template'] : '';

        $folder = GSDATAOTHERPATH . '/multiBlock/category/';
        $filename = $folder . $categoryname . '.json';
        $template = $folder . $categoryname . '.txt';
        $chmod_mode = 0755;

        if (!file_exists($folder)) {
            if (!mkdir($folder, $chmod_mode, true) && !is_dir($folder)) {
                echo "Error: Could not create directory.";
                return;
            }
        }

        if (file_exists($folder)) {
            if (file_put_contents($filename, $costaJson) === false || file_put_contents($template, $templatedata) === false) {
                echo "Error: Failed to write files.";
                return;
            }
        } else {
            echo "Error: Directory does not exist.";
            return;
        }

        if (isset($_POST['check']) && $_POST['check'] !== $_POST['categoryname']) {
            $oldName = str_replace(" ", "-", trim($_POST['check']));
            $newJson = $folder . $categoryname . '.json';
            $newTxt = $folder . $categoryname . '.txt';
            $oldJson = $folder . $oldName . '.json';
            $oldTxt = $folder . $oldName . '.txt';

            if (file_exists($oldJson) && !rename($oldJson, $newJson)) {
                echo "Error: Failed to rename JSON file.";
                return;
            }
            if (file_exists($oldTxt) && !rename($oldTxt, $newTxt)) {
                echo "Error: Failed to rename template file.";
                return;
            }
        }

        echo "<meta http-equiv='refresh' content='0'>";
    }

    public function saveCatOne()
    {
        $costa = [];

        if (isset($_POST['label']) && is_array($_POST['label'])) {
            foreach ($_POST['label'] as $key => $value) {
                $costa[] = [
                    'name' => isset($_POST['categorytitle']) ? htmlspecialchars($_POST['categorytitle'], ENT_QUOTES, 'UTF-8') : '',
                    'key' => (int) $key,
                    'title' => isset($_POST['title'][$key]) ? htmlspecialchars($_POST['title'][$key], ENT_QUOTES, 'UTF-8') : '',
                    'label' => isset($_POST['label'][$key]) ? str_replace(" ", "-", strtolower(trim($_POST['label'][$key]))) : '',
                    'value' => isset($_POST['value'][$key]) ? htmlspecialchars($_POST['value'][$key], ENT_QUOTES, 'UTF-8') : '',
                    'select' => isset($_POST['select'][$key]) ? htmlspecialchars($_POST['select'][$key], ENT_QUOTES, 'UTF-8') : ''
                ];
            }
        }

        $costaJson = json_encode($costa, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);

        $categoryname = isset($_POST['savecat']) && !empty($_POST['categoryname'])
            ? str_replace(" ", "-", trim($_POST['categoryname']))
            : (isset($_GET['categoryname']) ? str_replace(" ", "-", trim($_GET['categoryname'])) : '');

        $folder = GSDATAOTHERPATH . '/oneBlock/category/';
        $filename = $folder . $categoryname . '.json';
        $chmod_mode = 0755;

        if (!file_exists($folder)) {
            if (!mkdir($folder, $chmod_mode, true) && !is_dir($folder)) {
                echo "Error: Could not create directory.";
                return;
            }
        }

        if (file_put_contents($filename, $costaJson) === false) {
            echo "Error: Failed to write JSON file.";
            return;
        }

        if (isset($_POST['check']) && $_POST['check'] !== $_POST['categoryname']) {
            $oldName = str_replace(" ", "-", trim($_POST['check']));
            $oldFile = $folder . $oldName . '.json';
            $newFile = $folder . $categoryname . '.json';
            if (file_exists($oldFile) && !rename($oldFile, $newFile)) {
                echo "Error: Failed to rename JSON file.";
                return;
            }
        }

        echo "<meta http-equiv='refresh' content='0'>";
    }

    public function newBlockOptions()
    {
        $cat = @file_get_contents(GSDATAOTHERPATH . 'multiBlock/category/' . str_replace(" ", "-", $_GET['newmulticategory']) . '.json');
        $multicategory = json_decode($cat, true) ?? [];

        foreach ($multicategory as $category) {
            $nis = str_replace(" ", "", $category['label']);
            $valer = isset($dater->$nis) ? $dater->$nis : ($category['value'] ?? '');

            if ($category['select'] === 'wysywig') {
                echo '
                    <p style="margin:0;margin-top:20px;font-weight:400;font-size:15px;margin-bottom:5px;">' . htmlspecialchars($category['title'], ENT_QUOTES, 'UTF-8') . ' :</p>
                    <textarea id="post-content" name="' . $nis . '" style="width:100%;display:block;height:250px;" class="mbinput">' . html_entity_decode($valer, ENT_QUOTES, 'UTF-8') . '</textarea>
                ';
            } elseif ($category['select'] === 'image') {
                global $SITEURL;
                echo '<span class="formedit">';
                echo '<p style="margin:0;margin-top:20px;font-weight:400;font-size:15px;">' . htmlspecialchars($category['title'], ENT_QUOTES, 'UTF-8') . ' :</p>
                    <div class="mb_img">';
                if ($valer !== 'undefined' && !empty($valer)) {
                    echo ' <img src="' . htmlspecialchars($valer, ENT_QUOTES, 'UTF-8') . '" style="width:80px;height:80px;object-fit:cover;">';
                }
                echo '
                        <input type="text" class="mb_foto foto mbinput" name="' . $nis . '" value="' . htmlspecialchars($valer, ENT_QUOTES, 'UTF-8') . '">
                        <button class="mb_fotobtn choose-image">' . i18n_r("multiBlock/CHOOSEIMAGE") . '</button>
                    </div></span>';
            } elseif ($category['select'] === 'file') {
                global $SITEURL;
                echo '<span class="formedit">';
                echo '<p style="margin:0;margin-top:20px;font-weight:400;font-size:15px;">' . htmlspecialchars($category['title'], ENT_QUOTES, 'UTF-8') . ' :</p>
                    <div class="mb_img">';
                if ($valer !== 'undefined' && !empty($valer)) {
                    echo ' <img src="' . htmlspecialchars($valer, ENT_QUOTES, 'UTF-8') . '" style="width:80px;height:80px;object-fit:cover;">';
                }
                echo '
                        <input type="text" class="mb_file file mbinput" name="' . $nis . '" value="' . htmlspecialchars($valer, ENT_QUOTES, 'UTF-8') . '">
                        <button class="mb_filebtn choose-image">Choose File</button>
                    </div></span>';
            } elseif ($category['select'] === 'textarea') {
                echo '<p style="margin:0;margin-top:20px;font-weight:400;font-size:15px;display:inline-block;">' . htmlspecialchars($category['title'], ENT_QUOTES, 'UTF-8') . ' :</p>
                    <textarea class="mbinput" style="width:100%;height:250px;" name="' . $nis . '">' . html_entity_decode($valer, ENT_QUOTES, 'UTF-8') . '</textarea>';
            } elseif ($category['select'] === 'dropdown') {
                $ars = explode('|', trim($category['value']));
                echo '<p style="margin:0;margin-top:20px;font-weight:400;font-size:15px;display:inline-block;">' . htmlspecialchars($category['title'], ENT_QUOTES, 'UTF-8') . ' :</p>
                    <select style="width:100%;padding:10px;" class="' . $nis . '" name="' . $nis . '">';
                foreach ($ars as $sel) {
                    $selValue = str_replace(" ", "^", $sel);
                    echo '<option value="' . htmlspecialchars($selValue, ENT_QUOTES, 'UTF-8') . '">' . htmlspecialchars($sel, ENT_QUOTES, 'UTF-8') . '</option>';
                }
                echo '</select>';
                echo '<script>document.querySelector("select.' . $nis . '").value = "' . htmlspecialchars(str_replace(" ", "^", $valer), ENT_QUOTES, 'UTF-8') . '";</script>';
            } elseif ($category['select'] === 'link') {
                echo '<p style="margin:0;margin-top:20px;font-weight:400;font-size:15px;">' . htmlspecialchars($category['title'], ENT_QUOTES, 'UTF-8') . ' :</p>
                    <select style="width:100%;padding:15px;display:block;border:solid 1px #ddd;background:#fff;margin-top:10px;" class="' . $nis . '" name="' . $nis . '">';
                foreach (glob(GSDATAPAGESPATH . "*.{xml}", GLOB_BRACE) as $page) {
                    $path_parts = pathinfo($page);
                    global $SITEURL;
                    $pageUrl = $SITEURL . $path_parts['filename'];
                    echo "<option value='" . htmlspecialchars($pageUrl, ENT_QUOTES, 'UTF-8') . "'>" . htmlspecialchars($path_parts['filename'], ENT_QUOTES, 'UTF-8') . "</option>";
                }
                echo '</select>';
                echo '<script>document.querySelector("select.' . $nis . '").value = "' . htmlspecialchars($valer, ENT_QUOTES, 'UTF-8') . '";</script>';
            } else {
                echo '<p style="margin:0;margin-top:20px;font-weight:400;font-size:15px;">' . htmlspecialchars($category['title'], ENT_QUOTES, 'UTF-8') . ' :</p>
                    <input class="mbinput" type="' . htmlspecialchars($category['select'], ENT_QUOTES, 'UTF-8') . '" name="' . $nis . '" value="' . html_entity_decode($valer, ENT_QUOTES, 'UTF-8') . '">';
            }
        }
    }

    public function saveMultiBlock()
    {
        $costa = [];
        foreach ($_POST as $key => $value) {
            $costa[$key] = trim(preg_replace('/\s\s+/', ' ', htmlentities($value, ENT_QUOTES, 'UTF-8')));
        }
        $costaJson = json_encode($costa, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);

        $owncategory = $_GET['newmulticategory'] ?? '';
        $name = str_replace(" ", "-", trim($_POST['namemultiblock'] ?? ''));

        $folder = GSDATAOTHERPATH . 'multiBlock/' . $owncategory . '/';
        $filename = $folder . $name . '.json';
        $chmod_mode = 0755;

        if (!file_exists($folder)) {
            if (!mkdir($folder, $chmod_mode, true) && !is_dir($folder)) {
                echo "Error: Could not create directory.";
                return;
            }
        }

        if (file_put_contents($filename, $costaJson) === false) {
            echo "Error: Failed to write JSON file.";
            return;
        }

        if (!empty($_POST['nameolder']) && $_POST['nameolder'] !== $_POST['namemultiblock']) {
            $oldName = str_replace(" ", "-", trim($_POST['nameolder']));
            $oldFile = $folder . $oldName . '.json';
            $newFile = $folder . $name . '.json';
            if (file_exists($oldFile) && !rename($oldFile, $newFile)) {
                echo "Error: Failed to rename JSON file.";
                return;
            }
        }

        echo "<meta http-equiv='refresh' content='0'>";
    }

    public function saveOneBlock()
    {
        $costa = [];
        foreach ($_POST as $key => $value) {
            $costa[$key] = trim(preg_replace('/\s\s+/', ' ', htmlentities($value, ENT_QUOTES, 'UTF-8')));
        }
        $costaJson = json_encode($costa, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);

        $owncategory = $_GET['newmulticategory'] ?? '';
        $name = str_replace(" ", "-", trim($_POST['name'] ?? ''));

        $folder = GSDATAOTHERPATH . 'oneBlock/' . $owncategory . '/';
        $filename = $folder . $name . '.json';
        $chmod_mode = 0755;

        if (!file_exists($folder)) {
            if (!mkdir($folder, $chmod_mode, true) && !is_dir($folder)) {
                echo "Error: Could not create directory.";
                return;
            }
        }

        if (file_put_contents($filename, $costaJson) === false) {
            echo "Error: Failed to write JSON file.";
            return;
        }

        if (!empty($_POST['nameolder']) && $_POST['nameolder'] !== $_POST['name']) {
            $oldName = str_replace(" ", "-", trim($_POST['nameolder']));
            $oldFile = $folder . $oldName . '.json';
            $newFile = $folder . $name . '.json';
            if (file_exists($oldFile) && !rename($oldFile, $newFile)) {
                echo "Error: Failed to rename JSON file.";
                return;
            }
        }

        echo "<meta http-equiv='refresh' content='0'>";
    }

    public function saveOrder()
    {
        $owncategory = $_GET['newmulticategory'] ?? '';
        $arrayinfo = $_POST['array'] ?? '';

        $folder = GSDATAOTHERPATH . 'multiBlock/' . $owncategory . '/';
        $filename = $folder . 'order.txt';
        $chmod_mode = 0755;

        if (!file_exists($folder)) {
            if (!mkdir($folder, $chmod_mode, true) && !is_dir($folder)) {
                echo "Error: Could not create directory.";
                return;
            }
        }

        if (file_put_contents($filename, $arrayinfo) === false) {
            echo "Error: Failed to write order file.";
            return;
        }

        echo "<meta http-equiv='refresh' content='0'>";
    }
}