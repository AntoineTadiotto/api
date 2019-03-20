<?php
namespace App\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\Controller\Annotations as Rest;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use App\Entity\Article;
use Doctrine\Common\Persistence\ObjectManager;

/**
 * Article controller.
 * @Route("/api", name="api_")
 */
class ArticleController extends FOSRestController
{
  /**
   * Lists all Articles.
   * @Rest\Get("/articles")
   *
   * @return Response
   */
  public function getArticleAction(ObjectManager $manager)
  {
    // $repository = $this->getDoctrine()->getRepository(Article::class);
    // $articles = $repository->findall();

    $conn = $manager->getConnection();
        $sql = '
                SELECT * FROM article a
        ';
        $stmt = $conn->prepare($sql);
        $stmt->execute();
        $data = $stmt->fetchAll();


    return $this->handleView($this->view($data, 200));
  }

}
