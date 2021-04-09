
<?php require_once '_header.php';?>

<!-- header -->
<div class="ballot-header">
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
	<div style="background-color: #f6f6f6;padding-top:13px;padding-bottom:13px;margin-top:-6px;margin-right:0;margin-left:0;" class="row">
		<div class="col-md-6" style="background-color: #f6f6f6;margin-top: -10px;">    
			<h4 style="padding-top: 10px;"><strong>Name : <?php echo $info!=null ? $info['name'] : ""; ?></strong></h4>
			<h4 style="padding-top: 10px;"><strong>Score : <?php echo $info!=null ? $info['score'].'/100' : ""; ?></strong></h4>	
		    <h4 style="padding-top: 10px;padding-bottom:12px;"><strong>Total number of correct answers : <?php echo $info3 == 0? '': $info3;?></strong></h4>
        </div>
		<div class="col-md-6" style="background-color: #f6f6f6;margin-top: -10px;">	
            <h4>TIEBREAKER QUESTIONS</h4>
			<h4>Film with the Most Oscars : 
            
            <select id="info1" style="height: 30px; border: 0; border-bottom: solid 1px;background-color: #f6f6f6;margin-left:10px;">
                <?php 
                    $array = ["1917", "Bombshell", "Ford v Ferrari", "Honeyland", "Jojo Rabbit", "Joker", "Judy", "Little Women", "Marriage Story", "Once Upon a Time in Hollywood", "Pain and Glory", "Parasite", "Star Wars: The Rise of Skywalker", "The Irishman", "The Two Popes"];
                    foreach($array as $value) {
                        if($value === $info1)
                            echo '<option value="'.$value.'" selected>'.$value.'</option>';
                        else
                            echo '<option value="'.$value.'">'.$value.'</option>';
                    }
                ?>
            </select>
            </h4>
			<h4>How many?
            <select id="info2" style="height: 30px; width: 160px; border: 0; border-bottom: solid 1px;background-color: #f6f6f6;margin-left:10px;">
                <?php
                    for($i = 1; $i <= 12; $i++) {
                        if ($i == $info2)
                            echo '<option value="'.$i.'" selected>'.$i.'</option>';
                        else
                            echo '<option value="'.$i.'">'.$i.'</option>';
                    }
                ?>
            </select>
            </h4>	
		</div>
	</div>
</div>

<!-- content -->
<div class="ballot-content">
<form id="form_user_problem" action="<?php echo base_url();?>home/setProblem" method="post">
	<div id="ballots">    
		<?php for ($i=0; $i<count($problems); $i++) { ?>
		<div class="ballot-box ballots-col3">
			<div class="ballot-sell-header"><h5><?php echo $problems[$i]['title'].' ('. $problems[$i]['score'].')'; ?></h5></div>
			<?php 
				for ($j=0; $j<count($problems[$i]['data']); $j++) { 
					
					$name = ($admin_answers=='') ? 'name="'.$i.'"' : '';
					$value = ($i>9) ? 'r'.$i.'000'.$j.'p' : 'r'.$i.'00'.$j.'p';
					$checked = (strpos($user_answers, $value)!==false || strpos($admin_answers, $value)!==false) ? 'checked' : '';
					$disabled = ($isLogin && $admin_answers!='') ? 'disabled' : '';
					$class = ($admin_answers!='') ? 
								(strpos($admin_answers, $value)!==false) ? 'radio-success':'radio-danger' : 
								'radio-primary';
					$percentItem = isset($percent[$i][$value]) ? $percent[$i][$value] : 0;
					
					echo '<div class="ballot-sell radio '.$class.'">';
					echo '<input  type="radio" '.$name.' id="radio'.$value.'" value="'.$value.'" '.$checked.' '.$disabled.' required="required">';
					echo '<label for="radio'.$value.'">'.$problems[$i]['data'][$j].'</label>';
                    echo '<div class="ballot-progress" data-progress="'.$percentItem.'"></div>';
                    echo '<span class="ballot-progress-sapn">'.$percentItem.'%</span>';
					echo '</div>';
					 
				}
			 ?>		
		</div>
		<?php } ?>
	</div>
	
	
	<div style="width:100%;text-align:center;background: #fafafa;margin-top: 15px;padding-top: 15px;padding-bottom: 10px;">
		<?php if ($admin_answers=='') { ?>
		<button type="button" class="btn btn-danger waves-effect w-md waves-light m-b-5" id="reset_user">Reset</button>
		<button type="submit" class="btn btn-success waves-effect w-md waves-light m-b-5">Submit to Server</button>
		<?php }?>
	</div>
	
</form>
</div>

<!-- footer -->
<div class="ballot-footer">
	<!--<h2>POPSUGAR</h2>
	<h4>@popsugar</h4>-->
</div>     

<style>
.ballot-sell {
    padding-top: 10px;
    padding-bottom: 10px;
    border-bottom: solid 1px #ddd;
    cursor: pointer;
}

.ballot-sell:hover{
    background: #efefef;
    opacity: 0.5;
}

.ballot-progress{
    position: absolute; 
    top: -2px; 
    left: 0; 
    width: 0%; 
    height: calc(100% - 1px);
    background: #aaa;
    opacity:0.2;
}

.ballot-progress-sapn{
    float: right;
    display: none;
}
</style>

<?php require_once '_footer.php';?>
