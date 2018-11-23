<?php

namespace Netiul\DoctrineMoneyModule\Form\Element\Factory;

use PHPUnit_Framework_TestCase as TestCase;
use Zend\Form\FormElementManager;
use Zend\ServiceManager\Config;
use Zend\ServiceManager\ServiceManager;
use Netiul\DoctrineMoneyModule\Form\Element\CurrencySelect;

class CurrencySelectFactoryTest extends TestCase
{
    /**
     * @var ServiceManager
     */
    private $serviceManager;

    private $config = [
        'money' => [
            'currencies' => [
                'BRL' => 'Brazilian Real',
                'SAD' => 'Sad Asteka',
            ],
        ],
    ];

    public function setUp()
    {
        $this->serviceManager = new ServiceManager(new Config($this->config));
    }

    public function testFactoryCanCreateElement()
    {
        $factory = new CurrencySelectFactory();
        $this->serviceManager->setService('Config', $this->config);

        $formElementManager = $this->getMock(FormElementManager::class);
        $formElementManager->expects($this->once())->method('getServiceLocator')->willReturn($this->serviceManager);

        $this->assertInstanceOf(CurrencySelect::class, $factory($formElementManager));
    }

    public function testFactoryCreateElementWithExpectedCurrencies()
    {
        $factory = new CurrencySelectFactory();
        $this->serviceManager->setService('Config', $this->config);

        $formElementManager = $this->getMock(FormElementManager::class);
        $formElementManager->expects($this->once())->method('getServiceLocator')->willReturn($this->serviceManager);

        /* @var CurrencySelect $currencySelect */
        $currencySelect = $factory($formElementManager);

        $this->assertEquals($this->config['money']['currencies'], $currencySelect->getValueOptions());
    }

    public function testFactoryCreateElementsWithNoCurrenciesShouldTrownAnException()
    {
        $factory = new CurrencySelectFactory();
        $this->serviceManager->setService('Config', []);

        $formElementManager = $this->getMock(FormElementManager::class);
        $formElementManager->expects($this->once())->method('getServiceLocator')->willReturn($this->serviceManager);

        $this->setExpectedException('InvalidArgumentException');

        /* @var CurrencySelect $currencySelect */
        $factory($formElementManager);
    }
}
