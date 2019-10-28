<?php
include_once 'MainController.php';


class ProductController extends MainController
{
    public static function includeProduct()
    {
      include_once dirname(__DIR__)."/classes/Product.php";
    }
    public static function create(array $data)
    {
        self::includeProduct();

        try{

            $pro = new Product();
            $pro->setName($data['name']);
            $pro->setDescription($data['description']);
            $pro->setPrice($data['price']);
            $pro->setCategoryId($data['category_id']);
            $pro->setCreated("2018-06-01 01:12:26");
            $pro->setModified("2018-06-01 01:12:26");

            if(!$pro->hasName())
                return ['status'=>'error','message'=>'Name is required','code'=>400];
            if(!$pro->hasDescription())
                return ['status'=>'error','message'=>'Descripcion is required','code'=>400];
            if(!$pro->hasPrice())
                return ['status'=>'error','message'=>'Price is required','code'=>400];
            if(!$pro->hasCategoryId())
                return ['status'=>'error','message'=>'CategoryId is required','code'=>400];

            /*if(!$pro->save())
                return $pro->getErrors();*/
            if($pro->save())
                return ['status'=>'ok','message'=>'Saved Product','code'=>200];

        }
        catch (Exception $exception)
        {
            return ['status'=>'ok','message'=>'Exception throwed:'.$exception->getMessage() ,'code'=>500];
        }
    }
}