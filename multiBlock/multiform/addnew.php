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
		border: solid 2px #676767;
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
		cursor: pointer;
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
		color: green;
	}
	pre{
		background:#fff;border:1px solid #ddd;border-left:3px solid var(--main-color);;color:#2e94b9;page-break-inside:avoid;font-family:monospace;font-size:15px;line-height:1.6;margin-bottom:1.6em;max-width:100%;overflow:auto;padding:1em 1.5em;display:block;word-wrap:break-word
	}
</style>

<h3><?php echo i18n_r("multiBlock/MULTIBLOCK"); ?> - <?php echo i18n_r("multiBlock/ADDNEWCATEGORY"); ?></h3>

<form method="post">
	<input type="text" style="display:none" value="<?php echo str_replace(" ", "-", @$_GET['categoryname']); ?>" name="check">
	<input type="text" style="display:none" value="<?php echo str_replace(" ", "-", @$_GET['categorytitle']); ?>" name="checktitle">
	<input type="text" required placeholder="<?php echo i18n_r("multiBlock/CATEGORYNAMEPLACEHOLDER"); ?>" style="width: 100%;
		padding: 10px;" name="categorytitle" class="mb_title_name" required value="<?php echo str_replace('-', ' ', @$_GET['categorytitle'] ?? ''); ?>">
	<br><br>
	<input type="text" required placeholder="<?php echo i18n_r("multiBlock/SLUGTITLE"); ?>" class="mb_title" name="categoryname" value="<?php echo str_replace('-', ' ', @$_GET['categoryname'] ?? ''); ?>" pattern="[A-Za-z0-9]+">


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
				$cat = file_get_contents(GSDATAOTHERPATH . 'multiBlock/category/' . str_replace(" ", "-", $_GET['categoryname']) . '.json');

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
							<option value="file">' . i18n_r("multiBlock/FILE") . '</option>
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

		<div style="width:100%; background:#fafafa; display:flex; justify-content:flex-end; padding:5px; box-sizing:border-box; border:solid 1px #ddd; margin-top:20px;">
			<input type="submit" name="savecat" class="mb_submit" value="<?php echo i18n_r("multiBlock/SAVECAT"); ?>">
		</div>

	</div>


	<div class="mb_template">
		<h3><?php echo i18n_r("multiBlock/TEMPLATE"); ?></h3>


		<script src="https://cdnjs.cloudflare.com/ajax/libs/codemirror/6.65.7/codemirror.min.js" integrity="sha512-8RnEqURPUc5aqFEN04aQEiPlSAdE0jlFS/9iGgUyNtwFnSKCXhmB6ZTNl7LnDtDWKabJIASzXrzD0K+LYexU9g==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
		<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/codemirror/6.65.7/codemirror.min.css" integrity="sha512-uf06llspW44/LZpHzHT6qBOIVODjWtv4MxCricRxkzvopAlSWnTf6hpZTFxuuZcuNE9CBQhqE0Seu1CoRk84nQ==" crossorigin="anonymous" referrerpolicy="no-referrer" />
		<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/codemirror/6.65.7/theme/rubyblue.min.css" integrity="sha512-pt+OhZW7o2pmHEahNFroPWkGR89L0tmDqCzXK+7WM1vGLtUyxms1JxZsXgJbOdFwylRnEt0yHnU6y2uAs40FxQ==" crossorigin="anonymous" referrerpolicy="no-referrer" />
		<script src="https://cdnjs.cloudflare.com/ajax/libs/codemirror/6.65.7/mode/php/php.min.js" integrity="sha512-jZGz5n9AVTuQGhKTL0QzOm6bxxIQjaSbins+vD3OIdI7mtnmYE6h/L+UBGIp/SssLggbkxRzp9XkQNA4AyjFBw==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
		<script src="https://cdnjs.cloudflare.com/ajax/libs/codemirror/6.65.7/mode/css/css.min.js" integrity="sha512-rQImvJlBa8MV1Tl1SXR5zD2bWfmgCEIzTieFegGg89AAt7j/NBEe50M5CqYQJnRwtkjKMmuYgHBqtD1Ubbk5ww==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
		<script src="https://cdnjs.cloudflare.com/ajax/libs/codemirror/6.65.7/mode/javascript/javascript.min.js" integrity="sha512-I6CdJdruzGtvDyvdO4YsiAq+pkWf2efgd1ZUSK2FnM/u2VuRASPC7GowWQrWyjxCZn6CT89s3ddGI+be0Ak9Fg==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
		<script src="https://cdnjs.cloudflare.com/ajax/libs/codemirror/6.65.7/mode/xml/xml.min.js" integrity="sha512-LarNmzVokUmcA7aUDtqZ6oTS+YXmUKzpGdm8DxC46A6AHu+PQiYCUlwEGWidjVYMo/QXZMFMIadZtrkfApYp/g==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
		<script src="https://cdnjs.cloudflare.com/ajax/libs/codemirror/6.65.7/mode/htmlmixed/htmlmixed.min.js" integrity="sha512-HN6cn6mIWeFJFwRN9yetDAMSh+AK9myHF1X9GlSlKmThaat65342Yw8wL7ITuaJnPioG0SYG09gy0qd5+s777w==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
		<script src="https://cdnjs.cloudflare.com/ajax/libs/codemirror/6.65.7/mode/clike/clike.min.js" integrity="sha512-l8ZIWnQ3XHPRG3MQ8+hT1OffRSTrFwrph1j1oc1Fzc9UKVGef5XN9fdO0vm3nW0PRgQ9LJgck6ciG59m69rvfg==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>

		<style type="text/css">
			.CodeMirror {
				height: 400px;
			}
		</style>

		<textarea name="template" class="mb_textarea"><?php
		if (isset($_GET['categoryname'])) {
			echo file_get_contents(GSDATAOTHERPATH . 'multiBlock/category/' . str_replace(" ", "-", $_GET['categoryname']) . '.txt');
		};
		?> </textarea>

		<script>
			var editor = CodeMirror.fromTextArea(document.querySelector(".mb_textarea"), {
				theme: "rubyblue",
				lineNumbers: true,
				matchBrackets: true,
				indentUnit: 4,
				indentWithTabs: true,
				enterMode: "keep",
				tabMode: "shift",
				mode: "htmlmixed"
			});
		</script>
		
		<div style="width:100%; background:#fafafa; display:flex; justify-content:flex-end; padding:5px; box-sizing:border-box; border:solid 1px #ddd; margin-top:20px;">
			<input type="submit" name="savecat" class="mb_submit" value="<?php echo i18n_r("multiBlock/SAVECAT"); ?>">
		</div>

		<br>

		<h3><?php echo i18n_r("multiBlock/PLACEHOLDERS"); ?></h3>

		<div style="width:100%; height:auto; padding:15px; background:#fafafa; border:solid 1px #ddd; margin:10px 0; font-size:12px !important; box-sizing:border-box">

			<b><?php echo i18n_r("multiBlock/DEFAULT"); ?></b><br>
			<code style=""> &#60;?php mbvaluetext('valuename');?&#62; </code> <br>

			<b><?php echo i18n_r("multiBlock/DEFAULT").' '. i18n_r("multiBlock/RETURN"); ?></b><br>
			<code style=""> &#60;?php r_mbvaluetext('valuename');?&#62; </code> <br>

			<b><?php echo i18n_r("multiBlock/WYSIWYGPLACEHOLDER"); ?></b><br>

			<code style=""> &#60;?php mbvalue('valuename');?&#62; </code> <br>

			<b><?php echo i18n_r("multiBlock/WYSIWYGPLACEHOLDER").' '. i18n_r("multiBlock/RETURN"); ?></b><br>

			<code style=""> &#60;?php r_mbvalue('valuename');?&#62; </code> <br>

			<b><?php echo i18n_r("multiBlock/DATEFUNCTION"); ?></b><br>

			<code style=""> &#60;?php mbdate('valuename','d.m.Y');?&#62; </code> <br>

			<b><?php echo i18n_r("multiBlock/DROPDOWPLACEHOLDER"); ?></b><br>

			<code style=""> &#60;?php mbdropdown('valuename');?&#62; </code><br>

			<b><?php echo i18n_r("multiBlock/DROPDOWNVALUE"); ?></b>
			<br>

			<code style="">example 1|example 2|example 3</code> <br>

			<b><?php echo i18n_r("multiBlock/THUMBNAILPLACEHOLDER"); ?></b><br>

			<code style=""> &#60;?php mbthumb('imageslug','350');?&#62; </code> <br>

			<hr style="margin: 20px 0; border: 0; border-bottom: 1px dashed #ccc; background: #999;">

			<b><?php echo i18n_r("multiBlock/LISTCALL"); ?></b><br>

			<code style="color:blue;"> &#60;?php getMultiBlock('categoryname');?&#62; </code><br>

			<b><?php echo i18n_r("multiBlock/FORCELISTORDER"); ?></b><br>
			<code style=""> &#60;?php mborder();?&#62; </code> <br>

			<b><?php echo i18n_r("multiBlock/FORCELISTORDER2"); ?></b><br>

			<code style="color:blue;"> &#60;?php getMultiBlock('categoryname' , '#idContainer or .classContainer');?&#62; </code>

			<hr style="margin: 20px 0; border: 0; border-bottom: 1px dashed #ccc; background: #999;">
			
			<span style="color:grey;">Page theme example:</span>
<pre>
&#60;div class="wrapper" <span style="color:green">id="sort-me"></span>
	<span style="color:blue" >&#60;?php getMultiBlock('SomeSlug','<span style="color:green" >#sort-me</span>');?></span>
&#60;/div>
</pre>
				
			<span style="color:grey;">MB template example:</span>
<pre>
&#60;div class="block" <span style="color:green">&#60;?php mborder();?></span>>
	&#60;h4 class="card-title m-0"><span style="color:blue">&#60;?php mbvaluetext('title');?></span> &#60;/h4>
	&#60;img src="&#60;img src="<span style="color:blue">&#60;?php mbthumb('photo','300');?></span>">
	&#60;p class="date"><span style="color:blue">&#60;?php mbdate('pub-date','d.m.Y');?></span> &#60;/p>
	&#60;span class="info"><span style="color:blue">&#60;?php mbvalue('valuename');?></span>&#60;/span>
	<span style="color:red" >&#60;?php if(r_mbvaluetext('docs') !== ''):?></span>
	&#60;a href="<span style="color:blue">&#60;?php mbvaluetext('docs');?></span>">Download PDF &#60;/a>
	<span style="color:red" >&#60;?php endif;?></span>
&#60;/div> 
</pre>

<style>
	.row {
		display : flex;
		align-items : center;
		margin-bottom: 15px;
	}
	.key {
		position: relative;
		height: 15px;
		width: 15px;
		margin: 0 5px 0 20px;
		border: 1px solid black;
	}
	.red {
		background-color: red;
	}
	.green {
		background-color: green;
	}
	.blue {
		background-color: blue;
	}
</style>
<div class="row">
	<p><div class="key green"></div>Enable manual sorting <div class="key blue"></div>Placeholders <div class="key red"></div>IF value exits, display the following</p>
</div>

		</div>

	</div>

</form>

<br><br>

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

		const former = `<li>
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
			<option value="file"><?php echo i18n_r("multiBlock/FILE"); ?></option>
			<option value="dropdown"><?php echo i18n_r("multiBlock/DROPDOWN"); ?></option>
			<option value="link"><?php echo i18n_r("multiBlock/LINK"); ?></option>
		</select>
		<button class="mb_close">✕</button>
	</li>`;

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

<script src="<?php global $SITEURL; echo $SITEURL; ?>plugins/multiBlock/js/Sortable.min.js"></script>

<script>
	var el = document.getElementById('mb_inputs');
	var sortable = Sortable.create(el, {
		animation: 200,
	});

	document.querySelector('.mb_title').addEventListener('keyup', x => {

		document.querySelector('form').setAttribute('action', '<?php global $SITEURL;
																echo $SITEURL; ?>admin/load.php?id=multiBlock&addnew&categorytitle=' + document.querySelector('.mb_title_name').value + '&categoryname=' + document.querySelector('.mb_title').value)

	})


	document.querySelector('.mb_title_name').addEventListener('keyup', x => {

		document.querySelector('form').setAttribute('action', '<?php global $SITEURL;
																echo $SITEURL; ?>admin/load.php?id=multiBlock&addnew&categorytitle=' + document.querySelector('.mb_title_name').value + '&categoryname=' + document.querySelector('.mb_title').value)

	})
</script>

<?php
if (isset($_POST['savecat'])) {
	global $bb;
	$bb->saveCatMulti();
}; ?>
