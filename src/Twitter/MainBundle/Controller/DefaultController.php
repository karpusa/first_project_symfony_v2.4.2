<?php

namespace Twitter\MainBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

// these import the "@Route" and "@Template" annotations
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

use Twitter\MainBundle\Form\Type\TweetFormType;
use Twitter\MainBundle\Entity\Tweet;

class DefaultController extends Controller
{
    public function indexAction($twittername='')
    {
        if ($this->get('security.context')->isGranted('IS_AUTHENTICATED_REMEMBERED')) {
            $tweet=new Tweet();
            $form_tweet = $this->createForm(new TweetFormType(),$tweet);
            $request = $this->get('request');
            if ($request->getMethod() == 'POST')
            {
                $form_tweet->bind($request);

                if ($form_tweet->isValid()) {
                    $em = $this->getDoctrine()->getEntityManager();
                    $tweet->setStatus(0);
                    $tweet->setUser($this->getUser());
                    $tweet->setCreatedAt(new \DateTime());
                    $em->persist($tweet);
                    $em->flush();
                }  
            } 
            
            $repository = $this->getDoctrine()->getRepository('TwitterMainBundle:Tweet');
                
            if (!$twittername){
                $tweet_items =$repository->findAllByIdJoinedToLike($this->getUser()->getId());
            }elseif($twittername==$this->getUser()->getusernameCanonical()){
                $tweet_items = $repository->findBy(
                    array('user' => $this->getUser()->getId())
                );
            }else{
                $tweet_items = $repository->findBy(
                    array('user' => $this->getUser()->getId())
                );
            }

            return $this->render('TwitterMainBundle:Default:index_user.html.twig',array('form_tweet'=>$form_tweet->createView(),'tweet_items'=>$tweet_items,'csrf_token' => $this->container->get('form.csrf_provider')->generateCsrfToken('authenticate')));
        }else{
            return $this->render('TwitterMainBundle:Default:index.html.twig',array('csrf_token' => $this->container->get('form.csrf_provider')->generateCsrfToken('authenticate')));
        }
    }
}
