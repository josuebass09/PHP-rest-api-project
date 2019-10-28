<?php


class Response
{
    private $http_code;
    private $message;
    private $status;
    private $data;

    /**
     * @return mixed
     */
    public function getHttpCode()
    {
        return http_response_code();
    }

    /**
     * @param mixed $http_code
     */
    public function setHttpCode(int $http_code): void
    {
        $this->http_code = http_response_code($http_code);
    }

    /**
     * @return mixed
     */
    public function getMessage()
    {
        return $this->message;
    }

    /**
     * @param mixed $message
     */
    public function setMessage($message): void
    {
        $this->message = $message;
    }

    /**
     * @return mixed
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * @param mixed $status
     */
    public function setStatus($status): void
    {
        $this->status = $status;
    }

    /**
     * @return mixed
     */
    public function getData()
    {
        return $this->data;
    }

    /**
     * @param mixed $data
     */
    public function setData($data): void
    {
        $this->data = $data;
    }
    public function prepare()
    {
        return ['status'=>$this->status,'message'=>$this->message,'data'=>$this->data,'code'=>$this->getHttpCode()];
    }


    public function asJson($data)
    {
        print json_encode($data);

    }
    public function asHtml($data)
    {
        $keys = array_keys($data);
        $html ="<!DOCTYPE html>
                <html>
	                <head>
		            <meta charset='UTF-8'>
                    </head>
		                <body>
			                <table border=1>";
        $html.="<thead>
        <tr>";
        foreach ($keys as $k)
        {
            $html.="<th>".$k."</th>";
        }
        $html.="</tr>
				</thead>
				<tbody>";
        $html.="<tr> 
                        <td>".$data['status']."</td>
                        <td>".$data['message']."</td>
                        <td>".$data['data']."</td>
                        <td>".$data['code']."</td>
                    </tr>";

        $html.="</tbody>
			</table>
		</body>
	</html>";
        print $html;
    }
    public function asXml($data)
    {
        $xml = new SimpleXMLElement('<response/>');
        array_walk_recursive(array_flip($data),array($xml,'addChild'));
        print $xml->asXML();
    }
    public function asText($data)
    {
        print "|status|message|data|code|".PHP_EOL."|".$data['status']."|".$data['message']."|".$data['data']."|".$data['code']."|";
    }
}