<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace Magento\Framework\View\Test\Unit\Element\Html;

class LinkTest extends \PHPUnit\Framework\TestCase
{
    /**
     * @var array
     */
    protected $allowedAttributes = [
        'href',
        'shape',
        'tabindex',
        'onfocus',
        'onblur',
        'id',
        'some_invalid_data',
    ];

    /**
     * @var \Magento\Framework\View\Element\Html\Link
     */
    protected $link;

    /**
     * @param \Magento\Framework\View\Element\Html\Link $link
     * @param string $expected
     *
     * @dataProvider getLinkAttributesDataProvider
     */
    public function testGetLinkAttributes($link, $expected)
    {
        $this->assertEquals($expected, $link->getLinkAttributes());
    }

    public function getLinkAttributesDataProvider()
    {
        $objectManagerHelper = new \Magento\Framework\TestFramework\Unit\Helper\ObjectManager($this);

        $escaperMock = $this->getMockBuilder(\Magento\Framework\Escaper::class)
            ->setMethods(['escapeHtml'])->disableOriginalConstructor()->getMock();

        $escaperMock->expects($this->any())
            ->method('escapeHtml')
            ->will($this->returnArgument(0));

        $urlBuilderMock = $this->getMockBuilder(\Magento\Framework\UrlInterface::class)
            ->setMethods(['getUrl'])->disableOriginalConstructor()->getMockForAbstractClass();

        $urlBuilderMock->expects($this->any())
            ->method('getUrl')
            ->will($this->returnValue('http://site.com/link.html'));

        $validtorMock = $this->getMockBuilder(\Magento\Framework\View\Element\Template\File\Validator::class)
            ->setMethods(['isValid'])->disableOriginalConstructor()->getMock();

        $scopeConfigMock = $this->getMockBuilder(\Magento\Framework\App\Config::class)
            ->setMethods(['isSetFlag'])->disableOriginalConstructor()->getMock();

        $resolverMock = $this->getMockBuilder(\Magento\Framework\View\Element\Template\File\Resolver::class)
            ->setMethods([])->disableOriginalConstructor()->getMock();

        $contextMock = $this->getMockBuilder(\Magento\Framework\View\Element\Template\Context::class)
            ->setMethods(['getEscaper', 'getUrlBuilder', 'getValidator', 'getResolver', 'getScopeConfig'])
            ->disableOriginalConstructor()
            ->getMock();

        $contextMock->expects($this->any())
            ->method('getValidator')
            ->will($this->returnValue($validtorMock));

        $contextMock->expects($this->any())
            ->method('getResolver')
            ->will($this->returnValue($resolverMock));

        $contextMock->expects($this->any())
            ->method('getEscaper')
            ->will($this->returnValue($escaperMock));

        $contextMock->expects($this->any())
            ->method('getUrlBuilder')
            ->will($this->returnValue($urlBuilderMock));

        $contextMock->expects($this->any())
            ->method('getScopeConfig')
            ->will($this->returnValue($scopeConfigMock));

        /** @var \Magento\Framework\View\Element\Html\Link $linkWithAttributes */
        $linkWithAttributes = $objectManagerHelper->getObject(
            \Magento\Framework\View\Element\Html\Link::class,
            ['context' => $contextMock]
        );
        /** @var \Magento\Framework\View\Element\Html\Link $linkWithoutAttributes */
        $linkWithoutAttributes = $objectManagerHelper->getObject(
            \Magento\Framework\View\Element\Html\Link::class,
            ['context' => $contextMock]
        );

        foreach ($this->allowedAttributes as $attribute) {
            $linkWithAttributes->setDataUsingMethod($attribute, $attribute);
        }

        $expectedFull  = 'href="http://site.com/link.html" shape="shape" ';
        $expectedFull .= 'tabindex="tabindex" onfocus="onfocus" onblur="onblur" id="id"';

        return [
            'full' => [
                'link' => $linkWithAttributes,
                'expected' => $expectedFull,
            ],
            'empty' => [
                'link' => $linkWithoutAttributes,
                'expected' => 'href="http://site.com/link.html"',
            ],
        ];
    }
}
