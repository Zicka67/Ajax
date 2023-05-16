<?php

namespace App\Controller;

use App\Form\VideoType;
use App\Services\VideoService;
use App\Repository\VideoRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class VideoController extends AbstractController
{
    #[Route('/', name: 'app_video')]
    public function index(RequestStack $requestStack, VideoRepository $videoRepository, VideoService $videoService): Response
    {
        $request = $requestStack->getMainRequest();

        $videoForm = $this->createForm(VideoType::class, $videoRepository->new());
        
        $videoForm->handleRequest($request);

        $response = null;
        if($videoForm->isSubmitted()) {
            $response = $videoService->handleVideoForm($videoForm);
            if ($response instanceof JsonResponse) {
                return $response;
            }
        }

        return $this->render('video/index.html.twig', [
            'form'=>$videoForm->createView(),
            'response' => $response,
            'videos' => $videoRepository->findAll(),
        ]);
    }
}
