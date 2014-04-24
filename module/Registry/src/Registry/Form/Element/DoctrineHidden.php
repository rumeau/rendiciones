<?php
namespace Registry\Form\Element;

use Zend\Form\Element\Hidden as ZendHidden;
use DoctrineModule\Form\Element\Proxy;

class DoctrineHidden extends ZendHidden
{
	/**
	 * @var Proxy
	 */
	protected $proxy;
	
	/**
	 * @return Proxy
	 */
	public function getProxy()
	{
		if (null === $this->proxy) {
			$this->proxy = new Proxy();
		}
		return $this->proxy;
	}
	
	/**
	 * @param  array|\Traversable $options
	 * @return ObjectSelect
	 */
	public function setOptions($options)
	{
		$this->getProxy()->setOptions($options);
		return parent::setOptions($options);
	}
	
	/**
	 * {@inheritDoc}
	 */
	public function setValue($value)
	{
		return parent::setValue($this->getProxy()->getValue($value));
	}
}
