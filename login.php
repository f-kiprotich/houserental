<!DOCTYPE html>
<html lang="en">
<?php 
session_start();
include('./db_connect.php');
ob_start();
if(!isset($_SESSION['system'])){
	$system = $conn->query("SELECT * FROM system_settings limit 1")->fetch_array();
	foreach($system as $k => $v){
		$_SESSION['system'][$k] = $v;
	}
}
ob_end_flush();
?>
<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">
  <title><?php echo $_SESSION['system']['name'] ?></title>
  <?php include('./header.php'); ?>
  <?php 
    if(isset($_SESSION['login_id']))
      header("location:index.php?page=home");
  ?>
</head>
<style>
	body {
		width: 100%;
		height: calc(100%);
		background: #007bff;
	}
	main#main {
		width: 100%;
		height: calc(100%);
		background: white;
	}
	#login-right {
		position: absolute;
		right: 0;
		width: 40%;
		height: calc(100%);
		background: blueviolet;
		display: flex;
		align-items: center;
		justify-content: center;
	}
	#login-left {
		position: absolute;
		left: 0;
		width: 60%;
		height: calc(100%);
		background: blue;
		display: flex;
		align-items: center;
	}
	#login-right .card {
		width: 100%;
		max-width: 400px;
		padding: 2em;
		border-radius: 8px;
		box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
	}
	.logo {
		font-size: 8rem;
		background: white;
		padding: .5em 0.7em;
		border-radius: 50%;
		color: #000000b3;
	}
	h4 {
		color: #007bff;
		text-align: center;
		margin-bottom: 1em;
	}
	.form-group label {
		font-weight: bold;
		color: #333;
	}
	.form-control {
		border-radius: 4px;
	}
	.btn-primary {
		background-color: #007bff;
		border: none;
		width: 100%;
		padding: 0.75em;
		border-radius: 4px;
		font-size: 1em;
	}
	.btn-primary:hover {
		background-color: #0056b3;
	}
	.extra-links {
		text-align: center;
		margin-top: 1em;
	}
	.extra-links a {
		color: #007bff;
		margin: 0 0.5em;
		text-decoration: none;
	}
</style>
<body>

  <main id="main" class="bg-light">
  		<div id="login-left" class="bg-dark">
  		</div>

  		<div id="login-right" class="bg-light">
  			<div class="card">
  				<div class="card-body">
  					<h4><?php echo $_SESSION['system']['name'] ?></h4>
  					<form id="login-form">
  						<div class="form-group">
  							<label for="username">Username</label>
  							<input type="text" id="username" name="username" class="form-control" required>
  						</div>
  						<div class="form-group">
  							<label for="password">Password</label>
  							<input type="password" id="password" name="password" class="form-control" required>
  						</div>
  						<div class="form-group">
  							<label for="role">Role</label>
  							<select id="role" name="role" class="form-control" required>
  								<option value="admin">Administrator</option>
  								<option value="staff">Staff</option>
  							</select>
  						</div>
  						<button class="btn btn-primary btn-block">Login</button>
  					</form>
  					<div class="extra-links">
  						<a href="register.php">Sign Up</a> 
  						<a href="forgot_password.php">Forgot Password?</a>
  					</div>
  				</div>
  			</div>
  		</div>
  </main>

</body>
<script>
	$('#login-form').submit(function(e){
		e.preventDefault();
		$('#login-form button').attr('disabled', true).text('Logging in...');
		$.ajax({
			url: 'ajax.php?action=login',
			method: 'POST',
			data: $(this).serialize(),
			error: err => {
				console.log(err);
				$('#login-form button').removeAttr('disabled').text('Login');
			},
			success: function(resp) {
				if(resp == 1) {
					location.href = 'index.php?page=home';
				} else {
					$('#login-form').prepend('<div class="alert alert-danger">Username or password is incorrect.</div>');
					$('#login-form button').removeAttr('disabled').text('Login');
				}
			}
		})
	});
</script>	
</html>
