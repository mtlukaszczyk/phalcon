<?php

use Phalcon\Acl;
use Phalcon\Acl\Role;
use Phalcon\Acl\Resource;
use Phalcon\Events\Event;
use Phalcon\Mvc\User\Plugin;
use Phalcon\Mvc\Dispatcher;
use Phalcon\Acl\Adapter\Memory as AclList;

/**
 * SecurityPlugin
 *
 * This is the security plugin which controls that users only have access to the modules they're assigned to
 */
class SecurityPlugin extends Plugin {

    /**
     * Returns an existing or new access control list
     *
     * @returns AclList
     */
    public function getAcl() {
        if (!isset($this->persistent->acl)) {
            $acl = new AclList();
            $acl->setDefaultAction(Acl::DENY);
            // Register roles
            $roles = [
                'users' => new Role(
                        'Users', 'Member privileges, granted after sign in.'
                ),
                'guests' => new Role(
                        'Guests', 'Anyone browsing the site who is not signed in is considered to be a "Guest".'
                )
            ];
            foreach ($roles as $role) {
                $acl->addRole($role);
            }

            //Public area resources
            $publicResources = [
                'Index' => ['index'],
                'User' => ['login', 'index'],
                'Errors' => ['notfound', 'noaccess', 'servererror'],
                'Test' => ['index']
            ];
            foreach ($publicResources as $resource => $actions) {
                $acl->addResource(new Resource($resource), $actions);
            }
            //Grant access to public areas to both users and guests
            foreach ($roles as $role) {
                foreach ($publicResources as $resource => $actions) {
                    foreach ($actions as $action) {
                        $acl->allow($role->getName(), $resource, $action);
                    }
                }
            }

            //The acl is stored in session, APC would be useful here too
            $this->persistent->acl = $acl;
        }
        return $this->persistent->acl;
    }

    /**
     * This action is executed before execute any action in the application
     *
     * @param Event $event
     * @param Dispatcher $dispatcher
     * @return bool
     */
    public function beforeExecuteRoute(Event $event, Dispatcher $dispatcher) {
        $auth = $this->session->has('userID');

        if (!$auth) {

            $role = 'Guests';
            $controller = $dispatcher->getControllerName();
            $action = $dispatcher->getActionName();
            $acl = $this->getAcl();

            $allowed = $acl->isAllowed($role, $controller, $action);

            if (!$allowed) {
                $dispatcher->forward([
                    'controller' => 'errors',
                    'action' => 'noAccess'
                ]);
                $this->session->destroy();
                return false;
            }
        } else {
            return true;
        }
    }

}
