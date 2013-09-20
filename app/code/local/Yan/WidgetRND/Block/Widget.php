<?php
class Yan_WidgetRND_Block_Widget extends Mage_Core_Block_Template  
	implements Mage_Widget_Block_Interface 
{	
	public function WidgetRND(){
		$count = $this->getTitle();
		$arr = array();
		$products_id = array();
		$arr_rnd = array();
		$products = Mage::getSingleton('catalog/product');
		$category = Mage::getSingleton('catalog/category');
		$arr = $this->getData();
		foreach ($arr as $k => $v){
			if ($v == 'on'){
				$category->load($k);
				$collection = $category->getProductCollection();
				foreach ($collection as $product) {
					$products_id[] = $product->getId();
				}	
			}
		}
// 		print_r($products_id);
// 		die();
		if (!empty($products_id)){
			if (count($products_id) >= $count){
				if (count($products_id) == 1){
					$arr_rnd = $products_id[0];
				} else { $arr_rnd = array_rand($products_id, $count); }
			} else {
				if (count($products_id) > 1){
					foreach ($products_id as $k => $v){
						$arr_rnd[] = $k;
					}	
				} else { $arr_rnd = $products_id[0]; }		
			} 
// 			print_r ($arr_rnd);
// 			die();
			$num = 0;
			echo "<table align='center' border='5'><tr align='center'>";
			if (is_array($arr_rnd)){
				foreach ($arr_rnd as $v){
					if ($num % 3 == 0){ echo "</tr><tr align='center'>"; }
					$products->load($products_id[$v]);
					echo "<td align='center'><p align='center'><img src='" . $products->getImageUrl() . "' align='top'></p>";
					echo "<p align='center'>" . $products->getName() . "</p></td>";
					$num++;
				}	
			} else {
				echo "</tr><tr align='center'>"; 
				if ($count == 1) { $products->load($products_id[$arr_rnd]); }
				else { $products->load($arr_rnd); }
				echo "<td align='center'><p align='center'><img src='" . $products->getImageUrl() . "' align='top'></p>";
				echo "<p align='center'>" . $products->getName() . "</p></td>";
			}
			echo "</tr></table>";
		}
	} 
	
	public function _toHtml(){
		$this->WidgetRND();
	}
}