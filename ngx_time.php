<?php
/**
 * Created by PhpStorm.
 * User: zenus
 * Date: 15-11-8
 * Time: 下午9:13
 */

define('NGX_HAVE_GETTIMEZONE', 1);

function week($i){

    static $week  = array( "Sun", "Mon", "Tue", "Wed", "Thu", "Fri", "Sat" );
    return $week[$i];
}
class ngx_tm_t
{
      private $tm_sec;			/* Seconds.	[0-60] (1 leap second) */
      private $tm_min;			/* Minutes.	[0-59] */
      private $tm_hour;			/* Hours.	[0-23] */
      private $tm_mday;			/* Day.		[1-31] */
      private $tm_mon;			/* Month.	[0-11] */
      private $tm_year;			/* Year	- 1900.  */
      private $tm_wday;			/* Day of week.	[0-6] */
      private $tm_yday;			/* Days in year.[0-365]	*/
      private $tm_isdst;			/* DST.		[-1/0/1]*/

      private $__tm_gmtoff;		/* Seconds east of UTC.  */
      private $__tm_zone;	/* Timezone abbreviation.  */

    public function __set($property,$value){
        $this->$property = $value;
    }
    public function __get($property){
       return $this->$property;
    }
};
function months($i){
    static $months = array( "Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec" );
    return $months[$i];
}

class ngx_time_t {
 private /*  time_t    */  $sec;
 private /*  ngx_uint_t*/  $msec;
 private /*  ngx_int_t */  $gmtoff;

    public function __set($property,$value){
       $this->$property = $value;
    }
    public function  __get($property){
       return $this->$property;
    }

}

define('NGX_TIME_SLOTS',64);

function ngx_timezone_update()
{
     time();
     localtime(time());
     strftime( "%H", time());
}

function ngx_timeofday(){

    return ngx_cache_time();
}

function ngx_cache_time(ngx_time_t $t = null){
    static $ngx_cache_time = null;
    if(!is_null($t)){
       $ngx_cache_time = $t;
    }else{
       return $ngx_cache_time;
    }
}

function ngx_gettimeofday(){

    return gettimeofday();
}

function ngx_cached_syslog_time($i=null){
   static $ngx_cached_syslog_time = null;
    if(!is_null($i)){
        $ngx_cached_syslog_time = $i;
    }else{
        return $ngx_cached_syslog_time;
    }
}

function ngx_current_msec($i = null){
   static $ngx_current_msec = null;
    if(!is_null($i)){
        $ngx_current_msec = $i;
    }else{
       return $ngx_current_msec;
    }
}

function cached_http_time($arr = null){
    static $cached_http_time = null;
    if(!is_null($arr)){
       $cached_http_time  = $arr;
    }else{
       return $cached_http_time;
    }
}

function cached_http_log_time($arr = null){
    static $cached_http_log_time = null;
    if(!is_null($arr)){
       $cached_http_log_time = $arr;
    }else{
       return $cached_http_log_time;
    }

}

function cached_http_log_iso8601($arr = null){
    static $cached_http_log_iso8601 = null;
    if(!is_null($arr)){
       $cached_http_log_iso8601 = $arr;
    }else{
       return $cached_http_log_iso8601;
    }

}

function  cached_syslog_time($arr = null){
    static $cached_syslog_time  = null;
    if(!is_null($arr)){
       $cached_syslog_time = $arr ;
    }else{
       return $cached_syslog_time;
    }

}

function ngx_time_update()
{
//u_char          *p0, *p1, *p2, *p3, *p4;
//    ngx_tm_t         tm, gmt;
//    time_t           sec;
//    ngx_uint_t       msec;
//    ngx_time_t      *tp;
//    struct timeval   tv;

    /** not multithread mode**/
//    if (!ngx_trylock(&ngx_time_lock)) {
//        return;
//    }

    $tv = ngx_gettimeofday();

    $sec = $tv['tv_sec'];
    $msec = $tv['tv_usec'] / 1000;

    ngx_current_msec($sec * 1000 + $msec);

//    static ngx_time_t        cached_time[NGX_TIME_SLOTS];
    $cached_time = cached_time();
    $slot = slot();
    $tp = $cached_time[$slot];
    if ($tp['sec'] == $sec) {
        $tp['msec'] = $msec;
        return;
    }

    if ($slot == NGX_TIME_SLOTS - 1) {
        slot(0);
    } else {
        slot($slot+1);
    }

    $tp['sec'] = $sec;
    $tp['msec'] = $msec;
//    ngx_cfg('cached_time',$cached_time);
    /***
     *
     *
     */


    $gmt = new ngx_tm_t();
    ngx_gmtime($sec, $gmt);

    $cached_http_time = cached_http_time();
    $slot = slot();

    $p0 = $cached_http_time[$slot][0];

    $args = array(
        week($gmt->tm_wday),
        $gmt->tm_mday,
        months($gmt->tm_mon - 1),
        $gmt->tm_year,
        $gmt->tm_hour,
        $gmt->tm_min,
        $gmt->tm_sec
    );
    ngx_sprintf($p0, "%s, %02d %s %4d %02d:%02d:%02d GMT",$args);

    $tp['gmtoff'] = ngx_gettimezone();
    $cached_time[$slot] = $tp;
    cached_time($cached_time);
    ngx_gmtime($sec + $tp['gmoff'] * 60, $gmt);



    $cached_err_log_time = cached_err_log_time();
    $slot = slot();
    $p1 = $cached_err_log_time[$slot][0];

    $args = array(
        $gmt->tm_year,
        $gmt->tm_mon,
        $gmt->tm_mday,
        $gmt->tm_hour,
        $gmt->tm_min,
        $gmt->tm_sec
    );
    ngx_sprintf($p1, "%4d/%02d/%02d %02d:%02d:%02d",$args);





    $cached_http_log_time = cached_http_log_time();
    $slot = slot();

   $p2 = $cached_http_log_time[$slot][0];

    $args = array(
        $gmt->tm_mday,
        months($gmt->tm_mon - 1),
        $gmt->tm_year,
        $gmt->tm_hour,
        $gmt->tm_min,
        $gmt->tm_sec,
        $tp['gmtoff'] < 0 ? '-' : '+',
        ngx_abs($tp['gmtoff'] / 60),
        ngx_abs($tp['gmtoff'] % 60),
    );
    ngx_sprintf($p2, "%02d/%s/%d:%02d:%02d:%02d %c%02d%02d",$args);

    $cached_http_log_iso8601 = cached_http_log_iso8601();
    $slot = slot();
    $p3 = $cached_http_log_iso8601[$slot][0];
    $args = array(
        $gmt->tm_year,
        $gmt->tm_mon,
        $gmt->tm_mday,
        $gmt->tm_hour,
        $gmt->tm_min,
        $gmt->tm_sec,
        $cached_time[$slot]['gmtoff'] < 0 ? '-' : '+',
        ngx_abs($tp['gmtoff'] / 60),
        ngx_abs($tp['gmtoff'] % 60),
    );
    ngx_sprintf($p3, "%4d-%02d-%02dT%02d:%02d:%02d%c%02d:%02d",$args);


    $cached_syslog_time = cached_syslog_time();
    $slot = slot();
    $p4 = $cached_syslog_time[$slot][0];

    $args = array(
        months($gmt->tm_mon - 1),
        $gmt->tm_mday,
        $gmt->tm_hour,
        $gmt->tm_min,
        $gmt->tm_sec
    );
    ngx_sprintf($p4, "%s %2d %02d:%02d:%02d",$args);

    //ngx_memory_barrier();

    ngx_cached_time($tp);
    ngx_cached_http_time($p0);
    ngx_cached_err_log_time($p1);
    ngx_cached_http_log_time($p2);
    ngx_cached_http_log_iso8601($p3);
    ngx_cached_syslog_time($p4);

}


function ngx_gettimezone()
{
//    u_long                 n;
//    TIME_ZONE_INFORMATION  tz;
//
//    n = GetTimeZoneInformation(&tz);
//
//    switch (n) {
//
//        case TIME_ZONE_ID_UNKNOWN:
//            return -tz.Bias;
//
//        case TIME_ZONE_ID_STANDARD:
//            return -(tz.Bias + tz.StandardBias);
//
//        case TIME_ZONE_ID_DAYLIGHT:
//            return -(tz.Bias + tz.DaylightBias);
//
//        default: /* TIME_ZONE_ID_INVALID */
//            return 0;
//    }
    return 0;
}

function ngx_gmtime($t, ngx_tm_t $tp)
{
//    ngx_int_t   yday;
//    ngx_uint_t  n, sec, min, hour, mday, mon, year, wday, days, leap;

    /* the calculation is valid for positive time_t only */

    $n = $t;

    $days = $n / 86400;

    /* January 1, 1970 was Thursday */

    $wday = (4 + $days) % 7;

    $n %= 86400;
    $hour = $n / 3600;
    $n %= 3600;
    $min = $n / 60;
    $sec = $n % 60;

    /*
     * the algorithm based on Gauss' formula,
     * see src/http/ngx_http_parse_time.c
     */

    /* days since March 1, 1 BC */
    $days = $days - (31 + 28) + 719527;

    /*
     * The "days" should be adjusted to 1 only, however, some March 1st's go
     * to previous year, so we adjust them to 2.  This causes also shift of the
     * last February days to next year, but we catch the case when "yday"
     * becomes negative.
     */

    $year = ($days + 2) * 400 / (365 * 400 + 100 - 4 + 1);

    $yday = $days - (365 * $year + $year / 4 - $year / 100 + $year / 400);

    if ($yday < 0) {
        $leap = ($year % 4 == 0) && ($year % 100 || ($year % 400 == 0));
        $yday = 365 + $leap + $yday;
        $year--;
    }

    /*
     * The empirical formula that maps "yday" to month.
     * There are at least 10 variants, some of them are:
     *     mon = (yday + 31) * 15 / 459
     *     mon = (yday + 31) * 17 / 520
     *     mon = (yday + 31) * 20 / 612
     */

    $mon = ($yday + 31) * 10 / 306;

    /* the Gauss' formula that evaluates days before the month */

    $mday = $yday - (367 * $mon / 12 - 30) + 1;

    if ($yday >= 306) {

        $year++;
        $mon -= 10;

        /*
         * there is no "yday" in Win32 SYSTEMTIME
         *
         * yday -= 306;
         */

    } else {

        $mon += 2;

        /*
         * there is no "yday" in Win32 SYSTEMTIME
         *
         * yday += 31 + 28 + leap;
         */
    }

    $tp->tm_sec =  $sec;
    $tp->tm_min =  $min;
    $tp->tm_hour = $hour;
    $tp->tm_mday = $mday;
    $tp->tm_mon =  $mon;
    $tp->tm_year = $year;
    $tp->tm_wday = $wday;
}

function ngx_time_init()
{

//ngx_cached_err_log_time.len = sizeof("1970/09/28 12:00:00") - 1;
//    ngx_cached_http_time.len = sizeof("Mon, 28 Sep 1970 06:00:00 GMT") - 1;
//    ngx_cached_http_log_time.len = sizeof("28/Sep/1970:12:00:00 +0600") - 1;
//    ngx_cached_http_log_iso8601.len = sizeof("1970-09-28T12:00:00+06:00") - 1;
//    ngx_cached_syslog_time.len = sizeof("Sep 28 12:00:00") - 1;
//
//    ngx_cached_time = &cached_time[0];
//
//    ngx_time_update();
}

function ngx_time_lock($time_lock = null){
   static $ngx_time_lock = null;
    if(!is_null($time_lock)){
        $ngx_time_lock = $time_lock;
    }else{
        return $ngx_time_lock;
    }
}


function cached_gmtoff($i = null){
    static $cached_gmtoff = null;
    if(!is_null($i)){
        $cached_gmtoff = $i;
    }else{
        return $cached_gmtoff;
    }
}

function cached_time($t = null){
    static $cached_time = null;
   if(!is_null($t)){
       if($t instanceof ngx_time_t){
           $cached_time[] = $t;
       }else{
           return $cached_time[$t];
       }
   }else{
      return $cached_time;
   }
}

function slot($i = null){
    static $slot = null;
    if(!is_null($i)){
       $slot = $i;
    }else{
       return $slot;
    }
}

function  cached_err_log_time($char = null ){
   // [NGX_TIME_SLOTS]
    static $cached_err_log_time = null;
    if(!is_null($char)){
       $cached_err_log_time[] = $char;
    }else{
       return $cached_err_log_time;
    }
}



function ngx_cached_time(ngx_time_t $t = null){
    static $ngx_cached_time = null;
    if(!is_null($t)){
        $ngx_cached_time = $t ;
    }else{
       return $ngx_cached_time;
    }
}

function ngx_cached_err_log_time($s = null){
    static $ngx_cached_err_log_time = null;
    if(!is_null($s)){
         $ngx_cached_err_log_time = $s;
    }else{
        return $ngx_cached_err_log_time;
    }
}

function ngx_cached_http_time($s = null){
   static $ngx_cached_http_time = null;
    if(!is_null($s)){
       $ngx_cached_http_time = $s;
    }else{
        return $ngx_cached_http_time;
    }
}

function ngx_cached_http_log_time($s = null){
   static $ngx_cached_http_log_time = null;
    if(!is_null($ngx_cached_http_log_time)){
       $ngx_cached_http_log_time = $s;
    }else{
       return $ngx_cached_http_log_time;
    }
}

/**
 * @param null $s
 */
function ngx_cached_http_log_iso8601($s = null){
    static $ngx_cached_http_log_iso8601 = null;
    if(!is_null($s)){
       $ngx_cached_http_log_iso8601 = $s;
    }else{
       return $ngx_cached_http_log_iso8601;
    }
}

//function ngx_cached_syslog_time($s = null){
//   static $ngx_cached_syslog_time = null;
//    if(!is_null($s)){
//       $ngx_cached_syslog_time = $s;
//    }else{
//       return $ngx_cached_syslog_time;
//    }
//}

/**
 * @param $ms
 */
function ngx_msleep($ms) {
   usleep($ms * 1000);
}

function ngx_time_sigsafe_update()
{
//u_char          *p, *p2;
//    ngx_tm_t         tm;
//    time_t           sec;
//    ngx_time_t      *tp;
//    struct timeval   tv;

    if (!ngx_trylock(ngx_time_lock())) {
        return;
    }

    $tv = ngx_gettimeofday();

    $sec = $tv['tv_sec'];
    $slot= slot();
    $tp = cached_time($slot);

    if ($tp->sec == $sec) {
        ngx_unlock(ngx_time_lock());
        return;
    }

    if ($slot == NGX_TIME_SLOTS - 1) {
        $slot = 0;
    } else {
        $slot++;
    }

    $tp = cached_time($slot);
    $tp->sec = 0;
    slot($slot);

    $tm = new ngx_tm_t();
    ngx_gmtime($sec + cached_gmtoff() * 60, $tm);

    //p = &cached_err_log_time[slot][0];
    $p = cached_err_log_time($slot);

    ngx_sprintf($p, "%4d/%02d/%02d %02d:%02d:%02d",
    array($tm->tm_year, $tm->tm_mon,
    $tm->tm_mday, $tm->tm_hour,
    $tm->tm_min, $tm->tm_sec));

  //  p2 = cached_syslog_time[slot][0];
     $p2 = cached_syslog_time($slot);
      //slot($slot);
     ngx_sprintf($p2, "%s %2d %02d:%02d:%02d",
                      array(months($tm->tm_mon - 1), $tm->tm_mday,
                       $tm->tm_hour, $tm->tm_min, $tm->tm_sec));

    //ngx_memory_barrier();

    ngx_cached_err_log_time($p);
    ngx_cached_syslog_time($p2);

    ngx_unlock(ngx_time_lock());
}


