<?php

namespace OCUserBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use OCUserBundle\Entity\User;

class LoadUser implements FixtureInterface {
	public function load(ObjectManager $manager) {
		// Les noms de chomeurs
		$listRolesNames = array (
				'ROLE_CHOMEUR' => array (
						'Alexandre',
						'Marine',
						'Anna' 
				),
				'ROLE_ENTREPRISE' => array (
						'Monsanto',
						'NuclearIndustry' 
				) 
		);
		
		foreach ( $listRolesNames as $role => $arrayNames ) {
			
			foreach ($arrayNames as $name) {
				
				// On crée l'utilisateur
				$user = new User ();
				
				// Le nom d'utilisateur et le mot de passe sont identiques
				$user->setUsername ( $name );
				$user->setPassword ( $name );
				
				// On ne se sert pas du sel pour l'instant
				$user->setSalt ( '' );
				
				// On définit uniquement le role ROLE_CHOMEUR qui est le role de base
				$user->setRoles (array (
						$role
				));
				
				// On le persiste
				$manager->persist ( $user );
			}
		}
		
		// On déclenche l'enregistrement
		$manager->flush ();
	}
}