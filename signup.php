<?php
include 'logic/signup.php';
?>
<!DOCTYPE html>
<html lang="en">
   <head>
       <meta charset="utf-8">
       <meta name="viewport" content="width=device-width, initial-scale=1">
       <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-+0n0xVW2eSR5OomGNYDnhzAbDsOXxcvSN1TPprVMTNDbiYZCxYbOOl7+AMvyTG2x" crossorigin="anonymous">
       <title>RentLad | Welcome</title>
       <link rel="icon" type="image/x-icon" href="resources/icons/rentld.png" >
   </head>
   <body>
    <?php include "include/header.php" ?>
    <main class="container m-auto col-lg-4 col-sm-6 col-md-6">
        <form action="signup.php" method="post" enctype="multipart/form-data">
            <h1 class="h3 m-5 fw-normal text-center">welcome to RentLad</h1>

            <div class="form-floating border-bottom border-success rounded">
                <?php 
                      if(isset($signupErr)){echo $signupErr;}
                ?>
                <input type="text" class="form-control" id="txtName" name="txtName" placeholder="name" required>
                <label for="txtName">Name</label>
            </div>
            <div class="form-floating border-bottom border-success rounded">
                <input type="text" class="form-control" id="txtSurname" name="txtSurname" placeholder="Surname" required>
                <label for="txtSurname">Surname</label>
            </div>
            <div class="form-floating   border-bottom border-success rounded">
                <input type="email" class="form-control" id="txtEmail" name="txtEmail" placeholder="email" required>
                <label for="txtEmail">Email</label>
                <?php if(isset($emailCheck)){echo $emailCheck;}?>
            </div>
            <div class="form-floating   border-bottom border-success rounded" >
                <input type="text" class="form-control" id="txtPhoneNumber" name="txtPhoneNumber" placeholder="phone number" required>
                <label for="txtPhoneNumber">Phone Number</label>
                <?php if(isset($phoneCheck)){echo $phoneCheck;}?>
            </div>
            <div class="form-floating  border-bottom border-success rounded">
                <input type="password" class="form-control" id="txtPassword" name="txtPassword" placeholder="Password" required>
                <label for="txtPassword">Create Password</label>
            </div>
            <div class="form-floating  border-bottom border-success rounded">
                <input type="password" class="form-control" id="txtConfirmPassword" name="txtConfirmPassword" placeholder="ConfirmPassword" required>
                <label for="txtConfirmPassword">Confirm Password</label>
                <?php if(isset($passwordCheck)){echo $passwordCheck;}?>
            </div>
            <fieldset class="scheduler-border mx-3" >
                <legend class="scheduler-border"><small class="text-secondary">register as</small></legend>

                <div class="form-check-inline mx-1">
                    <label class="form-check-label">
                        <input type="radio" class="form-check-input" name="UserType" value="Student" required>Student
                    </label>
                </div>
                <div class="form-check-inline disabled ">
                    <label class="form-check-label">
                        <input type="radio" class="form-check-input" name="UserType" value="Landlord" required>Landlord
                    </label>
                </div>
            </fieldset>
            <div class="form-group mx-3">
                <label class="col-form-label">User Image</label>
                    <input class="form-control border-success" name="userImage" type="file" required>
            </div>
            
            <button class="btn btn-primary w-100 py-2 mt-4" type="submit">Register</button>
            <p class="mt-5 mb-3 text-body-secondary">&copy;<?php echo date('Y'); ?> | RentLad.co.za</p>
        </form>
   
   <script>
    function setupCharacterLimit(textareaId, maxChars) {
    // Get the textarea element
    var textarea = document.getElementById(textareaId);

    // Create a unique ID for the character count display element
    var charCountId = textareaId + '-charCount';

    // Create the character count display element
    var charCount = document.createElement('div');
    charCount.id = charCountId;
    charCount.className = 'text-muted';
    charCount.textContent = getCharCountMessage(maxChars);

    // Insert the character count display element after the textarea
    textarea.parentNode.insertBefore(charCount, textarea.nextSibling);

    // Add an input event listener to the textarea
    textarea.addEventListener('input', function () {
        // Get the current character count
        var currentChars = textarea.value.length;

        // Update the character count display
        charCount.textContent = getCharCountMessage(maxChars - currentChars);

        // Check if the user has exceeded the character limit
        if (currentChars > maxChars) {
            // Trim the text to the maximum allowed characters
            textarea.value = textarea.value.substring(0, maxChars);
        }
    });

    // Add a blur event listener to validate and sanitize the input when the textarea loses focus
    textarea.addEventListener('blur', function () {
        // Validate and sanitize the input
        var sanitizedInput = sanitizeInput(textarea.value);

        // Update the textarea value with the sanitized input
        textarea.value = sanitizedInput;
    });
}

function getCharCountMessage(remainingChars) {
    if (remainingChars === 1) {
        return '1 character remaining';
    } else {
        //return remainingChars + ' characters remaining';
    }
}
setupCharacterLimit('txtName', 19);
setupCharacterLimit('txtSurname', 24);
setupCharacterLimit('txtEmail', 49);
setupCharacterLimit('txtPhoneNumber', 10);
setupCharacterLimit('txtPassword', 10);
setupCharacterLimit('txtPassword', 10);
setupCharacterLimit('txtConfirmPassword', 10);
   </script>
   <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-gtEjrD/SeCtmISkJkNUaaKMoLD0//ElJ19smozuHV6z3Iehds+3Ulb9Bn9Plx0x4" crossorigin="anonymous"></script>
</body>
   </html>