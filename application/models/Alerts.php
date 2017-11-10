<?php

class Alerts extends Venturia_Db_Table_Abstract {
	
	protected $_name = "Alerts";
	protected $_primary = "id_alert";
	protected $_rowClass = 'Alert';

}