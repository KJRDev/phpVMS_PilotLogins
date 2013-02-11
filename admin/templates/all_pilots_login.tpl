<!--
Module Completed By Vansers

This module is only use for phpVMS (www.phpvms.net) - (A Virtual Airline Admin Software)

@Created By Vansers
@Copyrighted @ 2011
@Under CC 3.0
@http://creativecommons.org/licenses/by-nc-sa/3.0/


Version 1.0 (August.24.11) - Module Created -->

<h3>All Pilot Logins</h3>
<table id="grid"></table>
<div id="pager"></div>
<br />

<link rel="stylesheet" type="text/css" media="screen" href="<?php echo fileurl('/lib/js/jqgrid/css/ui.jqgrid.css');?>" />
<script src="<?php echo fileurl('/lib/js/jqgrid/js/i18n/grid.locale-en.js');?>" type="text/javascript"></script>
<script src="<?php echo fileurl('/lib/js/jqgrid/js/jquery.jqGrid.min.js');?>" type="text/javascript"></script>

<script type="text/javascript">
$("#grid").jqGrid({
   url: '<?php echo adminaction('/PilotLogins/getloginjson');?>',
   datatype: 'json',
   mtype: 'GET',
   colNames: ['', 'Pilot ID', 'First Name', 'Last Name', 'Date', 'IP Recorded', 'Client'],
   colModel : [
   		{index: 'id', name: 'id', hidden: true, search: false },
		{index: 'pilotid', name : 'pilotid', width: 10, sortable : true, align: 'center', search: 'true', searchoptions:{sopt:['eq','ne']}},
		{index: 'firstname', name : 'firstname', width: 20, sortable : true, align: 'center', search: 'true', searchoptions:{sopt:['eq','ne']}},
		{index: 'lastname', name : 'lastname', width: 20, sortable : true, align: 'center', search: 'true', searchoptions:{sopt:['eq','ne']}},
		{index: 'datestamp', name : 'datestamp', width: 15, sortable : true, align: 'center', search: 'true', searchoptions:{sopt:['eq','ne']}},
		{index: 'ip', name : 'ip', width: 20, sortable : true, align: 'center', searchoptions:{sopt:['eq','ne']}},
		{index: 'client', name : 'client', width: 35, sortable : true, align: 'center',searchoptions:{sopt:['eq','ne']}},
	],
    pager: '#pager', rowNum: 30,
    sortname: 'id', sortorder: 'desc',
    viewrecords: true, autowidth: true,
    height: '100%'
	
});

jQuery("#grid").jqGrid('navGrid','#pager', 
	{edit:false,add:false,del:false,search:true,refresh:true},
	{}, // edit 
	{}, // add 
	{}, //del 
	{multipleSearch:true} // search options 
); 
</script>