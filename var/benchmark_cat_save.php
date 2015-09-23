<?php
/**
 * Measures category save performance
 *
 * @category  Smile
 * @package   Smile_OneTimeScript
 * @author    Volodymyr Fesko <volodymyr.fesko@smile.fr>
 * @copyright 2013 Smile
 */
error_reporting(E_ALL | E_STRICT);
ini_set('display_errors', 'On');

require_once('script_base.php');

Mage::app('admin');

$categoryIds = array(
    10, // Furniture
    22, // Living Room
    23, // Bedroom
    13, // Electronics
    12, // Cameras
    15, // Computers
);

$attributesToSelect = array(
    'name',
    'is_anchor',
);

$timesToBenchmark = 10;

$categoryCollection = Mage::getModel('catalog/category')
    ->getCollection()
    ->addAttributeToSelect($attributesToSelect)
    //->addAttributeToFilter('entity_id', $categoryIds)
    ;

echo "Loading category collection...\n";
$categoryCollection->load();

echo "Starting benchmark (times is {$timesToBenchmark})...\n";

$csvHeadrs = array(
    'category_id',
    'name',
    'level',
    'product_count',
    'children_count',
    'bench_min_secs',
    'bench_max_secs',
    'bench_avg_secs',
);
$csvFileHandle = fopen('bench_ee110_cat_save.csv', 'w+');
fputcsv($csvFileHandle, $csvHeadrs);

/** @var $category Mage_Catalog_Model_Category */
foreach ($categoryCollection as $category) {
    $benchmarkTimes = getBenchmarkTimesSecs(
        function($c){
            echo '.';
            $c->setName($c->getName().'.');
            echo $c->save();
        },
        array($category),
        $timesToBenchmark
    );
    echo "\n";

    $csvRow = array(
        'category_id' => $category->getId(),
        'name' => $category->getName(),
        'level' => $category->getLevel(),
        'product_count' => $category->getProductCount(),
        'children_count' => $category->getChildrenCount(),
        'bench_min_secs' => $benchmarkTimes['min'],
        'bench_max_secs' => $benchmarkTimes['max'],
        'bench_avg_secs' => $benchmarkTimes['avg'],
    );
    fputcsv($csvFileHandle, array_values($csvRow));

    echo "Benchmark value added:\n";
    foreach ($csvRow as $name => $value) {
        echo "{$name}: {$value}\n";
    }
    echo "\n";
}

echo "Benchmark finished.\n";

// ---

/**
 * Returns benchmark times in seconds: min, max and avg
 *
 * @param callable $benchmarkLambdaFunction Benchmark lambda function
 * @param array $benchmarkFunctionArgumentsArray Benchmark function arguments
 * @param int $timesToCallBenchmarkFunction How many times benchmark function should be cold
 *
 * @return array
 */
function getBenchmarkTimesSecs($benchmarkLambdaFunction, array $benchmarkFunctionArgumentsArray, $timesToCallBenchmarkFunction = 10)
{
    $singleBenchmarkTimes = array();
    foreach (range(1, $timesToCallBenchmarkFunction) as $n) {
        $singleBenchmarkTimes[] = call_user_func_array(
            'getSingleBenchmarkTimeSecs',
            array($benchmarkLambdaFunction, $benchmarkFunctionArgumentsArray)
        );
    }
    $benchmarkTimes = array();
    $benchmarkTimes['min'] = min($singleBenchmarkTimes);
    $benchmarkTimes['max'] = max($singleBenchmarkTimes);
    $benchmarkTimes['avg'] = array_sum($singleBenchmarkTimes) / count($singleBenchmarkTimes);
    return $benchmarkTimes;
}

/**
 * Returns single benchmark time in seconds
 *
 * @param string $benchmarkLambdaFunction Benchmark lambda function
 * @param array $benchmarkFunctionArgumentsArray Benchmark arguments array
 *
 * @return float
 */
function getSingleBenchmarkTimeSecs($benchmarkLambdaFunction, array $benchmarkFunctionArgumentsArray)
{
    $autoStartTimer = 1;
    $timer = new Timer($autoStartTimer);
    call_user_func_array($benchmarkLambdaFunction, $benchmarkFunctionArgumentsArray);
    return $timer->get();
}