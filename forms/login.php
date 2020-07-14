<?php
$page_title = "Log In";
include_once $_SERVER['DOCUMENT_ROOT'] . '/web-assets/tpl/app_header.php';

if (isset($_SESSION['customer_id'])) {
  header("Location: ../dashboard.php");
}
?>
<h1><?php echo $page_title ?></h1>

<form id="login" method="post" action="../index.php?action=login" class="needs-validation" novalidate>
  <div class="alert alert-info my-4" role="alert">Don't have an account? <a href="/collegePlanner/forms/signup.php">Sign Up</a></div>
  <div class="card border-info">
    <div class="card-header">Log In</div>
    <div class="card-body">
      <?php
      if (isset($_REQUEST['alert'])) {
        switch($_REQUEST['alert']) {
          case 'wronglogin':
            echo "<div class='alert alert-danger' role='alert'>The username and password combination did not match.</div>";
          break;
        }
      } else {
        echo "<div class='alert alert-primary alert-dismissible'>Please enter your username and password to log in.</div>";
      }
      ?>
      <!-- Username -->
      <div class="form-group row">
        <label for="username" class="col-sm-2">Username</label>
        <div class= "col-md-6">
          <input type="text" class="form-control" id="username" name="username" required>
        </div>
      </div>
      <!-- Password -->
      <div class="form-group row">
        <label for="password" class="col-sm-2">Password</label>
        <div class= "col-md-6">
          <input type="password" class="form-control" id="password" name="password" required>
        </div>
      </div>

      <div class="form-group row">
        <div class= "col-md-6">
          <button type="submit" class="btn btn-lg btn-primary">Login</button>
        </div>
      </div>
    </div>
  </div>
</form>
