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

class PilotLogins extends CodonModule {
	
	public function navbar()
	{
		if(PilotGroups::group_has_perm(Auth::$usergroups, FULL_ADMIN))
		{
		echo '<li><a href="'.SITE_URL.'/admin/index.php/PilotLogins/">View All Pilot Logins</a></li>';
		}
	}

    	public function index() 
	{
        $this->viewlogins();
    	}
	
	public function viewlogins()
	{
		$this->ShowAllPilotLoginList();
	}
	
	protected function ShowAllPilotLoginList() 
	{
        $this->render('all_pilots_login.tpl');
    }
	
	public function getloginjson()
	{
		$page = $this->get->page; // get the requested page
        $limit = $this->get->rows; // get how many rows we want to have into the grid
        $sidx = $this->get->sidx; // get index row - i.e. user click to sort
        $sord = $this->get->sord; // get the direction
        if (!$sidx) $sidx = 1;


        /* Do the search using jqGrid */
        $where = array();
        if ($this->get->_search == 'true') {

            $searchstr = jqgrid::strip($this->get->filters);
            $where_string = jqgrid::constructWhere($searchstr);

            # Append to our search, add 1=1 since it comes with AND
            #	from above
            $where[] = "1=1 {$where_string}";
        }

        # Do a search without the limits so we can find how many records
        $count = count(PilotLoginsData::findLogins($where));

        if ($count > 0) {
            $total_pages = ceil($count / $limit);
        } else {
            $total_pages = 0;
        }

        if ($page > $total_pages) {
            $page = $total_pages;
        }

        $start = $limit * $page - $limit; // do not put $limit*($page - 1)
        if ($start < 0) {
            $start = 0;
        }

        # And finally do a search with the limits
        $pilotlogins = PilotLoginsData::findLogins($where, $limit, $start, "{$sidx} {$sord}");
        if (!$pilotlogins) {
            $pilotlogins = array();
        }

        # Form the json header
        $json = array(
            'page' => $page, 
            'total' => $total_pages, 
            'records' => $count,
            'rows' => array()
        );

        # Add each row to the above array
        foreach ($pilotlogins as $row) 
		{
            
			    $pilotid = PilotData::getPilotCode($row->code, $row->pilotid);
    			
				$firstname = $row->firstname;
				$lastname = $row->lastname;
			
			

            $tmp = array(
				'id' => $row->id, 
				'cell' => array( # Each column, in order
				$row->id,
                $pilotid,
				$firstname,
				$lastname,
				$row->datestamp, 
				$row->ip, 
				$row->client, 
				), 
			);

            $json['rows'][] = $tmp;
        }

        header("Content-type: text/x-json");
        echo json_encode($json);
	}


}
