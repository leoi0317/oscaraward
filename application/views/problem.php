

<?php require_once '_header.php';?>	
								
<!-- header -->
<div class="ballot-header" style="padding-bottom:0">
	<div id="title" style="box-shadow: 0 3px 4px rgba(0,0,0,0.2);">
		<div class="ballot-header-login">
		<?php if (!$isLogin) { ?>
    		<div><a href="#" data-toggle="modal" data-target="#signin-modal">Sign In</a></div>
			<div style="margin-top:6px"><a href="#" data-toggle="modal" data-target="#signup-modal">Sign Up</a></div>
		<?php } else { ?>
			<div><a href="#" style="margin-left:20px" id="signOut">Sign Out</a></div>
			<div style="margin-top:6px"><a href="#" data-toggle="modal" data-target="#change-modal">Change Password</a></div>
		<?php }?>
		</div>
		<h2><? $year = date('Y'); 
            $ends = array('th','st','nd','rd','th','th','th','th','th','th');
            if (($year % 100) >= 11 && ($year%100) <= 13)
               $abbreviation = 'th';
            else
               $abbreviation = $ends[($year-1928) % 10];
            echo ($year-1928).$abbreviation; ?> Academy Awards</h2>
		<h1 class="header-title m-t-0 m-b-30"><?=date('Y')?> - OSCARS BALLOT</h1>										
		<p>Fill out your annual ballot with your predictions on who will take home the awards. Good luck.</p>
		<div id="triangle1" style="width: 0;height: 0;z-index:0;position:absolute;top:20px;left:10px"></div>
		<div id="triangle" style="width: 0;height: 0;z-index:0;position:absolute;top:20px;left:10px"></div>
	</div>
	
	<div class="ballot-menu">
		<div class="navbar">						
			<ul class="nav">
				<li style="float:left;"><a href="<?php echo base_url()?>admin/user">Users</a></li>
				<li style="float:right;border-bottom: solid 2px #c85b5f;" class="active"><a href="#">Answers</a></li>													
			</ul>
		</div>
	</div>
</div>

<!-- content -->
<div class="ballot-content">
<form id="form_admin_problem" action="<?php echo base_url();?>admin/setProblem" method="post">
	<div id="ballots">    
		<?php for ($i=0; $i<count($problems); $i++) { ?>
		<div class="ballot-box ballots-col3">
			<div class="ballot-sell-header"><h5><?php echo $problems[$i]['title'].' ('. $problems[$i]['score'].')'; ?></h5></div>
			<?php 
				for ($j=0; $j<count($problems[$i]['data']); $j++) { 
					
					$name = 'name="'.$i.'"';
					$value = ($i>9) ? 'r'.$i.'000'.$j.'p' : 'r'.$i.'00'.$j.'p';
					$checked = (strpos($admin_answers, $value)!==false) ? 'checked' : '';									
					
					echo '<div class="ballot-sell radio radio-primary">';
					echo '<input  type="radio" '.$name.' id="radio'.$value.'" value="'.$value.'" '.$checked.'>';
					echo '<label for="radio'.$value.'">'.$problems[$i]['data'][$j].'</label>';
					echo '</div>';
					 
				}
			 ?>			 
		</div>
		<?php } ?>		
	</div>
	
	<div style="width:100%;text-align:center;background: #fafafa;margin-top: 15px;padding-top: 15px;padding-bottom: 10px;">
		<button type="button" class="btn btn-danger waves-effect w-md waves-light m-b-5" id="reset_admin">Reset</button>
		<button type="submit" class="btn btn-success waves-effect w-md waves-light m-b-5">Save</button>
	</div>
</form>
</div>

<!-- footer -->
<div class="ballot-footer">
	<!--<h2>POPSUGAR</h2>
	<h4>@popsugar</h4>-->
</div>            

<?php require_once '_footer.php';?>
