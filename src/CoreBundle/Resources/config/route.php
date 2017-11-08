<?php
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Validator\Constraints as Assert;



use \CoreBundle\Repository\DemandeRepository;
require __DIR__."/dev.php";

$app->get('/'.$bundleName."/test","CoreBundle\Controller\DemandesController::testAction");
$app->get('/'.$bundleName."/demande","CoreBundle\Controller\DemandesController::addDemandePageController");

$app->post('/'.$bundleName."/demande","CoreBundle\Controller\DemandesController::addDemandesController")->bind("core_add_demande");
