<?php
namespace App\Controller;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\JsonResponse;
use FOS\RestBundle\View\View;
use FOS\RestBundle\Controller\Annotations as FOSRest;
use App\Entity\Localite;
use App\Entity\Bien;
use App\Entity\Typebien;
use App\Entity\Client;
use App\Entity\Image;
use App\Entity\Reservation;



   /**
 * Brand controller.
 *
 * @Route("/")
 */
class FrontController extends Controller
{
    /**
     * Lists all Biens
     * @FOSRest\Get("/biens")
     *
     * @return array
     */
    public function getBienAction( Request $request)
    {
        $repository = $this->getDoctrine()->getRepository(Bien::class);       
        $bien = $repository->findBy(['etat'=>0]);
        
        foreach($bien as $key=>$values){
            foreach($values->getImages() as $key1=>$images){ 
                $images->setImage(base64_encode(stream_get_contents($images->getImage())));
            }
        }
        
    
       
       
        if(!count($bien)){
            $response =array(
                "code"=>false,
                "msg"=>"liste des biens",
                "error"=>null,
                "data"=>null,
               
            );
            return new JsonResponse($response);
        }  
                
        $data = $this->get('jms_serializer')->serialize($bien, 'json'); 

            $response =array(
                "code"=>true,
                "msg"=>"liste des client",
                "error"=>null,
                "data"=>json_decode($data)
            );
            return new JsonResponse($response,Response::HTTP_OK  );
        
 
    
    }
    /**
     * Lists one Bien
     * @FOSRest\Get("/bienID/{id}" , name="bienID")
     *
     * @return array
     */
    public function OneBienAction($id)
    {
        $repository = $this->getDoctrine()->getRepository(Bien::class);
               $bien = $repository->find($id);
        
             foreach($bien->getImages() as $key=>$images){
                $images->setImage(base64_encode(stream_get_contents($images->getImage())));
            }
       
       
        if($bien==null){
            $response =array(
                "code"=>false,
                "msg"=>"pas de bien",
                "error"=>null,
                "data"=>null,
               
            );
            return new JsonResponse($response);
        }  
                
        $data = $this->get('jms_serializer')->serialize($bien, 'json'); 

            $response =array(
                "code"=>true,
                "msg"=>"un bien",
                "error"=>null,
                "data"=>json_decode($data)
            );
            return new JsonResponse($response,Response::HTTP_OK  );
        
 
    
    }
 /**
     * list typebien
     *  @FOSRest\Get("/typebien", name="typebien")
     * @return array
     */
    public function getTypeBien(){
        $repository = $this->getDoctrine()->getRepository(Typebien::class);
        $typebien = $repository->findAll();
        if(!count($typebien)){
            $response =array(
                "code"=>false,
                "msg"=>"pas de Typebien",
                "error"=>null,
                "data"=>null,
            
            );
            return new JsonResponse($response);
        }  
                
        $data = $this->get('jms_serializer')->serialize($typebien, 'json'); 

            $response =array(
                "code"=>true,
                "msg"=>"liste des Typebien",
                "error"=>null,
                "data"=>json_decode($data)
            );
            return new JsonResponse($response,Response::HTTP_OK  );       
     
   }
   /**
     * list localite
     *  @FOSRest\Get("/localite", name="localite")
     * @return array
     */
    public function getLocalite(){
        $repository = $this->getDoctrine()->getRepository(Localite::class);
        $localite = $repository->findAll();
        if(!count($localite)){
            $response =array(
                "code"=>false,
                "msg"=>"pas de localite",
                "error"=>null,
                "data"=>null,
               
            );
            return new JsonResponse($response);
        }  
                
        $data = $this->get('jms_serializer')->serialize($localite, 'json'); 

            $response =array(
                "code"=>true,
                "msg"=>"liste des localite",
                "error"=>null,
                "data"=>json_decode($data)
            );
            return new JsonResponse($response,Response::HTTP_OK  );       
 
    
   }
  /**

* Lists By Biens

* @FOSRest\Post("/recherche")

*

* @return array

*/

public function getBienByValuesAction( Request $request)

{

    $repository = $this->getDoctrine()->getRepository(Bien::class);
    $biens = $repository->findByValues($request->get("localite"), $request->get("typebien"), $request->get("prix_loc"));

    if (empty($biens)) {
        $response = array(
            'code' => 1,
            'Message' => 'Pas de resultat',
            'error' => null,
            'result' => null,
        );

        return new JsonResponse($response, Response::HTTP_NOT_FOUND);
    }

   

    $data = $this->get('jms_serializer')->serialize($biens, 'json');

    $response = array(
        'code' => 0,
        'Message' => 'success',
        'error' => null,
        'result' => json_decode($data),
    );

    return new JsonResponse($response, 201);
}
 /**

* create Biens

* @FOSRest\Post("/reservation/{id}" ,name="reservation")

*

* @return array

*/

public function addreserveAction( Request $request,$id)

{
    
        $idbien = $request->get('id');
        var_dump($idbien);
        $idclient = $request->get('idclient');
        if(empty($idclient))
        { 
            $data = $request->getContent();
            $clients = $this->get('jms_serializer')
            ->deserialize($data, 'App\Entity\Client','json');  
        var_dump($clients->getNomclient('nomclient'));
            if(!empty($clients))
            {
                $newClient = new Client();
                $newClient->setNumeropiece($clients->getNumeropiece('numeropiece'));
                $newClient->setNomclient($clients->getNomclient('nomclient')); 
                $newClient->setTelclient($clients->getTelclient('telclient'));
                $newClient->setAdresseclient($clients->getAdresseclient('adresseclient'));
                $newClient->setEmailclient($clients->getEmailclient('emailclient'));
                $newClient->setPassword($clients->getPassword('password'));
                $em = $this->getDoctrine()->getManager();
                $em->persist($newClient);
                $em->flush();
                $idclient = $newClient->getId();
            }
        }

        if (empty($idbien))
        {
            $response = array(
                'code' => 0,
                'Message' => 'error',
                'error' => null,
                'result' => null,
            );

            return new JsonResponse($response, Response::HTTP_BAD_REQUEST);
        }

        $em = $this->getDoctrine()->getManager();
        $idbien = $em->getRepository(Bien::class)->find($idbien);
        $user = $em->getRepository(Client::class)->find($idclient);

        if (empty($user) || empty($idbien)) 
        {
           
            return new JsonResponse('', Response::HTTP_BAD_REQUEST);
        }

       
        $reserv = new Reservation();
        $reserv->setDatereservation(new \DateTime());
        $reserv->setEtat(0);
        $reserv->setClient($user);
        $reserv->setBien($idbien);
        $em = $this->getDoctrine()->getManager();
        $em->persist($reserv);
        $em->flush();

        $response = array(
            'code' => 0,
            'Message' => 'success',
            'error' => null,
            'result' => null,
        );

        return new JsonResponse($response, Response::HTTP_CREATED);
        
    }

/**
     * Connect Client.
     * @FOSRest\Post("/connexionclient/{id}")
     *
     * @return array
     */

    public function connexionClientAction(Request $request,$id)
    {
        $idbien = $request->get('id');
        $emailclient = $request->get('emailclient');
        $password = $request->get('password');

        $em = $this->getDoctrine()->getManager();

        $client = $em->getRepository(Client::class)->findBy(array('emailclient' => $emailclient, 'password' => $password));

        if(!$client)
        {       

            $response = array(
                'code' => 0,
                'Message' => 'Votre reservation n a pas etait pris en compte',
                'error' => null,
                'type' => null,
            );
            return new JsonResponse($response, 200);
        }

        $em = $this->getDoctrine()->getManager();
        $idbien = $em->getRepository(Bien::class)->find($id);
        
       
        $reserv = new Reservation();
        $reserv->setDatereservation(new \DateTime());
        $reserv->setEtat(0);
        $reserv->setClient($client[0]);
        $reserv->setBien($idbien);
        $em = $this->getDoctrine()->getManager();
        $em->persist($reserv);
        $em->flush();

            $response = array(
            'code' => 1,
            'Message' => 'success',
            'error' => null,
            'type' => json_decode($this->get('jms_serializer')->serialize($client, 'json'))   
        );
    
        return new JsonResponse($response, Response::HTTP_CREATED);
    }

    
    
}
