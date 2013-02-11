<?php
/**
Module Completed By Vansers

This module is only use for phpVMS (www.phpvms.net) - (A Virtual Airline Admin Software)

@Created By Vansers
@Copyrighted @ 2011
@Under CC 3.0
@http://creativecommons.org/licenses/by-nc-sa/3.0/
**/

// Version 1.0 (August.24.11) - Module Created
// Version 1.1 (September.11.11) - Module Updated


class PilotLoginsData extends CodonData {
	
    public static function findLogins($params, $count = '', $start = '', $order_by = '') {
        
		$sql = 'SELECT l.*, p.*
				FROM pilotlogins l
				LEFT JOIN '.TABLE_PREFIX.'pilots p ON p.pilotid = l.pilotid
				';
		     
        $sql .= DB::build_where($params);

        // Order matters
        if (strlen($order_by) > 0) {
            $sql .= ' ORDER BY ' . $order_by;
        }

        if (strlen($count) != 0) {
            $sql .= ' LIMIT ' . $count;
        }

        if (strlen($start) != 0) {
            $sql .= ' OFFSET ' . $start;
        }

        $ret = DB::get_results($sql);


        return $ret;
    }
	
	
    public static function AddLogin($pilotid) {
		
		$message = DB::escape($message);
        
		 $sql = "INSERT INTO pilotlogins 
				(`pilotid`, `datestamp`, `ip`, `client`) VALUES ('{$pilotid}', NOW(), '{$_SERVER['REMOTE_ADDR']}', '{$_SERVER['HTTP_USER_AGENT']}')";
		
		DB::query($sql);
        
    }
	
	
	// VERSION 1.1
	
	
	//This function grabs the list by pilotid, usally used in profile areas
	public function get_pilotlogin($pilotid)
    {
        $query = "SELECT * FROM pilotlogins WHERE pilotid='$pilotid' ORDER BY id DESC";

        return DB::get_results($query);
		
    }
	
	//This function grabs the last login that the pilot logged in, in profile.
	public static function getLastLogin($pilotid, $count = 1) {
        
        if($pilotid == '') {
            return false;
        }
        
        $sql = 'SELECT * FROM pilotlogins
					WHERE pilotid=' . intval($pilotid);

        $sql .= ' ORDER BY datestamp DESC
					LIMIT ' . intval($count);

        if ($count == 1) return DB::get_row($sql);
        else  return DB::get_results($sql);
    }
	
	
	public static function getLoginCount($pilotid) {
        
        $sql = 'SELECT COUNT(*) AS total FROM pilotlogins
					WHERE pilotid=' . $pilotid . '
					GROUP BY pilotid';

        $total = DB::get_row($sql);

        if ($total == '') {
            return 0;
        }

        return $total->total;
    }

    
}
