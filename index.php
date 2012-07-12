<?php




if(!isset($_GET['action']))
{
	/************** list users   ****************/
	
	// include
        include 'header.php';
	echo '<div class="main_container white_bg">
			<div class="content">';
			
			
		echo '<ul class="pagination">
			<li><h2>You are here :</h2></li>
			<li><a href="#">Invited Users</a></li>
			</ul>';
			
	include 'ntfn.php';
	
	/********* calculate users list and total users **********/
	
	$totalFbInvited       = User::getTotalFbInvitedUsers();
	$totalEmailInvited    = User::getTotalEmailInvitedUsers();
	
	$pagination = new Pagination();
	$pgnArr     = $pagination->getPaginationData(5,5,'pagenum',$totalEmailInvited);
	$from = $pgnArr['from'];
	$to   = $pgnArr['to'];
	$lastpage = $pgnArr['lastpage'];
	$currentPage = $pgnArr['currentPage'];
	$pageLinksArr = $pgnArr['linksArr'];
	$arrInvitedUsers      = User::getEmailInvitedUsers($from,$to);
	
	echo '<pre>';print_r($pagnArr);echo '</pre>';
	
	?>
	
	<script>
		$(function() {
			$( "#datepicker_from" ).datepicker();
			$( "#datepicker_to" ).datepicker();
		});
	</script>

     <div> <h2>Total Invited Users (through Facebook + through Email): <?php echo $totalFbInvited + $totalEmailInvited;?></h2></div><br>
	<div>
		<div> <a target="_blank" href='index.php?page=genCSV&of_invited_users=1'><span class='blue'>Download CSV of All Invited Users</span></a></div><br>
		
		<table class='general_table'>
		
		<form action='index.php?page=genCSV&of_invited_users=1' method='post'>
				<tr>
					<th><span class='blue'>Download CSV of invited Users </span> From <input type='text' name='date_from' id='datepicker_from'> TO <input type='text' id='datepicker_to'name='date_to'>
				
				<input type='submit' class="grey_btn_simple m_r20" value="Download"></th></tr>
		</form>
		</table>
	</div>
	<div style='clear:both'></div><br><br>
	
	 <div><h2>List Of Users Invited Through Email </h2></div>
        <table class="general_table hr_sep12">
          <tr>
            <th>Name</th>    
            <th>Email</th>   
           
            <th>Time</th>   
             
          </tr>
		  
		  <?php
		  
		  if(is_array($arrInvitedUsers))
		  {
			foreach($arrInvitedUsers as $key => $user)
			  {
					$couponStatus = 'No';
					if($user['coupon_sent'] == '1')
					{
						$couponStatus = 'Yes';
					}
					
					$addTime = date('M d ,Y',$user['addtime']);
			  
					echo "<tr>
							<td>". $user['invited_name'] ."</td>    
							<td>". $user['invited_email'] ."</td> 
							<td>". $addTime ."</td>
							</tr>   ";
			  }
		  }
		  
		  ?>
		  
		  
       
      </table>
     
	 <table class="general_table hr_sep12">
	 <tr>
		<?php
		
			if(!empty($pageLinksArr) && !is_array($pageLinksArr) && count($pageLinksArr) > 1)
			{
				foreach($pageLinksArr as $key => $page)
				{
					if($currentPage == $page) 
					{
						echo '<th><a href="#">'.$page.'</a>';
					}
					else
					{
						echo '<th><a href="'.$baseUrl.'&pagenum='.$page.'">'.$page.'</a>';
					}
					
				}
				
				
			}
		
		?>
	 </tr>
	 </table>
	 
    </div>
  </div>
 
 <?php
 include 'footer.php';
 exit();
 }
 ?>
 