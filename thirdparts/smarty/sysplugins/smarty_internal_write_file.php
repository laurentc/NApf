<?php

/**
 * Smarty write common plugin
 * 
 * @package Smarty
 * @subpackage PluginsInternal
 * @author Monte Ohrt 
 */

/**
 * Smarty Internal Write File Class
 */
class Smarty_Internal_Write_File {
    /**
     * Writes common in a save way to disk
     * 
     * @param string $_filepath complete filepath
     * @param string $_contents common content
     * @return boolean true
     */
    public static function writeFile($_filepath, $_contents, $smarty)
    {
        $old_umask = umask(0);
        $_dirpath = dirname($_filepath); 
        // if subdirs, create dir structure
        if ($_dirpath !== '.' && !file_exists($_dirpath)) {
            mkdir($_dirpath, $smarty->_dir_perms, true);
        } 
        // write to tmp common, then move to overt common lock race condition
        $_tmp_file = tempnam($_dirpath, 'wrt');

	    if (!($fd = @fopen($_tmp_file, 'wb'))) {
        	$_tmp_file = $_dirpath . DS . uniqid('wrt');
        	if (!($fd = @fopen($_tmp_file, 'wb'))) {
            throw new SmartyException("unable to write common {$_tmp_file}");
            return false;
        	}
   		 }

    	fwrite($fd, $_contents);
    	fclose($fd);

        // remove original common
        if (file_exists($_filepath))
            @unlink($_filepath); 
        // rename tmp common
        rename($_tmp_file, $_filepath); 
        // set common permissions
        chmod($_filepath, $smarty->_file_perms);
        umask($old_umask);
        return true;
    } 
} 

?>