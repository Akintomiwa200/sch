$(document).ready(function() {
    // Login Form Handling
    $('#login-form').validate({
        rules: {
            instEmail: {
                required: true,
                email: true
            },
            instPassword: {
                required: true,
                minlength: 8
            }
        },
        submitHandler: function(form) {
            const formData = {
                email: $('#instEmail').val(),
                password: $('#instPassword').val(),
                remember: $('#rememberMe').is(':checked')
            };

            $.ajax({
                url: 'processes/login.php',
                method: 'POST',
                data: formData,
                beforeSend: function() {
                    $('#btn-login').html('<i class="fa fa-spinner fa-spin"></i> Processing');
                },
                success: function(response) {
                    if (response.success) {
                        window.location.href = 'pages/instructor/dashboard.php';
                    } else {
                        showAuthError(response.message);
                    }
                },
                error: function() {
                    showAuthError('Connection error. Please try again.');
                },
                complete: function() {
                    $('#btn-login').html('Login');
                }
            });
        }
    });

    function showAuthError(message) {
        $('#errorDiv').html(`
            <div class="alert alert-danger alert-dismissible fade in">
                <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                ${message}
            </div>
        `);
    }
});