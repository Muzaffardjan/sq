<?php
/**
 * Sayyor qabul kunlari
 *
 * @author    Muzaffardjan Karaev
 * @copyright Copyright (c) "FOR EACH SOFT" LTD 2015 (http://www.each.uz)
 * @license   "FOR EACH SOFT" LTD PUBLIC LICENSE
 * Created:   11.03.2017
 */
namespace Users\Repository;

use Doctrine\ORM\EntityRepository;
use Users\Entity\User;

/**
 * Class UsersRepository
 * @package Users\Repository
 */
class UsersRepository extends EntityRepository
{
    public function getUser($identity)
    {
        $builder = $this->getEntityManager()->createQueryBuilder();

        $result = $builder->select('u')
            ->from(User::class, 'u')
            ->where($builder->expr()->eq('u.username', ':username'))
            ->setParameter('username', $identity)
            ->setMaxResults(1)
            ->getQuery()
            ->getResult();

        if ($result) {
            return current($result);
        }

        return null;
    }
}