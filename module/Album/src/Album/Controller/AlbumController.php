<?php

namespace Album\Controller;

use Album\Entity\Album;
use Zend\Mvc\Controller\MyBaseController;

//use Zend\Mvc\Controller\AbstractRestfulController;
use Zend\View\Model\JsonModel;
use Zend\Session\Container;

class AlbumController extends MyBaseController {

    protected $em;

    public function getEntityManager()
    {
        if (null === $this->em) {
            $this->em = $this->getServiceLocator()->get('doctrine.entitymanager.orm_default');
        }
        return $this->em;
    }

    /*public function checkLoginAction(){
        if(!$this->getServiceLocator()->get('Zend\Authentication\AuthenticationService')->hasIdentity()){
            return new JsonModel(array( 'logged_in' => false));
        }else{
            return new JsonModel(array( 'logged_in' => true));
        }
    }*/


    public function getList() {

            if($this->authorizedRequest())
            {
                $em = $this->getEntityManager();
                $results= $em->createQuery('select a from Album\Entity\Album as a  order by a.id DESC')->getArrayResult();
                return new JsonModel(array(
                        'data' => $results)
                );
            }else {
                return $this->defaultFailure();
            }
    }

    public function get($id) {
        if($this->authorizedRequest()){
            $em = $this->getEntityManager();
            $qb = $em->createQueryBuilder();
            $results= $em->createQuery('select a from Album\Entity\Album as a where a.id = '.$id)->getArrayResult();
            return new JsonModel(array("data" => $results));
        }else{
            return $this->defaultFailure();
        }

    }

    public function create($data) {

        if($this->authorizedRequest())
        {
            $em = $this->getEntityManager();

            $album = new Album();
            $album->setArtist($data['artist']);
            $album->setTitle($data['title']);

            $em->persist($album);
            $em->flush();

            return new JsonModel(array(
                'data' => $album->getId(),
            ));
        }else{
            return $this->defaultFailure();
        }

    }

    public function update($id, $data) {
        if($this->authorizedRequest()){
            $em = $this->getEntityManager();

            $album = $em->find('Album\Entity\Album', $id);
            $album->setArtist($data['artist']);
            $album->setTitle($data['title']);

            $album = $em->merge($album);
            $em->flush();
            return $this->get($album->getId());
        }else{
            return $this->defaultFailure();
        }
    }

    public function delete($id) {
       if($this->authorizedRequest()){
           $em = $this->getEntityManager();
           $album = $em->find('Album\Entity\Album', $id);
           $em->remove($album);
           $em->flush();
           return new JsonModel(array(
               'data' => 'deleted',
           ));
       }else{
           return $this->defaultFailure();
       }
    }
}