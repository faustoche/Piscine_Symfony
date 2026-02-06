<?php

namespace App\e00Bundle\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class FirstPageController {
    #[Route('/e00/firstpage', name: 'firstpage')]
    function firstpage(){
        return new Response("Hello World!");
    }
}