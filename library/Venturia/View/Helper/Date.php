<?php

class Venturia_View_Helper_Date {
	public function date($name, $value = null) {
		$time = 0;
		if ($value == null) {
			$time = time ();
		} else {
			$time = strtotime ( $value );
		}
		$day = date ( 'j', $time );
		$month = date ( 'n', $time );
		$year = date ( 'Y', $time );
		
		$out = "<select name=\"{$name}_day\">";
		for($i = 1; $i <= 31; $i ++)
			$out .= "<option value=\"$i\"" . ($day == $i ? ' selected="selected"' : '') . ">$i</option>";
		$out .= "</select>";
		
		$out .= "<select name=\"{$name}_month\">";
		for($i = 1; $i <= 12; $i ++)
			$out .= "<option value=\"$i\"" . ($month == $i ? ' selected="selected"' : '') . ">$i</option>";
		$out .= "</select>";
		
		$out .= "<select name=\"{$name}_year\">";
		for($i = $year - 10; $i <= $year + 10; $i ++)
			$out .= "<option value=\"$i\"" . ($year == $i ? ' selected="selected"' : '') . ">$i</option>";
		$out .= "</select>";
		
		return $out;
	}
}

?>
