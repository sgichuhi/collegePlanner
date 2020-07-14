<?php
session_start();
include_once $_SERVER['DOCUMENT_ROOT'] . "/collegePlanner/db.php";

$action = isset($_REQUEST['action']) ? $_REQUEST['action'] : null;

$options = array (
    'signup' => 'signup',
    'login' => 'login',
    'references' => 'references',
    'editprofile' => 'editprofile',
    'logout' => 'logout'
);

if (array_key_exists($action, $options)) {
    $function = $options[$action];
    call_user_func($function);
} else {
    header("Location: forms/login.php");
}

//Valid Password
// function validPassword($pw) {
//   if (!preg_match_all('$\S*(?=\S{8,})(?=\S*[a-z])(?=\S*[A-Z])(?=\S*[\d])(?=\S*[\W])\S*$', $pw)) {
//     return false;
//   } else {
//     return true;
//   }
// }

//Sign Up Form
function signup() {
    global $dbh;
    $email = $_REQUEST['email_id'];
    $pw = $_REQUEST['pw']; $pw = password_hash($pw, PASSWORD_DEFAULT);
    $fname = $_REQUEST['fname'];
    $lname = $_REQUEST['lname'];
    $address = $_REQUEST['address'];
    $city = $_REQUEST['city'];
    $state = $_REQUEST['state'];
    $zip = $_REQUEST['zip'];
    $telephone = $_REQUEST['telephone'];
    $cellphone = $_REQUEST['cellphone'];
    $company = $_REQUEST['company'];
    $cust_yr_salary = $_REQUEST['yearlysalary'];

    if (validPassword($pw)) {
      $sql = <<<SQL
      INSERT INTO customers(email_id, login_pw, first_name, last_name, address_line_one, city_name, state_cd, postal_cd, pri_phone, alt_phone, employer_name, annual_income)
      VALUES("$email", "$pw","$fname", "$lname", "$address", "$city", "$state", "$zip", "$telephone", "$cellphone", "$company", $cust_yr_salary);
SQL;

      $result = $dbh->query($sql);

      if ($result) {
        $_SESSION['email'] = $email;

        $customer_id_sql = <<<SQL
        SELECT customer_id FROM customers WHERE email_id = "$email";
SQL;
        $customer_id_result = $dbh->query($customer_id_sql);
        while ($customer_id_row = $customer_id_result->fetch_assoc()) {
          $_SESSION['customer_id'] = $customer_id_row['customer_id'];
        }

        header("Location: dashboard.php");
      } else {
        echo ("It didn't work.") . mysqli_error($dbh);
      }

    }

}

//Login Function
function login() {
    global $dbh;

    $email = $_REQUEST['email_id'];
    $pw = $_REQUEST['pw'];

    $sql = <<<SQL
        SELECT * FROM customers WHERE email_id = "$email";
SQL;

    $result = $dbh->query($sql);

    while ($row = $result->fetch_assoc()) {
        $hashed_pw = $row['login_pw'];
        $before_login_check_id = $row['customer_id'];
        $before_login_check_email = $row['email_id'];
    }

    if (!isset($hashed_pw)) {
      echo "The password was incorrect.";
    }

    if (password_verify($pw, $hashed_pw)) {
        header("Location: dashboard.php"); //Changed to a redirect because refreshing the page would cause issues.
        $_SESSION['customer_id'] = $before_login_check_id;
        $_SESSION['email'] = $before_login_check_email;
    } else {
        header("Location: forms/login.php?alert=wronglogin");
    }
}

//Loan App Function
function loanapp() {
    global $dbh;
    $email = $_SESSION['email'];

    //Get needed info from cust. table
    $cust_sql = <<<SQL
        SELECT customer_id, annual_income FROM customers WHERE email_id = "$email";
SQL;


    $cust_result = $dbh->query($cust_sql);

    if ($cust_result) {
      while ($row = $cust_result->fetch_assoc()) {
        $salary = $row['annual_income'];
        $cust_id = $row['customer_id'];
        $L_Term = $_REQUEST['loanlength'];
      }
    }

    $loantype = $_REQUEST['loantype'];
    $amount = $_REQUEST['amount'];
    $loanterm = $_REQUEST['loanlength'];
    $extended_warranty = $_REQUEST['extended_warranty'];
    $payoff_insurance = $_REQUEST['payoff_insurance'];
    $monthly_payment_insurance = $_REQUEST['monthly_payment_insurance'];

    $loan_interest_terms_sql = <<<SQL
      SELECT interest_rate FROM loan_interest_terms WHERE loan_type_cd = "$loantype" and loan_term_months = $loanterm;
SQL;

    $loan_interest_terms_result = $dbh->query($loan_interest_terms_sql);


    if ($loan_interest_terms_result) {
      $loan_interest_terms_row = $loan_interest_terms_result->fetch_assoc();
      $L_Int = $loan_interest_terms_row['interest_rate'];
    } else {
      echo mysqli_error($dbh);
    }

    $run_sql = true;

    switch ("$loantype") {
        case 'A':
          $monthly_I = $amount * (($L_Int / 100) / 12); //Converts the interest rate to a decimal and adds 1 to it.
          $monthly_I_str = number_format($monthly_I, 2);
          $monthly_payment = (($amount / $loanterm) + $monthly_I);
          $monthly_payment_str = number_format($monthly_payment, 2);
          echo ("Monthly Payment: " . $monthly_payment . "<br>Salary: " . $salary);
          if (!($monthly_payment <= (.50 * $salary))) { //If the monthly payment is greater than half of the salary, the loan cannot be made.
            header("Location: forms/loanapp_f.php?alert=loantoobig&minrequirement=50&monthly_payment=$monthly_payment&loantype=automobile");
            $run_sql = false;
          }
        break;
        case 'H':
          $monthly_I = $amount * (($L_Int / 100) / 12); //Converts the interest rate to a decimal and divides it by 12.
          $monthly_I_str = number_format($monthly_I, 2);
          $monthly_payment = (($amount / $loanterm) + $monthly_I);
          $monthly_payment_str = number_format($monthly_payment, 2);
          if (!($monthly_payment <= (.027 * $salary))) { //If the monthly payment is greater than half of the salary, the loan cannot be made.
            header("Location: forms/loanapp_f.php?alert=loantoobig&minrequirement=2.7&monthly_payment=$monthly_payment&loantype=home");
            $run_sql = false;
          }
        break;
        case 'B':
          $monthly_I = $amount * (($L_Int / 100) / 12); //Converts the interest rate to a decimal and adds 1 to it.
          $monthly_I_str = number_format($monthly_I, 2);
          $monthly_payment = (($amount / $loanterm) + $monthly_I);
          $monthly_payment_str = number_format($monthly_payment, 2);
          if (!($monthly_payment <= (.015 * $salary))) { //If the monthly payment is greater than half of the salary, the loan cannot be made.
            header("Location: forms/loanapp_f.php?alert=loantoobig&minrequirement=1.5&monthly_payment=$monthly_payment&loantype=boat");
            $run_sql = false;
          }
        break;
        case 'M':
          $monthly_I = $amount * (($L_Int / 100) / 12); //Converts the interest rate to a decimal and adds 1 to it.
          $monthly_I_str = number_format($monthly_I, 2);
          $monthly_payment = (($amount / $loanterm) + $monthly_I);
          $monthly_payment_str = number_format($monthly_payment, 2);
          if (!($monthly_payment <= (.015 * $salary))) { //If the monthly payment is greater than half of the salary, the loan cannot be made.
            header("Location: forms/loanapp_f.php?alert=loantoobig&minrequirement=1.5&monthly_payment=$monthly_payment&loantype=motorcycle");
            $run_sql = false;
          }
        break;
        case 'S':
          $monthly_I = $amount * (($L_Int / 100) / 12); //Converts the interest rate to a decimal and adds 1 to it.
          $monthly_I_str = number_format($monthly_I, 2);
          $monthly_payment = (($amount / $loanterm) + $monthly_I);
          $monthly_payment_str = number_format($monthly_payment, 2);
          if (!($monthly_payment <= (.15 * $salary))) { //If the monthly payment is greater than half of the salary, the loan cannot be made.
            header("Location: forms/loanapp_f.php?alert=loantoobig&minrequirement=15&monthly_payment=$monthly_payment&loantype=student");
            $run_sql = false;
          }
        break;
    }

    if ($run_sql) {
      $math_sql = <<<SQL
      INSERT INTO loan_application(customer_id, loan_type_cd, loan_amount, monthly_payment, loan_term_months, interest_rate, extended_warranty, payoff_insurance, monthly_payment_insurance)
      VALUES($cust_id, "$loantype", $amount, $monthly_payment, $loanterm, $L_Int, "$extended_warranty", "$payoff_insurance", "$monthly_payment_insurance");
SQL;
      $result = $dbh->query($math_sql);

      if ($result) {
        echo "Customer ID: " . $cust_id;
        echo "<br> Loan Type: " . $loantype;
        echo "<br> Amount: " . $amount;
        echo "<br> Monthly Payment: " . $monthly_payment;
        echo "<br> Loan Term: " . $loanterm;
        echo "<br> Interest Rate: " . $L_Int;
        echo "<br> Salary: " . $salary;
        echo "<br> Error: " . mysqli_error($dbh);
        var_dump(!($monthly_payment <= (.15 * $salary)));
        header("Location: dashboard.php");
      } else {
        echo ("It didn't work. (loanapp) <br>");
        // var_dump($loantype == 'H');
        echo "Customer ID: " . $cust_id;
        echo "<br> Loan Type: " . $loantype;
        echo "<br> Amount: " . $amount;
        echo "<br> Monthly Payment: " . $monthly_payment;
        echo "<br> Loan Term: " . $loanterm;
        echo "<br> Interest Rate: " . $L_Int;
        echo "<br> Salary: " . $salary;
        echo "<br> Error: " . mysqli_error($dbh);
      }
    }
}

//Edit Profile
function editprofile() {
    global $dbh;
    $email = $_REQUEST['email_id'];
    $fname = $_REQUEST['fname'];
    $lname = $_REQUEST['lname'];
    $address = $_REQUEST['address'];
    $city = $_REQUEST['city'];
    $state = $_REQUEST['state'];
    $zip = $_REQUEST['zip'];
    $pri_phone = $_REQUEST['telephone'];
    $alt_phone = $_REQUEST['cellphone'];
    $company = $_REQUEST['company'];
    $cust_yr_salary = $_REQUEST['yearlysalary'];
    $customer_id = $_SESSION['customer_id'];

    $sql = <<<SQL
    UPDATE customers
    SET email_id = "$email", first_name = "$fname", last_name = "$lname", address_line_one = "$address", city_name = "$city", state_cd = "$state", postal_cd = "$zip", pri_phone = "$pri_phone", alt_phone = "$alt_phone", employer_name = "$company", annual_income = "$cust_yr_salary"
    WHERE customer_id = $customer_id;
SQL;

    $result = $dbh->query($sql);

    if ($result) {
      $_SESSION['email'] = $email;

      $customer_id_sql = <<<SQL
      SELECT customer_id FROM customers WHERE email_id = "$email";
SQL;
      $customer_id_result = $dbh->query($customer_id_sql);

      while ($customer_id_row = $customer_id_result->fetch_assoc()) {
        $_SESSION['customer_id'] = $customer_id_row['customer_id'];
      }

      header("Location: dashboard.php");
    } else {
      mysqli_error($dbh);
    }
}


//References
function references() {
  global $dbh;
  $ref_first_name = $_REQUEST['ref_first_name'];
  $ref_last_name = $_REQUEST['ref_last_name'];
  $ref_phone = $_REQUEST['ref_phone'];
  $address_line_one = $_REQUEST['address_line_one'];
  $city_name = $_REQUEST['city_name'];
  $state_cd = $_REQUEST['state_cd'];
  $postal_cd = $_REQUEST['postal_cd'];
  $customer_id = $_SESSION['customer_id'];

  $sql = <<<SQL
  INSERT INTO customer_references(customer_id, ref_first_name, ref_last_name, ref_phone, address_line_one, city_name, state_cd, postal_cd)
  VALUES($customer_id, "$ref_first_name", "$ref_last_name", "$ref_phone", "$address_line_one", "$city_name", "$state_cd","$postal_cd");
SQL;

  $result = $dbh->query($sql);

  if ($result) {
    header("Location: dashboard.php");
  } else {
    echo mysqli_error($dbh);
  }
}

//Logout
function logout() {
  session_unset();
  session_destroy();
  header("Location: forms/login.php");
}
?>
