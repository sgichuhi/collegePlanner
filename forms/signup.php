<?php
$page_title = "Sign Up";
include_once $_SERVER['DOCUMENT_ROOT'] . '/bdpa-loans/web-assets/tpl/app_header.php';
include_once $_SERVER['DOCUMENT_ROOT'] . '/bdpa-loans/web-assets/tpl/app_nav.php';

if (isset($_SESSION['customer_id'])) {
  header("Location: ../dashboard.php");
}
?>
<h1><?php echo $page_title ?></h1>
<div class="alert alert-info my-4" role="alert">Already have an account? <a href="/bdpa-loans/forms/login.php">Log In</a></div>
        <div class="card my-4 mx- border-info">

            <div class="card-header">Sign Up</div>
            <div class="card-body">
                <form action="/bdpa-loans/index.php?action=signup" method="post">
                    <!--Email-->
                    <div class="form-group row">
                        <label for="email" class="col-sm-3">Email</label>
                        <input type="email" class="form-control col-sm-9" name="email_id" required>
                    </div>
                    <!--Password-->
                    <div class="form-group row">
                        <label for="password" class="col-sm-3">Password</label>
                        <input type="password" class="form-control col-sm-9" name="pw" required>
                    </div>
                    <!--First Name-->
                    <div class="form-group row">
                        <label for="username" class="col-sm-3">First Name</label>
                        <input type="text" class="form-control col-sm-9" name="fname" required>
                    </div>
                    <!--Last Name-->
                    <div class="form-group row">
                        <label for="username" class="col-sm-3">Last Name</label>
                        <input type="text" class="form-control col-sm-9" name="lname" required>
                    </div>
                    <!--Address-->
                    <div class="form-group row">
                        <label for="username" class="col-sm-3">Address</label>
                        <input type="text" class="form-control col-sm-9" name="address" required>
                    </div>
                    <!--City-->
                    <div class="form-group row">
                        <label for="username" class="col-sm-3">City</label>
                        <input type="text" class="form-control col-sm-9" name="city" required>
                    </div>
                    <!--State-->
                    <div class="form-group row">
                        <label for="username" class="col-sm-3">State</label>
                        <input type="text" class="form-control col-sm-9" name="state" required>
                    </div>
                    <!--Zip-->
                    <div class="form-group row">
                        <label for="username" class="col-sm-3">Zip Code</label>
                        <input type="text" class="form-control col-sm-9" name="zip" required>
                    </div>
                    <!--Telephone-->
                    <div class="form-group row">
                        <label for="username" class="col-sm-3">Telephone</label>
                        <input type="text" class="form-control col-sm-9" name="telephone" required>
                    </div>
                    <!--Cell Phone-->
                    <div class="form-group row">
                        <label for="username" class="col-sm-3">Cell Phone</label>
                        <input type="text" class="form-control col-sm-9" placeholder="###-###-####" name="cellphone" required>
                    </div>
                    <!--Company-->
                    <div class="form-group row">
                        <label for="username" class="col-sm-3">Company</label>
                        <input type="text" class="form-control col-sm-9" name="company" required>
                    </div>
                    <!--Yearly Salary-->
                    <div class="form-group row">
                        <label for="username" class="col-sm-3">Yearly Salary</label>
                        <input type="text" class="form-control col-sm-9" name="yearlysalary" required>
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


<!--

Username
Password
First Name
Last Na,e
Address
City
State
Zip
Telephone
Cellphone
company
comp adress
comp city
comp state
comp zip
comp tel
type
yearly salary

    [[[[[[[[[[[[[[[      ]]]]]]]]]]]]]]]
    [::::::::::::::      ::::::::::::::]
    [::::::::::::::      ::::::::::::::]
    [::::::[[[[[[[:      :]]]]]]]::::::]
    [:::::[                      ]:::::]
    [:::::[                      ]:::::]
    [:::::[                      ]:::::]
    [:::::[                      ]:::::]
    [:::::[     CODE THE WEB     ]:::::]
    [:::::[  http://brackets.io  ]:::::]
    [:::::[                      ]:::::]
    [:::::[                      ]:::::]
    [:::::[                      ]:::::]
    [:::::[                      ]:::::]
    [::::::[[[[[[[:      :]]]]]]]::::::]
    [::::::::::::::      ::::::::::::::]
    [::::::::::::::      ::::::::::::::]
    [[[[[[[[[[[[[[[      ]]]]]]]]]]]]]]]

-->
