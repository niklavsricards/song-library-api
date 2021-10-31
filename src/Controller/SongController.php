<?php

namespace App\Controller;

use App\Repository\SongRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\Annotation\Route;

class SongController extends AbstractController
{
    private SongRepository $songRepository;

    public function __construct(SongRepository $songRepository)
    {
        $this->songRepository = $songRepository;
    }

    /**
     * @Route("/api/songs/add", name="add_song", methods={"POST"})
     */
    public function add(Request $request): JsonResponse
    {
        $data = json_decode($request->getContent(), true);

        $title = $data['title'];
        $artist = $data['artist'];
        $length = $data['length'];

        if (empty($title) || empty($artist) || empty($length)) {
            throw new NotFoundHttpException('Expecting mandatory parameters!');
        }

        $this->songRepository->addSong($title, $artist, $length);

        return new JsonResponse(['status' => 'Customer created!'], Response::HTTP_CREATED);
    }
}
