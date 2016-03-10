<?php
namespace OCUserBundle\EventListener;

use FOS\UserBundle\FOSUserEvents;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use FOS\UserBundle\Event\UserEvent;
use FOS\UserBundle\Model\UserInterface;

class RegisterListener implements EventSubscriberInterface
{
    public static function getSubscribedEvents()
    {
        return [ FOSUserEvents::REGISTRATION_SUCCESS => 'onRegistrationSuccess' ];
    }

    /**
     * @TODO
     * @param $event
     */
    public function onRegistrationSuccess( $event )
    {
        $formValues = $event->getRequest();
        $user = $event->getUser();
        die();
        $user->addRole( 'ROLE_USER' );
    }
}