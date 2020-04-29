<?php


namespace App\Controller;

use App\Model\ArtManager;
use mysql_xdevapi\Exception;

class ArtController extends AbstractController
{
    public function selectPicture($param)
    {

    }

    public function index()
    {
        $artManager = new ArtManager();

        $rand = rand(rand(), rand());
        while ($rand > 474476) {
            $rand -= 474476;
        }

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

    public function artConsult($artId)
    {
        // Récupère par la methode GET l'id de l'image (balise <a>) et envoie sur la page de consultation
        //artConsult.
        $data = $this->get("https://collectionapi.metmuseum.org/public/collection/v1/objects/$artId");
        return $this->twig->render('ArtConsult/artConsult.html.twig', [
            'details' => $data
        ]);
    }

    public function allArt()
    {
        $arts = $this->get("https://collectionapi.metmuseum.org/public/collection/v1/objects/");
        shuffle($arts['objectIDs']);
        for ($i = 0; $i < 18; $i++) {
            $oeuvres[$i]=$arts['objectID'][$i];
        }var_dump($oeuvres);
        return $this->twig->render('AllArt/allArt.html.twig', [
            'details' => $oeuvres
            ]);
    }

    public function artCategory()
    {
        if (isset($_POST['submit'])) {


            //ARTISTES
            if (isset($_POST['artist']) and ($_POST['artist']) !== "") {
                $artiste = $_POST['artist'];
                $arts = $this->get("https://collectionapi.metmuseum.org/public/collection/v1/search?hasImage=true&artistOrCulture=true&q=$artiste");
                shuffle($arts['objectIDs']);
                $i = 0;
                foreach ($arts as $oeuvre => $id) {
                    $oeuvres[$i] = $id;
                    $i++;
                }
                if (count($oeuvres[1]) >= 12) {
                    $n = 11;
                } elseif (count($oeuvres[1]) < 12) {
                    $n = count($oeuvres[1]);
                }
                for ($i = 0; $i <= $n; $i++) {
                    try {

                        $data[$i] = $this->get("https://collectionapi.metmuseum.org/public/collection/v1/objects/" . $oeuvres[1][$i]);
                        if ($data[$i] === '') {
                            $data[$i] = array_pop($data[$i]);

                            exit();
                        }
                    } catch (\Exception $e) {
                        echo "";
                    }
                }

                return $this->twig->render('ArtCategory/artCategory.html.twig', [
                    'details' => $data
                ]);
            } //KEYWORD
            elseif (isset($_POST['keyword']) and $_POST['keyword'] !== '') {
                $keyword = $_POST['keyword'];
                $arts = $this->get("https://collectionapi.metmuseum.org/public/collection/v1/search?q=$keyword");
                shuffle($arts['objectIDs']);
                $i = 0;
                foreach ($arts as $oeuvre => $id) {
                    $oeuvres[$i] = $id;
                    $i++;
                }
                if (count($oeuvres[1]) >= 12) {
                    $n = 11;
                } elseif (count($oeuvres[1]) < 12) {
                    $n = count($oeuvres[1]);
                }
                for ($i = 0; $i <= $n; $i++) {
                    try {

                        $data[$i] = $this->get("https://collectionapi.metmuseum.org/public/collection/v1/objects/" . $oeuvres[1][$i]);
                        if ($data[$i] === '') {
                            $data[$i] = array_pop($data[$i]);

                            exit();
                        }
                    } catch (\Exception $e) {
                        echo "";
                    }
                }

                return $this->twig->render('ArtCategory/artCategory.html.twig', [
                    'details' => $data
                ]);
            }
        }
        return $this->twig->render('ArtCategory/artCategory.html.twig');
    }
}


