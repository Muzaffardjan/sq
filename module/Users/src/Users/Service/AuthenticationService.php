<?php
/**
 * Sayyor qabul kunlari
 *
 * @author    Muzaffardjan Karaev
 * @copyright Copyright (c) "FOR EACH SOFT" LTD 2015 (http://www.each.uz)
 * @license   "FOR EACH SOFT" LTD PUBLIC LICENSE
 * Created:   09.03.2017
 */
namespace Users\Service;

use Zend\Authentication\AuthenticationService as ZendAuthService;
use ZfcRbac\Identity\IdentityProviderInterface as ZfcRbacIdentity;

class AuthenticationService extends ZendAuthService implements ZfcRbacIdentity
{

}