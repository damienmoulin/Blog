<?php
/**
 * Created by PhpStorm.
 * User: damien
 * Date: 31/03/17
 * Time: 15:58
 */

namespace AppBundle\Controller;

use AppBundle\Entity\Article;
use AppBundle\Form\ArticleType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class ArticleController
 * @package AppBundle\Controller
 * @Route("/admin/article")
 */
class ArticleController extends Controller
{

    /**
     * @param Request $request
     * @Route("/", name="app_admin_article_index")
     */
    public function indexAction(Request $request)
    {
        $articles = $this->getDoctrine()->getRepository('AppBundle:Article')->findAll();

        return $this->render(':admin/article:index.html.twig',
            [
                'articles' => $articles
            ]);
    }

    /**
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     * @Route("/add", name="app_admin_article_add")
     */
    public function addAction(Request $request)
    {
        $article = new Article();

        $form = $this->createForm(ArticleType::class, $article, array(
            'action' => $this->generateUrl('app_admin_article_add'),
            'method' => 'GET',
        ));

        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();

            $article->setCreatedAt(new \DateTime());
            $article->setUpdatedAt(new \DateTime());
            $article->Draft();

            $em->persist($article);

            foreach ( $article->getPictures() as $picture) {
                $filename = sha1(uniqid(mt_rand(), true)).'.jpeg';
                $picture->setFilename($filename);
                $picture->getMedia()->move($this->getParameter('picture_directory'), $filename);
            }

            $em->flush();

            return $this->redirectToRoute('app_admin_article_add');
        }

        return $this->render(':admin/article:add.html.twig', [
            'form' => $form->createView()
        ]);
    }

    /**
     * @param Article $article
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     * @Route("/draft/{id}", name="app_admin_article_draft")
     */
    public function draftAction(Article $article)
    {
        $article->Draft();

        $em = $this->getDoctrine()->getManager();
        $em->persist($article);
        $em->flush();

       return $this->redirectToRoute('app_admin_article_index');
    }

    /**
     * @param Article $article
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     * @Route("/publish/{id}", name="app_admin_article_publish")
     */
    public function publishAction(Article $article)
    {
        $article->Publish();
        $em = $this->getDoctrine()->getManager();
        $em->persist($article);
        $em->flush();

        return $this->redirectToRoute('app_admin_article_index');
    }

    /**
     * @param Article $article
     * @return Response
     * @Route("/{id}", name="app_admin_article_detail")
     */
    public function detailAction(Article $article)
    {
        return $this->render(':admin/article:detail.html.twig',
            [
                'article' => $article
            ]);
    }
}