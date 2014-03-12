<?php
/*
* jika definisi Login tidak ada maka blank.
*/
if(!defined('Login')){
	die();
}

require_once('fa-config.php');

?>

<html>
	<head>
		<title> Login </title>
		<link type="text/css" rel="stylesheet" href="<?php stylesheet();?>" />
	<style>
	body{
		margin:0;
		padding: 0;
	}
	.form-login {
		text-align: center;
		padding: 10% 0;
	}
	.form-login form {
		position: relative;
		display: inline-block;
		padding: 40px;
	}
	.form-login .title {
    	margin: -40px -40px 0;
	    padding: 10px;
	    color: #fff;
	    font-weight: bold;
	}
	input{
		width: 100%;
		border:none;
		padding: 20px;
		outline: none;
	}
	.form-login .u, .form-login .p{
		width: 250px;
	}
	.form-login .u{
		border-left: 4px solid #2C3E50;
		margin-top: 30px;
		background: #FFF;
	}
	.form-login .p{
		border-left: 4px solid #2C3E50;
		background: #FFF;
		border-top: 1px solid #ccc;

	}
	.submit {
	    text-align: right;
	}
	.submit button,.submit .button {
	    padding: 8px 20px;
	    margin-top: 15px;
	}
	.submit .button{
		display: inline-block;
		cursor: pointer;
	}
	.credit{
		font-size: 12px;
	}
	.alert{
		display: inline-block;
		font-size: 12px;
		width: 200px;
		top: 30%;
	}
	.wrong{
		text-align: center;
		font-weight: bold;
		font-size: 14px;
		border: 1px solid #DDD;
		padding: 20px;
		background: #C7C7C7;
		position: absolute;
		top: -65px;
		left: 0;
		width: 87.5%;
		color: #CA4F4F;
		display: none;
	}
	</style>
	</head>
	
	<body class="concrete">
		<header></header>
		<article class="form-login">
		<form action="check_login.php" method="post" class="formlog peter-river">
			<div class="wrong"> </div>
			<div class="title midnight-blue"> LOGIN </div>
				<div class="u">
					<input type="text" name="user" placeholder="Username" >
				</div>
				<div class="p">
					<input type="password" name="pass" placeholder="Password" >
				</div>
				<div class="s">
					<div class="submit">
						<div class="button button-midnight login">Log In</div>
						<!-- <button class="button button-midnight login">Log In</button> -->
					</div>
				</div>
			</form>
			<p class="credit"> &copy; 2014 Fifa Development</p>
		</article>
		<footer></footer>
		<script src="<?php get_js();?>"></script>
		<script>
		jQuery(function($){
			jQuery('input').val('');

			jQuery('body').keyup(function(event) {
				if(event.keyCode == 13){
					jQuery('.login').trigger('click');
				}
			});

			jQuery('.login').on('click',function(){
				var usr  = jQuery('[name|="user"]');
				var pass = jQuery('[name|="pass"]');
				var url  = jQuery('form').attr('action');

				if( usr.val() == '' ){
					usr.parent().css('position', 'relative');
					usr.before('<span class="alert pumpkin">Username Tidak Boleh Kosong</span>');
					jQuery('.alert').css({
						'padding': '5px 10px',
						'position': 'absolute',
						'left' : usr.width()+'px',
					});
				}else if(pass.val() == ''){
					pass.parent().css('position','relative');
					pass.before('<span class="alert pumpkin">Password Tidak Boleh Kosong</span>');
					jQuery('.alert').css({
						'padding': '5px 10px',
						'position': 'absolute',
						'left' : pass.width()+'px',
					});
				}else{
					var sendData = $(this).parents('form').serialize();
					$.ajax({
						url:url,
						type:'post',
						data:sendData,
						success:function(result){
							if(result == 'error'){
								jQuery('.wrong').fadeIn('fast', function() {
									$(this).html('Username dan Password Salah');
								});
							}else{
								window.location=result;
								
							}
						}
					});
					return false;
				}

				jQuery(usr).focus(function() {
					$(this).parent().children('.alert').fadeOut('slow');	
				});

				jQuery(pass).focus(function() {
					$(this).parent().children('.alert').fadeOut('slow');	
				});

				
			});
		});
		</script>
	</body>
</html>
