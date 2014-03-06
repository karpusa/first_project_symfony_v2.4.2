<?php

namespace Twitter\MainBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;

// these import the "@Route" and "@Template" annotations
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

use Twitter\MainBundle\Form\Type\TweetFormType;
use Twitter\MainBundle\Entity\Tweet;

use Twitter\MainBundle\Form\Type\SearchFormType;
use Twitter\MainBundle\Entity\Search;

class DefaultController extends Controller
{
    public function indexAction($twittername='')
    {
        if ($this->get('security.context')->isGranted('IS_AUTHENTICATED_REMEMBERED')) {
            
            $repository = $this->getDoctrine()->getRepository('TwitterMainBundle:Tweet');
            
            $search=new Search();
            $form_search = $this->createForm(new SearchFormType(),$search);
            
            $tweet=new Tweet();
            $form_tweet = $this->createForm(new TweetFormType(),$tweet);
            $request = $this->get('request');
            if ($request->getMethod() == 'POST')
            {
                if(!is_null($this->getRequest()->get('tweetform'))){
                    $form_tweet->bind($request);

                    if ($form_tweet->isValid()) {
                        $tweet->setStatus(0);
                        $tweet->setUser($this->getUser());
                        $tweet->setCreatedAt(new \DateTime());
                        
                        $em = $this->getDoctrine()->getManager();                        
                        $em->persist($tweet);
                        $em->flush();
                    }  
                }elseif(!is_null($this->getRequest()->get('reply_message'))){
                     if ($this->get('form.csrf_provider')->isCsrfTokenValid('reply_token', $this->getRequest()->get('reply_token'))) {
                        
                        $tweet_parent = $repository->find($this->getRequest()->get('reply_parent_id'));   
                        //                        $tweet_parent = $repository->findBy(array('parentId' => $this->getRequest()->get('reply_parent_id'))); 
                        if ($tweet_parent){
                            $tweet_new = new Tweet();
                            $tweet_new->setUser($this->getUser());                        
                            $tweet_new->setMessage($this->getRequest()->get('reply_message'));
                            $tweet_new->setParentId($this->getRequest()->get('reply_parent_id')); 
                            $user_parent=$tweet_parent->getUserParent();
                            $tweet_new->setUserParent(!is_null($user_parent)?$user_parent:$tweet_parent->getUser());                        
                            $tweet_new->setStatus(1);                        
                            $tweet_new->setCreatedAt(new \DateTime());                        

                            $em = $this->getDoctrine()->getManager();
                            $em->persist($tweet_new);
                            $em->flush();
                        }
                     }
                }
                    
                    
            } 
            
            $user_current=NULL;    
            if (!$twittername){
                $tweet_items =$repository->findAllByIdJoinedToLike($this->getUser()->getId());
            }elseif($twittername==$this->getUser()->getusernameCanonical()){
                $tweet_items = $repository->findAllTweetsByUser($this->getUser()->getId());   
            }else{
                $repositoryUser = $this->getDoctrine()->getRepository('TwitterUserBundle:User');                    
                $user_current = $repositoryUser->findOneBy(
                    array('usernameCanonical' => $twittername,'enabled'=>1)
                );  
                if ($user_current){
                    $tweet_items = $repository->findAllTweetsByUser($user_current);                         
                }
            }

            return $this->render('TwitterMainBundle:Default:index_user.html.twig',array('currentuser'=>$user_current,'currentaccount'=>$twittername,'form_tweet'=>$form_tweet->createView(),'tweet_items'=>$tweet_items,'form_search'=>$form_search->createView()));
        }else{
            return $this->render('TwitterMainBundle:Default:index.html.twig',array('csrf_token' => $this->container->get('form.csrf_provider')->generateCsrfToken('authenticate')));
        }
    }
    
    public function retwitAction()
    {
        $request=$this->get('request');
        if ($request->isXmlHttpRequest()) {
            $id = $request->get("id");
            if (!$id){
                return new Response(0);
            }
            $repository = $this->getDoctrine()->getRepository('TwitterMainBundle:Tweet');            
            $retwit = $repository->findBy(
                array('user' => $this->getUser()->getId(),'status'=>2,'parentId'=>$request->get("id"))
            );            
            if ($retwit){
                return new Response(2);
            }
            $retwit = $repository->find($id);            
            if (!$retwit){
                return new Response(0);
            }
            
            $tweet_new = new Tweet();
            $tweet_new->setUser($this->getUser());                        
            $tweet_new->setParentId($id);
            $tweet_new->setUserParent($retwit->getUser());            
            $tweet_new->setMessage($retwit->getMessage());            
            $tweet_new->setStatus(2);                        
            $tweet_new->setCreatedAt(new \DateTime());                        

            $em = $this->getDoctrine()->getManager();
            $em->persist($tweet_new);
            $em->flush();
            
            return new Response(1);
        }
        return new Response(0);
    }    

    public function searchAction()
    {
        $search=new Search();
        $form_search = $this->createForm(new SearchFormType(),$search);    
        $request = $this->get('request');        
        if ($request->getMethod() == 'POST')
        {
            if(!is_null($this->getRequest()->get('searchform'))){
                $form_search->bind($request);
                if ($form_search->isValid()) {
                    $repository = $this->getDoctrine()->getRepository('TwitterUserBundle:User');   
                    $usersearch = $repository->searchUserByName($search->getName());
                    return $this->render('TwitterMainBundle:Default:search.html.twig',array('form_search'=>$form_search->createView(),'search_items'=>$usersearch));
                }
            }
        }
        return $this->render('TwitterMainBundle:Default:search.html.twig',array('form_search'=>$form_search->createView(),'search_items'=>NULL));
    } 
    
    public function ifollowAction()
    {
        $search=new Search();
        $form_search = $this->createForm(new SearchFormType(),$search);         
        $repositoryLike = $this->getDoctrine()->getRepository('TwitterMainBundle:Like');         
        $ifollow_items = $repositoryLike->findBy(
            array('userFollow' => $this->getUser())
        );         
        return $this->render('TwitterMainBundle:Default:ifollow.html.twig',array('form_search'=>$form_search->createView(),'ifollow_items'=>$ifollow_items));
    } 
    
    public function mefollowAction()
    {
        $search=new Search();
        $form_search = $this->createForm(new SearchFormType(),$search);
        $repositoryLike = $this->getDoctrine()->getRepository('TwitterMainBundle:Like');         
        $mefollow_items = $repositoryLike->findBy(
            array('user' => $this->getUser())
        );            
        return $this->render('TwitterMainBundle:Default:mefollow.html.twig',array('form_search'=>$form_search->createView(),'mefollow_items'=>$mefollow_items));
    }        
    
    public function followingCountAction($user_id){
        $repositoryLike = $this->getDoctrine()->getRepository('TwitterMainBundle:Like');                 
        return new Response($repositoryLike->followingCount($user_id)); 
    }
    public function followersCountAction($user_id){
        $repositoryLike = $this->getDoctrine()->getRepository('TwitterMainBundle:Like');                 
        return new Response($repositoryLike->followersCount($user_id)); 
    }    
}
