<?php
/**
 * Created by PhpStorm.
 * User: damien
 * Date: 30/03/17
 * Time: 15:09
 */

namespace AppBundle\Controller;

use AppBundle\Entity\Theme;
use AppBundle\Form\ThemeType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

/**
 * Class ThemeController
 * @package AppBundle\Controller
 * @Route("admin/theme", name="app_theme")
 */
class ThemeController extends Controller
{
    /**
     * @return \Symfony\Component\HttpFoundation\Response
     * @Route("/", name="app_theme")
     */
    public function indexAction()
    {
        $themes = $this->getDoctrine()->getRepository('AppBundle:Theme')->findAll();

        // replace this example code with whatever you need
        return $this->render('admin/theme/index.html.twig',
            [
                'themes' => $themes
            ]
        );
    }

    /**
     * @param Request $request
     * @param Theme $id
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     * @Route("/add/{id}", name="app_theme_add")
     */
    public function addAction(Request $request, Theme $id = null)
    {

        if ($id == null) {
            $theme = new Theme();
        }
        else {
            $theme = $id;
        }
        $form = $this->createForm(ThemeType::class, $theme);

        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($theme);
            $em->flush();

            return $this->redirectToRoute('app_theme');

        }
        return $this->render('admin/theme/add.html.twig',
            [
                'form' => $form->createView()
            ]);
    }

    /**
     * @param Theme $id
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     * @Route("/delete/{id}", name="app_theme_delete")
     */
    public function deleteAction(Theme $id)
    {
        $em = $this->getDoctrine()->getManager();
        $em->remove($id);
        $em->flush();

        return $this->redirectToRoute('app_theme');
    }
}