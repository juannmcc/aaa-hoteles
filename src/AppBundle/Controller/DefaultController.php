<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

use AppBundle\Entity\Habitaciones;
use AppBundle\Entity\Hoteles;
use AppBundle\Entity\TipoHabs;
use AppBundle\Entity\Registros;
use AppBundle\Entity\Personas;
use AppBundle\Form\HabitacionType;
use AppBundle\Form\HabitacionesType;
use AppBundle\Form\RegistrosType;
use AppBundle\Form\PersonaType;
use AppBundle\Form\TipoHabsType;
use AppBundle\Twig\AppExtension;

class DefaultController extends Controller
{

    /**
     * @Route("/", name="homepage")
     */
    public function indexAction(Request $request)
    {

        /* Recoger varias habitaciones para la Vista Previa de Habitaciones */

        $em = $this->getDoctrine()->getManager();
        $habsRep = $em->getRepository("AppBundle:Habitaciones");
        $habs = $habsRep->findAll();

        return $this->render('default/index.html.twig', array("habitaciones"=>$habs));
    }

     /**
     * @Route("/{slugHotel}/habitaciones", name="roompage", options={"expose"=true})
     */
    public function roomsAction(Request $request, $slugHotel)
    {
        $em = $this->getDoctrine()->getManager();

        $stmt = $em->getConnection()->prepare("SELECT id, nombre FROM hoteles WHERE slug = '".strval($slugHotel)."';");
        $stmt->execute();
        $idHotel = $stmt->fetchColumn(); 

        /* Recoger habitaciones en sus pisos y hoteles correspondientes */

        $stmt = $em->getConnection()->prepare("SELECT max(planta) FROM habitaciones WHERE idHotel = $idHotel;");
        $stmt->execute();
        $maxPisos = $stmt->fetchColumn();    

        $pisosXHotel = array();
        $registrosXHotel = array();
        for ($planta = 1 ; $planta <= $maxPisos ; $planta++ ){
            $stat = $em->getConnection()->prepare("SELECT * FROM habitaciones WHERE idHotel = $idHotel AND planta = $planta;");
            $stat->execute();
            array_push($pisosXHotel, $stat->fetchAll());

            /* Recoger registros relacionados con cada habitacion */

            $registros = array();
            foreach ($stat->fetchAll() as $habitacion){
                $stat = $em->getConnection()->prepare("SELECT * FROM registros WHERE idHabitacion = $habitacion->id;");
                $stat->execute();
                array_push($registros, $stat->fetchAll());
            }
            array_push($registrosXHotel, $registros);
        }         


        $stmt = $em->getConnection()->prepare("SELECT nombre FROM hoteles WHERE slug = '".strval($slugHotel)."' LIMIT 1;");
        $stmt->execute();
        $nombreHotel = $stmt->fetchColumn(); 

        return $this->render('default/rooms.html.twig', array("nombreHotel" => $nombreHotel, "pisosXHotel"=>$pisosXHotel, "registrosXHotel"=>$registrosXHotel, "slugHotel"=>$slugHotel));

    }

/**
     * @Route("/{slugHotel}/registro/nuevo/{idHabitacion}", name="roompage_newreg", options={"expose"=true})
     */
    public function newRegAction(Request $request, $slugHotel, $idHabitacion)
    {
        $em = $this->getDoctrine()->getManager();

        $stmt = $em->getConnection()->prepare("SELECT nombre FROM hoteles WHERE slug = '".strval($slugHotel)."' LIMIT 1;");
        $stmt->execute();
        $nombreHotel = $stmt->fetchColumn(); 

        /* Recoger entidades referentes al Registro nuevo */

        $habitaciones = $em->getRepository("AppBundle:Habitaciones");
        $habitacion=$habitaciones->findOneById($idHabitacion);

        $registro = new Registros();
        $registro->setIdhabitacion($habitacion);

        $personas = new Personas();
        $personas->addIdregistro($registro);
        
        /* Formulario para introducir un nuevo Registro , pudiendo seleccionar varias personas */

        $limitPisos = intval($habitacion->getIdhotel()->getId())+1;
        $precioCalculado = 0.0;

        $form = $this->createForm(RegistrosType::class, $registro);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $registro=$form->getData();
            $personas=$form->getData();

            foreach ($personas as $persona){
               $registro->addIdpersona($persona); 
               $persona->addIdregistro($registro);

               $stmt = $em->getConnection()->prepare("INSERT INTO clientes (idPersona, idRegistro) VALUES (".$persona->getId().", ".$registro->getId().");");
                $stmt->execute();
            }

            $this->addFlash(
                'notice',
                'Un nuevo registro ha sido introducido correctamente.'
            );

            $em->persist($personas);
            $em->persist($registro);

            $em->flush();

            return $this->redirectToRoute('roompage', array('slugHotel' => $slugHotel));
        }

        return $this->render('rooms/regnew.html.twig', array(
            "form" => $form->createView(), "reg"=>$registro, "nombreHotel"=>$nombreHotel, "precioCalculado"=>$precioCalculado, "slugHotel"=>$slugHotel));
        
    }

    /**
     * @Route("/{slugHotel}/registro/editar/{idHabitacion}", name="roompage_detailed", options={"expose"=true})
     */
    public function editRegAction(Request $request, $slugHotel, $idHabitacion)
    {
        $em = $this->getDoctrine()->getManager();

        $stmt = $em->getConnection()->prepare("SELECT id FROM registros WHERE idHabitacion = ".$idHabitacion." ORDER BY fechasalida DESC LIMIT 1");
        $stmt->execute();
        $registros = $stmt->fetchColumn(); 

        $habitaciones = $em->getRepository("AppBundle:Habitaciones");
        $habitacion=$habitaciones->findOneById($idHabitacion);

        $tipoHabs = $em->getRepository("AppBundle:Tipohabs");
        $tipoHab=$tipoHabs->findOneById($habitacion->getIdtipohab());

        $stmt = $em->getConnection()->prepare("SELECT nombre FROM hoteles WHERE slug LIKE '".strval($slugHotel)."' LIMIT 1;");
        $stmt->execute();
        $nombreHotel = $stmt->fetchColumn(); 

        /* Pantalla para editar un registro ... con su unica posibilidad de Desocupar registro */

        $registrosReg = $em->getRepository("AppBundle:Registros");
        $registro = $registrosReg->findOneById($registros);

        $personas = array();
        foreach ($registro->getIdpersona() as $persona){
            array_push($personas, $persona);
        }

        $precioactual = intval($tipoHab->getPreciobase())*count($personas);
        $precioTotal = floatval($precioactual);
        
        return $this->render('rooms/regedit.html.twig', array("slugHotel"=>$slugHotel,
            "nombreHotel"=>$nombreHotel, 
            "registro"=>$registro,
            "personas"=>$personas, 
            "habitacion"=>$habitacion,
            "tipoHab" => $tipoHab, 
            "precioTotal" => $precioTotal));
        
    }

    /**
     * @Route("/{slugHotel}/habitaciones/borrar/{idHabitacion}", name="roompage_deleteroom")
     */
    public function removeRoomAction($idHabitacion, $slugHotel)
    {
        // Creo un ENTITY MANAGER
        $em = $this->getDoctrine()->getManager();
        $listaHabs = $em->getRepository("AppBundle:Habitaciones");

        $hab=$listaHabs->findOneById($idHabitacion);

        $em->remove($hab);
        $flush=$em->flush();

        if ($hab->getNombre() != "" || $hab->getNombre() != NULL) {
            $nombreHab = $hab->getNombre();
        } else {
            $nombreHab = "<i>Sin nombre</i>";
        }
        $this->addFlash(
            'notice',
            'La habitación #'.$idHabitacion.' '.$nombreHab.' ha sido eliminado correctamente.'
        );

        return $this->redirectToRoute('roompage', array('slugHotel' => $slugHotel))
    }

    /**
     * @Route("/{slugHotel}/habitaciones/tipos", name="roomtype_create")
     */
    public function updateRoomtypeAction(Request $request, $slugHotel)
    {
        $em = $this->getDoctrine()->getManager();

        /* Posibilidad de crear nuevo tip ode Habitacion */
        $listaTipoHabs = $em->getRepository("AppBundle:Tipohabs")->findBy(array(), 
            array('preciobase' => 'ASC',));

        $tipoHabBlanco = new TipoHabs();
        $form=$this->createForm(TipoHabsType::class, $tipoHabBlanco);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $tipoHab=$form->getData();

            $em = $this->getDoctrine()->getManager();
            $em->persist($tipoHab);
            $em->flush();

            return $this->redirectToRoute('roomtype_create', array('slugHotel' => $slugHotel));
        }

        return $this->render('rooms/roomsType.html.twig', array("slugHotel" => $slugHotel,
            'form' => $form->createView(), 'tipos' => $listaTipoHabs));

    }
    /**
     * @Route("/{slugHotel}/registros/borrar/{idRegistro}", name="roompage_deletereg")
     */
    public function removeRegAction($idRegistro, $slugHotel)
    {
        // Creo un ENTITY MANAGER
        $em = $this->getDoctrine()->getManager();
        $listaRegs = $em->getRepository("AppBundle:Registros");

        $reg=$listaRegs->findOneById($idRegistro);

        if (!$reg) {
            throw $this->createNotFoundException(
                'No reg for id '.$idRegistro
            );
        }

        $reg->setFechasalida(new \DateTime());
        $flush=$em->flush();

        $this->addFlash(
            'notice',
            'El registro #'.$idRegistro.' ha sido actualizado correctamente.'
        );

        return $this->redirectToRoute('roompage', array('slugHotel' => $slugHotel));
    }

    /**
     * @Route("/{slugHotel}/clients/borrar/{idCliente}", name="deleteclient_page")
     */
    public function removeClientAction($slugHotel, $idCliente)
    {

        $em = $this->getDoctrine()->getManager();
        $persona = $em->getRepository("AppBundle:Personas")->findOneById($idCliente);

        if (!$persona) {
            throw $this->createNotFoundException(
                'No person for id '.$idCliente
            );
        }

        $em->remove($persona);
        $flush=$em->flush();

        $this->addFlash(
            'notice',
            'La persona #'.$idCliente.' ha sido borrado correctamente.'
        );

        return $this->redirectToRoute('clientspage', array('slugHotel' => $slugHotel));
    }

     /**
     * @Route("/{slugHotel}/habitaciones/editar/{idHabitacion}", name="roompage_editroom")
     */
    public function editRoomAction($idHabitacion, $slugHotel)
    {
    }

    /**
     * @Route("/{slugHotel}/habitaciones/nuevo", name="roompage_create")
     * @Route("/{slugHotel}/habitaciones/nuevo/{numPisos}", name="roompage_create_2")
     */
    public function newRoomAction(Request $request, $slugHotel, $numPisos = 1)
    {
        $em = $this->getDoctrine()->getManager();
        $habitacion = new Habitaciones();
        $habitacion->setPlanta($numPisos);

        $form=$this->createForm(HabitacionesType::class, $habitacion, 
            array('limit_min' => 1, 'limit' => 99));

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $habitacion=$form->getData();

            $em = $this->getDoctrine()->getManager();
            $em->persist($habitacion);
            $em->flush();

            return $this->redirectToRoute('roompage', array('slugHotel' => $slugHotel));

        }

        return $this->render('rooms/newRoom.html.twig', array("slugHotel" => $slugHotel,
            'form' => $form->createView(), 'planta' => $numPisos));
    }

    /**
     * @Route("/{slugHotel}/habitaciones/borrarPlanta/{planta}", name="roompage_remove_floor")
     */
    public function removeFloorAction(Request $request, $slugHotel, $planta)
    {

        $em = $this->getDoctrine()->getManager();

        $stmt = $em->getConnection()->prepare("SELECT id FROM hoteles WHERE slug = '".strval($slugHotel)."';");
        $stmt->execute();
        $idHotel = $stmt->fetchColumn(); 

        $stmt = $em->getConnection()->prepare("SELECT max(planta) FROM habitaciones WHERE idHotel = $idHotel;");
        $stmt->execute();
        $maxPisos = $stmt->fetchColumn();  

        if ($planta >= $maxPisos){
            $query = $em->createQuery(
                'SELECT h FROM AppBundle:Habitaciones h WHERE h.planta = :planta')->setParameter('planta', $planta);
     
            $habitaciones = $query->getResult();

            foreach ($habitaciones as $hab){
                $em->remove($hab);
            }

            $flush=$em->flush();

            return $this->redirectToRoute('roompage', array('slugHotel' => $slugHotel));
        }

        return $this->render('rooms/removeRoom.html.twig', array('slugHotel' => $slugHotel));
    }

    /**
     * @Route("/{slugHotel}/registros", name="regpage")
     */
    public function regsAction($slugHotel)
    {

        $em = $this->getDoctrine()->getManager();
        $stmt = $em->getConnection()->prepare("SELECT * FROM registros r WHERE idHabitacion IN (SELECT id FROM habitaciones WHERE idHotel IN (SELECT id FROM hoteles WHERE slug LIKE '".$slugHotel."')) ORDER BY r.fechasalida DESC;");
        $stmt->execute();
        $listaRegistros = $stmt->fetchAll(); 

        return $this->render('default/registry.html.twig', array("listaRegistros"=>$listaRegistros,
            "slugHotel" => $slugHotel));
    }

    /**
     * @Route("/{slugHotel}/habitaciones/update/{idHabitacion}/{numPiso}", name="updateroom_page")
     */
    public function updateRoomAction(Request $request, $slugHotel, $idHabitacion, $numPiso)
    {

        $em = $this->getDoctrine()->getManager();
        $listaHabs = $em->getRepository("AppBundle:Habitaciones");
        $hab=$listaHabs->findOneById($idHabitacion);

        $form=$this->createForm(HabitacionesType::class, $hab, array('limit' => $numPiso, 'limit_min' => $numPiso));
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $habitacion=$form->getData();

            $hoteles = $em->getRepository("AppBundle:Hoteles");
            $query = $hoteles->createQueryBuilder('p')->where('p.slug LIKE :slug')->setParameter('slug', $slugHotel)->getQuery();
            $hotel = $query->getResult();

            $habitacion->setIdhotel($hotel);
            $em = $this->getDoctrine()->getManager();
            $em->persist($habitacion);
            $em->flush();

            return $this->redirectToRoute('roompage', array('slugHotel' => $slugHotel));
        }

        return $this->render('rooms/roomedit.html.twig', array("slugHotel" => $slugHotel,
            'form' => $form->createView()));
    }

    /**
     * @Route("/{slugHotel}/clientes", name="clientspage")
     */
    public function clientsAction(Request $request, $slugHotel)
    {

        $em = $this->getDoctrine()->getManager();
        $stmt = $em->getConnection()->prepare("SELECT nombre FROM hoteles WHERE slug = '".strval($slugHotel)."' LIMIT 1;");
        $stmt->execute();
        $nombreHotel = $stmt->fetchColumn(); 
        $listaClientes = $em->getRepository("AppBundle:Personas")->findAll();

        $persona = new Personas();

        $form = $this->createForm(PersonaType::class, $persona);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $persona=$form->getData();

            $em = $this->getDoctrine()->getManager();
            $em->persist($persona);
            $em->flush();

            return $this->redirectToRoute('clientspage', array('slugHotel' => $slugHotel));
        }

                $stmt = $em->getConnection()->prepare("SELECT nombre FROM hoteles WHERE slug = '".strval($slugHotel)."' LIMIT 1;");
        $stmt->execute();
        $nombreHotel = $stmt->fetchColumn(); 

        return $this->render(
            'default/clients.html.twig', 
            array("listaClientes"=>$listaClientes, "nombreHotel" => $nombreHotel, "form" => $form->createView(), "slugHotel" => $slugHotel)
        );
    }

        /**
     * @Route("/{slugHotel}/clientes/editar/{idCliente}", name="editclients_page")
     */
    public function editClientAction(Request $request, $slugHotel, $idCliente)
    {
        $em = $this->getDoctrine()->getManager();
        $listaCls = $em->getRepository("AppBundle:Personas");
        $cliente=$listaCls->findOneById($idCliente);

        $form = $this->createForm(PersonaType::class, $cliente);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $persona=$form->getData();

            $em = $this->getDoctrine()->getManager();
            $em->persist($persona);
            $em->flush();

            return $this->redirectToRoute('clientspage', array('slugHotel' => $slugHotel));
        }

        return $this->render(
            'rooms/clientsEdit.html.twig', 
            array("form" => $form->createView(), "slugHotel" => $slugHotel)
        );
    }
}
