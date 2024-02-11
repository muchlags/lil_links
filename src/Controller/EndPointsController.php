<?php

namespace App\Controller;

use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use Doctrine\ORM\EntityManagerInterface;
use App\Entity\LinkPairs;

class EndPointsController extends AbstractController
{
    #[Route('/s/{url}', name: 'url_shortener', requirements: ['url' => '.+'])]
    public function shorten(string $url, EntityManagerInterface $em): JsonResponse
    {

        $url = base64_decode($url);
        $url = urldecode($url);
        // dd($url);

        // return $this->render('home/homepage.html.twig', [
        //     'title' => 'Home',
        // ]);
        // return new Response('Shortened string');

        // $res = [
        //     'url_shortened' => 'test'
        // ];
        
        // $em = $this->getDoctrine()->getManager();

        $linkpairs = new LinkPairs();
        $linkpairs->setLpUrl($url);

        //randomize
        //check
        //save to db
        $newKey = '';
        $isDupFlag = true;
        // dd($url);
        while($isDupFlag){
            $newKey = $this->getNewKey();
            $isDupFlag = $this->isDup($newKey, $em);
            // dd($url);
        }
        // dd([$newKey, $url]);
        $linkpairs->setLpKey($newKey);
        // Set other properties as needed

        $em->persist($linkpairs);
        $em->flush();

        // return new JsonResponse($res);
        return $this->json($newKey);

        // return $this->redirectToRoute('your_route'); // Redirect to another page after insertion

    }
    #[Route('/i/{url}', name: 'url_inflater', requirements: ['url' => '.+'])]
    public function inflate(string $url, EntityManagerInterface $em):Response
    {
        $url = base64_decode($url);
        $url = urldecode($url);

        $url = explode("/",$url);
        $url = $url[count($url) - 1];

        // $repository = $em->getRepository(LinkPairs::class);
        // $linkpairs = $repository->findOneBy(['lp_key' => $url]);
        
        $linkpairs = $this->getLinkPairByKey($url, $em);


        // $linkpairs = $repository->findAll();
        // dd($linkpairs);
        // return new Response($linkpairs);
        if (!$linkpairs) {
            // throw $this->createNotFoundException(sprintf('No link for key "%s"', $key));
            return new Response(sprintf('No link for key "%s"', $url));
        }
        return $this->json($linkpairs->getLpUrl());

    }
    #[Route('/r/{url}', name: 'url_redirector')]
    public function redir(string $url, EntityManagerInterface $em):Response
    {
        
        // $repository = $em->getRepository(LinkPairs::class);
        // $linkpairs = $repository->findOneBy(['lp_key' => $url]);
        
        $linkpairs = $this->getLinkPairByKey($url, $em);


        // $url = html_entity_decode($url);
        // $url = inflate($url);
        if (!$linkpairs) {
            // throw $this->createNotFoundException(sprintf('No link for key "%s"', $key));
            return new Response(sprintf('No link for key "%s"', $url));
        }
        // return $this->json($linkpairs->lpUrl);
        // return new Response($linkpairs->getLpUrl());
        return $this->redirect($linkpairs->getLpUrl());

    }

    /**
     * Retrieves a LinkPair entity based on the provided key.
     */
    private function getLinkPairByKey(string $key, EntityManagerInterface $em): ?LinkPairs
    {
        $repository = $em->getRepository(LinkPairs::class);
        return $repository->findOneBy(['lp_key' => $key]);
    }
    private function isDup(string $key, EntityManagerInterface $em){
        $repository = $em->getRepository(LinkPairs::class);
        $linkpairs = $repository->findOneBy(['lp_key' => $key]);
        // $linkpairs = $repository->findAll();
        // dd($linkpairs);
        // return new Response($linkpairs);
        if (!$linkpairs) {
            // throw $this->createNotFoundException(sprintf('No link for key "%s"', $key));
            // return new Response(sprintf('No link for key "%s"', $url));
            return false;
        }else{
            return true;
        }
    }

    private function getNewKey(){
        //random_bytes () function in PHP
        $length = random_bytes('6');
        
        //Return the result and convert by binaryhexadecimal
        return bin2hex($length);
    }
}