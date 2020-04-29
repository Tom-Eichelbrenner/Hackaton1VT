<?php
/**
 * Created by PhpStorm.
 * User: sylvain
 * Date: 07/03/18
 * Time: 18:20
 * PHP version 7
 */

namespace App\Model;

use App\Controller\ArtController;

/**
 *
 */
class ArtManager extends AbstractManager
{
    const TABLE = "tablenull";

    /**
     *  Initializes this class.
     */
    public function __construct()
    {
        parent::__construct(self::TABLE);
    }

    public function getRandomArt($picData){
        $numberOfPicture = $picData['total'];
        $rand = rand(0,$numberOfPicture);
        $selected = $picData['objectIDs'][$rand];
        return $selected;
    }

    public function getRandomDetails($data){
        $title = $data['title'];
        $artist = $data['artistDisplayName'];
        $repository = $data['repository'];
        $primaryImage = $data['primaryImage'];
        $additionalImages = $data['additionalImages'];
        return [
            'artistDisplayName' => $artist,
            'title' => $title,
            'repository' => $repository,
            'primaryImage' => $primaryImage,
            'additionalImages' => $additionalImages
        ];
    }

    public function getImage($details){
        $image = $details['primaryImage'];
        return $image;
    }
}