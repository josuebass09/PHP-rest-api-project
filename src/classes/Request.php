<?php


class Request
{
    /**
     * @var
     */
    private $url;
    private $method;
    private $status;
    private $params;
    private $format;
    private $header;
    private $host;
    private $response;
    private $module;

    /**
     * Request constructor.
     *
     */
    public function __construct()
    {
        $this->url = $this->getUrl();
        $this->method = $_SERVER['REQUEST_METHOD'];
        if($this->hasHeader()){
            $this->header = getallheaders();
        }
        $this->format = $this->readFormat();
        $this->host = $_SERVER['HTTP_HOST'];
        if($this->format==='JSON')
        {
            $this->params = $this->getJsonBody();
        }
        elseif($this->format==="XML")
        {
            $this->params = $this->getXmlBody();
        }
        else{
            $this->params = $this->getHttpParams();
        }
        $this->module = $this->extractModule();
        $this->status =0;
        $this->response = null;

    }

    /**
     * @return array
     */
    public function getParams():array
    {
        return $this->params;
    }

    /**
     * @return string
     */
    public function getMethod():string
    {
        return $this->method;
    }

    /**
     * @return mixed
     */
    public function getUrl()
    {
        if(isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on')
            $link = "https";
        else
            $link = "http";

        $link .= "://";
        $link .= $_SERVER['HTTP_HOST'];
        $link .= $_SERVER['REQUEST_URI'];
        return $link;
    }

    private function hasHeader()
    {
        if(!empty(getallheaders()))
        {
            return true;
        }
        return false;
    }

    /**
     * @return string
     */
    private function readFormat()
    {
        if(isset($this->header['Content-Type']))
        {
            switch ($this->header['Content-Type'])
            {
                case 'application/json';
                    return "JSON";

                case 'application/xml';
                    return "XML";
            }
        }
        return "HTTP";
    }
    private function getJsonBody()
    {
        $inputJSON = file_get_contents('php://input');
        if(!empty($inputJSON))
        {
            return json_decode($inputJSON, TRUE);
        }
        return null;
    }
    private function getXmlBody()
    {

    }
    private function getHttpParams()
    {
        return $_REQUEST;
    }

    /**
     * @return int
     */
    public function getStatus(): int
    {
        return http_response_code();
    }

    /**
     * @param int $status
     */
    public function setStatus(int $status): void
    {

        $this->status = http_response_code($status);
    }

    public function readResponse($status,$message)
    {
        return ['status'=>$status,'message'=>$message,'data'=>'','code'=>$this->getStatus()];
    }
    private function extractModule()
    {

        $urlArray = explode("/",$this->url);
        for ($i=0;$i<sizeof($urlArray);$i++)
        {
            if($urlArray[$i] != strrchr(parse_url(__DIR__, PHP_URL_PATH),'/'))
            {
                unset($urlArray[$i]);
            }

        }

        $generatedEndpoint = implode("/",$urlArray);
        return substr($generatedEndpoint,strpos($generatedEndpoint,'/'));


        //return strrchr(parse_url($this->url, PHP_URL_PATH),'/');
    }
    private function reverse_strrchr($haystack, $needle, $trail) {
        return strrpos($haystack, $needle) ? substr($haystack, 0, strrpos($haystack, $needle) + $trail) : false;
    }

    /**
     * @return false|string
     */
    public function getModule()
    {
        return $this->module;
    }
}