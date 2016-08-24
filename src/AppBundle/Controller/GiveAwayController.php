<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use FOS\UserBundle\Model\UserInterface;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;

class GiveAwayController extends Controller
{
    /**
     * @Route("/", name="search")
     */
    public function searchAction(Request $request)
    {	
       	
    	$user = $this->getUser();
        if (!is_object($user) || !$user instanceof UserInterface) {
            throw new AccessDeniedException('This user does not have access to this section.');
        }

       	$name = '';
       	$sort = '';
       	$results = [];
       	$filtered = [];

    	if(!empty($request->request->get('_name'))){
            $name = $request->request->get('_name');
            $sort = $request->request->get('_sort');
            $repo = $this->getDoctrine()
                  ->getRepository('AppBundle:Giveaway');
            $results = $repo->fetchGiveaways($name, $sort);
            $authCheck = $this->get('security.authorization_checker');

            if (!in_array('ROLE_ADMIN', $user->getRoles())) {

	            foreach($results as $item) {
	            	$gotAccess = $authCheck->isGranted('VIEW', $item);
                        
	            	if($gotAccess) {
	            	 		//non-admin for 'other' items that has been granted explicit Role based access
	            	 		//php app/console acl:set --role=ROLE_USER  VIEW AppBundle/Entity/Giveaway:3
                            array_push($filtered, $item);
		        }
	            }
            }else {
            	//ROLE_ADMIN sees all
            	$filtered = $results;
            }
            
    	}

        return $this->render('AppBundle:GiveAway:search.html.twig', 
                array(
                    '_name' => $name,
                    '_sort' => $sort,
                    'giveaways' => $filtered
                ));
    }

}
