<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use App\Entity\Devel\Question;
use DateTimeImmutable;
use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerAwareTrait;

final class Version20191112032151 extends AbstractMigration implements ContainerAwareInterface
{

    use ContainerAwareTrait;

    public function getDescription() : string
    {
        return 'Fill table question with some test questions';
    }

    /**
     * @param Schema $schema
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function up(Schema $schema) : void
    {
        /** @var EntityManager $em */
        $em = $this->container->get('doctrine.orm.entity_manager');

        $question1 = (new Question())
            ->setAnswerCount(5)
            ->setBestAnswer('pepazdepa')
            ->setTitle('Otázka 1')
            ->setUrl('devel.cz')
            ->setTime(new DateTimeImmutable('2019-01-01'))
        ;

        $question2 = (new Question())
            ->setAnswerCount(6)
            ->setBestAnswer('batman')
            ->setTitle('Otázka 2')
            ->setUrl('devel.cz')
            ->setTime(new DateTimeImmutable('2019-11-11'))
        ;

        $question3 = (new Question())
            ->setAnswerCount(16)
            ->setBestAnswer('okurka')
            ->setTitle('Otázka 3')
            ->setUrl('devel.cz')
            ->setTime(new DateTimeImmutable('2019-11-09'))
        ;

        $em->persist($question1);
        $em->persist($question2);
        $em->persist($question3);

        $em->flush();
    }

    public function down(Schema $schema) : void
    {
        $this->connection->executeQuery('TRUNCATE TABLE question;');
    }

}
