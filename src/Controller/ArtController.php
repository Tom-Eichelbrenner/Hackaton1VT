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
        if ($data['artistDisplayName'] === "") {
            $name = "false";
        } else {
            $name = "true";
        }

        $commentaire = [
            'This piece of art is really incredible...  It makes me think a lot about our society...',
            'I saw this ArtWork on NewYork City, amazing job! I highly recommand
                        to everyone to see this once in a life!',
            'I\'m stunned.',
            'Just unbelievable.',
            'W.O.W',
            'Don\'t waste your time looking for a solution to be smart, this artwork is what you need!',
            'As far as the contemporary atmosphere is concerned, this work of art in its entirety and not as an end in itself should be taken into consideration among the draconian openings and in a correct perspective.',
            'Because of the intrinsic extremity, one cannot do without experimenting with the sum of possible strategies quickly by examining this work.',
            'Notwithstanding the induced conjuncture, it is preferable to stop stigmatizing the main openings we know, all things being equal, this is what should come to all of you in mind when you see this object',
        ];
        shuffle($commentaire);
        return $this->twig->render('Home/index.html.twig', [
            'details' => $data,
            'noname' => $name,
            'commentaire' => $commentaire[3]
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
        $arts = $this->get("https://collectionapi.metmuseum.org/public/collection/v1/search?hasImage=true&q=painting");
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

        return $this->twig->render('AllArt/allArt.html.twig', [
            'details' => $data
        ]);
    }

    /*$arts = $this->get("https://collectionapi.metmuseum.org/public/collection/v1/objects/");
    shuffle($arts['objectIDs']);
    for ($i = 0; $i < 18; $i++) {
        $oeuvres[$i]=$arts['objectID'][$i];
    }var_dump($oeuvres);
    return $this->twig->render('AllArt/allArt.html.twig', [
        'details' => $oeuvres
        ]);
}*/

    public function artCategory()
    {
        if (isset($_POST['submit'])) {
            //ARTISTES
            if (isset($_POST['artist']) and ($_POST['artist']) !== "") {
                $artiste = $_POST['artist'];
                $message = "Voici quelques resultats liés a $artiste";
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
                    'details' => $data,
                    'message' => $message
                ]);
            } //KEYWORD
            elseif (isset($_POST['keyword']) and $_POST['keyword'] !== '') {
                $keyword = $_POST['keyword'];
                $message = "Voici quelques résultats liés au mot clé : $keyword";
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
                    'details' => $data,
                    'message' => $message
                ]);
            }
        }
        return $this->twig->render('ArtCategory/artCategory.html.twig');
    }
}
