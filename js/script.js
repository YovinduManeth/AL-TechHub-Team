function setupPasswordToggle(toggleId, passwordId, iconId) {

    const toggleButton = document.getElementById(toggleId);
    const passwordInput = document.getElementById(passwordId);
    const eyeIcon = document.getElementById(iconId);

        if (!toggleButton || !passwordInput || !eyeIcon) {
        return;
    }

    toggleButton.addEventListener("click", function () {

        if (passwordInput.type === "password") {

            passwordInput.type = "text";

            eyeIcon.classList.remove("bi-eye");
            eyeIcon.classList.add("bi-eye-slash");

            toggleButton.setAttribute(
                "aria-label",
                "Hide password"
            );

        } else {

            passwordInput.type = "password";

            eyeIcon.classList.remove("bi-eye-slash");
            eyeIcon.classList.add("bi-eye");

            toggleButton.setAttribute(
                "aria-label",
                "Show password"
            );
        }

    });
}

setupPasswordToggle(
    "togglePassword",
    "password",
    "eyeIcon"
);

setupPasswordToggle(
    "toggleConfirmPassword",
    "confirmPassword",
    "confirmEyeIcon"
);


const registerForm = document.getElementById("registerForm");
const password = document.getElementById("password");
const confirmPassword = document.getElementById("confirmPassword");

if (registerForm && password && confirmPassword) {

    registerForm.addEventListener("submit", function (event) {

        if (password.value !== confirmPassword.value) {

            event.preventDefault();

            confirmPassword.classList.add("is-invalid");

            alert("Passwords do not match. Please check your password.");

        } else {

            confirmPassword.classList.remove("is-invalid");

        }

    });

}


document.addEventListener("DOMContentLoaded", function () {

    const smoothLinks = document.querySelectorAll('a[href^="#"]');

    smoothLinks.forEach(function (link) {

        link.addEventListener("click", function (event) {

            const targetId = this.getAttribute("href");

            if (targetId === "#") {
                return;
            }

            const target = document.querySelector(targetId);

            if (target) {

                event.preventDefault();

                target.scrollIntoView({
                    behavior: "smooth",
                    block: "start"
                });

            }

        });

    });

});