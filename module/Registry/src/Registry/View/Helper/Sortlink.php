<?php
namespace Registry\View\Helper;

use Zend\Stdlib\RequestInterface;
use Zend\I18n\View\Helper\AbstractTranslatorHelper;
use Zend\View\Helper\EscapeHtml;

class Sortlink extends AbstractHtmlTranslatorHelper
{
	protected $request;
	
	/**
	 * Html escape helper
	 *
	 * @var EscapeHtml
	 */
	protected $escapeHtmlHelper;
	
	public function __construct(RequestInterface $request)
	{
		$this->request = $request;
		
		return $this;
	}
	
	protected function getRequest()
	{
		return $this->request;
	}
	
	public function __invoke($by, $label = '', $defaultColumn = false, $url = array(), $htmlLabel = false, $attributes = array(), $renderCaret = true)
	{
		$view = $this->getView();
		$urlHelper  = $view->plugin('url');
		
		
		$curBy = $this->getRequest()->getQuery('by', '');
		$sort = $this->getRequest()->getQuery('sort', 'asc');
		$sort = trim(strtolower($sort));
		$sortInverseMap = array(
			'asc' => 'desc',
			'desc' => 'asc',
		);
		if (!empty($curBy) && $curBy !== $by) {
			$renderCaret = false;
			$sort = 'asc';
		} else {
			if (empty($curBy) || $curBy !== $by) {
				if (!$defaultColumn) {
					$renderCaret = false;
				}
			}
			$sort = $sortInverseMap[$sort]; 
		}
		
		$queryParams = $this->getRequest()->getQuery()->toArray();
		$newQueryParams = array('sort' => $sort, 'by' => $by);
		$newQueryParams = array_merge($queryParams, $newQueryParams);
		if (empty($url)) {
			$url = $urlHelper(null, array(), array('query' => $newQueryParams), true);
		} else {
			if (isset($url['params'])) {
				$newQueryParams = array_merge($url['params'], $newQueryParams);
				unset($url['params']);
			}

			if (!isset($url[2])) {
				$url[2] = array('query' => $newQueryParams);
			} else {
				$url[2] = array_merge($url[2], array('query' => $newQueryParams));
			}
			
			$url = call_user_func_array($urlHelper, $url);
		}
		
		$attributes = array_merge($attributes, array(
			'href' => $url
		));
		
		$translator = $this->getTranslator();
		$translatorTextDomain = $this->getTranslatorTextDomain();
		
		if ($translator !== null) {
			$label = $translator->translate($label, $translatorTextDomain);
		}
		
		if (!$htmlLabel) {
			$escapeHtml = $this->getEscapeHtmlHelper();
			$label = $escapeHtml($label);
		}
		
		// Object header
		$xhtml = '<a' . $this->htmlAttribs($attributes) . '>' . PHP_EOL
		. $label . PHP_EOL
		. (($renderCaret) ? ' <span class="caret' . ($sort === 'desc' ? ' caret-up' : '') . '"></span>' . PHP_EOL : '') 
		. '</a>';
		
		return $xhtml;
	}
	
	/**
	 * Retrieve the escapeHtml helper
	 *
	 * @return EscapeHtml
	 */
	protected function getEscapeHtmlHelper()
	{
		if ($this->escapeHtmlHelper) {
			return $this->escapeHtmlHelper;
		}
	
		if (method_exists($this->getView(), 'plugin')) {
			$this->escapeHtmlHelper = $this->view->plugin('escapehtml');
		}
	
		if (!$this->escapeHtmlHelper instanceof EscapeHtml) {
			$this->escapeHtmlHelper = new EscapeHtml();
		}
	
		return $this->escapeHtmlHelper;
	}
}
