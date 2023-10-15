<?php
require_once("./models/ProductModel.php");
require_once("./functions.php");

class ProductController
{
    private $csvFile = './logs/output.csv';
    private $errorFile = './logs/errors.txt';
    private $summaryFile = './logs/summary.txt';

    private function writeError($text)
    {
        date_default_timezone_set('Asia/Kolkata');
        $currentDateTimeReadable = date('F j, Y, g:i a');
        // Example format: October 9, 2023, 3:45 pm

        $file = fopen($this->errorFile, 'a');
        fwrite($file, $text . ' This error log generated on ' . $currentDateTimeReadable . PHP_EOL . PHP_EOL);
        fclose($file);
    }

    private function validateRow($row, $currentRow)
    {
        $requiredFields = ['sku', 'name', 'category', 'price'];
        foreach ($requiredFields as $field) {
            if (checkField($row[$field])) {
                $this->writeError('Row Number: ' . $currentRow . ' can not be inserted because ' . $field . ' is missing.');
                return false;
            }
        }

        if (checkPrice($row['price'])) {
            $this->writeError('Row Number: ' . $currentRow . ' can not be inserted because price is less than equal to zero.');
            return false;
        }

        if (checkSkuLength($row['sku'])) {
            $this->writeError('Row Number: ' . $currentRow . ' can not be inserted because sku lenght must be between 8-10 characters.');
            return false;
        }

        if (!ctype_alnum($row['sku'])) {
            $this->writeError('Row Number: ' . $currentRow . ' can not be inserted because sku should be alpha numeric.');
            return false;
        }

        return true;
    }

    public function createCSV($productObject)
    {
        try {
            $products = $productObject->getAllProducts();

            $file = fopen($this->csvFile, 'w');
            if (!$file) {
                throw new Exception('Error in file handling ' . $this->csvFile);
            }

            fputcsv($file, array_keys($products[0]));

            foreach ($products as $product) {
                fputcsv($file, $product);
            }

            fclose($file);
        } catch (Exception $e) {
            echo "There is a Exception: " . $e;
        }
    }

    public function loadCSV($productObject)
    {
        try {
            $file = fopen($this->csvFile, 'r');
            if (!$file) {
                throw new Exception('Error in file handling ' . $this->csvFile);
            }

            $data = [];
            $keys = fgetcsv($file);
            while (($row = fgetcsv($file)) !== false) {
                $assocRow = array_combine($keys, $row);
                $data[] = $assocRow;
            }
            $numberOfRowInserted = 0;
            $numberOfRowFailed = 0;
            $currentRow = 1;

            foreach ($data as $row) {
                $isValid = $this->validateRow($row, $currentRow);
                if ($isValid) {
                    $isRowPresent = $productObject->get($row['sku']);
                    if ($isRowPresent) {
                        $currentRow++;
                        continue;
                    }

                    $category = $productObject->getCategoryByName($row['categoryName']);

                    if ($category) {
                        $productObject->setAll($row);
                        $productObject->create();
                    } else {
                        $productObject->setCategoryName($row['categoryName']);
                        $productObject->setCategoryDescription('Default Description');
                        $categoryId = $productObject->createCategory();
                        $row['category'] = $categoryId;
                        $productObject->setAll($row);
                        $productObject->create();
                    }

                    $numberOfRowInserted++;
                } else {
                    $numberOfRowFailed++;
                }

                $currentRow++;
            }

            $file = fopen($this->summaryFile, 'w');
            if (!$file) {
                throw new Exception('Error in file handling ' . $this->csvFile);
            }
            fwrite($file, 'Number of Row Processed: ' . $currentRow - 1 . PHP_EOL . 'Number of Row Inserted: ' . $numberOfRowInserted . PHP_EOL . 'Number of Row Failed: ' . $numberOfRowFailed);
            fclose($file);
        } catch (Exception $e) {
        }
    }

    public function index()
    {
        $product = new ProductModel();
        // $product->setAll(['sku' => 'SKU4', 'name' => 'Prod 4', 'description' => 'Desc of prod2', 'category' => '1', 'brand' => 'samsung', 'price' => '292', 'image' => 'http', 'weight' => '23', 'dimensions' => '7x8x8']);
        // $product->setCategoryName('New category');
        // $product->setCategoryDescription('It is created');
        // $product->createCategory(1);

        // $this->createCSV($product);
        $this->loadCSV($product);

        include "./views/home/index.php";
    }
}
