<?php
include 'DB.php';

class Product
{
    private $name;
    private $description;
    private $price;
    private $category_id;
    private $created;
    private $modified;
    private $db;
    private $errors;

    /*public function __construct($name, $description, $price, $category_id,$created, $modified)
    {

        $this->name = $name;
        $this->description = $description;
        $this->price = $price;
        $this->category_id = $category_id;
        $this->created = $created;
        $this->modified = $modified;
        $this->db = DB::getConnection();
        $this->errors=array();
    }*/
    public function __construct()
    {
        $this->db = DB::getConnection();
        $this->errors = array();
    }

    public function save()
    {
        if($this->db instanceof PDOException) {
            $this->errors = ['module' => 'DB', 'method' => 'getConnection', 'message' => $this->db->getMessage(), 'file' => $this->db->getFile(), 'line' => $this->db->getLine()];
            return false;
        }
        try{
            $query = "INSERT INTO products(name,description,price,category_id,created,modified) VALUES (:name,:description,:price,:category_id,:created,:modified)";
            $statement = $this->db->prepare($query);
            $statement->execute(['name'=>$this->name,'description'=>$this->description,'price'=>$this->price,'category_id'=>$this->category_id,'created'=>$this->created,'modified'=>$this->modified]);
            return true;
        }
        catch (PDOException $exception)
        {
            $this->errors = ['module'=>'products','method'=>'save','message'=>$exception->getMessage(),'file'=>$exception->getFile(),'line'=>$exception->getLine()];
            return false;
        }
    }

    /**
     * @return bool
     */
    public function hasName()
    {
        if(isset($this->name) AND !empty($this->name))
            return true;
        return false;
    }

    /**
     * @return bool
     */
    public function hasDescription()
    {
        if(isset($this->description) AND !empty($this->description))
            return true;
        return false;
    }

    /**
     * @return bool
     */
    public function hasPrice()
    {
        if(isset($this->price) AND !empty($this->price))
            return true;
        return false;
    }

    /**
     * @return bool
     */
    public function hasCategoryId()
    {
        if(isset($this->category_id) AND !empty($this->category_id))
            return true;
        return false;
    }

    /**
     * @return array
     */
    public function getErrors()
    {
        return $this->errors;
    }

    /**
     * @return mixed
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @return mixed
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * @return mixed
     */
    public function getPrice()
    {
        return $this->price;
    }

    /**
     * @return mixed
     */
    public function getCategoryId()
    {
        return $this->category_id;
    }

    /**
     * @return mixed
     */
    public function getCreated()
    {
        return $this->created;
    }

    /**
     * @return mixed
     */
    public function getModified()
    {
        return $this->modified;
    }

    /**
     * @param mixed $name
     */
    public function setName($name): void
    {
        $this->name = $name;
    }

    /**
     * @param mixed $description
     */
    public function setDescription($description): void
    {
        $this->description = $description;
    }

    /**
     * @param mixed $price
     */
    public function setPrice($price): void
    {
        $this->price = $price;
    }

    /**
     * @param mixed $category_id
     */
    public function setCategoryId($category_id): void
    {
        $this->category_id = $category_id;
    }

    /**
     * @param mixed $created
     */
    public function setCreated($created): void
    {
        $this->created = $created;
    }

    /**
     * @param mixed $modified
     */
    public function setModified($modified): void
    {
        $this->modified = $modified;
    }

    /**
     * @param array $errors
     */
    public function setErrors(array $errors): void
    {
        $this->errors = $errors;
    }



}