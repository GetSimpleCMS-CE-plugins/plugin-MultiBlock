<style>
	.mb_add {
		min-width: 150px;
		background: #000;
		padding: 10px 15px;
		color: #fff !important;
		border: none;
		border-radius:5px;
		display: inline-block;
		text-align: center;
		text-decoration: none !important;
		margin-bottom: 40px;
	}
	
	.mb_new {
		background: #006600;
	}

	.mb_edit {
		background: #FFB71E;
		padding: 10px 15px;
		display: inline-flex;
		align-items: center;
		justify-content: center;
		text-decoration: none !important;
		color: #fff !important;
		margin-right: 10px;
		border-radius:5px;
	}

	.mb_edit_delete {
		background: red;
		border: none;
		display: inline-flex !important;
		cursor: pointer;
		font-weight: 600;
	}

	.mb_catlist {
		display: flex;
		flex-direction: column;
		margin-top: 30px;
		margin: 0 !important;
		padding: 0 !important;
	}

	.mb_catlist li {
		display: flex;
		justify-content: space-between;
		align-items: center;
		padding: 10px;
	}

	.mb_catlist p {
		font-size: 15px;
		margin: 0 !important;
		padding: 0 !important;
		font-weight: 400;
	}

	.mb_catlist li:nth-child(odd) {
		background: #fafafa;
	}
</style>

<h3><?php echo i18n_r("multiBlock/MULTIBLOCKSETTINGS"); ?></h3>

<a href="<?php global $SITEURL;
			echo $SITEURL; ?>admin/load.php?id=multiBlock&addnew" class="mb_add mb_new"><?php echo i18n_r("multiBlock/ADDNEWMBBTN"); ?> ➕</a>
<a href="<?php global $SITEURL;
			echo $SITEURL; ?>admin/load.php?id=multiBlock&addnewOneBlock" class="mb_add mb_new"><?php echo i18n_r("multiBlock/ADDNEWOBBTN"); ?> ➕</a>
<a href="<?php global $SITEURL;
			echo $SITEURL; ?>admin/load.php?id=multiBlock&blockoptions" class="mb_add"><?php echo i18n_r("multiBlock/BLOCKOPTIONSBTN"); ?> ⚙️</a>
<a href="<?php global $SITEURL;
			echo $SITEURL; ?>admin/load.php?id=multiBlock&migrator" class="mb_add"><?php echo i18n_r("multiBlock/MIGRATEBTN"); ?> ⚙️</a>

<hr><br>

<h3><?php echo i18n_r("multiBlock/MBLIST"); ?></h3>

<ul class="mb_catlist">
	<?php
	foreach (glob(GSDATAOTHERPATH . "/multiBlock/category/*.json") as $filename) {
		global $SITEURL;

		$content = json_decode(file_get_contents($filename), true);

		$info = pathinfo($filename);
		echo '
		<li> 
			<p>' . $content[0]['name'] . ' <span style="opacity:0.5;font-size:12px;margin-left:10px">slug: ' . basename($filename, '.' . $info['extension']) . '</span></p>
			 <div>
				<a href="' . $SITEURL . 'admin/load.php?id=multiBlock&addnew&&categorytitle=' . $content[0]['name'] . '&categoryname=' . basename($filename, '.' . $info['extension']) . '" class="mb_edit">' . i18n_r("multiBlock/EDIT") . '</a>
				<a href="' . $SITEURL . 'admin/load.php?id=multiBlock&category&duplicatecat=' . basename($filename, '.' . $info['extension']) . '" class="mb_edit">' . i18n_r("multiBlock/DUPLICATE") . '</a>
			
				<form method="post"  onclick="return confirm(`' . i18n_r('multiBlock/DELETEQUESTION') . '`);" style="display:inline-flex" action="' . $SITEURL . 'admin/load.php?id=multiBlock&category&deletecat=' . basename($filename, '.' . $info['extension']) . '">
					<input type="submit" value="✕" title="' . i18n_r("multiBlock/DELETE") . '" class="mb_edit mb_edit_delete"> 
				</form>
			</div>
		</li>';
	};
	?>
</ul>

<br><hr><br>

<h3><?php echo i18n_r("multiBlock/OBLIST"); ?></h3>

<ul class="mb_catlist">
	<?php
	foreach (glob(GSDATAOTHERPATH . "/oneBlock/category/*.json") as $filename) {
		global $SITEURL;
		$info = pathinfo($filename);
		$content = json_decode(file_get_contents($filename), true);

		echo '
		<li>
			<p>' . $content[0]['name'] . '<span style="opacity:0.5;font-size:12px;margin-left:10px">slug: ' . basename($filename, '.' . $info['extension']) . '</span></p> 
			<div>
				<a href="' . $SITEURL . 'admin/load.php?id=multiBlock&addnewOneBlock&categorytitle=' . $content[0]['name'] . '&categoryname=' . basename($filename, '.' . $info['extension']) . '" class="mb_edit">' . i18n_r("multiBlock/EDIT") . '</a>
				<a href="' . $SITEURL . 'admin/load.php?id=multiBlock&category&duplicateOneBlock=' . basename($filename, '.' . $info['extension']) . '" class="mb_edit">' . i18n_r("multiBlock/DUPLICATE") . '</a>
			
				<form method="post"  onclick="return confirm(`' . i18n_r('multiBlock/DELETEQUESTION') . '`);" style="display:inline-flex" action="' . $SITEURL . 'admin/load.php?id=multiBlock&category&deletecatOneBlock=' . basename($filename, '.' . $info['extension']) . '">
					<input type="submit" value="✕" title="' . i18n_r("multiBlock/DELETE") . '" class="mb_edit mb_edit_delete"> 
				</form>
			</div>
		</li>';
	};
	?>
</ul>

<br><hr>

<?php
if (isset($_GET['deletecatOneBlock'])) {
	global $SITEURL;

	unlink(GSDATAOTHERPATH . "oneBlock/category/" . $_GET['deletecatOneBlock'] . ".json");

	echo '<script> location.replace("' . $SITEURL . 'admin/load.php?id=multiBlock&category");</script>';

	function removeDir($path)
	{
		$dir = new DirectoryIterator($path);
		foreach ($dir as $fileinfo) {
			if ($fileinfo->isFile() || $fileinfo->isLink()) {
				unlink($fileinfo->getPathName());
			} elseif (!$fileinfo->isDot() && $fileinfo->isDir()) {
				removeDir($fileinfo->getPathName());
			}
		}
		rmdir($path);
	}
	$katalog = GSDATAOTHERPATH . "oneBlock/" . $_GET['deletecatOneBlock'] . "/";
	removeDir($katalog);
}

if (isset($_GET['duplicateOneBlock'])) {
	global $SITEURL;

	$sourceCat = $_GET['duplicateOneBlock'];
	$newCatName = $sourceCat . '_copy';
	
	$counter = 1;
	while (file_exists(GSDATAOTHERPATH . "oneBlock/category/" . $newCatName . ".json")) {
		$newCatName = $sourceCat . '_copy' . $counter;
		$counter++;
	}

	copy(
		GSDATAOTHERPATH . "oneBlock/category/" . $sourceCat . ".json",
		GSDATAOTHERPATH . "oneBlock/category/" . $newCatName . ".json"
	);

	function copyDir($source, $dest)
	{
		if (!is_dir($dest)) {
			mkdir($dest, 0755, true);
		}
		
		$dir = new DirectoryIterator($source);
		foreach ($dir as $fileinfo) {
			if (!$fileinfo->isDot()) {
				if ($fileinfo->isFile() || $fileinfo->isLink()) {
					copy($fileinfo->getPathName(), $dest . '/' . $fileinfo->getFilename());
				} elseif ($fileinfo->isDir()) {
					copyDir($fileinfo->getPathName(), $dest . '/' . $fileinfo->getFilename());
				}
			}
		}
	}

	$sourceDir = GSDATAOTHERPATH . "oneBlock/" . $sourceCat . "/";
	$destDir = GSDATAOTHERPATH . "oneBlock/" . $newCatName . "/";
	
	if (is_dir($sourceDir)) {
		copyDir($sourceDir, $destDir);
	}

	echo '<script> location.replace("' . $SITEURL . 'admin/load.php?id=multiBlock&category");</script>';
}

if (isset($_GET['deletecat'])) {
	global $SITEURL;

	unlink(GSDATAOTHERPATH . "multiBlock/category/" . $_GET['deletecat'] . ".json");
	unlink(GSDATAOTHERPATH . "multiBlock/category/" . $_GET['deletecat'] . ".txt");

	echo '<script> location.replace("' . $SITEURL . 'admin/load.php?id=multiBlock&category");</script>';

	function removeDir($path)
	{
		$dir = new DirectoryIterator($path);
		foreach ($dir as $fileinfo) {
			if ($fileinfo->isFile() || $fileinfo->isLink()) {
				unlink($fileinfo->getPathName());
			} elseif (!$fileinfo->isDot() && $fileinfo->isDir()) {
				removeDir($fileinfo->getPathName());
			}
		}
		rmdir($path);
	}

	$katalog = GSDATAOTHERPATH . "multiBlock/" . $_GET['deletecat'] . "/";
	removeDir($katalog);
};

if (isset($_GET['duplicatecat'])) {
	global $SITEURL;

	 $sourceCat = $_GET['duplicatecat'];
	$newCatName = $sourceCat . '_copy';
	
	 $counter = 1;
	while (file_exists(GSDATAOTHERPATH . "multiBlock/category/" . $newCatName . ".json")) {
		$newCatName = $sourceCat . '_copy' . $counter;
		$counter++;
	}

	 copy(
		GSDATAOTHERPATH . "multiBlock/category/" . $sourceCat . ".json",
		GSDATAOTHERPATH . "multiBlock/category/" . $newCatName . ".json"
	);
	
	copy(
		GSDATAOTHERPATH . "multiBlock/category/" . $sourceCat . ".txt",
		GSDATAOTHERPATH . "multiBlock/category/" . $newCatName . ".txt"
	);

	 function copyDir($source, $dest)
	{
		if (!is_dir($dest)) {
			mkdir($dest, 0755, true);
		}
		
		$dir = new DirectoryIterator($source);
		foreach ($dir as $fileinfo) {
			if (!$fileinfo->isDot()) {
				if ($fileinfo->isFile() || $fileinfo->isLink()) {
					copy($fileinfo->getPathName(), $dest . '/' . $fileinfo->getFilename());
				} elseif ($fileinfo->isDir()) {
					copyDir($fileinfo->getPathName(), $dest . '/' . $fileinfo->getFilename());
				}
			}
		}
	}

	 $sourceDir = GSDATAOTHERPATH . "multiBlock/" . $sourceCat . "/";
	$destDir = GSDATAOTHERPATH . "multiBlock/" . $newCatName . "/";
	
	if (is_dir($sourceDir)) {
		copyDir($sourceDir, $destDir);
	}

	echo '<script> location.replace("' . $SITEURL . 'admin/load.php?id=multiBlock&category");</script>';
}

?>