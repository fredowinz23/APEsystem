<?php
if (!defined('WEB_ROOT')) {
	exit;
}


$search = (isset($_GET['search']) && $_GET['search'] > '') ? $_GET['search'] : '';

$sql = "SELECT s_id, s_teacher, s_room, s_subject , s_class , s_from , s_to, s_m, s_t, s_w, s_th, s_f, s_s FROM tbl_schedule
		ORDER BY s_from";
$result = dbQuery($sql);
$date = date('Y-m-d');	
?> 
<table id="rounded-corner" summary="2007 Major IT Companies' Profit">
           
                                
                                <form action="processUser.php?action=addUser" method="post"  name="frmListUser" id="frmListUser">

        <thead>
    	<tr>
            <th scope="col" class="rounded-company" width="20%">Teacher</th>
            <th scope="col" class="rounded" >Room</th>
            <th scope="col" class="rounded" >Class</th>
            <th scope="col" class="rounded" width="20%">Check</th>
        </tr>
    </thead>

<?php
while($row = dbFetchAssoc($result)) {
	extract($row);
	
	if ($i%2) {
		$class = 'row1';
	} else {
		$class = 'row2';
	}
	
	$tsql = "SELECT *
        FROM tbl_user where user_name='$s_teacher'";
		$tresult = mysql_query($tsql);
		$tshow = mysql_fetch_array($tresult);	
		$tfname= $tshow['user_fname'];
		$tlname= $tshow['user_lname'];
	

	$asql = "SELECT *
        FROM tbl_sematt where a_teacher='$s_teacher'";
		$aresult = mysql_query($asql);
		$ashow = mysql_fetch_array($aresult);
		$acount = mysql_num_rows($aresult);	
		$astatus= $ashow['a_status'];
		$aid= $ashow['a_id'];
		
	
	
	$i += 1;
?>
  <tr class="<?php echo $class; ?>"> 
   <td><?php echo $tfname; ?> <?php echo $tlname; ?></td>
   <td><?php echo $s_room; ?></td>
   <td><?php echo $s_class; ?> <br>(<?php echo $s_subject; ?>)</td>
   
   <?
   if ($acount == 0){
   ?>
   
   <td width="120" align="center"><a href="javascript:addSchedule(<?php echo $s_id; ?>);" class="ico edit"><img src="<?php echo WEB_ROOT; ?>admin/include/images/user_edit.png" alt="" title="" border="0" /></a></td>
   <?
   }
   else
   {
   ?>
     <td width="300" align="center"><font color=red><? echo $astatus;?></font> - 
     <a href="javascript:modifySchedule(<?php echo $s_id; ?>,<?php echo $aid; ?>);" class="ico edit"><img src="<?php echo WEB_ROOT; ?>admin/include/images/user_edit.png" alt="" title="" border="0" /></a></td>
   
   <?
   }
   ?>
   
   
   
  </tr>
<?php
} // end while

?>
  <tr> 
   <td colspan="6">&nbsp;</td>
  </tr>

 </table>
 
<input type="button" value="print" onclick="location.href='<?php echo WEB_ROOT;?>"admin/attendance/index.php?view=print&search=/?php echo $search;?>'