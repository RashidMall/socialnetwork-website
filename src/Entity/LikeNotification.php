<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\LikeNotificationRepository")
 */
class LikeNotification extends Notification
{
    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\MicroPost")
     */
    private $microPost;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\User")
     */
    private $likedByUser;

    /**
     * @return mixed
     */
    public function getMicroPost()
    {
        return $this->microPost;
    }

    /**
     * @param mixed $microPost
     */
    public function setMicroPost($microPost): void
    {
        $this->microPost = $microPost;
    }

    /**
     * @return mixed
     */
    public function getLikedByUser()
    {
        return $this->likedByUser;
    }

    /**
     * @param mixed $likedByUser
     */
    public function setLikedByUser($likedByUser): void
    {
        $this->likedByUser = $likedByUser;
    }

}
