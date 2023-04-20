<style>
	.mb_title {
		width: 100%;
		padding: 10px;
	}

	.mb_textarea {
		width: 100%;
		height: 400px;
		padding: 10px;
		box-sizing: border-box;
	}

	.mb_submit {
		background: #000;
		width: 150px;
		color: #fff;
		padding: 10px 15px;
		border: none;
		cursor: pointer;
	}

	.mb_buttons {
		margin-right: 0;
		margin-left: auto;
		width: auto;
		display: flex;
		justify-content: end;
		gap: 5px;
	}

	.mb_btngeneral,
	.mb_btntemplate,
	.backtolist {
		all: unset;
		background: #000;
		color: #fff;
		padding: 10px 15px;
		border: none;
		color: #fff !important;
		text-decoration: none !important;
		cursor: pointer;
	}

	.backtolist {
		background: #222;
	}

	.mb_inputs {
		margin: 0 !important;
		padding: 0 !important;
		list-style-type: none;
		width: 100%;
		display: block;
		box-sizing: border-box !important;
	}

	.mb_inputs li,
	.info {
		display: grid;
		grid-template-columns: 25px 1fr 1fr 1fr 1fr 30px;
		gap: 10px;
		justify-content: space-between;
		align-items: center;
		padding: 10px;
		box-sizing: border-box;
	}

	.info {
		text-align: center;
		background: #fafafa;
		border: solid 1px #ddd;
		margin-top: 20px;
	}

	.info p {
		margin: 0;
		padding: 0;
	}

	.mb_inputs li p {
		font-size: 12px;
		margin: 0 !important;
		padding: 0 !important;
		text-align: center;
		font-weight: bold;
	}

	.mb_inputs li:nth-child(odd) {
		background: #fafafa;
	}

	.mb_inputs li input,
	.mb_inputs li select {
		width: 100%;
		padding: 5px;
	}

	.mb_addbtndiv {
		width: 100%;
		margin-top: 20px;
	}

	.mb_close {
		background-color: red;
		font-size: 14px;
		color: #fff;
		border: none;
		height: 100%;
		cursor:pointer;
	}

	.mb_newinput {
		background: #000;
		color: #fff;
		display: inline-block;
		border: none;
		padding: 10px 15px;
		cursor: pointer;
	}

	.mb_inputs li input,
	.mb_inputs li select {
		box-sizing: border-box;
	}

	input {
		box-sizing: border-box;
	}

	code {
		border: solid 1px #ddd;
		background: #fafafa;
		padding: 5px;
		display: inline-block;
		margin: 10px 0;
		color: blue;
	}
</style>

<h3>OneBlock - <?php echo i18n_r("multiBlock/ADDNEWCATEGORY"); ?></h3>

<form method="post">
	<input type="text" style="display:none" value="<?php echo str_replace(" ", "-", @$_GET['categoryname']); ?>" name="check">
	<input type="text" style="display:none" value="<?php echo str_replace(" ", "-", @$_GET['categorytitle']); ?>" name="checktitle">

	<input type="text" required placeholder="<?php echo i18n_r("multiBlock/CATEGORYNAMEPLACEHOLDER"); ?>" style="width: 100%;
		padding: 10px;" name="categorytitle" class="mb_title_name" required value="<?php echo str_replace('-', ' ', @$_GET['categorytitle'] ?? ''); ?>">
	<br><br>
	<input type="text" required placeholder="<?php echo i18n_r("multiBlock/SLUG"); ?>" class="mb_title" pattern="[A-Za-z0-9]+" name="categoryname" value="<?php echo str_replace('-', ' ', @$_GET['categoryname'] ?? ''); ?>">


	<hr style="margin: 20px 0; border: 0; border-bottom: 2px dashed #ddd; background: #999;">

	<div class="mb_buttons" style="width:100%;background:#fafafa;display:flex; justify-content:flex-end;padding:5px;box-sizing:border-box;border:solid 1px #ddd;margin-bottom:20px;">
		<button class="mb_btngeneral"><?php echo i18n_r("multiBlock/GENERALBTN"); ?></button>
		<button class="mb_btntemplate"><?php echo i18n_r("multiBlock/TEMPLATEBTN"); ?></button>
		<a href="<?php global $SITEURL;
					echo $SITEURL; ?>admin/load.php?id=multiBlock&category" class="backtolist"><?php echo i18n_r("multiBlock/BACKBTN"); ?></a>
	</div>

	<div class="mb_general">

		<div class="mb_addbtndiv">
			<button class="mb_newinput"><?php echo i18n_r("multiBlock/ADDNEWBTN"); ?> ➕</button>
		</div>

		<div class="info">
			<p><?php echo i18n_r("multiBlock/ID"); ?></p>
			<p><?php echo i18n_r("multiBlock/FIELDNAME"); ?></p>
			<p><?php echo i18n_r("multiBlock/SLUG"); ?></p>
			<p><?php echo i18n_r("multiBlock/DEFAULTVALUE"); ?></p>
			<p><?php echo i18n_r("multiBlock/FIELDTYPE"); ?></p>
		</div>

		<ul id="mb_inputs" class="mb_inputs">
			<?php
			if (isset($_GET['categoryname'])) {
				$cat = file_get_contents(GSDATAOTHERPATH . 'oneBlock/category/' . str_replace(" ", "-", $_GET['categoryname']) . '.json');

				$multicategory = json_decode($cat);

				$count = 0;

				foreach ($multicategory as $category) {
					echo '
						<li>
							<p>' . @$category->key . '</p>
							<input type="text" required class="mb_input" placeholder="' . i18n_r("multiBlock/FIELDNAME") . '" value="' . @$category->title . '" name="title[]">
							<input type="text" required class="mb_input" placeholder="' . i18n_r("multiBlock/SLUG") . '" value="' . @$category->label . '" name="label[]">
							<input type="text" class="mb_input" value="' . @$category->value . '" placeholder="' . i18n_r("multiBlock/DEFAULTVALUE") . '" name="value[]" >
							<select class="mb_input meselect-' . $count . '" name="select[]"  >
								<option value="text">' . i18n_r("multiBlock/TEXT") . '</option>
								<option value="wysywig">' . i18n_r("multiBlock/WYSIWYG") . '</option>
								<option value="textarea">' . i18n_r("multiBlock/TEXTAREA") . '</option>
								<option value="color">' . i18n_r("multiBlock/COLOR") . '</option>
								<option value="date">' . i18n_r("multiBlock/DATE") . '</option>
								<option value="image">' . i18n_r("multiBlock/IMAGE") . '</option>
								<option value="dropdown">' . i18n_r("multiBlock/DROPDOWN") . '</option>
								<option value="link">' . i18n_r("multiBlock/LINK") . '</option>
							</select>
							<button class="mb_close">✕</button>
						</li>
						<script>document.querySelector(".meselect-' . $count . '").value="' . @$category->select . '"</script>
						';

					$count++;
				}
			};; ?>
		</ul>
	</div>

	<div class="mb_template">
		<p><?php echo i18n_r("multiBlock/ONEBLOCKHELP"); ?></p>

		<b><?php echo i18n_r("multiBlock/TEMPLATE1"); ?></b>

		<div style="width:100%;height:auto;padding:15px;background:#fafafa;border:solid 1px #ddd;margin:10px 0;font-size:12px !important;box-sizing:border-box">
			<b><?php echo i18n_r("multiBlock/TEMPLATE2"); ?></b><br>
			<code style=""> &#60;?php getOneBlock('nameCategoryBlock','NameBlock','slugname');?&#62; </code> <br>

			<b><?php echo i18n_r("multiBlock/TEMPLATE3"); ?></b><br>

			<code style=""> &#60;?php getOneBlockWysywig('nameCategoryBlock','NameBlock','slugname');?&#62; </code> <br>

			<b><?php echo i18n_r("multiBlock/THUMBNAILPLACEHOLDER"); ?></b><br>

			<code style=""> &#60;?php getOneBlockThumb('nameCategoryBlock','NameBlock','slugname','width');?&#62; </code> <br>
		</div>
	</div>

	<div style="width:100%;background:#fafafa;display:flex; justify-content:flex-end;padding:5px;box-sizing:border-box;border:solid 1px #ddd;margin-top:20px;">
		<input type="submit" name="savecat" class="mb_submit" value="<?php echo i18n_r("multiBlock/SAVECAT"); ?>">
	</div>

</form>

<script>
	document.querySelector('.mb_template').style.display = "none";

	document.querySelector('.mb_btntemplate').addEventListener('click', (btn) => {
		btn.preventDefault();

		if (document.querySelector('.mb_template').style.display == "none") {
			document.querySelector('.mb_template').style.display = "block";
			document.querySelector('.mb_general').style.display = "none";
		} else if (document.querySelector('.mb_template').style.display == "block") {
			document.querySelector('.mb_template').style.display = "none";
			document.querySelector('.mb_general').style.display = "block";
		}

	});

	document.querySelector('.mb_btngeneral').addEventListener('click', (btn) => {
		btn.preventDefault();

		if (document.querySelector('.mb_template').style.display == "block") {
			document.querySelector('.mb_template').style.display = "none";
			document.querySelector('.mb_general').style.display = "block";
		} else if (document.querySelector('.mb_template').style.display == "none") {
			document.querySelector('.mb_template').style.display = "block";
			document.querySelector('.mb_general').style.display = "none";
		}

	});

	let count = 0;

	document.querySelector('.mb_newinput').addEventListener('click', (btn) => {
		btn.preventDefault();

		const former = `
		<li>
			<p>auto</p>
			<input type="text" required class="mb_input" placeholder="title" name="title[]">
			<input type="text" required class="mb_input" placeholder="slug" name="label[]">
			<input type="text" class="mb_input" placeholder="default value" name="value[]" >
			<select class="mb_input" name="select[]" >
				<option value="text"><?php echo i18n_r("multiBlock/TEXT"); ?></option>
				<option value="wysywig"><?php echo i18n_r("multiBlock/WYSIWYG"); ?></option>
				<option value="textarea"><?php echo i18n_r("multiBlock/TEXTAREA"); ?></option>
				<option value="color"><?php echo i18n_r("multiBlock/COLOR"); ?></option>
				<option value="date"><?php echo i18n_r("multiBlock/DATE"); ?></option>
				<option value="image"><?php echo i18n_r("multiBlock/IMAGE"); ?></option>
				<option value="dropdown"><?php echo i18n_r("multiBlock/DROPDOWN"); ?></option>
				<option value="link"><?php echo i18n_r("multiBlock/LINK"); ?></option>
			</select>
			<button class="mb_close">✕</button>
		</li>
	`;

		count++;

		document.querySelector('.mb_inputs').insertAdjacentHTML('beforeend', former);

		document.querySelectorAll('.mb_close').forEach(closebtn => {
			closebtn.addEventListener('click', x => {
				x.preventDefault();
				closebtn.parentElement.remove();
			})
		})

	});

	if (document.querySelector('.mb_inputs li')) {
		document.querySelector('.mb_inputs li').addEventListener('click', () => {

			document.querySelectorAll('.mb_input').forEach(x => {});

		})
	};

	document.querySelectorAll('.mb_close').forEach(closebtn => {
		closebtn.addEventListener('click', x => {
			x.preventDefault();
			closebtn.parentElement.remove();
		})
	})
</script>

<script src="<?php global $SITEURL;
				echo $SITEURL; ?>plugins/multiBlock/js/Sortable.min.js"></script>

<script>
	var el = document.getElementById('mb_inputs');
	var sortable = Sortable.create(el, {
		animation: 200,
	});

	document.querySelector('.mb_title_name').addEventListener('keyup', x => {
		document.querySelector('form').setAttribute('action', '<?php global $SITEURL;
																echo $SITEURL; ?>admin/load.php?id=multiBlock&addnewOneBlock&categoryname=' + document.querySelector('.mb_title').value + '&categorytitle=' + document.querySelector('.mb_title_name').value)
	})

	document.querySelector('.mb_title').addEventListener('keyup', x => {
		document.querySelector('form').setAttribute('action', '<?php global $SITEURL;
																echo $SITEURL; ?>admin/load.php?id=multiBlock&addnewOneBlock&categoryname=' + document.querySelector('.mb_title').value + '&categorytitle=' + document.querySelector('.mb_title_name').value)
	})
</script>

<?php
if (isset($_POST['savecat'])) {

	global $bb;
	$bb->saveCatOne();
}; ?>