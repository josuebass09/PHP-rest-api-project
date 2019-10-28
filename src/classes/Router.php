<?php

class Router
{
    public static function redirect(Request $request)
    {
        include_once 'route/Routes.php';
        include_once 'src/classes/Response.php';
        $response = new Response();
        if(!self::routeExists($routes,$request->getModule()))
        {
            $response->setStatus("error");
            $response->setMessage("Url not found");
            $response->setHttpCode(404);
            $response->setData("");
            $response->asJson($response->prepare());exit;
        }

        if(!self::methodAllowed($routes,$request->getModule(),$request->getMethod()))
        {
            $response->setStatus("error");
            $response->setMessage("Method not allowed");
            $response->setHttpCode(405);
            $response->setData("");
            $response->asJson($response->prepare());exit;
        }
        switch ($request->getModule())
        {
            case '/':
                //$request->setStatus(204);
                $response->setStatus("ok");
                $response->setMessage("Nothing to show");
                $response->setHttpCode(204);
                $response->setData("");
                $response->asJson($response->prepare());exit;
                break;
            /*case '/about':
                $response->setStatus("ok");
                $response->setMessage("Success Request");
                $response->setHttpCode(200);
                $response->setData(['made by'=>'Josué Hidalgo Ramírez','linkedin'=>'https://www.linkedin.com/in/josuebass09','email'=>'josuebass09@gmail.com']);
                $response->asJson($response->prepare());exit;
                //Response::asJson(['status'=>'ok','message'=>'Success request','data'=>['made by'=>'Josué Hidalgo Ramírez','linkedin'=>'https://www.linkedin.com/in/josuebass09','email'=>'josuebass09@gmail.com'],'code'=>200]);
                break;*/
            case '/product':
                $class = $routes['home']['options']['controller'];
                $db_response = $class::create($request->getParams());

                $response->setStatus($db_response['status']);
                $response->setMessage($db_response['message']);
                $response->setHttpCode($db_response['code']);
                $response->setData("");
                $response->asJson($response->prepare());exit;
                break;
        }

    }
    private static function render($path)
    {
        $fileName = str_replace('/','',strrchr(parse_url($path, PHP_URL_PATH),'/'));
        $location = self::getViewLocation($path);
        /*$files = self::getViewFolderFiles($location);
        $fullName = self::findFileName($files,$fileName);*/


        //print_r(exec($location));
        //print_r(self::findViewExtension(dirname($location)));

        $endpoint = $location.$fileName.".php";

        try{
            include_once $endpoint;
        }
        catch (Exception $exception)
        {
            return $exception;
        }
    }
    private static function get404View($rootPath)
    {
        return dirname($rootPath)."/views/404";
    }
    private static function loadViewPath($rootPath,$view)
    {
        if($view==='/')
        {
            return $rootPath."views/home.php";
        }
        return dirname($rootPath)."/views".$view;
    }
    private static function findFileName($files,$needed)
    {


    }
    private static function getViewLocation($path)
    {
        try
        {
            return dirname(__DIR__)."/views/";
        }
        catch (Exception $exception)
        {
            return $exception;
        }
    }

    private static function getViewFolderFiles($path)
    {
        try{
            return array_diff(scandir($path), array('.', '..'));
        }
        catch (Exception $exception)
        {
            return $exception;
        }
    }

    private static function routeExists($routes,$endpoint)
    {
        foreach ($routes as $route)
        {
            if($route['options']['route'] === $endpoint)
                return true;

        }
        return false;
    }

    private static function methodAllowed($routes,$endpoint,$method)
    {
        foreach ($routes as $route)
        {
            if($route['options']['route'] === $endpoint AND $route['options']['type'] === $method)
                return true;
        }
        return false;
    }


}