
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
		<h2><?php $year = date('Y'); 
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
				<li style="float:left;border-bottom: solid 2px #c85b5f;" class="active">
						<a href="#">Users</a>
				</li>
				<li style="float:right;"><a href="<?php echo base_url()?>admin/problem">Answers</a></li>													
			</ul>
		</div>
	</div>
</div>

<!-- content -->
<div class="ballot-content" style="padding-top:25px; padding-bottom:20px">
	<div class="panel"><div class="panel-body">
	<div class="table-rep-plugin">
	<div class="table-responsive b-0">
		<table class="table table-striped" id="datatable-editable">
			<thead>
				<tr>
					<th>Name</th>
					<th data-priority="6">Email</th>
					<th data-priority="6">Score</th>
                    <th data-priority="6">Number of Correct Categories</th>
                    <th data-priority="6">Most Oscars?</th>
    				<th data-priority="6">How many?</th>
					<th data-priority="6">Last Update</th>
					<th data-priority="3">Actions</th>
				</tr>
			</thead>
			<tbody>
			<?php if (!empty($list)) { foreach ($list as $item) { ?>
				<tr class="gradeX">
					<td><?php echo $item['name']; ?></td>
					<td><?php echo $item['email']; ?></td>
					<td><?php echo $item['score']; ?></td>
                    <td><?php echo $item['correct_categories']; ?></td>
                    <td><?php echo $item['info1']; ?></td>
    				<td><?php echo $item['info2']; ?></td>
					<td><?php echo $item['lastUpdate']; ?></td>
					<td class="actions">
						<a href="#" class="hidden on-editing cancel-row"><i class="fa fa-times"></i></a>
						<a href="#" class="on-default remove-row" onclick="onDeleteUser('<?php echo $item['id']; ?>')"><i class="fa fa-trash-o"></i></a>
					</td>
				</tr>	
			<?php }} ?>			
			</tbody>
		</table>
	</div>
	</div>
	</div></div>
</div>

<!-- footer -->
<div class="ballot-footer">
	<!--<h2>POPSUGAR</h2>
	<h4>@popsugar</h4>-->
</div>   
                                 
<?php require_once '_footer.php';?>