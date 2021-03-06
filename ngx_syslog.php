<?php
/**
 * Created by PhpStorm.
 * User: zenus
 * Date: 15-11-21
 * Time: 下午7:44
 * @param $i
 * @return
 */

function facilities($i){

    static $facilities = array(
        "kern", "user", "mail", "daemon", "auth", "intern", "lpr", "news", "uucp",
        "clock", "authpriv", "ftp", "ntp", "audit", "alert", "cron", "local0",
        "local1", "local2", "local3", "local4", "local5", "local6", "local7",
    );
    return $facilities[$i];
}

/* note 'error/warn' like in nginx.conf, not 'err/warning' */
function severities($i){
    static $severities = array(
        "emerg", "alert", "crit", "error", "warn", "notice", "info", "debug");
    return $severities[$i];
}

class ngx_syslog_peer_t {
    /**ngx_uint_t  **/   private   $facility;
    /**ngx_uint_t  **/  private    $severity;
    /**ngx_str_t  **/   private    $tag;

    /**ngx_addr_t **/    private   $server;
    /**ngx_connection_t **/  private $conn;
    /**unsigned  **/     private   $busy;
    /**unsigned  **/    private    $nohostname;

    public function __set($property, $value){
        if($property == 'conn' && $value instanceof ngx_connection_t){
           $this->conn = $value;
        }else{
           $this->$property = $value;
        }
    }

    public function __get($property){
       return $this->$property;
    }
}

function ngx_syslog_process_conf(ngx_conf_t $cf, ngx_syslog_peer_t $peer)
{
    $peer->facility = NGX_CONF_UNSET_UINT;
    $peer->severity = NGX_CONF_UNSET_UINT;

    if (ngx_syslog_parse_args($cf, $peer) != NGX_CONF_OK) {
        return NGX_CONF_ERROR;
    }

    if ($peer->server->sockaddr == NULL) {
        ngx_conf_log_error(NGX_LOG_EMERG, $cf, 0,
        "no syslog server specified");
        return NGX_CONF_ERROR;
    }

    if ($peer->facility == NGX_CONF_UNSET_UINT) {
        $peer->facility = 23; /* local7 */
    }

    if ($peer->severity == NGX_CONF_UNSET_UINT) {
        $peer->severity = 6; /* info */
    }

    if (empty($peer->tag)) {
        $peer->tag ="nginx";
    }
    $peer->conn->fd =  -1;

    return NGX_CONF_OK;
}

function ngx_syslog_parse_args(ngx_conf_t $cf, ngx_syslog_peer_t $peer)
{
//u_char      *p, *comma, c;
//    size_t       len;
//    ngx_str_t   *value;
//    ngx_url_t    u;
//    ngx_uint_t   i;

    $value = $cf->args;

    //p = value[1].data + sizeof("syslog:") - 1;
    $pp  = strlen("syslog:")-1;
    //$p = $value[1];
    $p = substr($value[1],$pp);

    for ( ;; ) {
        $comma = ngx_strchr($p, ',');

        if ($comma) {
            $len = strlen($p)-strlen($comma);
            $p[$len-1] = '';
        } else {
            $len = strlen($value[1])-($pp+1);
        }

        if (ngx_strncmp($p, "server=", 7) == 0) {

            // todo use -> instead of .
            if ($peer->server->sockaddr != NULL) {
                ngx_conf_log_error(NGX_LOG_EMERG, $cf, 0,
                    "duplicate syslog \"server\"");
                return NGX_CONF_ERROR;
            }

            //ngx_memzero(&u, sizeof(ngx_url_t));
            $u = new ngx_url_t();

            $u->url = substr($p, 7);
            $u->default_port = 514;

            if (ngx_parse_url($u) != NGX_OK) {
                if ($u->err) {
                    ngx_conf_log_error(NGX_LOG_EMERG, $cf, 0,
                        "%s in syslog server \"%V\"",
                        array($u->err, $u->url));
                }

                return NGX_CONF_ERROR;
            }

            $peer->server = $u->addrs[0];

        } else if (ngx_strncmp($p, "facility=", 9) == 0) {

            if ($peer->facility != NGX_CONF_UNSET_UINT) {
                ngx_conf_log_error(NGX_LOG_EMERG, $cf, 0,
                    "duplicate syslog \"facility\"");
                return NGX_CONF_ERROR;
            }

            $m = substr($p,9);
            for ($i = 0; facilities($i) != NULL; $i++) {
                if (ngx_strcmp($m, facilities($i)) == 0) {
                    $peer->facility = $i;
                    goto next;
                }
            }

            ngx_conf_log_error(NGX_LOG_EMERG, $cf, 0,
                "unknown syslog facility \"%s\"", $m);
            return NGX_CONF_ERROR;

        } else if (ngx_strncmp($p, "severity=", 9) == 0) {

            if ($peer->severity != NGX_CONF_UNSET_UINT) {
                ngx_conf_log_error(NGX_LOG_EMERG, $cf, 0,
                    "duplicate syslog \"severity\"");
                return NGX_CONF_ERROR;
            }

            $m = substr($p,9);
            for ($i = 0; severities($i) != NULL; $i++) {

                if (ngx_strcmp($m, severities($i)) == 0) {
                    $peer->severity = $i;
                    goto next;
                }
            }

            ngx_conf_log_error(NGX_LOG_EMERG, $cf, 0,
                "unknown syslog severity \"%s\"", $m);
            return NGX_CONF_ERROR;

        } else if (ngx_strncmp($p, "tag=", 4) == 0) {

            if ($peer->tag != NULL) {
                ngx_conf_log_error(NGX_LOG_EMERG, $cf, 0,
                    "duplicate syslog \"tag\"");
                return NGX_CONF_ERROR;
            }

            /*
             * RFC 3164: the TAG is a string of ABNF alphanumeric characters
             * that MUST NOT exceed 32 characters.
             */
            if ($len - 4 > 32) {
                ngx_conf_log_error(NGX_LOG_EMERG, $cf, 0,
                    "syslog tag length exceeds 32");
                return NGX_CONF_ERROR;
            }

            for ($i = 4; $i < $len; $i++) {
                $c = ngx_tolower($p[$i]);

                if ($c < '0' || ($c > '9' && $c < 'a' && $c != '_') || $c > 'z') {
                    ngx_conf_log_error(NGX_LOG_EMERG, $cf, 0,
                        "syslog \"tag\" only allows ".
                                       "alphanumeric characters ".
                                       "and underscore");
                    return NGX_CONF_ERROR;
                }
            }

            $peer->tag = substr($p,4);
            //peer->tag.len = len - 4;

        } else if ($len == 10 && ngx_strncmp($p, "nohostname", 10) == 0) {
            $peer->nohostname = 1;

        } else {
            ngx_conf_log_error(NGX_LOG_EMERG, $cf, 0,
                "unknown syslog parameter \"%s\"", $p);
            return NGX_CONF_ERROR;
        }

    next:

        if ($comma == false) {
            break;
        }

        $p = substr($comma ,1);
    }

    return NGX_CONF_OK;
}


function ngx_syslog_init_peer(ngx_syslog_peer_t $peer)
{
//ngx_socket_t         fd;
//    ngx_pool_cleanup_t  *cln;
    $ngx_syslog_dummy_event = ngx_syslog_dummy_event();

    $peer->conn->read = $ngx_syslog_dummy_event;
    $peer->conn->write = $ngx_syslog_dummy_event;

    $ngx_syslog_dummy_event->log = ngx_syslog_dummy_log();

    //ngx_syslog_dummy_event($ngx_syslog_dummy_event);

    $fd = ngx_socket($peer->server->sockaddr->sa_family, SOCK_DGRAM, 0);
    $ngx_cycle = ngx_cycle();
    if (!$fd) {
        ngx_log_error(NGX_LOG_ALERT, $ngx_cycle->log, socket_last_error(),
                      ngx_socket_n ." failed");
        return NGX_ERROR;
    }

    if (!ngx_nonblocking($fd)) {
        ngx_log_error(NGX_LOG_ALERT, $ngx_cycle->log, socket_last_error(),
                      ngx_nonblocking_n ." failed");
        goto failed;
    }

    if (!ngx_connect($fd, $peer->server->sockaddr, $peer->server->port)) {
        ngx_log_error(NGX_LOG_ALERT, $ngx_cycle->log, socket_last_error(),
                      "connect() failed");
        goto failed;
    }

//    cln = ngx_pool_cleanup_add(peer->pool, 0);
//    if (cln == NULL) {
//        goto failed;
//    }

    //todo how we clean ?
//    cln->data = peer;
//    cln->handler = ngx_syslog_cleanup;

    $peer->conn->fd = $fd;

    /* UDP sockets are always ready to write */
    $peer->conn->write->ready = 1;

    return NGX_OK;

failed:

    ngx_close_socket($fd);

    return NGX_ERROR;
}

function ngx_syslog_dummy_event(ngx_event_t $event = null){
   static $ngx_syslog_dummy_event;
    if($event !== null){
       $ngx_syslog_dummy_event = $event;
    }else{
       return $ngx_syslog_dummy_event;
    }
}

function ngx_syslog_dummy_log(ngx_log $log = null){
    static $ngx_syslog_dummy_log;
    if($log !== null){
       $ngx_syslog_dummy_log = $log;
    }else{
       return $ngx_syslog_dummy_log;
    }
}