

<?php

require_once("api/ApiController.php");
require_once("client/MasterController.php");
require_once("client/view/CollectionView.php");
require_once("client/view/Layout.php");

$a = new ApiController();
$cv = new CollectionView($a);
$m = new MasterController($a, $cv);



$m->init();

$l = new Layout();

$l->render($cv);