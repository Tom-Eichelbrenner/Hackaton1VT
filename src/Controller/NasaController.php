<?php


namespace App\Controller;

class NasaController extends AbstractController
{
    public function picture()
    {
        $picData = $this->get("https://collectionapi.metmuseum.org/public/collection/v1/search?medium=Paintings&hasImages=true&q=sunset.");

        return $this->twig->render('Index/IndexPicture.html.twig', [
            'pic_data' => $picData,
        ]);
    }
}
