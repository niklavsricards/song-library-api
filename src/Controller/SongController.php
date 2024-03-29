<?php

namespace App\Controller;

use App\Repository\SongRepository;
use PHPUnit\Util\Json;
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
        header('Access-Control-Allow-Origin: *');
        header("Access-Control-Allow-Headers: X-API-KEY, Origin, X-Requested-With, Content-Type, Accept, Access-Control-Request-Method");
        header("Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, DELETE");
        header("Allow: GET, POST, OPTIONS, PUT, DELETE");
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

    /**
     * @Route("/api/songs", name="get_all_songs", methods={"GET"})
     */
    public function getAll(): JsonResponse
    {
        $songs = $this->songRepository->findAll();

        $data = [];

        foreach ($songs as $song)
        {
            $data[] = [
                "id" => $song->getId(),
                "title" => $song->getTitle(),
                "artist" => $song->getArtist(),
                "length" => $song->getLength()
            ];
        }

        return new JsonResponse($data, Response::HTTP_OK);
    }
}
