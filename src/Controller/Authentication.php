<?php

namespace App\Controller;

use App\Component\Controller\AbstractController;
use App\Form\Type\RegistrationFormType;
use App\Service\Core\MailService;
use App\Entity\User;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

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
     * @param ContainerInterface $container
     * @param EntityManagerInterface $em
     * @param SessionInterface $session
     */
    public function __construct(
        ContainerInterface $container,
        EntityManagerInterface $em,
        SessionInterface $session
    )
    {
        if (class_exists(get_parent_class($this)) && method_exists(get_parent_class($this), __FUNCTION__)) {
            call_user_func_array([get_parent_class($this), __FUNCTION__], func_get_args());
        }
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

    #[Route("/login", name: "login", methods: ["GET"])]
    public function loginAction(AuthenticationUtils $authenticationUtils): Response
    {
        if ($this->getUser()) {
            return $this->redirectToRoute('account_index');
        }

        // get the login error if there is one
        $error = $authenticationUtils->getLastAuthenticationError();
        // last username entered by the user
        $lastUsername = $authenticationUtils->getLastUsername();

        $this->assign([
            'last_username' => $lastUsername,
            'error' => $error
        ]);

        return $this->render();
    }

    #[Route("/login/handler", name: "login_handler", methods: ["POST"])]
    public function loginCheckAction()
    {
        throw new \RuntimeException('This should never be called directly.');
    }

    #[Route("/logout", name: "logout")]
    public function logoutAction()
    {
        throw new \RuntimeException('This should never be called directly.');
    }

    /**
     * @return Response
     * @throws \LogicException
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

        return $this->render();
    }

    /**
     * @return RedirectResponse|Response
     * @throws \Twig\Error\LoaderError
     * @throws \Twig\Error\RuntimeError
     * @throws \Twig\Error\SyntaxError
     */
    #[Route("/register/handler", name: "register_handler", methods: ["POST"])]
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
