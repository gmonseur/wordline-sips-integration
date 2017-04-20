<?php
/**
 * write_log
 *
 * @param $path
 * @param $data
 * @param $mode
 * @return bool
 */
if (!function_exists('write_log'))
{
    function write_log($path, $data, $mode = 'a+')
    {
        if ( ! $fp = @fopen($path, $mode))
        {
            return FALSE;
        }

        $message = date("d/m/Y H:i:s").': '.$data.'('.$_SERVER['PHP_SELF'].')';
        $message .= "\r\n";

        flock($fp, LOCK_EX);
        fwrite($fp, $message);
        flock($fp, LOCK_UN);
        fclose($fp);

        return TRUE;
    }
}
?>