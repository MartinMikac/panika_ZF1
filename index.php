<?php
//error_reporting(E_ALL|E_STRICT);
error_reporting(E_ALL);

date_default_timezone_set('Europe/Prague');

set_include_path('.' . PATH_SEPARATOR . './library' . PATH_SEPARATOR . './application/domain/' . PATH_SEPARATOR . './application/models/' . PATH_SEPARATOR . get_include_path());
include "Zend/Loader.php";
@Zend_Loader::registerAutoload();

// load configuration
$config = new Zend_Config_Ini('./application/config.ini', 'general');
$registry = Zend_Registry::getInstance();
$registry->set('config', $config);


// Machine service
require_once './application/service/OnlineService.php';
Zend_Registry::set('onlineService', new OnlineService());

// Admin service
require_once './application/service/AdminService.php';
Zend_Registry::set('adminService', new AdminService());


// uzivateleView service
require_once './application/service/UzivateleViewService.php';
Zend_Registry::set('uzivateleViewService', new UzivateleViewService());

// Alert service
require_once './application/service/AlertService.php';
Zend_Registry::set('alertService', new AlertService());

// alertView service
require_once './application/service/AlertViewService.php';
Zend_Registry::set('alertViewService', new AlertViewService());


/*


// MachineHistory service
require_once './application/service/MachineHistoryChangeService.php';
Zend_Registry::set('machineHistoryChangeService', new MachineHistoryChangeService());

// MachineHistory service
require_once './application/service/FailureService.php';
Zend_Registry::set('failureService', new FailureService());


// MachineHistory service
require_once './application/service/HistoryFailureService.php';
Zend_Registry::set('historyFailureService', new HistoryFailureService());


// MachineDateView service
require_once './application/service/MachineDateViewService.php';
Zend_Registry::set('machineDateViewService', new MachineDateViewService());

// MachineDateView service
require_once './application/service/MachineDateClearViewService.php';
Zend_Registry::set('machineDateClearViewService', new MachineDateClearViewService());

// MachineDateView service
require_once './application/service/MachineDateCsvViewService.php';
Zend_Registry::set('machineDateCsvViewService', new MachineDateCsvViewService());

*/


//Basket service
//require_once './application/service/BasketService.php';
//Zend_Registry::set('basketService', new BasketService());

// Member service - MUSTER
//require_once './application/service/MemberService.php';
//Zend_Registry::set('memberService', new MemberService());
/*
// Category service
require_once './application/service/CategoryService.php';
Zend_Registry::set('categoryService', new CategoryService());

// MainCategory service
require_once './application/service/MainCategoryService.php';
Zend_Registry::set('mainCategoryService', new MainCategoryService());

// Item service
require_once './application/service/ItemService.php';
Zend_Registry::set('itemService', new ItemService());

// ItemDetail service
require_once './application/service/ItemDetailService.php';
Zend_Registry::set('itemDetailService', new ItemDetailService());

// Material service
require_once './application/service/MaterialService.php';
Zend_Registry::set('materialService', new MaterialService());

// TempBasket service
require_once './application/service/TempBasketService.php';
Zend_Registry::set('tempBasketService', new TempBasketService());

// TempBasketSummary service
require_once './application/service/TempBasketSummaryService.php';
Zend_Registry::set('tempBasketSummaryService', new TempBasketSummaryService());

//Customer service
require_once './application/service/CustomerService.php';
Zend_Registry::set('customerService', new CustomerService());

//Payment service
require_once './application/service/PaymentService.php';
Zend_Registry::set('paymentService', new PaymentService());

//TempOrder service
require_once './application/service/TempOrderService.php';
Zend_Registry::set('tempOrderService', new TempOrderService());

//Shiping service
require_once './application/service/ShipingService.php';
Zend_Registry::set('shipingService', new ShipingService());

//Order service
require_once './application/service/OrderService.php';
Zend_Registry::set('orderService', new OrderService());



//OrderStatut service
require_once './application/service/OrderStatutService.php';
Zend_Registry::set('orderStatutService', new OrderStatutService());

//Free service
require_once './application/service/FreeService.php';
Zend_Registry::set('freeService', new FreeService());
*/
// setup controller
$frontController = Zend_Controller_Front :: getInstance();


//  Pripojeni do DB

require_once './application/plugins/DbConnectPlugin.php';
$frontController->registerPlugin(new DbConnectPlugin($config->db->toArray()));


$frontController->throwExceptions(true);
$frontController->setControllerDirectory('./application/controllers');

$router = $frontController->getRouter();
$router->addRoute(
    'fauna',
    new Zend_Controller_Router_Route('fauna/:id',
                                     array('controller' => 'show',
                                           'action' => 'show'))
);

$router->addRoute(
    'flora',
    new Zend_Controller_Router_Route('flora/:id',
                                     array('controller' => 'show',
                                           'action' => 'show'))
);

$router->addRoute(
    'armada',
    new Zend_Controller_Router_Route('armada/:id',
                                     array('controller' => 'show',
                                           'action' => 'show'))
);

$router->addRoute(
    'fantasy',
    new Zend_Controller_Router_Route('fantasy/:id',
                                     array('controller' => 'show',
                                           'action' => 'show'))
);

$router->addRoute(
    'domaci',
    new Zend_Controller_Router_Route('domaci/:id',
                                     array('controller' => 'show',
                                           'action' => 'show'))
);

$router->addRoute(
    'doprava',
    new Zend_Controller_Router_Route('doprava/:id',
                                     array('controller' => 'show',
                                           'action' => 'show'))
);

$router->addRoute(
    'symboly',
    new Zend_Controller_Router_Route('symboly/:id',
                                     array('controller' => 'show',
                                           'action' => 'show'))
);

$router->addRoute(
    'halloween',
    new Zend_Controller_Router_Route('halloween/:id',
                                     array('controller' => 'show',
                                           'action' => 'show'))
);

$router->addRoute(
    'sport',
    new Zend_Controller_Router_Route('sport/:id',
                                     array('controller' => 'show',
                                           'action' => 'show'))
);



$router->addRoute(
    'vanoce',
    new Zend_Controller_Router_Route('vanoce/:id',
                                     array('controller' => 'show',
                                           'action' => 'show'))
);



// run!
$response = new Zend_Controller_Response_Http();
$response->setRawHeader('Expires: Mon, 26 Jul 1997 05:00:00 GMT');
$response->setRawHeader("Last-Modified: ".gmdate("D, d M Y H:i:s")." GMT");
$response->setRawHeader('Cache-Control: no-store, no-cache, must-revalidate');
$response->setRawHeader('Pragma: no-cache');


$frontController->dispatch(null , $response);
