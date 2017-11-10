<?php

class Miki_View_Helper_Navigace {

	/**
	 * 
	 * 
	 */
	public function navigace ( Venturia_Db_Rowset_ScrollAble $rowset , $page , $url ,$baseUrl ) {

		if ($rowset->pages() <= 1) {
			return ;
		}
		
		$nav = '' ;
		$nav .= '<div id="galerieNavigace">' ;
		$nav .= "
		      <div style=\"float: left; clear:both; padding-top=50px;\">";
		if (($page ) > 0) {
			$nav .= "<a href=\"{$url}\"><img style=\"border: 0px;\" src=\"".$baseUrl."/public/images/page_bar/dvoj_sipka_leva.gif\" alt=\"dvoj_sipka_leva.gif, 1 kB\" title=\"dvoj_sipka_leva\" height=\"23\" width=\"35\"/></a>";
		}else {
			$nav .= "<img style=\"border: 0px;\" src=\"".$baseUrl."/public/images/page_bar/dvoj_sipka_leva.gif\" alt=\"dvoj_sipka_leva.gif, 1 kB\" title=\"dvoj_sipka_leva\" height=\"23\" width=\"35\"/>";
		}

		
		if (($page - 1) >= 0) {
			$nav .= '<a href="?page='.($page-1).'">'; 
			$nav .= "<img class=\"noBorder\" src=\"".$baseUrl."/public/images/page_bar/sipka_leva.gif\" alt=\"sipka_leva.gif, 1 kB\" title=\"sipka_leva\"  height=\"23\" width=\"27\"/> ";
			$nav .= '</a>';
		}else {
			$nav .= "<img class=\"noBorder\" src=\"".$baseUrl."/public/images/page_bar/sipka_leva.gif\" alt=\"sipka_leva.gif, 1 kB\" title=\"sipka_leva\"  height=\"23\" width=\"27\"/> ";
		}

		$nav .= '</div>' ;
		
		$nav .= '<div style="float: left;width:13px; background-position: right; background-image: url('.$baseUrl.'/public/images/page_bar/bar_leva.gif); background-repeat: no-repeat;  height: 23px;" >';
		$nav .= '</div>';
		
		$nav .= '<div style="float: left; background-image: url('.$baseUrl.'/public/images/page_bar/bar.gif); background-repeat: repeat-x; width:500px; height: 23px; background-position: bottom;" >';
		$nav .= '<div style="float: right; text-align: right; height:23px; line-height:23px; width:470px; padding-right:30px;">počet záznamů: '.$rowset->countAll().' / strana '.($page+1).' z '.$rowset->pages().'</div>';
		$nav .= '</div>';		
		
		 $nav .= '<div style="float: left;width:13px; background-position: left;  background-image: url('.$baseUrl.'/public/images/page_bar/bar_prava.gif); background-repeat: no-repeat;height: 23px;" >
			</div>';
		 
		 $nav .= '<div style="float: left;">';
		 
		 if (($page + 1) < $rowset->pages()) {
			$nav .= '<a href="?page='.($page+1).'">';
			$nav .= "<img class=\"noBorder\" src=\"".$baseUrl."/public/images/page_bar/sipka_prava.gif\" alt=\"sipka_prava.gif, 1 kB\" title=\"sipka_prava\" height=\"23\" width=\"27\"/>";
			$nav .= '</a>';
		}else {
			$nav .= "<img class=\"noBorder\" src=\"".$baseUrl."/public/images/page_bar/sipka_prava.gif\" alt=\"sipka_prava.gif, 1 kB\" title=\"sipka_prava\" height=\"23\" width=\"27\"/>";
		}
		 
		if (($rowset->pages() ) != ($page+1)) {
			$nav .= '<a href="?page='.($rowset->pages()-1).'">';
			$nav .= '<img class="noBorder" src="'.$baseUrl.'/public/images/page_bar/dvoj_sipka_prava.gif" alt="dvoj_sipka_prava.gif, 1 kB" title="dvoj_sipka_prava"  height="23" width="35"/>
				</a>';
		}else {
			$nav .= '<img class="noBorder" src="'.$baseUrl.'/public/images/page_bar/dvoj_sipka_prava.gif" alt="dvoj_sipka_prava.gif, 1 kB" title="dvoj_sipka_prava"  height="23" width="35"/>';
		}
 

		$nav .= '</div>';
		$nav .= '</div>';
	
		return $nav ;
	}
}

?>