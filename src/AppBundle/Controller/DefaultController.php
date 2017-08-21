<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use AppBundle\Entity\PageBenchmark;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class DefaultController extends Controller
{
    /**
     * @Route("/", name="homepage")
     */
    public function indexAction(Request $request)
    {
        if($request->isMethod('POST')) {
            $basePage = $_POST['basePage'];
            $competitors = $_POST['competitors'];
            $benchmarkOne = new PageBenchmark($basePage, $competitors);
            $benchmarkOne->execute();
            $benchmarkOne->generateReport('now');
        }

        return $this->render('default/index.html.twig',  [
            'base_dir' => realpath($this->getParameter('kernel.project_dir')).DIRECTORY_SEPARATOR,
        ]);
    }
}
