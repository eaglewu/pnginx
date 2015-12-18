<?php
/**
 * Created by PhpStorm.
 * User: zenus
 * Date: 15-11-6
 * Time: 上午7:17
 */
define('EPUND',0);  /* php not define */
define('EPERM',1);  /* Operation not permitted */
define('ENOENT',2);  /* No such file or directory */
define('ESRCH',3);  /* No such process */
define('EINTR',4);  /* Interrupted system call */
define('EIO',5);  /* I/O error */
define('ENXIO',6);  /* No such device or address */
define('E2BIG',7);  /* Argument list too long */
define('ENOEXEC',8);  /* Exec format error */
define('EBADF',9);  /* Bad file number */
define('ECHILD',10);  /* No child processes */
define('EAGAIN',11);  /* Try again */
define('ENOMEM',12);  /* Out of memory */
define('EACCES',13);  /* Permission denied */
define('EFAULT',14);  /* Bad address */
define('ENOTBLK',15);  /* Block device required */
define('EBUSY',16);  /* Device or resource busy */
define('EEXIST',17);  /* File exists */
define('EXDEV',18);  /* Cross-device link */
define('ENODEV',19);  /* No such device */
define('ENOTDIR',20);  /* Not a directory */
define('EISDIR',21);  /* Is a directory */
define('EINVAL',22);  /* Invalid argument */
define('ENFILE',23);  /* File table overflow */
define('EMFILE',24);  /* Too many open files */
define('ENOTTY',25);  /* Not a typewriter */
define('ETXTBSY',26);  /* Text file busy */
define('EFBIG',27);  /* File too large */
define('ENOSPC',28);  /* No space left on device */
define('ESPIPE',29);  /* Illegal seek */
define('EROFS',30);  /* Read-only file system */
define('EMLINK',31);  /* Too many links */
define('EPIPE',32);  /* Broken pipe */
define('EDOM',33);  /* Math argument out of domain of func */
define('ERANGE',34);  /* Math result not representable */

define('EDEADLK',35);  /* Resource deadlock would occur */
define('ENAMETOOLONG',36);  /* File name too long */
define('ENOLCK',37);  /* No record locks available */
define('ENOSYS',38);  /* Function not implemented */
define('ENOTEMPTY',39);  /* Directory not empty */
define('ELOOP',40);  /* Too many symbolic links encountered */
define('EWOULDBLOCK', EAGAIN);  /* Operation would block */
define('ENOMSG',42);  /* No message of desired type */
define('EIDRM',43);  /* Identifier removed */
define('ECHRNG',44);  /* Channel number out of range */
define('EL2NSYNC',45);  /* Level 2 not synchronized */
define('EL3HLT',46);  /* Level 3 halted */
define('EL3RST',47);  /* Level 3 reset */
define('ELNRNG',48);  /* Link number out of range */
define('EUNATCH',49);  /* Protocol driver not attached */
define('ENOCSI',50);  /* No CSI structure available */
define('EL2HLT',51);  /* Level 2 halted */
define('EBADE',52);  /* Invalid exchange */
define('EBADR',53);  /* Invalid request descriptor */
define('EXFULL',54);  /* Exchange full */
define('ENOANO',55);  /* No anode */
define('EBADRQC',56);  /* Invalid request code */
define('EBADSLT',57);  /* Invalid slot */

define('EDEADLOCK',EDEADLK);

define('EBFONT',59);  /* Bad font file format */
define('ENOSTR',60);  /* Device not a stream */
define('ENODATA',61);  /* No data available */
define('ETIME',62);  /* Timer expired */
define('ENOSR',63);  /* Out of streams resources */
define('ENONET',64);  /* Machine is not on the network */
define('ENOPKG',65);  /* Package not installed */
define('EREMOTE',66);  /* Object is remote */
define('ENOLINK',67);  /* Link has been severed */
define('EADV',68);  /* Advertise error */
define('ESRMNT',69);  /* Srmount error */
define('ECOMM',70);  /* Communication error on send */
define('EPROTO',71);  /* Protocol error */
define('EMULTIHOP',72);  /* Multihop attempted */
define('EDOTDOT',73);  /* RFS specific error */
define('EBADMSG',74);  /* Not a data message */
define('EOVERFLOW',75);  /* Value too large for defined data type */
define('ENOTUNIQ',76);  /* Name not unique on network */
define('EBADFD',77);  /* File descriptor in bad state */
define('EREMCHG',78);  /* Remote address changed */
define('ELIBACC',79);  /* Can not access a needed shared library */
define('ELIBBAD',80);  /* Accessing a corrupted shared library */
define('ELIBSCN',81);  /* .lib section in a.out corrupted */
define('ELIBMAX',82);  /* Attempting to link in too many shared libraries */
define('ELIBEXEC',83);  /* Cannot exec a shared library directly */
define('EILSEQ',84);  /* Illegal byte sequence */
define('ERESTART',85);  /* Interrupted system call should be restarted */
define('ESTRPIPE',86);  /* Streams pipe error */
define('EUSERS',87);  /* Too many users */
define('ENOTSOCK',88);  /* Socket operation on non-socket */
define('EDESTADDRREQ',89);  /* Destination address required */
define('EMSGSIZE',90);  /* Message too long */

define('EPROTOTYPE',91);  /* Protocol wrong type for socket */
define('ENOPROTOOPT',92);  /* Protocol not available */
define('EPROTONOSUPPORT',93);  /* Protocol not supported */
define('ESOCKTNOSUPPORT',94);  /* Socket type not supported */
define('EOPNOTSUPP',95);  /* Operation not supported on transport endpoint */
define('EPFNOSUPPORT',96);  /* Protocol family not supported */
define('EAFNOSUPPORT',97);  /* Address family not supported by protocol */
define('EADDRINUSE',98);  /* Address already in use */
define('EADDRNOTAVAIL',99);  /* Cannot assign requested address */
define('ENETDOWN',100); /* Network is down */
define('ENETUNREACH',101); /* Network is unreachable */
define('ENETRESET',102); /* Network dropped connection because of reset */
define('ECONNABORTED',103); /* Software caused connection abort */
define('ECONNRESET',104); /* Connection reset by peer */
define('ENOBUFS',105); /* No buffer space available */
define('EISCONN',106); /* Transport endpoint is already connected */
define('ENOTCONN',107); /* Transport endpoint is not connected */
define('ESHUTDOWN',108); /* Cannot send after transport endpoint shutdown */
define('ETOOMANYREFS',109); /* Too many references: cannot splice */
define('ETIMEDOUT',110); /* Connection timed out */
define('ECONNREFUSED',111); /* Connection refused */
define('EHOSTDOWN',112); /* Host is down */
define('EHOSTUNREACH',113); /* No route to host */
define('EALREADY',114); /* Operation already in progress */
define('EINPROGRESS',115); /* Operation now in progress */
define('ESTALE',116); /* Stale NFS file handle */
define('EUCLEAN',117); /* Structure needs cleaning */
define('ENOTNAM',118); /* Not a XENIX named type file */
define('ENAVAIL',119); /* No XENIX semaphores available */
define('EISNAM',120); /* Is a named type file */

define('EREMOTEIO',121); /* Remote I/O error */
define('EDQUOT',122); /* Quota exceeded */

define('ENOMEDIUM',123); /* No medium found */
define('EMEDIUMTYPE',124); /* Wrong medium type */
define('ECANCELED',125); /* Operation Canceled */
define('ENOKEY',126); /* Required key not available */
define('EKEYEXPIRED',127); /* Key has expired */
define('EKEYREVOKED',128); /* Key has been revoked */
define('EKEYREJECTED',129); /* Key was rejected by service */

/* for robust mutexes */
define('EOWNERDEAD',130); /* Owner died */
define('ENOTRECOVERABLE',131); /* State not recoverable */

define('ERFKILL',132); /* Operation not possible due to RF-kill */

define('EHWPOISON',133); /* Memory page has hardware error */

define('NGX_FERROR',180); /*file error */
define('NGX_FLERROR',181); /*file error */
define('NGX_FCERROR',182); /*file error */
define('NGX_FDERROR',183); /*file delete error */
define('NGX_DCERROR',184); /*dir create file error */
define('NGX_FIERROR',185); /*stat file error */
define('NGX_FCNERROR',186); /*chown file error */
define('NGX_FCMERROR',187); /*chmod file error */
define('NGX_FRNERROR',188); /*rename file error */

define('NGX_EPERM',EPERM);
define('NGX_ENOENT',ENOENT);
define('NGX_ENOPATH',ENOENT);
define('NGX_ESRCH',ESRCH);
define('NGX_EINTR',EINTR);
define('NGX_ECHILD',ECHILD);
define('NGX_ENOMEM',ENOMEM);
define('NGX_EACCES',EACCES);
define('NGX_EBUSY',EBUSY);
define('NGX_EEXIST',EEXIST);
define('NGX_EXDEV',EXDEV);
define('NGX_ENOTDIR',ENOTDIR);
define('NGX_EISDIR',EISDIR);
define('NGX_EINVAL',EINVAL);
define('NGX_ENFILE',ENFILE);
define('NGX_EMFILE',EMFILE);
define('NGX_ENOSPC',ENOSPC);
define('NGX_EPIPE',EPIPE);
define('NGX_EINPROGRESS',EINPROGRESS);
define('NGX_ENOPROTOOPT',ENOPROTOOPT);
define('NGX_EOPNOTSUPP',EOPNOTSUPP);
define('NGX_EADDRINUSE',EADDRINUSE);
define('NGX_ECONNABORTED',ECONNABORTED);
define('NGX_ECONNRESET',ECONNRESET);
define('NGX_ENOTCONN',ENOTCONN);
define('NGX_ETIMEDOUT',ETIMEDOUT);
define('NGX_ECONNREFUSED',ECONNREFUSED);
define('NGX_ENAMETOOLONG',ENAMETOOLONG);
define('NGX_ENETDOWN',ENETDOWN);
define('NGX_ENETUNREACH',ENETUNREACH);
define('NGX_EHOSTDOWN',EHOSTDOWN);
define('NGX_EHOSTUNREACH',EHOSTUNREACH);
define('NGX_ENOSYS',ENOSYS);
define('NGX_ECANCELED',ECANCELED);
define('NGX_EILSEQ',EILSEQ);
define('NGX_ENOMOREFILES',0);
define('NGX_ELOOP',ELOOP);
define('NGX_EBADF',EBADF);

define('NGX_SYS_NERR',133);


function ngx_strerror($err, $errstr)
{

    $msg = $err < NGX_SYS_NERR ? ngx_cfg('ngx_sys_errlist')[$err]:$ngx_cfg('ngx_unknown_error');

    return $errstr.$msg;
}

function ngx_strerror_init()
{
    $ngx_sys_errlist = array(
        1=>' Operation not permitted ',
        2=>' No such file or directory ',
        3=>' No such process ',
        4=>' Interrupted system call ',
        5=>' I/O error ',
        6=>' No such device or address ',
        7=>' Argument list too long ',
        8=>' Exec format error ',
        9=>' Bad file number ',
        10=>' No child processes ',
        11=>' Try again ',
        12=>' Out of memory ',
        13=>' Permission denied ',
        14=>' Bad address ',
        15=>' Block device required ',
        16=>' Device or resource busy ',
        17=>' File exists ',
        18=>' Cross-device link ',
        19=>' No such device ',
        20=>' Not a directory ',
        21=>' Is a directory ',
        22=>' Invalid argument ',
        23=>' File table overflow ',
        24=>' Too many open files ',
        25=>' Not a typewriter ',
        26=>' Text file busy ',
        27=>' File too large ',
        28=>' No space left on device ',
        29=>' Illegal seek ',
        30=>' Read-only file system ',
        31=>' Too many links ',
        32=>' Broken pipe ',
        33=>' Math argument out of domain of func ',
        34=>' Math result not representable ',

        35=>' Resource deadlock would occur ',
        36=>' File name too long ',
        37=>' No record locks available ',
        38=>' Function not implemented ',
        39=>' Directory not empty ',
        40=>' Too many symbolic links encountered ',
        42=>' No message of desired type ',
        43=>' Identifier removed ',
        44=>' Channel number out of range ',
        45=>' Level 2 not synchronized ',
        46=>' Level 3 halted ',
        47=>' Level 3 reset ',
        48=>' Link number out of range ',
        49=>' Protocol driver not attached ',
        50=>' No CSI structure available ',
        51=>' Level 2 halted ',
        52=>' Invalid exchange ',
        53=>' Invalid request descriptor ',
        54=>' Exchange full ',
        55=>' No anode ',
        56=>' Invalid request code ',
        57=>' Invalid slot ',
        59=>' Bad font file format ',
        60=>' Device not a stream ',
        61=>' No data available ',
        62=>' Timer expired ',
        63=>' Out of streams resources ',
        64=>' Machine is not on the network ',
        65=>' Package not installed ',
        66=>' Object is remote ',
        67=>' Link has been severed ',
        68=>' Advertise error ',
        69=>' Srmount error ',
        70=>' Communication error on send ',
        71=>' Protocol error ',
        72=>' Multihop attempted ',
        73=>' RFS specific error ',
        74=>' Not a data message ',
        75=>' Value too large for defined data type ',
        76=>' Name not unique on network ',
        77=>' File descriptor in bad state ',
        78=>' Remote address changed ',
        79=>' Can not access a needed shared library ',
        80=>' Accessing a corrupted shared library ',
        81=>' .lib section in a.out corrupted ',
        82=>' Attempting to link in too many shared libraries ',
        83=>' Cannot exec a shared library directly ',
        84=>' Illegal byte sequence ',
        85=>' Interrupted system call should be restarted ',
        86=>' Streams pipe error ',
        87=>' Too many users ',
        88=>' Socket operation on non-socket ',
        89=>' Destination address required ',
        90=>' Message too long ',

        91=>' Protocol wrong type for socket ',
        92=>' Protocol not available ',
        93=>' Protocol not supported ',
        94=>' Socket type not supported ',
        95=>' Operation not supported on transport endpoint ',
        96=>' Protocol family not supported ',
        97=>' Address family not supported by protocol ',
        98=>' Address already in use ',
        99=>' Cannot assign requested address ',
        100=>' Network is down ',
        101=>' Network is unreachable ',
        102=>' Network dropped connection because of reset ',
        103=>' Software caused connection abort ',
        104=>' Connection reset by peer ',
        105=>' No buffer space available ',
        106=>' Transport endpoint is already connected ',
        107=>' Transport endpoint is not connected ',
        108=>' Cannot send after transport endpoint shutdown ',
        109=>' Too many references: cannot splice ',
        110=>' Connection timed out ',
        111=>' Connection refused ',
        112=>' Host is down ',
        113=>' No route to host ',
        114=>' Operation already in progress ',
        115=>' Operation now in progress ',
        116=>' Stale NFS file handle ',
        117=>' Structure needs cleaning ',
        118=>' Not a XENIX named type file ',
        119=>' No XENIX semaphores available ',
        120=>' Is a named type file ',
        121=>' Remote I/O error ',
        122=>' Quota exceeded ',
        123=>' No medium found ',
        124=>' Wrong medium type ',
        125=>' Operation Canceled ',
        126=>' Required key not available ',
        127=>' Key has expired ',
        128=>' Key has been revoked ',
        129=>' Key was rejected by service ',
        /* for robust mutexes */
        130=>' Owner died ',
        131=>' State not recoverable ',

        132=>' Operation not possible due to RF-kill ',

        133=>' Memory page has hardware error ',
    );

    ngx_cfg('ngx_sys_errlist',$ngx_sys_errlist);

    return NGX_OK;

}