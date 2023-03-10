<style>
	.mb_add{
		min-width:150px;
		background: #000;
		padding: 10px 15px;
		color:#fff !important;
		border:none;
		display:inline-block;
		text-align: center;
		text-decoration: none !important;
		margin-bottom: 40px;
	}

	.mb_edit{
		width:70px;
		background: #000;
		display: inline-flex;
		align-items: center;
		justify-content: center ;
		text-decoration: none !important;
		color:#fff !important;
		height:30px;
		margin-right:10px;
	}

	.mb_edit_delete{
		background: red;
		border:none;
		display:inline-flex !important;
	}

	.mb_catlist{
		display: flex;
		flex-direction: column;
		margin-top: 30px;
		margin: 0 !important;
		padding: 0 !important;
	}

	.mb_catlist li{
		display: flex;
		justify-content: space-between;
		align-items: center;
		padding: 10px;
	}

	.mb_catlist p{
		font-size:15px;
		margin: 0 !important;  
		padding: 0 !important;
		font-weight: 400;
	}

	.mb_catlist li:nth-child(odd){
		background: #fafafa;
	}
</style>

<h3><?php echo i18n_r("multiBlock/MULTIBLOCKSETTINGS");?></h3>

<a href="<?php global $SITEURL;echo $SITEURL;?>admin/load.php?id=multiBlock&addnew" class="mb_add"><?php echo i18n_r("multiBlock/ADDNEWMBBTN");?> ➕</a>
<a href="<?php global $SITEURL;echo $SITEURL;?>admin/load.php?id=multiBlock&addnewOneBlock" class="mb_add"><?php echo i18n_r("multiBlock/ADDNEWOBBTN");?> ➕</a>
<a href="<?php global $SITEURL;echo $SITEURL;?>admin/load.php?id=multiBlock&blockoptions" class="mb_add"><?php echo i18n_r("multiBlock/BLOCKOPTIONSBTN");?> ⚙️</a>

<hr><br>

<h3><?php echo i18n_r("multiBlock/MBLIST");?></h3>

<ul class="mb_catlist">
	<?php 
		foreach (glob(GSDATAOTHERPATH."/multiBlock/category/*.json") as $filename) {
			global $SITEURL;
		
			$info = pathinfo($filename);
			echo '<li><p>'.str_replace('-',' ',basename($filename,'.'.$info['extension'])).'</p> <div><a href="'.$SITEURL.'admin/load.php?id=multiBlock&addnew&categoryname='.basename($filename,'.'.$info['extension']).'"
			
			class="mb_edit">'.i18n_r("multiBlock/EDIT").'</a>
			
			<form method="post"  onclick="return confirm(`Are you sure?`);" style="display:inline-flex" action="'.$SITEURL.'admin/load.php?id=multiBlock&category&deletecat='.basename($filename,'.'.$info['extension']).'">
			<input type="submit" value="'.i18n_r("multiBlock/DELETE").'" class="mb_edit mb_edit_delete"> 
			</form>
			</div>
			</li>';
		}
	;?>
</ul>

<br><hr><br>

<h3><?php echo i18n_r("multiBlock/OBLIST");?></h3>

<ul class="mb_catlist">
    <?php 
		foreach (glob(GSDATAOTHERPATH."/oneBlock/category/*.json") as $filename) {
			global $SITEURL;
		 
			$info = pathinfo($filename);
			echo '<li><p>'.str_replace('-',' ',basename($filename,'.'.$info['extension'])).'</p> <div><a href="'.$SITEURL.'admin/load.php?id=multiBlock&addnewOneBlock&categoryname='.basename($filename,'.'.$info['extension']).'"
			
			class="mb_edit">'.i18n_r("multiBlock/EDIT").'</a>
			
			<form method="post"  onclick="return confirm(`Are you sure?`);" style="display:inline-flex" action="'.$SITEURL.'admin/load.php?id=multiBlock&category&deletecatOneBlock='.basename($filename,'.'.$info['extension']).'">
			<input type="submit" value="'.i18n_r("multiBlock/DELETE").'" class="mb_edit mb_edit_delete"> 
			</form>
			</div>
			</li>';
		}
	;?>
</ul>

<br><hr>

<?php
	if(isset($_GET['deletecatOneBlock'])){
		global $SITEURL;

		unlink(GSDATAOTHERPATH."oneBlock/category/".$_GET['deletecatOneBlock'].".json");
	   
		echo '<script> location.replace("'.$SITEURL.'admin/load.php?id=multiBlock&category");</script>';

		function removeDir($path) {
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
			$katalog = GSDATAOTHERPATH."oneBlock/".$_GET['deletecatOneBlock']."/";
			removeDir($katalog);
	}

	if(isset($_GET['deletecat'])){
		global $SITEURL;

		unlink(GSDATAOTHERPATH."multiBlock/category/".$_GET['deletecat'].".json");
		unlink(GSDATAOTHERPATH."multiBlock/category/".$_GET['deletecat'].".txt");
	   
		echo '<script> location.replace("'.$SITEURL.'admin/load.php?id=multiBlock&category");</script>';


		function removeDir($path) {
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

			$katalog = GSDATAOTHERPATH."multiBlock/".$_GET['deletecat']."/";
			removeDir($katalog);
	}
;?>