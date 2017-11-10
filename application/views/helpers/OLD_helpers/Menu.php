<?php

class Miki_View_Helper_Menu {

	/**
	 * 
	 * 
	 */
	public function menu ( $mainCats, $baseUrl ) {
		$menuRet = "";
		
		/*
		<dt onclick="javascript:showMenu('tricka');"><img src="<?php echo $this->baseUrl?>/public/images/menu/tricka.gif" alt="" title="" /></dt>
		<dd id="tricka">
			<ul>		
				
				<li><a href="<?php	echo $this->baseUrl?>/trika/kratky-rukav"><img src="<?php echo $this->baseUrl?>/public/images/menu/kratky_rukav.gif" alt="" title="" /></a></li>
				<li><a href="<?php	echo $this->baseUrl?>/trika/bez-rukavu"><img src="<?php echo $this->baseUrl?>/public/images/menu/bez_rukavu.gif" alt="" title="" /></a></li>
				<li><a href="<?php	echo $this->baseUrl?>/trika/detske"><img src="<?php echo $this->baseUrl?>/public/images/menu/detske.gif" alt="" title="" /></a></li>
				<li><a href="<?php	echo $this->baseUrl?>/trika/polokosile"><img src="<?php echo $this->baseUrl?>/public/images/menu/polokosile.gif" alt="" title="" /></a></li>
				<li><a href="<?php	echo $this->baseUrl?>/trika/polokosile-pike"><img src="<?php echo $this->baseUrl?>/public/images/menu/polokosile_pike.gif" alt="" title="" /></a></li>
				
			</ul>
		</dd>		
		*/
		
		foreach ($mainCats as $key=>$mainCat) {
			$menuRet .=  '<dt onclick="javascript:showMenu(\''.$key.'\');">';
			
			if (file_exists("public/images/menu/".$key.".gif")) {
				$menuRet .= "<img src=\"$baseUrl/public/images/menu/".$key.".gif\" alt=\"".$key."\" title=\"".$key."\" />";
			}else {
				$menuRet .=  $key;	
			}
			
			$menuRet .= "</dt>";
			$menuRet .= '<dd id="'.$key.'">';
			$menuRet .=	 "<ul>";
			
				foreach ($mainCat as $kategorie) {	
					//$menuRet .=	"<li><a href=\"".$baseUrl."/ukaz/index/jmeno/".$kategorie->jmeno."/id/".$kategorie->id_categories."\">";
					$menuRet .=	"<li><a href=\"".$baseUrl."/".$key."/".$kategorie->jmeno."\">";
					
					if (file_exists("public/images/menu/".$kategorie->jmeno.".gif")) {
						
						$menuRet .= "<img src=\"$baseUrl/public/images/menu/".$kategorie->jmeno.".gif\" alt=\"".$kategorie->jmeno."\" title=\"\" />";
					}else {
						$menuRet .=  $kategorie->jmeno;	
					}
					
					$menuRet .=  "</a></li>";
				}
			
			$menuRet .= "</ul>
				 </dd>";
		}
			
		return $menuRet ;
	}
}

?>