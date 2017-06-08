<?php 
namespace AppBundle\Twig;
use Symfony\Bridge\Doctrine\RegistryInterface;

class AppExtension extends \Twig_Extension {

    protected $doctrine;
    public function __construct(RegistryInterface $doctrine)
    {
        $this->doctrine = $doctrine;
    }
	public function getFunctions()
    {
        return array(
            new \Twig_SimpleFunction('estaDisp', array($this, 'checkIfRoomAvalaible')),
        );
    }

    /**
     * @param int $habID
     * @return boolean
     */
    public function checkIfRoomAvalaible($habID)
    {
    	$estaDisponible = true;

    	$em = $this->doctrine->getManager();
        $stmt = $em->getConnection()->prepare("SELECT * FROM registros WHERE idHabitacion = ".$habID." ORDER BY id DESC LIMIT 1;");
        $stmt->execute();

        $ahora = new \DateTime("now");

        foreach ($stmt->fetchAll() as $reg){
        	$antes = new \DateTime($reg['fechaEntrada']);
        	$despues = new \DateTime($reg['fechaSalida']);

	        if($despues >= $ahora && $antes <= $ahora){
			 	$estaDisponible = false;
			}
		}

        return $estaDisponible;
    }

}