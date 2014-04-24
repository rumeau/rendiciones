<?php
namespace Registry\Mvc\Controller\Plugin;

use Zend\Mvc\Controller\Plugin\AbstractPlugin;

class SortParams extends AbstractPlugin
{
	public function __invoke($map = array())
	{
		if (!is_array($map)) {
			throw new \Exception('A filtering map must be provided');
		}
		$sort = $this->getController()->params()->fromQuery('sort', 'asc');
		$sort = trim(strtolower($sort));
		$sort = in_array($sort, array('asc', 'desc')) ? $sort : 'asc';

		$by = $this->getController()->params()->fromQuery('by', 'number');
		$by = trim(strtolower($by));
		$by = array_key_exists($by, $map) ? $map[$by] : current($map);
		
		$result = new \stdClass();
		$result->by = $by;
		$result->sort = $sort;
		
		return $result;
	}
}
