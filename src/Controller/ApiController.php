<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class ApiController extends AbstractController
{
    #[Route('/api', name: 'app_api')]
    public function index(HttpClientInterface $client): Response
    {
        // make an api call to https://pokeapi.co/api/v2/pokemon
        $response = $client->request('GET', 'https://pokeapi.co/api/v2/pokemon/1/');
        $content = $response->toArray();
    }
}
