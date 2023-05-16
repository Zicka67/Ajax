<?php

namespace App\Services;

use App\Entity\Video;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;

class VideoService 
{

    public function __construct(private EntityManagerInterface $entityManager, private ParameterBagInterface $parameters)
    {
        
    }

    public function handleVideoForm(FormInterface $videoForm): JsonResponse
    {
        if($videoForm->isValid()) {
            return $this->handleValidForm($videoForm);
        } else {
            return $this->handleInValidForm($videoForm);    
        }

    }

    public function handleValidForm(FormInterface $videoForm): JsonResponse
    {
        /** @var Video $video */
        $video = $videoForm->getData();

        /** @var UploadedFile $uploadedThumbnail */
        $uploadedThumbnail = $videoForm['thumbnail']->getData();

        /** @var UploadedFile $uploadedVideo */
        $uploadedVideo = $videoForm['videoFile']->getData();

        if (!$uploadedThumbnail){
            $video->setThumbnail(null   );
        } else {
            $newFileName = $this->renameUploadedFile($uploadedThumbnail, $this->parameters->get('thumbnails.upload_directory'));
        }

        $newFileName = $this->renameUploadedFile($uploadedVideo, $this->parameters->get('videos.upload_directory'));
        $video->setVideoFile($newFileName);

        $this->entityManager->persist($video);
        $this->entityManager->flush();

        return new JsonResponse( [
            'code' => Video::VIDEO_ADDED_SUCCESSFULLY,
            'html' => ""
        ]);
    }

    public function handleInValidForm(FormInterface $videoForm): JsonResponse
    {
        return new JsonResponse( [
            "code" => Video::VIDEO_INVALID_FORM
        ]);
    }

    public function renameUploadedFile(UploadedFile $uploadedFile, string $directory)
    {
        $newFileName = uniqid(more_entropy: true) . ".{$uploadedFile->guessExtension()}";
        $uploadedFile->move($directory, $newFileName);

        return $newFileName;
    }

}