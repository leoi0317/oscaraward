<!-- SignIn Modal -->
<form id="form_signin" action="<?php echo base_url();?>/admin/signIn" method="post">
<div id="signin-modal" class="modal fade bs-example-modal-sm" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
	<div class="modal-dialog modal-sm">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
				<h3 class="modal-title">Log In</h3>
			</div>
			<div class="modal-body">
				<div class="row">
					<div class="col-xs-12">
						<div class="form-group">
							<label for="field-1" class="control-label">Email</label>
							<input type="text" class="form-control" id="in_email" name="in_email" placeholder="Email Address">
						</div>
					</div>							
				</div>
				<div class="row">
					<div class="col-xs-12">
						<div class="form-group">
							<label for="field-3" class="control-label">Password</label>
							<input type="password" class="form-control" id="in_pwd" name="in_pwd" placeholder="Password">
						</div>
					</div>
				</div>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-default waves-effect" data-dismiss="modal">Close</button>
				<button type="submit" class="btn btn-info waves-effect waves-light">Log In</button>
			</div>
		</div>
	</div>
</div>
</form>
<!-------->	

<!-- SignUp Modal -->
<form id="form_signup" action="<?php echo base_url();?>/admin/signOut" method="post">
<div id="signup-modal" class="modal fade bs-example-modal-sm" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
	<div class="modal-dialog modal-sm">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
				<h3 class="modal-title">Sign Up</h3>
			</div>
			<div class="modal-body">
				<div class="row">
					<div class="col-xs-12">
						<div class="form-group">
							<label for="field-1" class="control-label">Name</label>
							<input type="text" class="form-control" id="up_name" name="up_name" placeholder="Your Name">
						</div>
					</div>							
				</div>
				<div class="row">
					<div class="col-xs-12">
						<div class="form-group">
							<label for="field-1" class="control-label">Email</label>
							<input type="text" class="form-control" id="up_email" name="up_email" placeholder="Email Address">
						</div>
					</div>							
				</div>
				<div class="row">
					<div class="col-xs-12">
						<div class="form-group">
							<label for="field-3" class="control-label">Password</label>
							<input type="password" class="form-control" id="up_pwd" name="up_pwd" placeholder="Password">
						</div>
					</div>
				</div>
				<div class="row">
					<div class="col-xs-12">
						<div class="form-group">
							<label for="field-3" class="control-label">Confirm Password</label>
							<input type="password" class="form-control" id="confirm_pwd" name="confirm_pwd" placeholder="Confirm Password">
						</div>
					</div>
				</div>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-default waves-effect" data-dismiss="modal">Close</button>
				<button type="submit" class="btn btn-info waves-effect waves-light">Sign Up</button>
			</div>
		</div>
	</div>
</div>
</form>
<!-------->		

<!-- ChangePassword Modal -->
<form id="form_changePwd" action="<?php echo base_url();?>/admin/changePassword" method="post">
<div id="change-modal" class="modal fade bs-example-modal-sm" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
	<div class="modal-dialog modal-sm">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
				<h3 class="modal-title">Change Password</h3>
			</div>
			<div class="modal-body">
				<div class="row">
					<div class="col-xs-12">
						<div class="form-group">
							<label for="field-1" class="control-label">Old Password</label>
							<input type="password" class="form-control" id="old_pwd" name="old_pwd" placeholder="Old Password">
						</div>
					</div>							
				</div>
				<div class="row">
					<div class="col-xs-12">
						<div class="form-group">
							<label for="field-1" class="control-label">New Password</label>
							<input type="password" class="form-control" id="new_pwd" name="new_pwd" placeholder="New Password">
						</div>
					</div>							
				</div>
				<div class="row">
					<div class="col-xs-12">
						<div class="form-group">
							<label for="field-3" class="control-label">Confirm Password</label>
							<input type="password" class="form-control" id="confirm_new_pwd" name="confirm_new_pwd" placeholder="Confirm Password">
						</div>
					</div>
				</div>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-default waves-effect" data-dismiss="modal">Close</button>
				<button type="submit" class="btn btn-info waves-effect waves-light">Save</button>
			</div>
		</div>
	</div>
</div>
</form>
<!-------->	

<!-- User Delete Modal -->
<div id="dialog" class="modal-block mfp-hide">
				<section class="panel panel-info panel-color">
					<header class="panel-heading">
						<h2 class="panel-title">Are you sure?</h2>
					</header>
					<div class="panel-body">
						<div class="modal-wrapper">
							<div class="modal-text">
								<p>Are you sure that you want to delete this row?</p>
							</div>
						</div>

						<div class="row m-t-20">
							<div class="col-md-12 text-right">
								<button id="dlg_confirm" class="btn btn-primary waves-effect waves-light">Confirm</button>
								<button id="dlg_cancel" class="btn btn-default waves-effect">Cancel</button>
							</div>
						</div>
					</div>

				</section>
			</div>
<!--  -->