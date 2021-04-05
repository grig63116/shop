<?php

namespace App\Controller;

use Symfony\Component\Routing\Annotation\Route;
use App\Component\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;

/**
 * Class Account
 * @package App\Controller
 */
#[Route("/account", name: "account_")]
class Account extends AbstractController
{

    /**
     * @return Response
     */
    #[Route("/", name: "index")]
    public function indexAction()
    {
        if (!$this->getUser()) {
            return $this->redirectToRoute('authentication_login');
        }
        return $this->render();
    }

    /**
     * @return Response
     */
    #[Route("/user", name: "user", methods: ['GET'], condition: "request.isXmlHttpRequest()")]
    public function userAction(Request $request)
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');
        return $this->json($this->getUserData());
    }
}