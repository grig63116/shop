<?php

namespace App\Controller;

use App\Component\Controller\AbstractController;
use App\Form\RegistrationFormType;
use App\Entity\User;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Security\Core\Authorization\Voter\AuthenticatedVoter;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Form\FormInterface;

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
    #[Route("/login", name: "login_handler", methods: ["POST"], condition: "request.isXmlHttpRequest()")]
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
    public function registerAction(): Response
    {
        if ($this->getUser()) {
            return $this->redirectToRoute('account_index');
        }
        return $this->render();
    }

    /**
     * @return RedirectResponse|Response
     */
    #[Route("/register", name: "register_handler", methods: ["POST"], condition: "request.isXmlHttpRequest()")]
    public function registerHandlerAction(): Response
    {
        $this->denyAccessUnlessGranted(AuthenticatedVoter::IS_ANONYMOUS);
        $user = new User();

        $form = $this->createForm(RegistrationFormType::class, $user, [
            'action' => $this->generateUrl('authentication_register_handler')
        ]);

        $form->handleRequest($this->request);
        if (!$form->isSubmitted() || !$form->isValid()) {
            return $this->json($this->getFormData($form), Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        $password = $this->get('security.password_encoder')->encodePassword($user, $user->getPlainPassword());
        $user->setPassword($password);

        $this->em->persist($user);
        $this->em->flush();

        $this->loginUser($user);

        return $this->json([]);
    }

    /**
     * @return Response
     */
    #[Route("/register/form", name: "register_form", methods: ["GET"])]
    public function registerFormAction(): Response
    {
        $this->denyAccessUnlessGranted(AuthenticatedVoter::IS_ANONYMOUS);
        $user = new User();

        $form = $this->createForm(RegistrationFormType::class, $user, [
            'action' => $this->generateUrl('authentication_register_handler')
        ]);
        return $this->json($this->getFormData($form));
    }

    /**
     * @param FormInterface $form
     * @return array
     */
    private function getFormData(FormInterface $form): array
    {
        $view = $form->createView();
        $data = array_merge($view->vars, [
            'children' => []
        ]);
        foreach ($view->children as $name => $child) {
            $data['children'][$name] = $child->vars;
        }
        foreach ($form->all() as $name => $child) {
            $data['children'][$name] = $this->getFormData($child);
        }
        return $data;
    }
}
