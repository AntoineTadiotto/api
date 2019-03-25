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

  /**
   * Lists top 10 Articles.
   * @Rest\Get("/toparticles")
   *
   * @return Response
   */
  public function getTopArticleAction(ObjectManager $manager)
  {
    // $repository = $this->getDoctrine()->getRepository(Article::class);
    // $articles = $repository->findall();

    $conn = $manager->getConnection();
        $sql = '
        SELECT article_id, SUM(quantity) as quantityTotal FROM ligne_article GROUP BY article_id ORDER BY quantityTotal DESC LIMIT 3
        ';
        $stmt = $conn->prepare($sql);
        $stmt->execute();
        $data = $stmt->fetchAll();


    return $this->handleView($this->view($data, 200));
  }

}
