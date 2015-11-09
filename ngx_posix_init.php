<?php
/**
 * Created by PhpStorm.
 * User: zenus
 * Date: 15-11-8
 * Time: 上午7:04
 * @param ngx_log $log
 * @return int
 */

function ngx_os_init(ngx_log &$log)
{


    if (ngx_os_specific_init($log) != NGX_OK) {
        return NGX_ERROR;
    }

    if (ngx_init_setproctitle($log) != NGX_OK) {
        return NGX_ERROR;
    }

//#if (NGX_HAVE_SC_NPROCESSORS_ONLN)
//    if (ngx_ncpu == 0) {
//        ngx_ncpu = sysconf(_SC_NPROCESSORS_ONLN);
//    }
//#endif
//
//    if (ngx_ncpu < 1) {
    //todo  find way to get the  cpu amount
        ngx_cfg('ngx_ncpu',1);
    //}

    //todo find way to get cup info
///    ngx_cpuinfo();

    if (!empty($rlimit = posix_getrlimit())) {
        ngx_log_error(NGX_LOG_ALERT, $log, posix_get_last_error(),
            "getrlimit(RLIMIT_NOFILE) failed)");
        return NGX_ERROR;
    }

    ngx_cfg('ngx_max_sockets',$rlimit['soft openfiles']);

//#if (NGX_HAVE_INHERITED_NONBLOCK || NGX_HAVE_ACCEPT4)
    // todo find how to do this
    ngx_cfg('ngx_inherited_nonblocking', 1);
//#else
//    ngx_inherited_nonblocking = 0;
//#endif

    //todo find why do this
//    srandom(ngx_time());

    return NGX_OK;
}