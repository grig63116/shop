<?php

namespace App\Controller;

use App\Component\Controller\AbstractController;
use App\Form\Type\RegistrationFormType;
use App\Entity\User;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

/**
 * Class Authentication
 * @package App\Controller
 */
#[Route("/", name: "authentication_")]
class Authentication extends AbstractController
{
    /**
     * @var EntityManagerInterface
     */
    private $em;

    /**
     * @var SessionInterface
     */
    protected $session;

    /**
     * Authentication constructor.
     * @param EntityManagerInterface $em
     * @param SessionInterface $session
     */
    public function __construct(
        EntityManagerInterface $em,
        SessionInterface $session
    )
    {
        $this->em = $em;
        $this->session = $session;
    }

    /**
     * @return array
     */
    public static function getSubscribedServices()
    {
        return array_merge(parent::getSubscribedServices(), [
            'security.password_encoder' => '?' . UserPasswordEncoderInterface::class,
        ]);
    }

    /**
     * @return Response
     */
    #[Route("/login", name: "login", methods: ["GET"])]
    public function loginAction(): Response
    {
        if ($this->getUser()) {
            return $this->redirectToRoute('account_index');
        }

        return $this->render();
    }

    /**
     * @return Response
     */
    #[Route("/login", name: "login_handler", methods: ["POST"])]
    public function loginHandlerAction(): Response
    {
        return $this->json([]);
    }

    /**
     * @throw new \RuntimeException
     */
    #[Route("/logout", name: "logout")]
    public function logoutAction()
    {
        throw new \RuntimeException('This should never be called directly.');
    }

    /**
     * @return Response
     */
    #[Route("/register", name: "register", methods: ["GET"])]
    public function registerAction()
    {
        if ($this->getUser()) {
            return $this->redirectToRoute('account_index');
        }
        $user = new User();

        $form = $this->createForm(RegistrationFormType::class, $user, [
            'action' => $this->generateUrl('authentication_register_handler')
        ]);

        $this->assign([
            'form' => $form->createView()
        ]);
dump($form);exit;
        return $this->render();
    }

    /**
     * @return RedirectResponse|Response
     */
    #[Route("/register", name: "register_handler", methods: ["POST"])]
    public function registerHandlerAction()
    {
        if ($this->getUser()) {
            return $this->redirectToRoute('account_index');
        }
        $user = new User();

        $form = $this->createForm(RegistrationFormType::class, $user, [
            'action' => $this->generateUrl('authentication_register_handler')
        ]);

        $form->handleRequest($this->request);
        if (!$form->isSubmitted() || !$form->isValid()) {
            return $this->render('authentication/register.twig', [
                'form' => $form->createView(),
            ]);
        }

        $password = $this->get('security.password_encoder')->encodePassword($user, $user->getPlainPassword());
        $user->setPassword($password);

        $this->em->persist($user);
        $this->em->flush();

        $this->loginUser($user);

        return $this->redirectToRoute('account_index');
    }
}
