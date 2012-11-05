<?php
/**
 * ServerCore
 *
 * @name ServerCore
 * @author Romain Lienard <romain.lienard@goto-games.com>
 * @http: goto-games.com
 * @copyright (c)2012 GOTO Games (Romain Lienard)
 * @version 0.0.1
 * @package ***
 * @date: 05/10/12
 * @time: 13:27
 *
 *	Permission is hereby granted, free of charge, to any person obtaining a copy of this
 *	software and associated documentation files (the "Software"), to deal in the Software
 *	without restriction, including without limitation the rights to use, copy, modify, merge,
 *	publish, distribute, sublicense, and/or sell copies of the Software, and to permit persons
 *	to whom the Software is furnished to do so, subject to the following conditions:
 *
 * 	The above copyright notice and this permission notice shall be included in all copies
 *	or substantial portions of the Software.
 *
 *	THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR IMPLIED, INCLUDING
 *	BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY, FITNESS FOR A PARTICULAR PURPOSE AND
 *	NONINFRINGEMENT. IN NO EVENT SHALL THE AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM,
 *	DAMAGES OR OTHER LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
 * 	OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE SOFTWARE.
 **/


class ServerCore{

    /**
     * @var string
     */
    private $uriMotor = HOST;
    /**
     * @var array
     */
    private $roots = array(
        "Done"=>"Done_Handler",
        "Start"=>"Start_Handler"
    );

    /**
     * @param $url
     * @param $data
     * @param string $referer
     * @param string $method
     * @param int $port
     * @return array
     */
    private function httpRequest($url, $data, $referer = '', $method = 'POST', $port = 80) {

        // parse the given URL
        $url = parse_url($url);

        if ($url['scheme'] != 'http') {
            die('Error: Only HTTP request are supported !');
        }

        // extract host and path:
        $host = $url['host'];
        $path = $url['path'];

        // open a socket connection on port 80 - timeout: 30 sec
        $fp = fsockopen($host, $port, $errno, $errstr, 30);

        if ($fp){

            if ($method == "GET"){
                $data = http_build_query($data);
                $path.= "?" . $data;
            }

            // send the request headers:
            fputs($fp, "$method $path HTTP/1.1\r\n");
            fputs($fp, "Host: $host\r\n");


            if ($referer != '')
                fputs($fp, "Referer: $referer\r\n");

            fputs($fp, "Content-type: application/x-www-form-urlencoded\r\n");
            if ($method == "POST")
                fputs($fp, "Content-length: ". strlen($data) ."\r\n");
            fputs($fp, "Connection: close\r\n\r\n");
            if ($method == "POST")
                fputs($fp, $data);

            $result = '';
            while(!feof($fp)) {
                $result .= fgets($fp, 128);
            }
        }
        else {
            return array(
                'status' => 'err',
                'error' => "$errstr ($errno)"
            );
        }

        // close the socket connection:
        fclose($fp);

        // split the result header from the content
        $result = explode("\r\n\r\n", $result, 2);

        $header = isset($result[0]) ? $result[0] : '';
        $content = isset($result[1]) ? $result[1] : '';

        // return as structured array:
        return array(
            'status' => 'ok',
            'header' => $header,
            'content' => $content
        );
    }

    /**
     * @param string $path
     * @param array $data
     */
    public function motor($path = '/',$data = array()){
        $test = $this->httpRequest($this->uriMotor.$path,$data);
        echo $test['content'];
    }

    /**
     * @return bool|string
     */
    private function server(){

        $handler = null;
        $handler_inst = null;
        $dataGetted = array();

        $path = "/";
        $path = isset($_SERVER['PATH_INFO']) ? $_SERVER['PATH_INFO'] : $path;
        $path = isset($_SERVER['ORIG_PATH_INFO']) ? $_SERVER['ORIG_PATH_INFO'] : $path;

        $path = explode('/',$path);
        $lbl_handler = $path[1];
        $request_method = (isset($path[2]))?$path[2]:'get';

        if (isset($this->roots[$lbl_handler])) {
            $handler = $this->roots[$lbl_handler];
        }else {
            return('404');
        }

        if($path>2){
            for($i=3,$l=sizeof($path);$i<$l;$i++){
                $arr = explode('=',$path[$i]);
                $dataGetted[$arr[0]] = $arr[1];
            }
        }

        if($handler && class_exists($handler)){
            $handler_inst = new $handler();
            if(method_exists($handler_inst, $request_method )){
                header('Content-type: application/json');
                header('Expires: Mon, 26 Jul 1997 05:00:00 GMT');
                header('Last-Modified: ' . gmdate('D, d M Y H:i:s') . ' GMT');
                header('Cache-Control: no-store, no-cache, must-revalidate');
                header('Cache-Control: post-check=0, pre-check=0', false);
                header('Pragma: no-cache');
                echo $handler_inst->{$request_method}($dataGetted,$this);
            }else {
                return('404');
            }
        }else {
            return('404');
        }

        return true;

    }

    /**
     * @return bool
     */
    private function xhr_request()
    {
        return isset($_SERVER['HTTP_X_REQUESTED_WITH']) && $_SERVER['HTTP_X_REQUESTED_WITH'] === 'XMLHttpRequest';
    }

    /**
     *
     */
    public function __construct(){
        if($this->xhr_request()){
            $this->server();
        }
    }
}