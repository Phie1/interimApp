<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class CoinController extends Controller
{
    /**
     * @Route("/coin", name="coin")
     */
    public function index()
    {
    	//die(print_r(mt_rand(0,1)));
    	$number = mt_rand(0, 2);

    	if ($number = 0) {
    		$flip = "Papier";
    	} elseif ($number = 1) {
    		$flip = "Caillou";
    	} else {
    		$flip = "Ciseau";
    	}

    	return new Response(
            '<html><body>'.$number.'</body></html>'
        );
        /*return $this->render('coin/index.html.twig', [
            'controller_name' => 'CoinController',
            'coin_flip' => $flip
        ]);*/
    }
}
