<?php

namespace App\Repository;

use App\Entity\Trick;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\ORM\Tools\Pagination\Paginator;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;


/**
 * @method Trick|null find($id, $lockMode = null, $lockVersion = null)
 * @method Trick|null findOneBy(array $criteria, array $orderBy = null)
 * @method Trick[]    findAll()
 * @method Trick[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class TrickRepository extends ServiceEntityRepository
{
    public const PAGINATOR_PER_PAGE = 10;
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Trick::class);
    }
    /**
 * Get the paginated list of published articles
 *
 * @param int $page
 * @param int $maxperpage
 * @param string $sortby
 * @return Paginator
 */
public function getList($page=1, $maxperpage=10)
{
    $q = $this->_em->createQueryBuilder()
        ->select('trick')
        ->from('SimaDemoBundle:Trick','trick')
    ;
 
    $q->setFirstResult(($page-1) * $maxperpage)
        ->setMaxResults($maxperpage);
 
    return new Paginator($q);
}

   
}
