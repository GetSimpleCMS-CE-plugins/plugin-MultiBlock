<?php

# get correct id for plugin
$thisfile = basename(__FILE__, ".php");

$plugin_id = 'multiBlock';

i18n_merge($plugin_id) || i18n_merge($plugin_id, 'en_US');

# register plugin
register_plugin(
	$thisfile, //Plugin id
	'MultiBlock 🧱', 	//Plugin name
	'5.0', 		//Plugin version
	'Multicolor',  //Plugin author
	'https://discord.gg/d5s83yk4R6', //author website
	'create block what you want', //Plugin description
	'pages',
	'multiblock'  //main function (administration)
);


#add menu 

add_action('pages-sidebar', 'createSideMenu', [$thisfile, i18n_r('multiBlock/MULTIBLOCK') . ' 🧱', 'newmultiblock']);
$turnOneBlock = glob(GSDATAOTHERPATH . 'oneBlock/*/*.json');
if (count($turnOneBlock) > 0) {
	add_action('pages-sidebar', 'createSideMenu', [$thisfile, 'OneBlock 🧱', 'newoneblock']);
};
add_action('plugins-sidebar', 'createSideMenu', [$thisfile, i18n_r('multiBlock/MULTIBLOCKSETTINGS') . ' 🧱', 'category']);



#class for all function

include(GSPLUGINPATH . 'multiBlock/class/multiBlock.class.php');
$mb = new MultiBlock();

include(GSPLUGINPATH . 'multiBlock/class/oneBlock.class.php');
$ob = new OneBlock();

include(GSPLUGINPATH . 'multiBlock/class/frontMultiBlock.class.php');
$frontMb = new FrontMultiBlock();

include(GSPLUGINPATH . 'multiBlock/class/backBlock.class.php');
$bb = new BackBlock();


#paypal 


$paypal = '<form action="https://www.paypal.com/cgi-bin/webscr" method="post" target="_blank" style=" box-sizing:border-box;display:grid; width:100%;grid-template-columns:1fr auto; padding:10px;background:#fafafa;border:solid 1px #ddd;margin-top:20px;">
	<p style="margin:0;padding:0;"> ' . i18n_r('multiBlock/PAYPAL') . ' </p>
	<input type="hidden" name="cmd" value="_s-xclick">
	<input type="hidden" name="hosted_button_id" value="KFZ9MCBUKB7GL">
	<input type="image" src="https://www.paypalobjects.com/en_US/i/btn/btn_donate_SM.gif" name="submit" title="PayPal - The safer, easier way to pay online!" alt="Donate with PayPal button" border="0">
	<img alt="" src="https://www.paypal.com/en_PL/i/scr/pixel.gif" width="1" height="1" border="0">
</form>';



# functions
function multiblock()
{
	global $paypal;

	if (isset($_GET['category'])) {

		include(GSPLUGINPATH . 'multiBlock/category.php');

		echo $paypal;


		echo '<form  method="post" style="background:#fafafa;padding:10px;border:solid 1px #ddd;margin-top:10px;">
		<input type="submit" value="' . i18n_r("multiBlock/CACHETHUMB") . '" class="cleanthumb" style="padding:5px 10px;border:none;background:red;color:#fff;" name="cleanthumb">
		</form>';
	};

	if (isset($_GET['addnew'])) {

		include(GSPLUGINPATH . 'multiBlock/multiform/addnew.php');
	};

	if (isset($_GET['addnewOneBlock'])) {

		include(GSPLUGINPATH . 'multiBlock/oneform/addnewOneBlock.php');
	};


	if (isset($_GET['newmultiblock'])) {

		include('multiBlock/multiform/newmultiblock.php');

		echo $paypal;
	};

	//oneblock

	if (isset($_GET['newoneblock'])) {

		include('multiBlock/oneform/newoneblock.php');

		echo $paypal;
	};


	if (isset($_GET['newblock'])) {
		include(GSPLUGINPATH . 'multiBlock/multiform/newblock.php');
	};


	if (isset($_GET['newblock1'])) {
		include(GSPLUGINPATH . 'multiBlock/oneform/newblock1.php');
	};

	if (isset($_GET['blockoptions'])) {
		include(GSPLUGINPATH . 'multiBlock/blockOptions.php');
	};

	if (isset($_GET['migrator'])) {
		include(GSPLUGINPATH . 'multiBlock/migrator.php');
	};
}


//function multiblock

function mbOrder()
{
	global $mb;
	$mb->order();
};

function mbvaluetext($value)
{
	global $mb;
	$mb->text($value);
};


function mbvalue($value)
{
	global $mb;
	$mb->value($value);
};


function mbdropdown($value)
{
	global $mb;
	$mb->dropdown($value);
};


function mbthumb($value, $width)
{
	global $mb;
	$mb->thumb($value, $width);
}


/// function multiBlock front

function getMultiBlock($category, $orderid = '')
{
	global $frontMb;
	$frontMb->get($category, $orderid);
};


/// OneBlock function front

function getOneBlock($category, $name, $input)
{
	global $ob;
	$ob->get($category, $name, $input);
};

function getOneBlockWysywig($category, $name, $input)
{
	global $ob;
	$ob->wysywig($category, $name, $input);
};

function getOneBlockThumb($category, $name, $input, $width)
{

	global $ob;
	$ob->thumb($category, $name, $input, $width);
};



# function post

function mbCleanThumb()
{
	global $bb;
	$bb->cleanThumb();
};

if (isset($_POST['cleanthumb'])) {
	mbCleanThumb();
};
