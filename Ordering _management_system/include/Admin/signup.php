<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Signup</title>
    <link rel="stylesheet" href="./Display/css/sign-in.css">
    <style>
        /* Style for the password strength meter */
        #password-strength {
            height: 5px;
            width: 100%;
            border-radius: 3px;
            margin-top: 10px;
        }
        .weak { background-color: red; }
        .medium { background-color: yellow; }
        .strong { background-color: green; }
        .password-feedback {
            font-size: 12px;
            margin-top: 5px;
        }
    </style>
</head>
<body>
    <form action="signup-check.php" method="post">
        <div class="header">
            <img src="./image/chantong.jpg" alt="">
            <p>Chantong Enterprise</p>
        </div>
        <?php if(isset($_GET['error'])) { ?>
            <p class="error"><?php echo $_GET['error']?></p>
        <?php } ?>   

        <?php if(isset($_GET['success'])) { ?>
            <p class="success"><?php echo $_GET['success']?></p>
        <?php } ?>

        <?php if(isset($_GET['name'])) { ?>
            <input type="text" name="name" placeholder="Firstname" class="info" value="<?php echo $_GET['name'];?>">
        <?php } else { ?>
            <input type="text" name="name" placeholder="Firstname" class="info">
        <?php } ?>

        <?php if(isset($_GET['lname'])) { ?>
            <input type="text" name="lname" placeholder="Lastname" class="info" value="<?php echo $_GET['lname'];?>">
        <?php } else { ?>
            <input type="text" name="lname" placeholder="Lastname" class="info">
        <?php } ?>

        <input type="email" name="email" placeholder="Email address" class="info">
        
        <input type="password" placeholder="Password" name="password" id="password" class="info" oninput="checkPasswordStrength()">
        <input type="password" placeholder="Confirm password" name="confirmpass" class="info">
        
        <!-- Password strength meter and feedback -->
        <div id="password-strength"></div>
        <p id="password-feedback" class="password-feedback"></p>

        <button type="submit">Sign up</button>
        <a href="./sign-in.php">Already have an Account?<span> Sign in</span></a>
    </form>

    <script>
        function checkPasswordStrength() {
            const password = document.getElementById("password").value;
            const strengthMeter = document.getElementById("password-strength");
            const feedback = document.getElementById("password-feedback");

            // Regular expressions to check password conditions
            const lengthCondition = password.length >= 8;
            const upperCaseCondition = /[A-Z]/.test(password);
            const lowerCaseCondition = /[a-z]/.test(password);
            const numberCondition = /\d/.test(password);
            const specialCharCondition = /[!@#$%^&*(),.?":{}|<>]/.test(password);

            // Determine password strength
            let strength = "Weak";
            if (lengthCondition && (upperCaseCondition || lowerCaseCondition) && numberCondition && specialCharCondition) {
                strength = "Strong";
            } else if (lengthCondition && (upperCaseCondition || lowerCaseCondition) && (numberCondition || specialCharCondition)) {
                strength = "Medium";
            }

            // Update the strength meter
            if (strength === "Weak") {
                strengthMeter.className = "weak";
                feedback.innerText = "Password is too weak. Must be at least 8 characters with numbers and special characters.";
            } else if (strength === "Medium") {
                strengthMeter.className = "medium";
                feedback.innerText = "Password is medium. Add more complexity for better security.";
            } else if (strength === "Strong") {
                strengthMeter.className = "strong";
                feedback.innerText = "Strong password! Great job.";
            }
        }
    </script>
</body>
</html>
