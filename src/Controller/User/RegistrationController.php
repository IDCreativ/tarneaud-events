<?php

namespace App\Controller\User;

use App\Entity\User;
use App\Security\EmailVerifier;
use App\Form\InscriptionsFormType;
use App\Form\RegistrationFormType;
use App\Form\Inscriptions2FormType;
use Symfony\Component\Mime\Address;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\GeneralConfigurationRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use SymfonyCasts\Bundle\VerifyEmail\Exception\VerifyEmailExceptionInterface;

class RegistrationController extends AbstractController
{
    private $emailVerifier;
    private $generalConfigurationRepository;

    public function __construct(
        EmailVerifier $emailVerifier,
        GeneralConfigurationRepository $generalConfigurationRepository
        )
    {
        $this->emailVerifier = $emailVerifier;
        $this->generalConfigurationRepository = $generalConfigurationRepository;
    }

    /**
     * @Route("/register", name="app_register")
     */
    public function register(Request $request, UserPasswordEncoderInterface $passwordEncoder): Response
    {
        $user = new User();
        $form = $this->createForm(RegistrationFormType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // encode the plain password
            $user->setPassword(
                $passwordEncoder->encodePassword(
                    $user,
                    $form->get('plainPassword')->getData()
                )
            );

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($user);
            $entityManager->flush();

            // generate a signed url and email it to the user
            $this->emailVerifier->sendEmailConfirmation('app_verify_email', $user,
                (new TemplatedEmail())
                    ->from(new Address('verify@blue-com.fr', 'Verify Mail Bot'))
                    ->to($user->getEmail())
                    ->subject('Please Confirm your Email')
                    ->htmlTemplate('registration/confirmation_email.html.twig')
            );
            // do anything else you need here, like send an email

            return $this->redirectToRoute('app_login');
        }

        return $this->render('registration/register.html.twig', [
            'registrationForm' => $form->createView(),
        ]);
    }

    /**
     * @Route("/inscription", name="app_inscription")
     */
    public function inscription(Request $request, UserPasswordEncoderInterface $passwordEncoder): Response
    {
        if ($this->generalConfigurationRepository->findLast()->getEvent() != null) {
            $user = new User();
            $form = $this->createForm(InscriptionsFormType::class, $user);
            $form->handleRequest($request);

            $form2 = $this->createForm(Inscriptions2FormType::class, $user);
            $form2->handleRequest($request);

            $thePassword = '';
            $lastConfiguration = $this->generalConfigurationRepository->findLast();
            $thePassword = $lastConfiguration->getEvent()->getEventPassword();

            if ($form->isSubmitted() && $form->isValid()) {
                if ($lastConfiguration && $lastConfiguration->getEvent() != null) {
                    $user->setPassword(
                        $passwordEncoder->encodePassword(
                            $user,
                            $thePassword
                        )
                    );
        
                    $entityManager = $this->getDoctrine()->getManager();
                    $entityManager->persist($user);
                    $entityManager->flush();
        
                    return $this->redirectToRoute('app_login');
                }
            }
            if ($form2->isSubmitted() && $form2->isValid()) {
                if ($form2->get('password')->getData() == $thePassword || $thePassword == null) {

                    $user->setPassword(
                        $passwordEncoder->encodePassword(
                            $user,
                            $form2->get('password')->getData()
                        )
                    );

                    $entityManager = $this->getDoctrine()->getManager();
                    $entityManager->persist($user);
                    $entityManager->flush();

                    return $this->redirectToRoute('app_login');
                }
                else {
                    $this->addFlash('danger', 'Le mot de passe indiqué n\'est pas correct.');
                }
            }

            return $this->render('registration/inscription.html.twig', [
                'lastConfiguration'            => $lastConfiguration,
                'registrationForm' => $form->createView(),
                'registration2Form' => $form2->createView(),
            ]);
        }
        else {
            $this->addFlash('info', 'Les inscriptions ne sont pas disponibles pour le moment.');
            return $this->redirectToRoute('home');
        }
        
    }

    /**
     * @Route("/verify/email", name="app_verify_email")
     */
    public function verifyUserEmail(Request $request): Response
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');

        // validate email confirmation link, sets User::isVerified=true and persists
        try {
            $this->emailVerifier->handleEmailConfirmation($request, $this->getUser());
        } catch (VerifyEmailExceptionInterface $exception) {
            $this->addFlash('verify_email_error', $exception->getReason());

            return $this->redirectToRoute('app_register');
        }

        // @TODO Change the redirect on success and handle or remove the flash message in your templates
        $this->addFlash('success', 'Your email address has been verified.');

        return $this->redirectToRoute('home');
    }
}
