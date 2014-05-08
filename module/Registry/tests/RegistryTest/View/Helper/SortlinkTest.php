<?php
namespace RegistryTest\View\Helper;

use PHPUnit_Framework_TestCase as TestCase;
use Zend\View\Renderer\PhpRenderer;
use Zend\I18n\Translator\Translator;
use Registry\View\Helper;
use Zend\Http\PhpEnvironment\Request;
use Zend\Mvc\Router\RouteMatch;
use Zend\Mvc\Router\Http\TreeRouteStack as Router;

class SortlinkTest extends TestCase
{
	/**
     * @var \Zend\Form\View\Helper\AbstractHelper
     */
    public $helper;

    /**
     * @var \Zend\View\Renderer\RendererInterface
     */
    public $renderer;

    public function setUp()
    {
    	$request = new Request();
    	$request->setQuery(new \Zend\StdLib\Parameters(array('by' => 'test', 'sort' => 'asc')));
        $this->helper = new Helper\Sortlink($request);

        $this->helper->setView(new PhpRenderer());
    }

    public function testTranslator()
    {
    	$translator = Translator::factory(array(
    		'locale' => 'en_US',
    		'translation_file_patterns' => array(
    			array(
    				'type'     => 'gettext',
    				'base_dir' => __DIR__ . '/../../../../../Application/language',
    				'pattern'  => '%s.mo',
            	),
        	)
        ));

    	$this->assertNull($this->helper->getTranslator());

        $this->helper->setTranslator($translator, 'dummy');
        $this->assertInstanceOf('Zend\I18n\Translator\Translator', $this->helper->getTranslator());
        $this->assertTrue($this->helper instanceof Helper\AbstractHtmlTranslatorHelper);

		$this->helper->setTranslatorEnabled(false);
		$this->assertNull($this->helper->getTranslator());
        $this->helper->setTranslatorEnabled(true);
        $isInstance = $this->helper instanceof Helper\AbstractHtmlTranslatorHelper;
    	$this->assertTrue($isInstance);
    	if (!$isInstance) {
    		$this->markTestSkipped('El ViewHelper no es una instancia de AbstractHtmlTranslatorHelper');
    	}
    	
    	$this->assertTrue($this->helper->hasTranslator());
    	if (!$this->helper->hasTranslator()) {
    		$this->markTestSkipped('El ViewHelper no tiene asignado un translator');
    	}

    	$this->assertTrue($this->helper->isTranslatorEnabled());

    	$this->assertEquals('dummy', $this->helper->getTranslatorTextDomain());
    }

    public function testSortLink()
    {
    	$url = $this->helper->getView()->plugin('url');
    	$router = new Router();
        $router->addRoute('home', array(
            'type' => 'Zend\Mvc\Router\Http\Literal',
            'options' => array(
                'route' => '/',
            )
        ));
        $router->addRoute('default', array(
        	'type' => 'Zend\Mvc\Router\Http\Segment',
            'options' => array(
                'route' => '/:controller[/:action]',
            )
        ));

        $url->setRouter($router);
        

		$translator = Translator::factory(array(
    		'locale' => 'en_US',
    		'translation_file_patterns' => array(
    			array(
    				'type'     => 'gettext',
    				'base_dir' => __DIR__ . '/../../../../../Application/language',
    				'pattern'  => '%s.mo',
            	),
        	)
        ));

        $this->helper->setTranslator($translator, 'dummy');

    	$a = $this->helper->__invoke('test', 'Label', true, array('default', array('controller' => 'test', 'action' => 'dummy'), array(), 'params' => array('test' => '1')), true, array('title' => 'title'), true);
    	$html = <<<html
<a title="title" href="/test/dummy?test=1&amp;by=test&amp;sort=desc">
Label
 <span class="caret caret-up"></span>
</a>
html;
    	$this->assertEquals($html, $a);

    	$a = $this->helper->__invoke('dummy', 'Label', true, array('home', array()), true, array('title' => 'title'), true);
    	$html = <<<html
<a title="title" href="/?by=dummy&amp;sort=asc">
Label
</a>
html;
    	$this->assertEquals($html, $a);


    	$routeMatch = new RouteMatch(array());
        $routeMatch->setMatchedRouteName('home');
        $url->setRouteMatch($routeMatch);

    	$a = $this->helper->__invoke('test', 'Label', false, array(), true, array('title' => 'title'), true);
    	$html = <<<html
<a title="title" href="/?by=test&amp;sort=desc">
Label
 <span class="caret caret-up"></span>
</a>
html;
		$this->assertEquals($html, $a);




		$request = new Request();
    	$request->setQuery(new \Zend\StdLib\Parameters(array('by' => '', 'sort' => 'asc')));
        $this->helper = new Helper\Sortlink($request);
        $this->helper->setView(new PhpRenderer());
        
    	$routeMatch = new RouteMatch(array());
        $routeMatch->setMatchedRouteName('home');
        $url = $this->helper->getView()->plugin('url');
    	$router = new Router();
        $router->addRoute('home', array(
            'type' => 'Zend\Mvc\Router\Http\Literal',
            'options' => array(
                'route' => '/',
            )
        ));
        $router->addRoute('default', array(
        	'type' => 'Zend\Mvc\Router\Http\Segment',
            'options' => array(
                'route' => '/:controller[/:action]',
            )
        ));

        $url->setRouter($router);
        $url->setRouteMatch($routeMatch);

        $a = $this->helper->__invoke('dummy', 'Label', false, array('home', array()), false, array('title' => 'title'), true);
    	$html = <<<html
<a title="title" href="/?by=dummy&amp;sort=desc">
Label
</a>
html;
    	$this->assertEquals($html, $a);

    	
    }
}
