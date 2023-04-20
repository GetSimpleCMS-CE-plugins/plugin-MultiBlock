<?php

class frontMultiBlock
{


	public function get($category, $orderid)
	{
		global $getmb;
		$getmb;



		$orders = @file_get_contents(GSDATAOTHERPATH . 'multiBlock/' . $category . '/order.txt');

		foreach (glob(GSDATAOTHERPATH . "multiBlock/" . $category . "/*.json") as $mbBlock) {
			$info = pathinfo($mbBlock);
			$name = basename($mbBlock, '.' . $info['extension']);
			$template = GSDATAOTHERPATH . 'multiBlock/category/' . $category . '.txt';

			$mbjson = file_get_contents($mbBlock);

			global $getmb;

			$getmb = json_decode($mbjson);

			include($template);
		}

		if ($orderid !== '') {

			echo "
		<script>
			const arraylist" . str_replace('-', '', $category) . " = '" . @file_get_contents(GSDATAOTHERPATH . 'multiBlock/' . $category . '/order.txt') . "';
			const arraychange" . str_replace('-', '', $category) . " = arraylist" . str_replace('-', '', $category) . ".split(',');
			arraylist" . str_replace('-', '', $category) . ".split(',').forEach((x,i)=>{
				if(document.querySelector(`" . $orderid . " [data-id='`+x+`']`)!== null){
				  document.querySelector('" . $orderid . "').append(document.querySelector(`" . $orderid . " [data-id='`+x+`']`)); 
				} 
				 });
		</script>";

			global $counterOrder;
			$counterOrder = 0;
		}
	}
};
