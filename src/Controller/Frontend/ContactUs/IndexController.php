<?php

declare(strict_types=1);

namespace App\Controller\Frontend\ContactUs;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/contact", name="contact")
 */
class IndexController extends AbstractController
{
    /**
     * @Route("", name=".index")
     *
     * @return Response
     */
    public function index(): Response
    {
        return $this->render('/app/contact/index.html.twig');
    }
}
