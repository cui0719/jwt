<?php
namespace App;

use Tymon\JWTAuth\JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;

class Jwt extends JWTAuth
{
    public function parseToken($tokenn = "")
    {
        if (! $token = $this->parser->parseToken()) {
            if(!$tokenn){
                throw new JWTException('token已过期，未刷新token');
            }else{
                $token = $tokenn;
            }
//            throw new JWTException('token解析错误');
        }

        return $this->setToken($token);
    }

    public function __call($method, $parameters)
    {
        if (method_exists($this->manager, $method)) {
            return call_user_func_array([$this->manager, $method], $parameters);
        }
        echo '错误';
        die;
        throw new BadMethodCallException("Method [$method] does not exist.");
    }
}