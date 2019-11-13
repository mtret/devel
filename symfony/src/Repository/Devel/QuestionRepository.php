<?php

namespace App\Repository\Devel;

use App\Entity\Devel\Question;
use Cassandra\Date;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method Question|null find($id, $lockMode = null, $lockVersion = null)
 * @method Question|null findOneBy(array $criteria, array $orderBy = null)
 * @method Question[]    findAll()
 * @method Question[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class QuestionRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Question::class);
    }

    public function getAllInLastWeek() {
        $lastWeek = (new \DateTime())->modify('-168 hours');

        $qb = $this->_em->createQueryBuilder();
        $qb->select('q')
            ->from(Question::class, 'q')
            ->where('q.time >= :time')
            ->orderBy('q.answer_count', 'DESC')
            ->setParameter('time', $lastWeek->format('Y-m-d'));

        return $qb->getQuery()->getResult();
    }

}
