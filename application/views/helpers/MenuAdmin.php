<?php

class Miki_View_Helper_MenuAdmin {

	/**
	 * 
	 * 
	 */
	public function menuAdmin ( $mainCats, $baseUrl ) {
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
			$menuRet .=  '<dt class="adminMenuNadpis" >';
			$menuRet .=  $key;	
			$menuRet .= "</dt>";
			
			$menuRet .= '<dd>';
			$menuRet .=	 "<ul>";
			
				foreach ($mainCat as $kategorie) {	
					$menuRet .=	"<li  >
						<a   href=\"".$baseUrl."/admin/polozky/id/".$kategorie->id_categories."\">";
							$menuRet .=  "<span class=\"adminMenuPolozka\">".$kategorie->jmeno . "</span>";	
						$menuRet .=  "</a>
					</li>";
				}
			
			$menuRet .= "</ul><br />
				 </dd>";
		}
			
		return $menuRet ;
	}
}

?>