<?php
/**
 * BridgeRest
 *
 * @name BridgeRest
 * @author Romain Lienard <me@rlienard.fr>
 * @http: rlienard.fr
 * @copyright (c)2012 rlienard (Romain Lienard)
 * @version 0.0.3
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


class bridgeRest{

    /**
     * @param $url
     * @param $data
     * @param string $referer
     * @param string $method
     * @param int $port
     * @return array
     */
    public function httpRequest($url, $data, $referer = '', $method = 'GET', $port = 80) {

        // parse the given URL
        $url = parse_url($url);

        if ($url['scheme'] != 'http' && $url['scheme'] != 'https') {
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
        header('Content-type: application/json');
        header('Expires: Mon, 26 Jul 1997 05:00:00 GMT');
        header('Last-Modified: ' . gmdate('D, d M Y H:i:s') . ' GMT');
        header('Cache-Control: no-store, no-cache, must-revalidate');
        header('Cache-Control: post-check=0, pre-check=0', false);
        header('Pragma: no-cache');
        $test = $this->httpRequest($path,$data);
        echo $test['content'];
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
    }
}