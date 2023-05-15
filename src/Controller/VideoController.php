<?php

namespace App\Controller;

use App\Form\VideoType;
use App\Repository\VideoRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class VideoController extends AbstractController
{
    #[Route('/', name: 'app_video')]
    public function index(RequestStack $requestStack, VideoRepository $videoRepository): Response
    {
        $request = $requestStack->getMainRequest();

        $videoForm = $this->createForm(VideoType::class, $videoRepository->new());

        return $this->render('video/index.html.twig', [
            'form'=>$videoForm->createView()
        ]);
    }
}