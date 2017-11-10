<?php

class Miki_View_Helper_MenuKategorie {

	/**
	 * 
	 * 
	 */
	public function menuKategorie ( $mainCats,$categories, $baseUrl ) {
		$menuRet = "";
		
		//Zend_Debug::dump($mainCats);
		//Zend_Debug::dump($categories);
		
		
		/*
			<div class="kategorie-main" > MOTOCYKLY </div> 
			<div class="kategorie-normal" > Harley </div> 
			<div class="kategorie-normal" > Honda </div> 
			<div class="kategorie-normal" > Suzuki </div> 
			<div class="kategorie-normal" > Harley </div> 
			<div class="kategorie-normal" > Honda </div> 
			<div class="kategorie-normal" > Suzuki </div>
		*/
		
		
		
		foreach ($mainCats as $key=>$mainCat) {

			$menuRet .=  "
			
			<div class=\"kategorie-main\" >".$mainCat->jmenoShow."</div>
			";
						
				foreach ($categories as $kategorie) {
						if ($kategorie->id_mainCategories == $mainCat->id_mainCategories  	) {
							$menuRet .= "<div class=\"kategorie-normal\" ><a class=\"\" href=\"".$baseUrl."/".$mainCat->jmeno."/".$kategorie->jmeno."\">".$kategorie->jmenoShow."</a></div> 
							";
						}
					}
				
		}
		
		
		return $menuRet ;
	}
}

?>