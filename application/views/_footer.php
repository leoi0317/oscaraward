</div></div></div>
<!-- End of Row -->
</div> <!-- container -->
</div> <!-- content -->                

</div></div>    

<?php require_once '_modal.php';?>    

<!-- jQuery  -->
<script src="<?php echo base_url()?>assets/js/jquery.min.js"></script>
<script src="<?php echo base_url()?>assets/js/bootstrap.min.js"></script>
<script src="<?php echo base_url()?>assets/js/detect.js"></script>
<script src="<?php echo base_url()?>assets/js/fastclick.js"></script>
<script src="<?php echo base_url()?>assets/js/jquery.slimscroll.js"></script>
<script src="<?php echo base_url()?>assets/js/jquery.blockUI.js"></script>
<script src="<?php echo base_url()?>assets/js/waves.js"></script>
<script src="<?php echo base_url()?>assets/js/jquery.nicescroll.js"></script>
<script src="<?php echo base_url()?>assets/js/jquery.scrollTo.min.js"></script>

<!-- Modal-Effect -->
<script src="<?php echo base_url()?>assets/plugins/custombox/dist/custombox.min.js"></script>
<script src="<?php echo base_url()?>assets/plugins/custombox/dist/legacy.min.js"></script>

<!-- Responsive-table-->
<script src="<?php echo base_url()?>assets/plugins/RWD-Table-Patterns/dist/js/rwd-table.min.js" type="text/javascript"></script>
<script src="<?php echo base_url()?>assets/plugins/magnific-popup/dist/jquery.magnific-popup.min.js"></script>
<script src="<?php echo base_url()?>assets/plugins/jquery-datatables-editable/jquery.dataTables.js"></script>
<script src="<?php echo base_url()?>assets/plugins/datatables/dataTables.bootstrap.js"></script>
<script src="<?php echo base_url()?>assets/plugins/tiny-editable/mindmup-editabletable.js"></script>
<script src="<?php echo base_url()?>assets/plugins/tiny-editable/numeric-input-example.js"></script>
<script src="<?php echo base_url()?>assets/pages/datatables.editable.init.js"></script>

<!-- Validation js -->
<script type='text/javascript' src='<?php echo base_url();?>assets/plugins/validationengine/languages/jquery.validationEngine-en.js'></script>
<script type='text/javascript' src='<?php echo base_url();?>assets/plugins/validationengine/jquery.validationEngine.js'></script>        
<script type='text/javascript' src='<?php echo base_url();?>assets/plugins/jquery-validation/jquery.validate.js'></script> 

<!-- Toastr js -->
<script src="<?php echo base_url();?>assets/plugins/toastr/toastr.min.js"></script>

<script src="<?php echo base_url()?>assets/js/jquery.masonry.js"></script>

<!-- App js -->
<script src="<?php echo base_url()?>assets/js/jquery.core.js"></script>
<script src="<?php echo base_url()?>assets/js/jquery.app.js"></script>

<script>
	var resizefunc = [];

	var form_validate1 = $("#form_signin").validate({ ignore:[], rules:{
			in_email:{required:true, email:true, minlength:0, maxlength:255},
			in_pwd  :{required:true, minlength:0, maxlength:50}
		}
	});

	$("#form_signin").submit(function(event){
		event.preventDefault();
        if (form_validate1['successList'].length<2) return;
		$.post( "<?php echo base_url();?>admin/signIn", {email:$("#in_email").val(),pwd:$("#in_pwd").val()}, function(data) {
			var result = jQuery.parseJSON(data);
			
	    	if (result.state == false) {
                toastr.clear();
	    		toastr.options = {
	    				  "closeButton": false,
	    				  "debug": false,
	    				  "newestOnTop": false,
	    				  "progressBar": false,
	    				  "positionClass": "toast-top-right",
	    				  "preventDuplicates": false,
	    				  "onclick": null,
	    				  "showDuration": "300",
	    				  "hideDuration": "1000",
	    				  "timeOut": "5000",
	    				  "extendedTimeOut": "1000",
	    				  "showEasing": "swing",
	    				  "hideEasing": "linear",
	    				  "showMethod": "fadeIn",
	    				  "hideMethod": "fadeOut"
	    				};
	    		toastr["error"](result.msg, "LogIn Error");
	    		
	    	} else {
	    		$("#regForm").unbind('submit').submit();

	    		$(location).attr('href', result.url);
	    	}
    	});
	});

	var form_validate2 = $("#form_signup").validate({ ignore:[], rules:{
			up_name :{required:true, minlength:0, maxlength:255},
			up_email:{required:true, email:true, minlength:0, maxlength:255},
			up_pwd  :{required:true, minlength:0, maxlength:50},
			confirm_pwd  :{equalTo:"#up_pwd", minlength:0, maxlength:50}
		}
	});

	$("#form_signup").submit(function(event){
		event.preventDefault();
        if (form_validate2['successList'].length<4) return;
		$.post( "<?php echo base_url();?>admin/signUp", {name:$("#up_name").val(),email:$("#up_email").val(),pwd:$("#up_pwd").val()}, function(data) {
			var result = jQuery.parseJSON(data);
			
	    	if (result.state == false) {
                toastr.clear();
	    		toastr.options = {
	    				  "closeButton": false,
	    				  "debug": false,
	    				  "newestOnTop": false,
	    				  "progressBar": false,
	    				  "positionClass": "toast-top-right",
	    				  "preventDuplicates": false,
	    				  "onclick": null,
	    				  "showDuration": "300",
	    				  "hideDuration": "1000",
	    				  "timeOut": "5000",
	    				  "extendedTimeOut": "1000",
	    				  "showEasing": "swing",
	    				  "hideEasing": "linear",
	    				  "showMethod": "fadeIn",
	    				  "hideMethod": "fadeOut"
	    				};
	    		toastr["error"](result.msg, "SignUp Error");
	    		
	    	} else {
	    		$("#regForm").unbind('submit').submit();

	    		$(location).attr('href', '<?php echo base_url();?>');
	    	}
    	});
	});

	var form_validate3 = $("#form_changePwd").validate({ ignore:[], rules:{
			new_pwd :{required:true, minlength:0, maxlength:50},
			old_pwd:{required:true, minlength:0, maxlength:50},
			confirm_new_pwd  :{required:true, equalTo:"#new_pwd", minlength:0, maxlength:50}
		}
	});

	$("#form_changePwd").submit(function(event){
		event.preventDefault();
        if (form_validate3['successList'].length<3) return;
		$.post( "<?php echo base_url();?>admin/changePassword", {old_pwd:$("#old_pwd").val(),new_pwd:$("#new_pwd").val()}, function(data) {
			var result = jQuery.parseJSON(data);
			
	    	if (result.state == false) {
                toastr.clear();
	    		toastr.options = {
	    				  "closeButton": false,
	    				  "debug": false,
	    				  "newestOnTop": false,
	    				  "progressBar": false,
	    				  "positionClass": "toast-top-right",
	    				  "preventDuplicates": false,
	    				  "onclick": null,
	    				  "showDuration": "300",
	    				  "hideDuration": "1000",
	    				  "timeOut": "5000",
	    				  "extendedTimeOut": "1000",
	    				  "showEasing": "swing",
	    				  "hideEasing": "linear",
	    				  "showMethod": "fadeIn",
	    				  "hideMethod": "fadeOut"
	    				};
	    		toastr["error"](result.msg, "SignUp Error");
	    		
	    	} else {
		    	toastr.clear();
	    		toastr.options = {
	    				  "closeButton": false,
	    				  "debug": false,
	    				  "newestOnTop": false,
	    				  "progressBar": false,
	    				  "positionClass": "toast-top-right",
	    				  "preventDuplicates": false,
	    				  "onclick": null,
	    				  "showDuration": "300",
	    				  "hideDuration": "1000",
	    				  "timeOut": "5000",
	    				  "extendedTimeOut": "1000",
	    				  "showEasing": "swing",
	    				  "hideEasing": "linear",
	    				  "showMethod": "fadeIn",
	    				  "hideMethod": "fadeOut"
	    				};
	    		toastr["success"](result.msg, "Success");
	    	}
    	});
	});

	$("#form_user_problem").submit(function(event){
		event.preventDefault();

		var isLogin = '<?php echo $isLogin;?>';		

		if (isLogin == '1') {

			var formData = JSON.stringify($("#form_user_problem").serializeArray());
			
			$.post( "<?php echo base_url();?>home/setProblem", {problems:formData,info1:$('#info1').val(), info2:$('#info2').val()}, function(data) {
				$(location).attr('href', '<?php echo base_url();?>');
	    	});	    	
			
		} else {
            toastr.clear();
			toastr.options = {
	  				  "closeButton": false,
	  				  "debug": false,
	  				  "newestOnTop": false,
	  				  "progressBar": false,
	  				  "positionClass": "toast-top-right",
	  				  "preventDuplicates": false,
	  				  "onclick": null,
	  				  "showDuration": "300",
	  				  "hideDuration": "1000",
	  				  "timeOut": "5000",
	  				  "extendedTimeOut": "1000",
	  				  "showEasing": "swing",
	  				  "hideEasing": "linear",
	  				  "showMethod": "fadeIn",
	  				  "hideMethod": "fadeOut"
	  				};
	  			toastr["error"]("You have to sign in first.", "Warning");			
		}
	});

	$("#form_admin_problem").submit(function(event){
		event.preventDefault();

		var formData = JSON.stringify($("#form_admin_problem").serializeArray());

		$.post( "<?php echo base_url();?>admin/setProblem", {problems:formData}, function(data) {
			$(location).attr('href', data);
    	});
	});

	$("#signOut").on("click", function() {
		$.post( "<?php echo base_url();?>admin/signOut", {}, function(data) {
			$(location).attr('href', '<?php echo base_url();?>');
    	});
	});

	$("#reset_user").on("click", function() {
		var isLogin = '<?php echo $isLogin;?>';

		if (isLogin == '1') {
			$.post( "<?php echo base_url();?>home/setReset", {}, function(data) {
				$(location).attr('href', '<?php echo base_url();?>');
	    	});				
		} else {
            toastr.clear();
			toastr.options = {
  				  "closeButton": false,
  				  "debug": false,
  				  "newestOnTop": false,
  				  "progressBar": false,
  				  "positionClass": "toast-top-right",
  				  "preventDuplicates": false,
  				  "onclick": null,
  				  "showDuration": "300",
  				  "hideDuration": "1000",
  				  "timeOut": "5000",
  				  "extendedTimeOut": "1000",
  				  "showEasing": "swing",
  				  "hideEasing": "linear",
  				  "showMethod": "fadeIn",
  				  "hideMethod": "fadeOut"
  				};
  			toastr["error"]("You have to sign in first.", "Warning");	
		}
	});

	$("#reset_admin").on("click", function() {
		$.post( "<?php echo base_url();?>admin/setReset", {}, function(data) {
			$(location).attr('href', data);
    	});		
	});
	
	$(document).ready(function() {
		var $container = $('#ballots');
		$container.imagesLoaded(function () {
			$container.masonry({
				itemSelector: '.ballot-box',
				isFitWidth: true,
				isAnimated: true
			});
		});      
        
		
		var windowWidth = $(window).width();
		$("#triangle1").css({
			"border-top": $("#title").height()*0.9 + 'px solid rgba(0, 0, 0, 1)'
		});
		$("#triangle1").css({
			"border-right": windowWidth / 5 + 'px solid transparent'
		});
		$("#triangle").css({
			"border-top": $("#title").height() + 'px solid rgba(213, 167, 51, 1)'
		});
		$("#triangle").css({
			"border-right": windowWidth / 8 + 'px solid transparent'
		});
	});
	
	$(window).resize(function () {
		var windowWidthR = $(window).width();
		$("#triangle1").css({
			"border-top": $("#title").height()*0.9 + 'px solid rgba(0, 0, 0, 1)'
		});
		$("#triangle1").css({
			"border-right": windowWidthR / 5 + 'px solid transparent'
		});
		$("#triangle").css({
			"border-top": $("#title").height() + 'px solid rgba(213, 167, 51, 1)'
		});
		$("#triangle").css({
			"border-right": windowWidthR / 8 + 'px solid transparent'
		});
	});

	function onDeleteUser(user_id) {
		var confirm_dlg = confirm("Are you sure delete?");

		if (confirm_dlg == true) {
			$.post( "<?php echo base_url();?>admin/deleteUser", {id:user_id}, function(data) {
				$(location).attr('href', data);
	    	});	
		}
	}

	$(".ballot-sell").click(function(){
    
    	$(this).find('input').attr('checked', 'checked');
        /*
		var parent = $(this).parent();
		var childs = parent.find('.ballot-sell .ballot-progress');
		childs.each(function( i, val ) {
		  var percent = $(this).data("progress");
		  $(this).animate({
		  	width: percent+"%"
		  });
		});
        
        var childs = parent.find('.ballot-sell .ballot-progress-sapn');
    	childs.each(function( i, val ) {
		  $(this).show();
		});*/
	});

</script>
		
</body>
</html>