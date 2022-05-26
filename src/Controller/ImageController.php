<?php

namespace App\Controller;

use App\Controller\Response\ErrorResponse;
use App\Controller\Response\SuccessResponse;
use App\Entity\Image;
use App\Repository\ImageRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ImageController extends AbstractController
{
    #[Route('/api/image', methods: ['POST'])]
    public function add(Request $request, ImageRepository $imageRepository): JsonResponse
    {
        $path = $request->get('path');
        $chatId = $request->get('chatId');

        if (empty($path) || empty($chatId)) {
            return new ErrorResponse(['error' => 'Нет данных'], Response::HTTP_BAD_REQUEST);
        }

        $image = new Image();
        $image
            ->setPath($path)
            ->setChatId($chatId);
        $imageRepository->add($image, true);

        return new SuccessResponse(['image' => $image->getPath()],Response::HTTP_CREATED);
    }

    #[Route('/api/image', methods: ['GET'])]
    public function all(ImageRepository $imageRepository): JsonResponse
    {
        $images = $imageRepository->findAll();

        if (empty($images)) {
            return new ErrorResponse(['error' => 'Записей не найдено'], Response::HTTP_BAD_REQUEST);
        }

        foreach ($images as $image) {
            $data[] = [
                'id' => $image->getId(),
                'path' => $image->getPath(),
                'chatId' => $image->getChatId(),
            ];
        }

        return new SuccessResponse($data ?? [],Response::HTTP_OK);
    }
}
