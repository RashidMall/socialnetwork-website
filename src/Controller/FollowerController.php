<?php


namespace App\Controller;

use App\Entity\User;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Security("is_granted('ROLE_USER')")
 * @Route("/follower")
 */
class FollowerController extends AbstractController
{
    /**
     * @Route("/follow/{id}", name="follower_follow")
     */
    public function follow(User $userToFollow){
        $currentUser = $this->getUser();

        // User can't follow himself
        if($userToFollow->getId() !== $currentUser->getId()){
            $currentUser->getFollowing()->add($userToFollow);

            $this->getDoctrine()->getManager()->flush();
        }

        return $this->redirectToRoute(
            'micro_post_user',
            ['username' => $userToFollow->getUsername()]
        );
    }

    /**
     * @Route("/unfollow/{id}", name="follower_unfollow")
     */
    public function unfollow(User $userToUnfollow){
        $currentUser = $this->getUser();
        $currentUser->getFollowing()->removeElement($userToUnfollow);

        $this->getDoctrine()->getManager()->flush();

        return $this->redirectToRoute(
            'micro_post_user',
            ['username' => $userToUnfollow->getUsername()]
        );
    }
}