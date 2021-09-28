<?php

namespace App\Controller;

use App\Entity\Item;
use App\Repository\ItemRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ApiController extends AbstractController
{
    /**
     * @Route("/api/item/", name="api_liste" ,methods={"GET"})
     */
    public function index(ItemRepository $repo): Response
    {
       return $this->json($repo->findAll());
    }

    /**
     * @Route("/api/item/{id}", name="api_delete" ,methods={"DELETE"})
     */
    public function delete(Item $item,EntityManagerInterface $em): Response
    {
        $em->remove($item);
        $em->flush();
        return $this->json($item);
    }

    /**
     * @Route("/api/item/{id}", name="api_acheter" ,methods={"PUT"})
     */
    public function acheter(Item $item,EntityManagerInterface $em): Response
    {
        // inverser l etat isBought
        $etat = $item->getIsBought();
        $item->setIsBought(!$etat);
        $em->flush();
        return $this->json($item);
    }
    /**
     * @Route("/api/item/", name="api_ajouter" ,methods={"POST"})
     */
    public function ajouter(EntityManagerInterface $em,Request $req): Response
    {
        // body obj json
        $json = $req->getContent();
        $obj = json_decode($json);

        $item = new item();
        $item->setName($obj->name);
        $item->setIsBought(false);
        $em->persist($item);
        $em->flush();
        return $this->json($item);
    }
}
