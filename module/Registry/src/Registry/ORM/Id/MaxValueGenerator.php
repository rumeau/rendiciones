<?php
namespace Registry\ORM\Id;

class MaxValueGenerator
{	
	public function generate($em, $entity)
	{
		if ($entity->getStatus() === 1) {
			return 0;
		}
		$query = $em->createQueryBuilder();
		$query->select('MAX(r.number) + 1 as nextnumber')
			->from('Registry\Entity\Registry', 'r')
			->where('r.user = :USER')
			->andWhere('r.status != 1')
			->setParameter('USER', $entity->getUser());
		
		$next = $query->getQuery()->getSingleScalarResult();
		
		return $next !== null ? $next : 1;
	}
	
	public function isPostInsertGenerator()
	{
		return false;
	}
}
