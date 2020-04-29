<?php


namespace App\Controller;

use App\Model\ArtManager;

class ArtController extends AbstractController
{
    public function SelectPicture($param)
    {
        $artManager = new ArtManager();

        $picData = $this->get("https://collectionapi.metmuseum.org/public/collection/v1/search?medium=Paintings&hasImages=true&q=$param.");

        $selected = $artManager->getRandomArt($picData);

        $details = $this->get("https://collectionapi.metmuseum.org/public/collection/v1/objects/$selected");

        $image = $artManager ->getImage($details);

        echo "<img src=\"$image\">";
    }

    public function index(){
        $artManager = new ArtManager();
        for ($i = 0; $i <= 2; $i ++) {

            $rand = round(rand(0, 20000));

            $data = $this->get("https://collectionapi.metmuseum.org/public/collection/v1/objects/$rand");
            $datas = $artManager->getRandomDetails($data);
            $details[$i] = $datas;
        }
        return $this->twig->render('Home/index.html.twig', [
            'details' => $details
        ] );
    }
}
