<?php declare(strict_types=1);

namespace App\Controller;

use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;
use App\Component\Controller\AbstractController;

/**
 * Class Home
 * @package App\Controller
 */
#[Route("/", name: "home_")]
class Home extends AbstractController
{
    /**
     * @return Response
     */
    #[Route("/", name: "index")]
    public function indexAction()
    {
        return $this->render();
    }
}