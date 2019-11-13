<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use App\Entity\Devel\User;
use Doctrine\DBAL\DBALException;
use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerAwareTrait;

final class Version20191112025637 extends AbstractMigration implements ContainerAwareInterface {

    use ContainerAwareTrait;

    public function getDescription()
    : string {
        return 'Fill table user with some test users';
    }

    /**
     * @param Schema $schema
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function up(Schema $schema)
    : void {
        /** @var EntityManager $em */
        $em = $this->container->get('doctrine.orm.entity_manager');

        $user1 = (new User())
            ->setEmail('testovaci1@odnikudnikam.eu')
            ->setSubscribed(true)
            ->setUsername('user1');

        $user2 = (new User())
            ->setEmail('testovaci2@odnikudnikam.eu')
            ->setSubscribed(false)
            ->setUsername('user2');

        $em->persist($user1);
        $em->persist($user2);

        $em->flush();
    }

    /**
     * @param Schema $schema
     * @throws DBALException
     */
    public function down(Schema $schema)
    : void {
        $this->connection->executeQuery('TRUNCATE TABLE user');
    }

}
