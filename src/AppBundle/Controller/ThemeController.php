<?php
/**
 * Created by PhpStorm.
 * User: damien
 * Date: 30/03/17
 * Time: 15:09
 */

namespace AppBundle\Controller;

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
     * @Route("/", name="app_theme")
     */
    public function indexAction(Request $request)
    {
        // replace this example code with whatever you need
        return $this->render('default/index.html.twig', [
            'base_dir' => realpath($this->getParameter('kernel.root_dir').'/..').DIRECTORY_SEPARATOR,
        ]);
    }
}