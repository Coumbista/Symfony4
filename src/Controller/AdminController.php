<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\JsonResponse;
use FOS\RestBundle\View\View;
use FOS\RestBundle\Controller\Annotations as FOSRest;
use App\Entity\Localite;
use App\Entity\Bien;
use App\Entity\Client;
use App\Entity\Image;
use App\Entity\Reservation;
use App\Entity\Typebien;
use App\Entity\Contrat;
use App\Entity\Paiement;

class AdminController extends Controller
{
    /**
     * @Route("/admin", name="admin")
     */
    public function index()
    {
        return $this->json([
            'message' => 'Welcome to your new controller!',
            'path' => 'src/Controller/AdminController.php',
        ]);
    }

    /**
     * Lists all Biens
     * @FOSRest\Get("/Reservation" ,name="Reservation")
     *
     * @return array
     */
    public function ListreserveAction( Request $request)
    {
        $repository = $this->getDoctrine()->getRepository(Reservation::class);       
        $reserve = $repository->findBy(['etat'=>0]);        
        $repository = $this->getDoctrine()->getRepository(Bien::class);       
        $bien = $repository->findall();   

        foreach($bien as $key=>$values){
            foreach($values->getImages() as $key1=>$images){                 
                $images->setImage(base64_encode(stream_get_contents($images->getImage())));
                
            }
        }
    
        if(!count($reserve)){
            $response =array(
                "code"=>false,
                "msg"=>"liste des biens",
                "error"=>null,
                "data"=>null,
            
            );
            return new JsonResponse($response);
        }  
                
        $data = $this->get('jms_serializer')->serialize($reserve, 'json'); 

            $response =array(
                "code"=>true,
                "msg"=>"liste des client",
                "error"=>null,
                "data"=>json_decode($data)
            );
            return new JsonResponse($response,Response::HTTP_OK  );
        
 
    
    }
     /**
     * Lists all detailBien
     * @FOSRest\Get("/detail/{id}" ,name="detail")
     *
     * @return array
     */
    public function DetailAction( $id)
    {
        $repository = $this->getDoctrine()->getRepository(Reservation::class);       
        $reserve = $repository->find($id);  
$repository = $this->getDoctrine()->getRepository(Bien::class);       
        $bien = $repository->find($id);     
      
           
          
        foreach($bien->getImages() as $key=>$images){
            $images->setImage(base64_encode(stream_get_contents($images->getImage())));
        }
        
    
       
        if(($reserve=='')){
            $response =array(
                "code"=>false,
                "msg"=>"liste des biens",
                "error"=>null,
                "data"=>null,
               
            );
            return new JsonResponse($response);
        }  
                
        $data = $this->get('jms_serializer')->serialize($reserve, 'json'); 

            $response =array(
                "code"=>true,
                "msg"=>"liste des client",
                "error"=>null,
                "data"=>json_decode($data)
            );
            return new JsonResponse($response,Response::HTTP_OK  );
        
 
    }
     /**
     * save contrat
     * @FOSRest\Post("/saveContrat/{id}" ,name="saveContrat")
     *
     * @return array
     */
    public function saveContrat(Request $request,$id){
        $idbien = $request->get('id');
        $idclient = $request->get('idclient');
        var_dump($idbien);
        $repository = $this->getDoctrine()->getRepository(Reservation::class); 
        $reserve = $repository->findBy(['etat'=>0]); 

        
        $repository = $this->getDoctrine()->getRepository(Bien::class)->find($idbien); 

       
        //    $total=$request->get('prix_loc');
        
        $data = $request->getContent();
        $contrats = $this->get('jms_serializer')
        ->deserialize($data, 'App\Entity\Contrat','json'); 

        $bien= new Bien();
        $contrat= new Contrat();
        $contrat->setDateContrat(new \DateTime());
        $contrat->setCaution($reserve->getBien()->getPrixLoc());
        $contrat->setDuree('1 ans renouvable');
        $contrat->setBien($reserve->getBien());
        $contrat->setClient($reserve->getClient());  
        $em = $this->getDoctrine()->getManager();           
        $em->persist($contrat);
        $em->flush();

       
        if($contrat){
            $paiement = new Paiement();
            $paiement->setDatePaiement(new \DateTime());
            $paiement->setMontant($contrat->getCaution());
            $paiement->setPeriode("fevrier 2018");
            $paiement->setContrat($contrat);
            $em->persist($paiement);
            $em->flush();
            $update=$this->getDoctrine()
            ->getManager()
            ->getRepository(Bien::class)
            ->updateEtatBien($idbien);
       
            $response = array(
                'code' => 0,
                'Message' => 'success',
                'error' => null,
                'result' => null,
            );
    
            return new JsonResponse($response, Response::HTTP_CREATED);
            
        }
        $reserve->setEtat("1");
        $em->persist($reserve);
        $em->flush();
        }
        
    }

