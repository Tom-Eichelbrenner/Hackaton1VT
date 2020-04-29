<?php


namespace App\Controller;

use App\Model\ArtManager;
use mysql_xdevapi\Exception;

class ArtController extends AbstractController
{
    public function selectPicture($param)
    {
        $artManager = new ArtManager();

        $path = "https://collectionapi.metmuseum.org/public/collection/v1/search?hasImages=true&q=$param.";

        $picData = $this->get($path);

        $selected = $artManager->getRandomArt($picData);

        $details = $this->get("https://collectionapi.metmuseum.org/public/collection/v1/objects/$selected");

        $image = $artManager->getImage($details);

        echo "<img src=\"$image\">";
    }

    public function index()
    {
        $artManager = new ArtManager();

        $rand = rand(0, 474476);

        try {
            $data = $this->get("https://collectionapi.metmuseum.org/public/collection/v1/objects/$rand");
        } catch (\Exception $e) {
            header('location: index');
        }
        while (empty($data['primaryImage']) and empty($data['primaryImageSmall'])) {
            $rand = rand(0, 474476);

            try {
                $data = $this->get("https://collectionapi.metmuseum.org/public/collection/v1/objects/$rand");
            } catch (\Exception $e) {
                header('location: index');
            }
        }
            return $this->twig->render('Home/index.html.twig', [
                'details' => $data
            ]);
    }
    public function artConsult(){
        return $this->twig->render('ArtConsult/artConsult.html.twig');
    }
    public function allArt(){
        return $this->twig->render('AllArt/allArt.html.twig');
    }
    public function artCategory(){
        return $this->twig->render('ArtCategory/artCategory.html.twig');
    }

}


