<?php
require_once("./Database.php");

class ProductModel
{
    private $name;
    private $sku;
    private $description;
    private $category;
    private $brand;
    private $price;
    private $image;
    private $weight;
    private $dimensions;

    private $categoryId;
    private $categoryName;
    private $categoryDescription;

    private $database;

    public function __construct()
    {
        $this->database = (new Database())->getConnection();
    }

    // Getters
    public function getName()
    {
        return $this->name;
    }

    public function getSku()
    {
        return $this->sku;
    }

    public function getDescription()
    {
        return $this->description;
    }

    public function getCategory()
    {
        return $this->category;
    }

    public function getCategoryName()
    {
        return $this->categoryName;
    }

    public function getCategoryDescription()
    {
        return $this->categoryDescription;
    }

    public function getCategoryId()
    {
        return $this->categoryId;
    }

    public function getBrand()
    {
        return $this->brand;
    }

    public function getPrice()
    {
        return $this->price;
    }

    public function getImage()
    {
        return $this->image;
    }

    public function getWeight()
    {
        return $this->weight;
    }

    public function getDimensions()
    {
        return $this->dimensions;
    }

    public function getAll()
    {
        return [
            'name' => $this->name,
            'sku' => $this->sku,
            'description' => $this->description,
            'category' => $this->category,
            'brand' => $this->brand,
            'price' => $this->price,
            'image' => $this->image,
            'weight' => $this->weight,
            'dimensions' => $this->dimensions,
            'categoryId' => $this->categoryId,
            'categoryName' => $this->categoryName,
            'categoryDescription' => $this->categoryDescription,
        ];;
    }

    // Setters
    public function setName($name)
    {
        $this->name = $name;
    }

    public function setSku($sku)
    {
        $this->sku = $sku;
    }

    public function setDescription($description)
    {
        $this->description = $description;
    }

    public function setCategory($category)
    {
        $this->category = $category;
    }

    public function setCategoryId($categoryId)
    {
        $this->category = $categoryId;
    }

    public function setCategoryName($categoryName)
    {
        $this->categoryName = $categoryName;
    }

    public function setCategoryDescription($categoryDescription)
    {
        $this->categoryDescription = $categoryDescription;
    }

    public function setBrand($brand)
    {
        $this->brand = $brand;
    }

    public function setPrice($price)
    {
        $this->price = $price;
    }

    public function setImage($image)
    {
        $this->image = $image;
    }

    public function setWeight($weight)
    {
        $this->weight = $weight;
    }

    public function setDimensions($dimensions)
    {
        $this->dimensions = $dimensions;
    }

    public function setAll($product)
    {
        $this->sku = $product['sku'];
        $this->name = $product['name'];
        $this->description = $product['description'];
        $this->category = $product['category'];
        $this->brand = $product['brand'];
        $this->price = $product['price'];
        $this->image = $product['image'];
        $this->weight = $product['weight'];
        $this->dimensions = $product['dimensions'];

        if (isset($product['categoryName'])) {
            $this->categoryName = $product['categoryName'];
        }
        if (isset($product['categoryDescription'])) {
            $this->categoryDescription = $product['categoryDescription'];
        }
    }

    public function createCategory()
    {
        try {
            $query = "INSERT INTO categories (categoryName, categoryDescription) VALUES (:categoryName, :categoryDescription)";
            $stmt = $this->database->prepare($query);

            $stmt->bindParam(':categoryName', $this->categoryName);
            $stmt->bindParam(':categoryDescription', $this->categoryDescription);

            $stmt->execute();
            $categoryId = $this->database->lastInsertId();
            return $categoryId;
        } catch (PDOException $e) {
            echo "Create Category Error: " . $e->getMessage();
            return false;
        }
    }

    public function getCategoryByName($categoryName)
    {
        try {
            $query = "SELECT * FROM categories WHERE categoryName = :categoryName";
            $stmt = $this->database->prepare($query);
            $stmt->bindParam(':categoryName', $categoryName);
            $stmt->execute();

            $category = $stmt->fetch(PDO::FETCH_ASSOC);
            return $category ? $category : null;
        } catch (PDOException $e) {
            echo "Get Category By Id Error: " . $e;
            return null;
        }
    }


    public function create()
    {
        try {
            $query = "INSERT INTO products (sku,name, description, category, brand, price, image, weight, dimensions) 
                    VALUES (:sku, :name, :description, :category, :brand, :price, :image, :weight, :dimensions)";

            $stmt = $this->database->prepare($query);
            $stmt->bindParam(':sku', $this->sku);
            $stmt->bindParam(':name', $this->name);
            $stmt->bindParam(':description', $this->description);
            $stmt->bindParam(':category', $this->category);
            $stmt->bindParam(':brand', $this->brand);
            $stmt->bindParam(':price', $this->price);
            $stmt->bindParam(':image', $this->image);
            $stmt->bindParam(':weight', $this->weight);
            $stmt->bindParam(':dimensions', $this->dimensions);

            $stmt->execute();
            return true;
        } catch (PDOException $e) {
            echo "Create Product Error: " . $e;
            return false;
        }
    }

    public function get($sku)
    {
        try {
            $query = "SELECT products.*, categories.* FROM products LEFT JOIN categories ON products.category = categories.id WHERE sku=:sku";
            $stmt = $this->database->prepare($query);
            $stmt->bindParam(':sku', $sku);
            $stmt->execute();
            $product = $stmt->fetch(PDO::FETCH_ASSOC);
            return $product;
        } catch (PDOException $e) {
            echo "Get Product Error: " . $e;
            return null;
        }
    }

    public function getAllProducts()
    {
        try {
            $query = "SELECT products.*, categories.* FROM products LEFT JOIN categories ON products.category = categories.id";
            $stmt = $this->database->prepare($query);
            $stmt->execute();
            $products = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return $products;
        } catch (PDOException $e) {
            echo "Get Products Error: " . $e;
            return null;
        }
    }

    public function delete($sku)
    {
        try {
            $query = "DELETE FROM products WHERE sku = :sku";
            $stmt = $this->database->prepare($query);
            $stmt->bindParam(':sku', $sku);
            $stmt->execute();
            return true;
        } catch (PDOException $e) {
            echo "Delete Product Error: " . $e;
            return false;
        }
    }

    public function update($sku, $updateArray)
    {
        try {
            $setValues = "";
            $params = [];
            foreach ($updateArray as $key => $value) {
                $setValues .= "$key=:$key, ";
                $params[":$key"] = $value;
            }
            $setValues = rtrim($setValues, ", ");

            $query = "UPDATE products SET $setValues WHERE sku = :sku";
            $params[':sku'] = $sku;
            $stmt = $this->database->prepare($query);
            $stmt->execute($params);
            return true;
        } catch (PDOException $e) {
            echo "Update Product Error: " . $e;
            return false;
        }
    }

    public function list($searchCriteria, $value, $start, $offset)
    {
        try {
            $limit = $offset -  $start;
            $searchValue = "%$value%";
            $query = "SELECT * FROM products WHERE $searchCriteria LIKE :value LIMIT :limit";
            $stmt = $this->database->prepare($query);
            $stmt->bindParam(':value', $searchValue, PDO::PARAM_STR);
            $stmt->bindParam(':limit', $limit, PDO::PARAM_INT);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            echo "List Error: " . $e;
            return NULL;
        }
    }
}
