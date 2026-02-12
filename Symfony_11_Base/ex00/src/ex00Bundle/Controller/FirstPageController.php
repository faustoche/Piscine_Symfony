<?php

namespace App\ex00Bundle\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class FirstPageController {
    #[Route('/ex00/firstpage', name: 'firstpage')]
    function firstpage(){
        return new Response("Hello World!");
    }
}