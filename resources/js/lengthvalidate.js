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

function sanitizeInput(input) {
    // Basic HTML escaping
    var sanitizedInput = input.replace(/&/g, '&amp;').replace(/</g, '&lt;').replace(/>/g, '&gt;');

    // Prevent script execution
    sanitizedInput = sanitizedInput.replace(/<script.*?>.*?<\/script>/gi, '');

    return sanitizedInput;
}

//////////////////////number validatioin
function setupNumberValidation(inputId) {
        // Get the input element
        var inputElement = document.getElementById(inputId);

        // Add a blur event listener to validate and sanitize the input when it loses focus
        inputElement.addEventListener('blur', function () {
            // Validate and sanitize the input for numbers
            var sanitizedNumber = validateAndSanitizeNumber(inputElement.value);

            // Update the input value with the sanitized number
            inputElement.value = sanitizedNumber;
        });
    }

    function validateAndSanitizeNumber(input) {
        // Remove non-numeric characters
        var numericInput = input.replace(/[^0-9]/g, '');

        // If the input is not a number or is empty, replace it with 1
        var sanitizedNumber = parseInt(numericInput, 10);
        if (isNaN(sanitizedNumber) || !isFinite(sanitizedNumber)) {
            sanitizedNumber = 1;
        }

        return sanitizedNumber.toString(); // Convert back to string
    }

setupNumberValidation('txtNumberofRooms');
setupNumberValidation('txtPrice');
setupNumberValidation('txtHouseNumber');

setupCharacterLimit('txtTitle', 49);
setupCharacterLimit('txtDescription', 199);
setupCharacterLimit('txtRules', 249);
setupCharacterLimit('txtCity', 99);
setupCharacterLimit('txtSuburb', 49);
setupCharacterLimit('txtStreetName', 99);
setupCharacterLimit('txtNearestCampus', 149);


