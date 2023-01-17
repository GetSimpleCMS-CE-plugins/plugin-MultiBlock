<form action="#" method="post">

<h3><?php echo i18n_r("multiBlock/MULTIBLOCKSETTINGSHIDE");?></h3>

    <div style="width:100%;background:#fafafa;opacity:1;border:solid 1px #ddd; padding:10px;box-sizing:border-box;">
        <p><?php echo i18n_r("multiBlock/DISABLEDELSECTION");?></p>
        <input type="checkbox" class="hidemultidelete" name="hidemultidelete">
    </div>

    <div style="width:100%;background:#fafafa;opacity:1;border:solid 1px #ddd; padding:10px;box-sizing:border-box;margin-top:10px">
        <p><?php echo i18n_r("multiBlock/DISABLEADDSECTION");?></p>
        <input type="checkbox"  class="hidemultiaddnew" name="hidemultiaddnew">
    </div> 

    <br>

    <h3><?php echo i18n_r("multiBlock/ONEBLOCKSETTINGSHIDE");?></h3>

<div style="width:100%;background:#fafafa;opacity:1;border:solid 1px #ddd; padding:10px;box-sizing:border-box;">
    <p><?php echo i18n_r("multiBlock/DISABLEDELSECTION");?></p>
    <input type="checkbox" class="hideonedelete" name="hideonedelete">
</div>


<div style="width:100%;background:#fafafa;opacity:1;border:solid 1px #ddd; padding:10px;box-sizing:border-box;margin-top:10px">
<p><?php echo i18n_r("multiBlock/DISABLEADDSECTION");?></p>
    <input type="checkbox"  class="hideoneaddnew" name="hideoneaddnew">
</div> 
    <input type="submit" name="saveSettings" value="<?php echo i18n_r("multiBlock/SAVESETTINGS");?>" style="background:#000; color:#fff;padding:0.5rem 1rem;border:none; margin-top:20px;">
</form>

<?php
    global $folder;
    global $fileDelete;
    global $fileAddNew;
    $folder = GSDATAOTHERPATH.'/multiBlockSettings/';
    $fileMultiDelete = $folder.'hideMultiDelete.txt';
    $fileMultiAddNew = $folder.'hideMultiAddNew.txt';


    $fileOneDelete = $folder.'hideOneDelete.txt';
    $fileOneAddNew = $folder.'hideOneAddNew.txt';

	if (isset($_POST['saveSettings'])) {
		$hideMultiDelete = @$_POST['hidemultidelete'];
		$hideMultiAddNew = @$_POST['hidemultiaddnew'];

        $hideOneDelete = @$_POST['hideonedelete'];
		$hideOneAddNew = @$_POST['hideoneaddnew'];

		$chmod = 0755;
		$fileExist = file_exists($folder) || mkdir($folder, $chmod);

		if ($fileExist) {

			file_put_contents($fileMultiDelete, $hideMultiDelete);
			file_put_contents($fileMultiAddNew, $hideMultiAddNew);

            
			file_put_contents($fileOneDelete, $hideOneDelete);
			file_put_contents($fileOneAddNew, $hideOneAddNew);
		}
	}; 
?>

<script>
    if ('<?php echo file_get_contents($fileOneDelete); ?>' == 'on') {
        const hideDelete = document.querySelector('.hideonedelete').checked = true;
    };

    if ('<?php echo file_get_contents($fileOneAddNew); ?>' == 'on') {
        const hideDelete = document.querySelector('.hideoneaddnew').checked = true;
    };

    if ('<?php echo file_get_contents($fileMultiDelete); ?>' == 'on') {
        const hideDelete = document.querySelector('.hidemultidelete').checked = true;
    };

    if ('<?php echo file_get_contents($fileMultiAddNew); ?>' == 'on') {
        const hideDelete = document.querySelector('.hidemultiaddnew').checked = true;
    };
</script>