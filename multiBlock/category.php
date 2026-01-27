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
	
	// Step 1: Display modal form to enter new category name
	if (!isset($_POST['confirm_duplicate'])) {
		// Load source category to get original title
		$sourceTitle = $sourceCat;
		if (file_exists(GSDATAOTHERPATH . "oneBlock/category/" . $sourceCat . ".json")) {
			$jsonContent = file_get_contents(GSDATAOTHERPATH . "oneBlock/category/" . $sourceCat . ".json");
			$jsonData = json_decode($jsonContent, true);
			if ($jsonData && is_array($jsonData) && count($jsonData) > 0 && isset($jsonData[0]['name'])) {
				$sourceTitle = $jsonData[0]['name'];
			}
		}
		
		$suggestedTitle = $sourceTitle . ' (' . i18n_r('multiBlock/DUPLICATE') . ')';
		$suggestedSlug = $sourceCat . '_copy';
		$counter = 1;
		while (file_exists(GSDATAOTHERPATH . "oneBlock/category/" . $suggestedSlug . ".json")) {
			$suggestedSlug = $sourceCat . '_copy' . $counter;
			$suggestedTitle = $sourceTitle . ' (' . i18n_r('multiBlock/DUPLICATE') . ' ' . $counter . ')';
			$counter++;
		}
		
		?>
		<style>
			.modal-overlay {
				position: fixed;
				top: 0;
				left: 0;
				width: 100%;
				height: 100%;
				background: rgba(0, 0, 0, 0.6);
				display: flex;
				align-items: center;
				justify-content: center;
				z-index: 9999;
			}
			
			.modal-content {
				background: #fff;
				padding: 25px;
				border-radius: 3px;
				box-shadow: 0 5px 15px rgba(0, 0, 0, 0.3);
				max-width: 500px;
				width: 90%;
			}
			
			.modal-header {
				margin: 0 0 20px 0;
				padding-bottom: 15px;
				border-bottom: 1px solid #ddd;
				font-size: 18px;
				font-weight: normal;
				color: #333;
			}
			
			.modal-body label {
				display: block;
				margin-bottom: 8px;
				font-weight: bold;
				color: #555;
			}
			
			.modal-body input[type="text"] {
				width: 100%;
				padding: 8px 10px;
				border: 1px solid #ccc;
				border-radius: 3px;
				font-size: 14px;
				box-sizing: border-box;
				margin-bottom: 15px;
			}
			
			.modal-body input[type="text"]:focus {
				border-color: #5897fb;
				outline: none;
				box-shadow: 0 0 3px rgba(88, 151, 251, 0.3);
			}
			
			.modal-footer {
				margin-top: 20px;
				padding-top: 15px;
				border-top: 1px solid #ddd;
				text-align: right;
			}
			
			.modal-footer .submit {
				background: #5897fb;
				color: #fff;
				border: none;
				padding: 8px 20px;
				border-radius: 3px;
				cursor: pointer;
				font-size: 14px;
				margin-left: 10px;
			}
			
			.modal-footer .submit:hover {
				background: #4178d4;
			}
			
			.modal-footer .cancel {
				background: #f0f0f0;
				color: #333;
				border: 1px solid #ccc;
				padding: 8px 20px;
				border-radius: 3px;
				text-decoration: none;
				display: inline-block;
				font-size: 14px;
			}
			
			.modal-footer .cancel:hover {
				background: #e0e0e0;
			}
		</style>
		
		<div class="modal-overlay">
			<div class="modal-content">
				<h3 class="modal-header"><?php echo i18n_r('multiBlock/DUPLICATE_CATEGORY'); ?>: <?php echo htmlspecialchars($sourceTitle); ?></h3>
				
				<form method="post" action="">
					<div class="modal-body">
						<label for="new_cat_title"><?php echo i18n_r('multiBlock/NEW_CATEGORY_TITLE'); ?>:</label>
						<input type="text" 
							   id="new_cat_title" 
							   name="new_cat_title" 
							   value="<?php echo htmlspecialchars($suggestedTitle); ?>" 
							   required 
							   autofocus>
						
						<label for="new_cat_slug"><?php echo i18n_r('multiBlock/NEW_CATEGORY_SLUG'); ?>:</label>
						<input type="text" 
							   id="new_cat_slug" 
							   name="new_cat_slug" 
							   value="<?php echo htmlspecialchars($suggestedSlug); ?>" 
							   required>
						
						<input type="hidden" name="source_cat" value="<?php echo htmlspecialchars($sourceCat); ?>">
						<input type="hidden" name="confirm_duplicate" value="1">
					</div>
					
					<div class="modal-footer">
						<a href="<?php echo $SITEURL; ?>admin/load.php?id=multiBlock&category" class="cancel"><?php echo i18n_r('multiBlock/CANCEL'); ?></a>
						<input type="submit" class="submit" value="<?php echo i18n_r('multiBlock/DUPLICATE'); ?>">
					</div>
				</form>
			</div>
		</div>
		
		<script>
			// Auto-generate slug from title
			document.getElementById('new_cat_title').addEventListener('input', function() {
				var slug = this.value
					.toLowerCase()
					.replace(/ą/g, 'a').replace(/ć/g, 'c').replace(/ę/g, 'e')
					.replace(/ł/g, 'l').replace(/ń/g, 'n').replace(/ó/g, 'o')
					.replace(/ś/g, 's').replace(/ź/g, 'z').replace(/ż/g, 'z')
					.replace(/á/g, 'a').replace(/é/g, 'e').replace(/í/g, 'i')
					.replace(/ó/g, 'o').replace(/ú/g, 'u').replace(/ñ/g, 'n')
					.replace(/[^a-z0-9]+/g, '_')
					.replace(/^_+|_+$/g, '');
				document.getElementById('new_cat_slug').value = slug;
			});
			
			// Focus input field
			document.getElementById('new_cat_title').focus();
			
			// Close modal on Escape key
			document.addEventListener('keydown', function(e) {
				if (e.key === 'Escape') {
					window.location.href = '<?php echo $SITEURL; ?>admin/load.php?id=multiBlock&category';
				}
			});
			
			// Close modal when clicking outside
			document.querySelector('.modal-overlay').addEventListener('click', function(e) {
				if (e.target === this) {
					window.location.href = '<?php echo $SITEURL; ?>admin/load.php?id=multiBlock&category';
				}
			});
		</script>
		<?php
		return;
	}
	
	// Step 2: Perform duplication with provided name
	if (isset($_POST['confirm_duplicate']) && isset($_POST['new_cat_title']) && isset($_POST['new_cat_slug'])) {
		$sourceCat = $_POST['source_cat'];
		$newCatTitle = trim($_POST['new_cat_title']);
		$newCatSlug = trim($_POST['new_cat_slug']);
		
		// Validate fields are not empty
		if (empty($newCatTitle) || empty($newCatSlug)) {
			echo '<script>alert("' . i18n_r('multiBlock/TITLE_SLUG_EMPTY') . '"); history.back();</script>';
			return;
		}
		
		// Sanitize slug - remove dangerous characters
		$newCatSlug = preg_replace('/[^a-zA-Z0-9_-]/', '_', $newCatSlug);
		
		// Check if category already exists
		if (file_exists(GSDATAOTHERPATH . "oneBlock/category/" . $newCatSlug . ".json")) {
			echo '<script>alert("' . i18n_r('multiBlock/CATEGORY_EXISTS') . '"); history.back();</script>';
			return;
		}
		
		// Copy and update JSON file
		if (file_exists(GSDATAOTHERPATH . "oneBlock/category/" . $sourceCat . ".json")) {
			$jsonContent = file_get_contents(GSDATAOTHERPATH . "oneBlock/category/" . $sourceCat . ".json");
			$jsonData = json_decode($jsonContent, true);
			
			// Update name field in first element of array
			if ($jsonData && is_array($jsonData) && count($jsonData) > 0 && isset($jsonData[0]['name'])) {
				$jsonData[0]['name'] = $newCatTitle;
			}
			
			// Save updated JSON
			file_put_contents(
				GSDATAOTHERPATH . "oneBlock/category/" . $newCatSlug . ".json",
				json_encode($jsonData, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE)
			);
		}
		
		// Recursive directory copy function
		function copyDir($source, $dest) {
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

		// Copy directory with contents
		$sourceDir = GSDATAOTHERPATH . "oneBlock/" . $sourceCat . "/";
		$destDir = GSDATAOTHERPATH . "oneBlock/" . $newCatSlug . "/";
		
		if (is_dir($sourceDir)) {
			copyDir($sourceDir, $destDir);
		}
		
		// Redirect back to category list
		echo '<script>location.replace("' . $SITEURL . 'admin/load.php?id=multiBlock&category");</script>';
	}
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
	
	// Step 1: Display modal form to enter new category name
	if (!isset($_POST['confirm_duplicate'])) {
		// Load source category to get original title
		$sourceTitle = $sourceCat;
		if (file_exists(GSDATAOTHERPATH . "multiBlock/category/" . $sourceCat . ".json")) {
			$jsonContent = file_get_contents(GSDATAOTHERPATH . "multiBlock/category/" . $sourceCat . ".json");
			$jsonData = json_decode($jsonContent, true);
			if ($jsonData && is_array($jsonData) && count($jsonData) > 0 && isset($jsonData[0]['name'])) {
				$sourceTitle = $jsonData[0]['name'];
			}
		}
		
		$suggestedTitle = $sourceTitle . ' (' . i18n_r('multiBlock/DUPLICATE') . ')';
		$suggestedSlug = $sourceCat . '_copy';
		$counter = 1;
		while (file_exists(GSDATAOTHERPATH . "multiBlock/category/" . $suggestedSlug . ".json")) {
			$suggestedSlug = $sourceCat . '_copy' . $counter;
			$suggestedTitle = $sourceTitle . ' (' . i18n_r('multiBlock/DUPLICATE') . ' ' . $counter . ')';
			$counter++;
		}
		
		?>
		<style>
			.modal-overlay {
				position: fixed;
				top: 0;
				left: 0;
				width: 100%;
				height: 100%;
				background: rgba(0, 0, 0, 0.6);
				display: flex;
				align-items: center;
				justify-content: center;
				z-index: 9999;
			}
			
			.modal-content {
				background: #fff;
				padding: 25px;
				border-radius: 3px;
				box-shadow: 0 5px 15px rgba(0, 0, 0, 0.3);
				max-width: 500px;
				width: 90%;
			}
			
			.modal-header {
				margin: 0 0 20px 0;
				padding-bottom: 15px;
				border-bottom: 1px solid #ddd;
				font-size: 18px;
				font-weight: normal;
				color: #333;
			}
			
			.modal-body label {
				display: block;
				margin-bottom: 8px;
				font-weight: bold;
				color: #555;
			}
			
			.modal-body input[type="text"] {
				width: 100%;
				padding: 8px 10px;
				border: 1px solid #ccc;
				border-radius: 3px;
				font-size: 14px;
				box-sizing: border-box;
				margin-bottom: 15px;
			}
			
			.modal-body input[type="text"]:focus {
				border-color: #5897fb;
				outline: none;
				box-shadow: 0 0 3px rgba(88, 151, 251, 0.3);
			}
			
			.modal-footer {
				margin-top: 20px;
				padding-top: 15px;
				border-top: 1px solid #ddd;
				text-align: right;
			}
			
			.modal-footer .submit {
				background: #5897fb;
				color: #fff;
				border: none;
				padding: 8px 20px;
				border-radius: 3px;
				cursor: pointer;
				font-size: 14px;
				margin-left: 10px;
			}
			
			.modal-footer .submit:hover {
				background: #4178d4;
			}
			
			.modal-footer .cancel {
				background: #f0f0f0;
				color: #333;
				border: 1px solid #ccc;
				padding: 8px 20px;
				border-radius: 3px;
				text-decoration: none;
				display: inline-block;
				font-size: 14px;
			}
			
			.modal-footer .cancel:hover {
				background: #e0e0e0;
			}
		</style>
		
		<div class="modal-overlay">
			<div class="modal-content">
				<h3 class="modal-header"><?php echo i18n_r('multiBlock/DUPLICATE_CATEGORY'); ?>: <?php echo htmlspecialchars($sourceTitle); ?></h3>
				
				<form method="post" action="">
					<div class="modal-body">
						<label for="new_cat_title"><?php echo i18n_r('multiBlock/NEW_CATEGORY_TITLE'); ?>:</label>
						<input type="text" 
							   id="new_cat_title" 
							   name="new_cat_title" 
							   value="<?php echo htmlspecialchars($suggestedTitle); ?>" 
							   required 
							   autofocus>
						
						<label for="new_cat_slug"><?php echo i18n_r('multiBlock/NEW_CATEGORY_SLUG'); ?>:</label>
						<input type="text" 
							   id="new_cat_slug" 
							   name="new_cat_slug" 
							   value="<?php echo htmlspecialchars($suggestedSlug); ?>" 
							   required>
						
						<input type="hidden" name="source_cat" value="<?php echo htmlspecialchars($sourceCat); ?>">
						<input type="hidden" name="confirm_duplicate" value="1">
					</div>
					
					<div class="modal-footer">
						<a href="<?php echo $SITEURL; ?>admin/load.php?id=multiBlock&category" class="cancel"><?php echo i18n_r('multiBlock/CANCEL'); ?></a>
						<input type="submit" class="submit" value="<?php echo i18n_r('multiBlock/DUPLICATE'); ?>">
					</div>
				</form>
			</div>
		</div>
		
		<script>
			// Auto-generate slug from title
			document.getElementById('new_cat_title').addEventListener('input', function() {
				var slug = this.value
					.toLowerCase()
					.replace(/ą/g, 'a').replace(/ć/g, 'c').replace(/ę/g, 'e')
					.replace(/ł/g, 'l').replace(/ń/g, 'n').replace(/ó/g, 'o')
					.replace(/ś/g, 's').replace(/ź/g, 'z').replace(/ż/g, 'z')
					.replace(/[^a-z0-9]+/g, '_')
					.replace(/^_+|_+$/g, '');
				document.getElementById('new_cat_slug').value = slug;
			});
			
			// Focus input field
			document.getElementById('new_cat_title').focus();
			
			// Close modal on Escape key
			document.addEventListener('keydown', function(e) {
				if (e.key === 'Escape') {
					window.location.href = '<?php echo $SITEURL; ?>admin/load.php?id=multiBlock&category';
				}
			});
			
			// Close modal when clicking outside
			document.querySelector('.modal-overlay').addEventListener('click', function(e) {
				if (e.target === this) {
					window.location.href = '<?php echo $SITEURL; ?>admin/load.php?id=multiBlock&category';
				}
			});
		</script>
		<?php
		return;
	}
	
	// Step 2: Perform duplication with provided name
	if (isset($_POST['confirm_duplicate']) && isset($_POST['new_cat_title']) && isset($_POST['new_cat_slug'])) {
		$sourceCat = $_POST['source_cat'];
		$newCatTitle = trim($_POST['new_cat_title']);
		$newCatSlug = trim($_POST['new_cat_slug']);
		
		// Validate fields are not empty
		if (empty($newCatTitle) || empty($newCatSlug)) {
			echo '<script>alert("' . i18n_r('multiBlock/TITLE_SLUG_EMPTY') . '"); history.back();</script>';
			return;
		}
		
		// Sanitize slug - remove dangerous characters
		$newCatSlug = preg_replace('/[^a-zA-Z0-9_-]/', '_', $newCatSlug);
		
		// Check if category already exists
		if (file_exists(GSDATAOTHERPATH . "multiBlock/category/" . $newCatSlug . ".json")) {
			echo '<script>alert("' . i18n_r('multiBlock/CATEGORY_EXISTS') . '"); history.back();</script>';
			return;
		}
		
		// Copy and update JSON file
		if (file_exists(GSDATAOTHERPATH . "multiBlock/category/" . $sourceCat . ".json")) {
			$jsonContent = file_get_contents(GSDATAOTHERPATH . "multiBlock/category/" . $sourceCat . ".json");
			$jsonData = json_decode($jsonContent, true);
			
			// Update name field in first element of array
			if ($jsonData && is_array($jsonData) && count($jsonData) > 0 && isset($jsonData[0]['name'])) {
				$jsonData[0]['name'] = $newCatTitle;
			}
			
			// Save updated JSON
			file_put_contents(
				GSDATAOTHERPATH . "multiBlock/category/" . $newCatSlug . ".json",
				json_encode($jsonData, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE)
			);
		}
		
		// Copy TXT file (preserve original content or use new title as fallback)
		$sourceTxtFile = GSDATAOTHERPATH . "multiBlock/category/" . $sourceCat . ".txt";
		$destTxtFile = GSDATAOTHERPATH . "multiBlock/category/" . $newCatSlug . ".txt";
        
		if (file_exists($sourceTxtFile)) {
		// Copy the entire content of the original TXT file
			$txtContent = file_get_contents($sourceTxtFile);
			file_put_contents($destTxtFile, $txtContent);
		} else {
			// Fallback: if source TXT doesn't exist, create new one with new title
			file_put_contents($destTxtFile, $newCatTitle);
		}
		
		// Recursive directory copy function
		function copyDir($source, $dest) {
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

		// Copy directory with contents
		$sourceDir = GSDATAOTHERPATH . "multiBlock/" . $sourceCat . "/";
		$destDir = GSDATAOTHERPATH . "multiBlock/" . $newCatSlug . "/";
		
		if (is_dir($sourceDir)) {
			copyDir($sourceDir, $destDir);
		}
		
		// Redirect back to category list
		echo '<script>location.replace("' . $SITEURL . 'admin/load.php?id=multiBlock&category");</script>';
	}
}

?>