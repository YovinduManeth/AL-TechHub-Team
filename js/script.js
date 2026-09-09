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

// ==========================================
// REGISTRATION SUCCESS MESSAGE
// ==========================================

const urlParams = new URLSearchParams(window.location.search);

if (urlParams.get("registered") === "success") {

    const registrationMessage =
        document.getElementById("registrationMessage");

    if (registrationMessage) {

        registrationMessage.classList.remove("d-none");
        registrationMessage.classList.add("d-flex");

    }

}



// ==========================================
// LOGIN ERROR MESSAGE
// ==========================================

const loginUrlParams = new URLSearchParams(window.location.search);

if (loginUrlParams.get("error") === "invalid") {

    const loginErrorMessage =
        document.getElementById("loginErrorMessage");

    if (loginErrorMessage) {

        loginErrorMessage.classList.remove("d-none");
        loginErrorMessage.classList.add("d-flex");

    }

    window.history.replaceState(
        {},
        document.title,
        window.location.pathname
    );

}


// ==========================================
// Global Day / Night Mode
// ==========================================

function setupThemeMode() {

    const modeButton =
        document.getElementById("themeToggle");

    const modeIcon =
        document.getElementById("themeIcon");


    // Stop if theme button does not exist
    if (!modeButton || !modeIcon) {
        return;
    }
}

// ==========================================
// Smooth Scrolling
// ==========================================

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

// ==========================================
// Data-Saver Mode
// ==========================================

function setupDataSaverMode() {

    const toggle =
        document.getElementById("dataModeToggle");

    const videoContainer =
        document.getElementById("videoContainer");

    const audioContainer =
        document.getElementById("audioContainer");

    const videoQualityBox =
        document.querySelector(".video-quality-box");

    const videoPlayer =
        document.getElementById("videoPlayer");

    const audioPlayer =
        document.getElementById("audioPlayer");

    const audioSource =
        audioPlayer
            ? audioPlayer.querySelector("source")
            : null;


    // Stop if this is not the lesson page

    if (
        !toggle ||
        !videoContainer ||
        !audioContainer ||
        !videoQualityBox ||
        !videoPlayer ||
        !audioPlayer ||
        !audioSource
    ) {

        return;

    }


    toggle.addEventListener(
        "change",
        function () {

            // ==========================================
            // DATA-SAVER ON
            // ==========================================

            if (toggle.checked) {

                // Save video position BEFORE stopping it

                const videoTime =
                    videoPlayer.currentTime;


                console.log(
                    "Switching to Data Saver Mode"
                );

                console.log(
                    "Video position:",
                    videoTime
                );


                // Stop video

                videoPlayer.pause();


                // Hide video

                videoContainer.style.display =
                    "none";


                // Hide quality selector

                videoQualityBox.style.display =
                    "none";


                // Show audio

                audioContainer.style.display =
                    "block";


                // Get audio source

                const audioPath =
                    audioSource.getAttribute("src");


                console.log(
                    "Data-Saver audio path:",
                    audioPath
                );


                // Check audio exists

                if (
                    !audioPath ||
                    audioPath.trim() === ""
                ) {

                    alert(
                        "No audio file is available for this lesson."
                    );


                    toggle.checked = false;

                    videoContainer.style.display =
                        "block";

                    videoQualityBox.style.display =
                        "flex";

                    audioContainer.style.display =
                        "none";

                    return;

                }


                // ==========================================
                // WAIT FOR AUDIO TO LOAD
                // ==========================================

                function startAudioAtVideoPosition() {

                    audioPlayer.currentTime =
                        videoTime;


                    console.log(
                        "Audio position set to:",
                        audioPlayer.currentTime
                    );


                    audioPlayer.play().catch(
                        function (error) {

                            console.log(
                                "Audio playback error:",
                                error
                            );

                        }
                    );

                }


                // If audio metadata is already available

                if (audioPlayer.readyState >= 1) {

                    startAudioAtVideoPosition();

                }


                // Otherwise wait for metadata

                else {

                    audioPlayer.addEventListener(
                        "loadedmetadata",
                        function audioReady() {

                            startAudioAtVideoPosition();


                            audioPlayer.removeEventListener(
                                "loadedmetadata",
                                audioReady
                            );

                        }
                    );

                }

            }
