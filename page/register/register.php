<?php
function removeTextBeforeUnderscore($inputString) {
  // Find the position of the underscore
  $underscorePosition = strpos($inputString, '_');

  // Check if underscore is found
  if ($underscorePosition !== false) {
      // Extract the substring starting from the position after the underscore
      $result = substr($inputString, $underscorePosition + 1);
      return $result;
  } else {
      // If underscore is not found, return the original string
      return $inputString;
  }
}

$errorMsg = false;
$errorCode = 0;
$successMsg = false;
if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $prov = removeTextBeforeUnderscore($_POST['prov']);
  $dist = removeTextBeforeUnderscore($_POST['dist']);
  $ward = removeTextBeforeUnderscore($_POST['ward']);
  // echo "<pre>";
  // print_r($_POST);
  // echo "</pre>";
    $fullname_reg = $_POST['fname'];
    $username_reg = $_POST['uname'];
    $password_reg = $_POST['passw'];
    $hashedPassword_reg = password_hash($password_reg, PASSWORD_DEFAULT);
    // 

    $emailRegex = '/^[^\s@]+@[^\s@]+\.[^\s@]+$/'; // Match Email format
    $asciiRegex = '/^[\x20-\x7E]+$/'; // Match ASCII
    $valid_fullname_reg = false;
    $valid_email_reg = false;
    $valid_pass_reg = false;

    if (strlen($fullname_reg) == 0 || strlen($fullname_reg) > 75) {
      $valid_fullname_reg = false;
    } else {
      $valid_fullname_reg = true;
    }
  
    if (strlen($username_reg) >= 1 && strlen($username_reg) < 3) {
      $valid_email_reg = false;
    } else {
      if (strlen($username_reg) == 0) {
        $valid_email_reg = false;
      } else {
        // Check if username is maximum 243 characters
        if (strlen($username_reg) > 254) {
          $valid_email_reg = false;
        } else {
          // Check if vaid email styling
          if (preg_match($emailRegex, $username_reg) && preg_match($asciiRegex, $username_reg)) {
            if (strpos($username_reg, " ") !== false) $valid_email_reg = false;
            else $valid_email_reg = true;
          } else {
            $valid_email_reg = false;
          }
        }
      }
    }
  
    // Check if password is filled
    if (strlen($password_reg) == 0 || strlen($password_reg) > 255) {
      $valid_pass_reg = false;
    } else {
      if (strpos($password_reg, " ") !== false) $valid_pass_reg = false;
      else $valid_pass_reg = true;
    }
  
    if ($valid_email_reg == false || $valid_pass_reg == false || $valid_fullname_reg == false) {
      $errorMsg = true;
      if ($valid_fullname_reg == false) $errorCode = 1;
      if ($valid_email_reg == false) $errorCode = 2;
      if ($valid_pass_reg == false) $errorCode = 3;
    } else {
      $query = "SELECT * FROM users WHERE username=?";
      $stmt = $conn->prepare($query);
      $stmt->bind_param("s", $username_reg);
      $stmt->execute();
      $result = $stmt->get_result();
      $stmt->close();
      if($result->num_rows > 0) {
        $errorMsg = true;
        $errorCode = 4;
      } else {
        $query = "INSERT INTO users (username, password, fullname, level, province, district, ward) VALUES ('$username_reg', '$hashedPassword_reg', '$fullname_reg', 1, '$prov', '$dist', '$ward')";
        $result = $conn->query($query);
        $successMsg = true;
      }
    }  
}
?>
<div class="tab-content" style="height: fit-content;">
  <div id="register" class="container tab-pane active"><br>
    <h2 class="text-center text-uppercase mt-3 mb-4">Signup a new account</h2>
    <div class="row d-flex flex-row justify-content-center mb-3">
      <form class="col-md-5" action="" method="post">
        <?php 
          if ($errorMsg) {
        ?>
        <div class="alert alert-danger alert-dismissible fade show">
          <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
          <strong>Registration fail!</strong><br><?php 
            if ($errorCode == 1) {echo "Invalid fullname input!";};
            if ($errorCode == 2) {echo "Invalid username input!";};
            if ($errorCode == 3) {echo "Invalid password input!";};
            if ($errorCode == 4) {echo "Username existed, pick another one!";};
          ?>
        </div>
        <?php
          } 
        ?>
        <?php 
          if ($successMsg){
        ?>
        <div class="alert alert-success alert-dismissible fade show">
          <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
          <strong>Registration successful!</strong><br>Please login!
        </div>
        <?php
          } 
        ?>

        <h4 class="text-center mt-3">Account information</h4>

        <div class="form-group input-group-sm">
          <label for="user_reg" class="mb-2">Email:</label>
          <input required type="email" class="form-control" id="user_reg" name="uname" placeholder="Type your email..."
            value="<?php if ($errorMsg) {echo $username_reg;}; ?>">
        </div>

        <p id="warn2_reg" class="text-danger m-0 mt-2" style="font-size: 13.5px;"></p>

        <div class="toast show mt-3 mb-3 w-100">
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
        </div>
        <div class="form-group input-group-sm">
          <label for="pass_reg" class="mb-2">Password:</label>
          <input required type="password" class="form-control" id="pass_reg" name="passw"
            placeholder="Type your password...">
        </div>

        <p id="warn3_reg" class="text-danger mt-2" style="font-size: 13.5px;"></p>

        <div class="toast show mt-3 mb-5 w-100">
          <div class="toast-header">
            Password requirement
          </div>
          <div class="toast-body">
            <ul class="mb-0">
              <li>From 1 - 255 characters</li>
              <li>May contain non - ASCII characters, exclude " " (space) character!</li>
            </ul>
          </div>
        </div>

        <hr>

        <h4 class="text-center">Personal information</h4>

        <div class="form-group input-group-sm">
          <label for="fullname_reg" class="mb-2">Fullname:</label>
          <input required type="text" class="form-control" id="fullname_reg" name="fname"
            placeholder="Type your fullname..." value="<?php if ($errorMsg) {echo $fullname_reg;}; ?>">
        </div>

        <p id="warn1_reg" class="text-danger mt-2" style="font-size: 13.5px;"></p>

        <div class="toast show mt-3 mb-3 w-100">
          <div class="toast-header">
            Fullname requirement
          </div>
          <div class="toast-body">
            <ul class="mb-0">
              <li>From 1 - 75 characters</li>
              <li>May contain non - ASCII characters</li>
            </ul>
          </div>
        </div>


        <div class="form-group input-group-sm mb-3">
          <label for="province" class="mb-2">Province:</label>
          <select class="form-select form-select-sm" id="province" name="prov" required>
            <option value="" disabled selected>--Select your province--</option>
          </select>
        </div>

        <div class="form-group input-group-sm mb-3">
          <label for="district" class="mb-2">District:</label>
          <select class="form-select form-select-sm" id="district" name="dist" required>
            <option value="" disabled selected>--Select your district--</option>
          </select>
        </div>


        <div class="form-group input-group-sm mb-5">
          <label for="ward" class="mb-2">Ward:</label>
          <select class="form-select form-select-sm" id="ward" name="ward" required>
            <option value="" disabled selected>--Select your ward--</option>
          </select>
        </div>



        <p class="text-center mt-4 mb-2" style="font-size:14px;">Already have an account? <a href="index.php?page=login"
            id="logIn-link" class="btn-link">Login</a> instead!</p>
        <button type="submit" class="btn btn-primary mt-3 mb-5 w-100 disabled" name="submit_reg"
          id="submitBtn_reg">Signup</button>
      </form>
    </div>
  </div>
</div>

<script>
var emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/; // Match email
var asciiRegex = /^[\x20-\x7E]+$/; // Match ASCII

const nameInputReg = document.getElementById("fullname_reg");
const userInputReg = document.getElementById("user_reg");
const passInputReg = document.getElementById("pass_reg");
const submitBtnReg = document.getElementById("submitBtn_reg");
const fullnameWarningReg = document.getElementById("warn1_reg");
const usernameWarningReg = document.getElementById("warn2_reg");
const passwordWarningReg = document.getElementById("warn3_reg");

var usernameList = []

function validateInputReg() {
  var nameTxt = nameInputReg.value;
  var userTxt = userInputReg.value;
  var passTxt = passInputReg.value;
  var valid_fullname = false;
  var valid_username = false;
  var valid_password = false;

  // Check if fullname is filled
  if (nameTxt.length === 0) {
    fullnameWarningReg.innerHTML = "*Please fill in your fullname!";
    valid_fullname = false;
  } else {
    if (nameTxt.length > 75) {
      fullnameWarningReg.innerHTML = "*Atmost 75 characters!";
      valid_fullname = false;
    } else {
      fullnameWarningReg.innerHTML = "";
      valid_fullname = true;
    }
  }

  if (userTxt.length >= 1 && userTxt.length < 3) {
    // Check if username is minimum 3 characters
    usernameWarningReg.innerHTML = "*Email must be at least 3 characters!";
    valid_username = false;
  } else {
    if (userTxt.length === 0) {
      usernameWarningReg.innerHTML = "*Please fill in your email!";
      valid_username = false;
    } else {
      // Check if username is maximum 243 characters
      if (userTxt.length > 254) {
        usernameWarningReg.innerHTML = "*Email must be at most 254 characters!";
        valid_username = false;
      } else {
        // Check if vaid email styling
        if (emailRegex.test(userTxt) && asciiRegex.test(userTxt)) {
          // Contain " " character?
          if (userTxt.includes(" ")) {
            usernameWarningReg.innerHTML = "*Must not contain space character!";
            valid_username = false;
          } else {
            usernameWarningReg.innerHTML = ""
            valid_username = true;
          }
        } else {
          usernameWarningReg.innerHTML = "*Invalid email input!";
          valid_username = false;
        }
      }
    }
  }

  // Validate existence in database
  if (usernameList.includes(userTxt)) {
    usernameWarningReg.innerHTML = "*Email already registered, select another one!";
    valid_username = false;
  }

  // Check if password is filled
  if (passTxt.length === 0) {
    passwordWarningReg.innerHTML = "*Please fill in your password!";
    valid_password = false;
  } else {
    if (passTxt.length > 255) {
      passwordWarningReg.innerHTML = "*Atmost 255 characters!";
      valid_password = false;
    } else {
      if (passTxt.includes(" ")) {
        passwordWarningReg.innerHTML = "*Must not contain space character!";
        valid_password = false;
      } else {
        passwordWarningReg.innerHTML = "";
        valid_password = true;
      }
    }
  }

  if (valid_fullname && valid_username && valid_password && document.getElementById('province').value !== '' && document
    .getElementById('district').value !== '' && document.getElementById('ward').value !== '')
    submitBtnReg.classList
    .remove(
      "disabled");
  else submitBtnReg.classList.add("disabled");
}

nameInputReg.addEventListener("keyup", validateInputReg);
userInputReg.addEventListener("keyup", validateInputReg);
passInputReg.addEventListener("keyup", validateInputReg);
document.getElementById('province').addEventListener('change', validateInputReg)
document.getElementById('district').addEventListener('change', validateInputReg)
document.getElementById('ward').addEventListener('change', validateInputReg)
</script>

<!-- Script for AJAX -->
<script>
const xhr = new XMLHttpRequest();
xhr.open("GET", "/server/server_email.php", true);
xhr.setRequestHeader("Content-Type", "text/xml");
xhr.onload = function() {
  if (xhr.status === 200) {
    var xmlDoc = xhr.responseXML;
    var products = xmlDoc.getElementsByTagName('user');
    for (var i = 0; i < products.length; i++) {
      usernameList.push(products[i].textContent);
    };
  } else console.error("Request fail. Status: " + xhr.status);
};
xhr.send();
</script>

<!-- Province/ District/ Ward -->
<script>
const provinceSelect = document.getElementById("province");
const districtSelect = document.getElementById("district");
const wardSelect = document.getElementById("ward");
var data = [];
var iddd = 0;

const xhttp = new XMLHttpRequest();
// xhttp.open("GET", "https://provinces.open-api.vn/api/?depth=3", true);
xhttp.open("GET", "/data/VietNam.json", true);

xhttp.onload = function() {
  if (xhttp.status === 200) {
    data = JSON.parse(xhttp.response);
    data.forEach((prv, idx) => {
      provinceSelect.innerHTML += `<option value="${idx}_${prv.name}">${prv.name}</option>`
      iddd = idx;
    })
  } else {
    console.error("Request fail. Status: " + xhttp.status);
  }
};
xhttp.send();

function updateDistrict() {
  const prvChoice = parseInt(provinceSelect.value.split('_')[0]);
  districtSelect.innerHTML = '<option value="" disabled selected>--Select your province--</option>';
  wardSelect.innerHTML = '<option value="" disabled selected>--Select your ward--</option>';
  data[prvChoice].districts.forEach((dst, idx) => {
    districtSelect.innerHTML += `<option value="${idx}_${dst.name}">${dst.name}</option>`
  })
}

function updateWard() {
  const prvChoice = parseInt(provinceSelect.value.split('_')[0]);
  const dstChoice = parseInt(districtSelect.value.split('_')[0]);
  wardSelect.innerHTML = '<option value="" disabled selected>--Select your ward--</option>';
  data[prvChoice].districts[dstChoice].wards.forEach((wrd, idx) => {
    wardSelect.innerHTML += `<option value="${idx}_${wrd.name}">${wrd.name}</option>`
  })
}

provinceSelect.addEventListener("change", updateDistrict);
districtSelect.addEventListener("change", updateWard);
</script>