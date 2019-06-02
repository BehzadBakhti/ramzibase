<?php

// $some_name = session_name("some_name");
// session_set_cookie_params(0, '/', '.ramzibase.com');
session_start();

require('config.php');
require('classes/Router.php');
require('classes/Controller.php');
require('classes/Model.php');
require('classes/BitGoSDK.php');
require('classes/Bahamta.php');
require('classes/Address_validation/Validation.php');
require('classes/Address_validation/Validation/LTC.php');
require('classes/Address_validation/Validation/ETH.php');
require('classes/Address_validation/Validation/BTC.php');
require('classes/Address_validation/Validation/DASH.php');
require('classes/Address_validation/Validation/DOGE.php');
require('classes/Address_validation/Utils/Sha3.php');
require('controllers/home.php');
require('controllers/users.php');
require('controllers/funds.php');
require('controllers/fourofour.php');
require('controllers/admins.php');
require('controllers/deals.php');
require('controllers/table_updates.php');
require('controllers/market_maker.php');
require('controllers/aboutUs.php');
require('controllers/features.php');
require('controllers/rules.php');
require('controllers/posts.php');
require('controllers/blogs.php');
require('models/blog.php');
require('models/post.php');
require('models/rules.php');
require('models/features.php');
require('models/market_maker.php');
require('models/aboutUs.php');
require('models/deal.php');
require('models/admin.php');
require('models/reserve.php');
require('models/fourofour.php');
require('models/fund.php');
require('models/user.php');
require('models/home.php');
require('models/table_update.php');
$router=new Router($_GET);
$controller=$router->createController();
if($controller){
	$controller->executeAction();
} 