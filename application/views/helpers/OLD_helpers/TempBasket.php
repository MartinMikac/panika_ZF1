<?php

class Miki_View_Helper_TempBasket {

	/**
	 * 
	 * 
	 */
	public function tempBasket ( $tempBaskets , $baseUrl  ) {
		$ret = "";
		
		$cena_celkem = 0;

		if ($tempBaskets) {
			foreach ($tempBaskets as $tempBasket) {
				$cena_celkem += $tempBasket->cena;	
				
			}
			
		}
			
		
		$ret .= "<span style=\"color:white\"><a style=\"color:white\" href=\"".$baseUrl."/koupit/kosik\">V košíku za ".$cena_celkem . " Kč </a> </span>";
		
		echo $ret;
		
	}
}

?>