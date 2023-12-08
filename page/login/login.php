<div class="tab-content" style="height: fit-content;">
  <div id="logIn" class="container tab-pane active"><br>
    <h2 class="text-center text-uppercase mt-3 mb-4">Login to your account</h2>
    <div class="row d-flex flex-row justify-content-center mb-3">
      <form class="col-md-5" action="page/login/login_processing.php" method="post">
        <?php
          if (isset($_SESSION['login_fail']) && $_SESSION['login_fail'] == true) {
        ?>
        <div class="alert alert-danger alert-dismissible fade show pe-3">
          <button type="button" class="btn-close" style="font-size: 15px; padding: 12px"
            data-bs-dismiss="alert"></button>
          <strong>Login fail!</strong><br>Double-check username or password!
        </div>
        <?php
          };
        ?>
        <div class="form-group input-group-sm">
          <label for="user_login" class="mb-2">Email:</label>
          <input required type="email" class="form-control" id="user_login" name="uname"
            placeholder="Type your email..."
            value="<?php echo isset($_SESSION['input_username']) ? htmlspecialchars($_SESSION['input_username']) : ''; ?>">
        </div>

        <p id="warn1_login" class="text-danger mt-2" style="font-size: 13.5px;"></p>
        <!-- <div class="toast bg-warning show w-100">
          <div class="toast-header">
            Email requirement
          </div>
          <div class="toast-body">
            <ul class="mb-0">
              <li>From 3 - 255 characters</li>
              <li>Only contain ASCII characters, exclude " " (space) character!</li>
              <li>Have valid email format <i>local_part@domain_part</i></li>
            </ul>
          </div>
        </div> -->

        <div class="form-group input-group-sm mt-3">
          <label for="pass_login" class="mb-2">Password:</label>
          <input required type="password" class="form-control" id="pass_login" name="passw"
            placeholder="Type your password...">
        </div>

        <p id="warn2_login" class="text-danger mt-2" style="font-size: 13.5px;"></p>

        <!-- <div class="toast bg-warning show w-100">
          <div class="toast-header">
            Password requirement
          </div>
          <div class="toast-body">
            <ul class="mb-0">
              <li>From 1 - 255 characters</li>
              <li>May contain non - ASCII characters, exclude " " (space) character!</li>
            </ul>
          </div>
        </div> -->

        <div class="form-group form-check mt-4 mb-4" style="font-size: 13.5px;">
          <label class="form-check-label">
            <input class="form-check-input" type="checkbox" name="remember"> Remember me (Stay logged in)
          </label>
        </div>

        <p class="text-center mt-4 mb-2" style="font-size:14px;">Don't have an account yet? <a
            href="index.php?page=register" id="logIn-link" class="btn-link">Register</a> instead!</p>

        <button type="submit" class="btn btn-primary mt-3 mb-5 w-100 disabled" name="submit_login"
          id="submitBtn_login">Login</button>
      </form>

    </div>
  </div>
</div>

<?php
if (isset($_SESSION['login_fail'])) unset($_SESSION['login_fail']);
if (isset($_SESSION['input_username'])) unset($_SESSION['input_username']);

?>

<script>
var emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/; // Match email
var asciiRegex = /^[\x20-\x7E]+$/; // Match ASCII

const userInput = document.getElementById("user_login");
const passInput = document.getElementById("pass_login");
const submitBtn = document.getElementById("submitBtn_login");
const usernameWarning = document.getElementById("warn1_login");
const passwordWarning = document.getElementById("warn2_login");

function validateInput() {
  var userTxt = userInput.value;
  var passTxt = passInput.value;
  var valid_username = false;
  var valid_password = false;

  if (userTxt.length >= 1 && userTxt.length < 3) {
    // Check if username is minimum 3 characters
    usernameWarning.innerHTML = "*Email must be at least 3 characters!";
    valid_username = false;
  } else {
    if (userTxt.length === 0) {
      usernameWarning.innerHTML = "*Please fill in your email!";
      valid_username = false;
    } else {
      // Check if username is maximum 243 characters
      if (userTxt.length > 254) {
        usernameWarning.innerHTML = "*Email must be at most 254 characters!";
        valid_username = false;
      } else {
        // Check if vaid email styling
        if (emailRegex.test(userTxt) && asciiRegex.test(userTxt)) {
          // Contain " " character?
          if (userTxt.includes(" ")) {
            usernameWarning.innerHTML = "*Must not contain space character!";
            valid_username = false;
          } else {
            usernameWarning.innerHTML = ""
            valid_username = true;
          }
        } else {
          usernameWarning.innerHTML = "*Invalid email input!";
          valid_username = false;
        }
      }
    }
  }

  // Check if password is filled
  if (passTxt.length === 0) {
    passwordWarning.innerHTML = "*Please fill in your password!";
    valid_password = false;
  } else {
    if (passTxt.length > 255) {
      passwordWarning.innerHTML = "*Atmost 255 characters!";
      valid_password = false;
    } else {
      if (passTxt.includes(" ")) {
        passwordWarning.innerHTML = "*Must not contain space character!";
        valid_password = false;
      } else {
        passwordWarning.innerHTML = "";
        valid_password = true;
      }
    }
  }

  if (valid_username && valid_password) submitBtn.classList.remove("disabled");
  else submitBtn.classList.add("disabled");
}

userInput.addEventListener("keyup", validateInput);
passInput.addEventListener("keyup", validateInput);
</script>