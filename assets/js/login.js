/* Serenity theme — custom login page AJAX handling.
   Vanilla JS (no jQuery dependency) — posts to admin-ajax.php against the
   handlers in inc/login.php (wp_signon()/retrieve_password() underneath). */
(function () {
    'use strict';

    document.addEventListener('DOMContentLoaded', function () {
        var cfg = window.SerenityLogin || {};
        var loginForm = document.getElementById('serenity-login-form');
        var forgotForm = document.getElementById('serenity-forgot-form');
        var alertBox = document.getElementById('serenity-login-alert');
        var forgotTrigger = document.getElementById('serenity-login-forgot-trigger');
        var backTrigger = document.getElementById('serenity-login-back-trigger');

        function showAlert(message, type) {
            if (!alertBox) return;
            alertBox.textContent = message;
            alertBox.className = 'serenity-login-alert serenity-login-alert-' + (type || 'error');
            alertBox.style.display = 'block';
        }
        function hideAlert() {
            if (alertBox) alertBox.style.display = 'none';
        }

        function setLoading(form, isLoading) {
            var btn = form.querySelector('button[type="submit"]');
            if (!btn) return;
            btn.disabled = isLoading;
            btn.classList.toggle('is-loading', isLoading);
        }

        function post(action, data) {
            var body = new URLSearchParams(Object.assign({ action: action, nonce: cfg.nonce }, data));
            return fetch(cfg.ajaxUrl, {
                method: 'POST',
                credentials: 'same-origin',
                headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
                body: body.toString(),
            }).then(function (res) { return res.json(); });
        }

        if (forgotTrigger && loginForm && forgotForm) {
            forgotTrigger.addEventListener('click', function () {
                hideAlert();
                loginForm.style.display = 'none';
                forgotForm.style.display = '';
            });
        }
        if (backTrigger && loginForm && forgotForm) {
            backTrigger.addEventListener('click', function () {
                hideAlert();
                forgotForm.style.display = 'none';
                loginForm.style.display = '';
            });
        }

        document.querySelectorAll('.serenity-pwd-toggle').forEach(function (btn) {
            btn.addEventListener('click', function () {
                var input = document.getElementById(btn.getAttribute('data-target'));
                if (!input) return;
                input.type = input.type === 'password' ? 'text' : 'password';
                btn.classList.toggle('is-visible', input.type === 'text');
            });
        });

        if (loginForm) {
            loginForm.addEventListener('submit', function (e) {
                e.preventDefault();
                hideAlert();
                setLoading(loginForm, true);
                post('serenity_login', {
                    username: document.getElementById('serenity-login-username').value,
                    password: document.getElementById('serenity-login-password').value,
                    remember: document.getElementById('serenity-login-remember').checked ? '1' : '',
                }).then(function (res) {
                    if (res.success) {
                        window.location.href = res.data.redirect;
                    } else {
                        setLoading(loginForm, false);
                        showAlert((res.data && res.data.message) || cfg.i18n.genericError, 'error');
                    }
                }).catch(function () {
                    setLoading(loginForm, false);
                    showAlert(cfg.i18n.genericError, 'error');
                });
            });
        }

        if (forgotForm) {
            forgotForm.addEventListener('submit', function (e) {
                e.preventDefault();
                hideAlert();
                setLoading(forgotForm, true);
                post('serenity_forgot_password', {
                    user_login: document.getElementById('serenity-forgot-login').value,
                }).then(function (res) {
                    setLoading(forgotForm, false);
                    if (res.success) {
                        showAlert(res.data.message, 'success');
                    } else {
                        showAlert((res.data && res.data.message) || cfg.i18n.genericError, 'error');
                    }
                }).catch(function () {
                    setLoading(forgotForm, false);
                    showAlert(cfg.i18n.genericError, 'error');
                });
            });
        }
    });
})();
