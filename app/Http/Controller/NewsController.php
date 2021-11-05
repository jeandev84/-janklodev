<?php
namespace App\Http\Controller;

use App\Entity\News;
use App\Http\Controller\Common\BaseController;
use App\Repository\NewsRepository;
use Jan\Component\Http\Request\Request;
use Jan\Component\Http\Response\Response;


/**
 * class NewsController
 *
 * @package App\Http\Controller
*/
class NewsController extends BaseController
{

    /**
     * @param Request $request
     * @param NewsRepository $repository
     * @return Response
     * @throws \Exception
    */
    public function index(Request $request, NewsRepository $repository): Response
    {
        $news = $repository->findAll();

        return $this->render('news/index.php', compact('news'));
    }


    /**
     * @param Request $request
     * @param NewsRepository $repository
     * @param $id
     * @return Response
     * @throws \Exception
    */
    public function show(Request $request, NewsRepository $repository, $id): Response
    {
        $news = $repository->findOneBy(['id' => $id]);

        if (! $news) {
            throw new \Exception('not found object news with id '. $id);
        }

        return $this->render('news/show.php', compact('news'));
    }


    /**
     * @param Request $request
     * @return Response
     * @throws \Exception
    */
    public function create(Request $request): Response
    {
        if ($request->request->all()) {

            $news = new News();

            $publishedAt = $request->request->get('publishedAt');

            $news->setTitle($request->request->get('title'))
                 ->setContent($request->request->get('content'))
                 ->setPublishedAt(new \DateTime($publishedAt));

            $this->em->persist($news);
            $this->em->flush();

            header('Location: /news');
            exit;
        }

        return $this->render('news/create.php');
    }
}