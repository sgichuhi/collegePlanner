<?php
$page_title = "Sign Up";
include_once $_SERVER['DOCUMENT_ROOT'] . '/web-assets/tpl/app_header.php';

if (isset($_SESSION['customer_id'])) {
  header("Location: ../dashboard.php");
}
?>
<h1><?php echo $page_title ?></h1>
<div class="alert alert-info my-4" role="alert">Already have an account? <a href="/collegePlanner/forms/login.php">Log In</a></div>
        <div class="card my-4 mx- border-info">

            <div class="card-header">Sign Up</div>
            <div class="card-body">
                <form action="/index.php?action=signup" method="post">
                    <!--Username-->
                    <div class="form-group row">
                        <label for="username" class="col-sm-3">Username</label>
                        <input type="text" class="form-control col-sm-9" name="username" required>
                    </div>
                    <!--Password-->
                    <div class="form-group row">
                        <label for="password" class="col-sm-3">Password</label>
                        <input type="password" class="form-control col-sm-9" name="password" required>
                    </div>
                    <!--First Name-->
                    <div class="form-group row">
                        <label for="firstname" class="col-sm-3">First Name</label>
                        <input type="text" class="form-control col-sm-9" name="firstname" required>
                    </div>
                    <!--Last Name-->
                    <div class="form-group row">
                        <label for="lastname" class="col-sm-3">Last Name</label>
                        <input type="text" class="form-control col-sm-9" name="lastname" required>
                    </div>
                    <div class="form-group row">
                      <div class= "col-md-6">
                        <button type="submit" class="btn btn-lg btn-primary">Sign Up</button>
                      </div>
                    </div>
            </div>
        </div>
<?php
    include_once $_SERVER['DOCUMENT_ROOT'] . '/web-assets/tpl/app_footer.php';
?>