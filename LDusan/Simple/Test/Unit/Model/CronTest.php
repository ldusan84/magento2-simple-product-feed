<?php
/**
 * Copyright © 2015 Magento. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace LDusan\Simple\Test\Unit\Model;

class CronTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var \LDusan\Simple\Model\Cron
     */
    protected $model;

    /**
     * @var \PHPUnit_Framework_MockObject_MockObject
     */
    protected $categoryRepositoryMock;

    /**
     * @var \PHPUnit_Framework_MockObject_MockObject
     */
    protected $categoryTreeMock;

    protected function setUp()
    {
        $this->productRepositoryMock = $this->getMock('\Magento\Catalog\Api\ProductRepositoryInterface');
        $this->searchCriteriaBuilderMock = $this->getMock('\Magento\Framework\Api\SearchCriteriaBuilder', [], [], '', false);
        $this->filterBuilderMock = $this->getMock('\Magento\Framework\Api\FilterBuilder', [], [], '', false);
        $this->csvMock = $this->getMock('\Magento\ImportExport\Model\Export\Adapter\Csv', [], [], '', false);

        $this->model = new \LDusan\Simple\Model\Cron(
            $this->productRepositoryMock,
            $this->searchCriteriaBuilderMock,
            $this->filterBuilderMock,
            $this->csvMock
        );
    }

    public function testOne()
    {
        $this->assertEquals(1, 1);
    }
}
