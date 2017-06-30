<?php

class Session_Redis_Handler
{
    public function __construct( $host, $port, $password, $timeout, $session_prefix, $session_timeout ) {
        $this->_redis = new Redis();
        $this->_host = $host;
        $this->_port = $port;
        $this->_password = $password;
        $this->_timeout = $timeout;
        $this->_session_prefix = $session_prefix;
        $this->_session_timeout = $session_timeout;
        return true;
    }

    public function open( $savePath, $sessionName ) {
        try {
            $this->_redis->connect( $this->_host, $this->_port, $this->_timeout );
            $this->_redis->setOption( Redis::OPT_PREFIX, $this->_session_prefix );
            $this->_redis->auth( $this->_password );
        } catch ( RedisException $e ) {
            // var_dump( $e );
        }
        return true;
    }

    public function close() {
        return true;
    }

    public function read( $id ){
        return $this->_redis->get( $id );
    }

    public function write( $id, $data ){
        $this->_redis->setex( $id, $this->_session_timeout, $data );
        return true;
    }

    public function destroy( $id ){
        $this->_redis->delete( $id );
        return true;
    }

    public function gc( $maxlifetime ) {
        return true;
    }
}
