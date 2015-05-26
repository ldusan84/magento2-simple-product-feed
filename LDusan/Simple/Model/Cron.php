<?php
namespace LDusan\Simple\Model;

use Magento\Catalog\Api\ProductRepositoryInterface;
use Magento\Framework\Api\SearchCriteriaBuilder;
use Magento\Framework\Api\FilterBuilder;
use Magento\ImportExport\Model\Export\Adapter\Csv;


class Cron
{
    protected $productRepository;
    protected $searchCriteriaBuilder;
    protected $filterBuilder;
    protected $csv;

    public function __construct(
        ProductRepositoryInterface $productRepository,
        SearchCriteriaBuilder $searchCriteriaBuilder,
        FilterBuilder $filterBuilder,
        Csv $csv
    ) {
        $this->productRepository = $productRepository;
        $this->searchCriteriaBuilder = $searchCriteriaBuilder;
        $this->filterBuilder = $filterBuilder;
        $this->csv = $csv;
    }


    public function export()
    {
        $items = $this->getProducts();    
        $this->writeToFile($items);
    }

    public function getProducts()
    {
        $filters = [];
        $now = new \DateTime();
        $interval = new \DateInterval('P1W');
        $lastWeek = $now->sub($interval);
        
        $filters[] = $this->filterBuilder
            ->setField('created_at')
            ->setConditionType('gt')
            ->setValue($lastWeek->format('Y-m-d H:i:s'))
            ->create();
        
        $this->searchCriteriaBuilder->addFilter($filters);
        
        $searchCriteria = $this->searchCriteriaBuilder->create();
        $searchResults = $this->productRepository->getList($searchCriteria);
        return $searchResults->getItems();
    }

    protected function writeToFile($items)
    {
        if (count($items) > 0) {
            $this->csv->setHeaderCols(['id', 'created_at', 'sku']);
            foreach ($items as $item) {
                $this->csv->writeRow(['id'=>$item->getId(), 'created_at' => $item->getCreatedAt(), 'sku' => $item->getSku()]);
            }    
        }
    }
}
