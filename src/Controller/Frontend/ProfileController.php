<?php

declare(strict_types=1);


namespace App\Controller\Frontend;

use App\ReadModels\User\UserFetcher;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ProfileController extends AbstractController
{
    private UserFetcher $users;

    public function __construct(UserFetcher $user)
    {
        $this->users = $user;
    }

    /**
     * @Route("/profile", name="profile.index")
     */
    public function index(): Response
    {
        $user = $this->users->findDetail($this->getUser()->getId());

        return $this->render('app/profile/index.html.twig', [
            'user' => $user,
        ]);
    }
}
