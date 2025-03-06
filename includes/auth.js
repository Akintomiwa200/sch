// includes/auth.js
"use strict";

const Auth = (() => {
    // Private variables
    const _config = {
        endpoints: {
            login: '/processes/login.php',
            register: '/processes/register.php',
            logout: '/processes/logout.php',
            forgotPassword: '/processes/forgot-password.php'
        },
        selectors: {
            loginForm: '#login-form',
            registerForm: '#register-form',
            authModal: '#authModal',
            errorDiv: '#authError'
        }
    };

    // Private methods
    const _handleResponse = (response, formType) => {
        if (response.success) {
            _clearErrors();
            _redirectAfterAuth(formType);
        } else {
            _showError(response.message || 'An error occurred');
        }
    };

    const _showError = (message) => {
        const $errorDiv = $(_config.selectors.errorDiv);
        $errorDiv.html(`
            <div class="alert alert-danger alert-dismissible fade show">
                ${message}
                <button type="button" class="close" data-dismiss="alert">
                    <span>&times;</span>
                </button>
            </div>
        `).slideDown();
    };

    const _clearErrors = () => {
        $(_config.selectors.errorDiv).html('').hide();
    };

    const _redirectAfterAuth = (formType) => {
        const redirectPath = formType === 'login' ? '/pages/instructor/dashboard.php' : '/';
        window.location.href = redirectPath;
    };

    const _handleAuthForm = (form, formType) => {
        $(form).validate({
            rules: {
                email: {
                    required: true,
                    email: true
                },
                password: {
                    required: true,
                    minlength: 8
                }
            },
            submitHandler: function(formElement) {
                const formData = $(formElement).serializeArray();
                const payload = Object.fromEntries(formData.map(x => [x.name, x.value]));
                
                $.ajax({
                    url: _config.endpoints[formType],
                    method: 'POST',
                    data: payload,
                    beforeSend: function() {
                        $(formElement).find('button[type="submit"]')
                            .prop('disabled', true)
                            .html('<i class="fa fa-spinner fa-spin"></i> Processing');
                    },
                    complete: function() {
                        $(formElement).find('button[type="submit"]')
                            .prop('disabled', false)
                            .html(formType === 'login' ? 'Login' : 'Register');
                    },
                    success: function(response) {
                        _handleResponse(response, formType);
                    },
                    error: function(xhr) {
                        _showError(xhr.responseJSON?.message || 'Server error occurred');
                    }
                });
            }
        });
    };

    // Public methods
    return {
        init: function() {
            // Initialize login form
            if ($(_config.selectors.loginForm).length) {
                _handleAuthForm(_config.selectors.loginForm, 'login');
            }

            // Initialize registration form
            if ($(_config.selectors.registerForm).length) {
                _handleAuthForm(_config.selectors.registerForm, 'register');
            }

            // Logout handler
            $('.logout-link').on('click', function(e) {
                e.preventDefault();
                $.post(_config.endpoints.logout)
                    .done(() => window.location.href = '/')
                    .fail(() => _showError('Logout failed'));
            });

            // Forgot password handler
            $('#forgot-password-form').on('submit', function(e) {
                e.preventDefault();
                const email = $('#forgotEmail').val();
                
                $.post(_config.endpoints.forgotPassword, { email })
                    .done(response => {
                        if (response.success) {
                            _showError('Password reset instructions sent to your email');
                        } else {
                            _showError(response.message);
                        }
                    })
                    .fail(() => _showError('Password reset failed'));
            });
        },

        showAuthModal: function(formType = 'login') {
            const $modal = $(_config.selectors.authModal);
            $modal.find('.modal-title').text(formType === 'login' 
                ? 'Login to OpenLearn' 
                : 'Create Instructor Account');
            $modal.modal('show');
        }
    };
})();

// Initialize auth module on document ready
$(document).ready(() => Auth.init());