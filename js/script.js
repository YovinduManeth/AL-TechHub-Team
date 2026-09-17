// =========================================================
// A/L TechHub - Main JavaScript
// =========================================================


// =========================================================
// PASSWORD SHOW / HIDE
// =========================================================

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


// Student Login password
setupPasswordToggle(
    "togglePassword",
    "password",
    "eyeIcon"
);


// Student Registration password
setupPasswordToggle(
    "toggleConfirmPassword",
    "confirmPassword",
    "confirmEyeIcon"
);


// =========================================================
// REGISTRATION FORM VALIDATION
// =========================================================

const registerForm = document.getElementById("registerForm");
const registerPassword = document.getElementById("password");
const registerConfirmPassword =
    document.getElementById("confirmPassword");

if (
    registerForm &&
    registerPassword &&
    registerConfirmPassword
) {

    registerForm.addEventListener("submit", function (event) {

        if (
            registerPassword.value !==
            registerConfirmPassword.value
        ) {

            event.preventDefault();

            registerConfirmPassword.classList.add(
                "is-invalid"
            );

            alert(
                "Passwords do not match. Please check your password."
            );

        } else {

            registerConfirmPassword.classList.remove(
                "is-invalid"
            );

        }

    });

}


// =========================================================
// REGISTRATION SUCCESS MESSAGE
// =========================================================

const urlParams =
    new URLSearchParams(window.location.search);

if (
    urlParams.get("registered") ===
    "success"
) {

    const registrationMessage =
        document.getElementById(
            "registrationMessage"
        );

    if (registrationMessage) {

        registrationMessage.classList.remove(
            "d-none"
        );

        registrationMessage.classList.add(
            "d-flex"
        );

    }

}


// =========================================================
// LOGIN ERROR MESSAGE
// =========================================================

if (
    urlParams.get("error") ===
    "invalid"
) {

    const loginErrorMessage =
        document.getElementById(
            "loginErrorMessage"
        );

    if (loginErrorMessage) {

        loginErrorMessage.classList.remove(
            "d-none"
        );

        loginErrorMessage.classList.add(
            "d-flex"
        );

    }

    // Remove error parameter from the URL
    window.history.replaceState(
        {},
        document.title,
        window.location.pathname
    );

}


// =========================================================
// SMOOTH SCROLLING
// =========================================================

document.addEventListener(
    "DOMContentLoaded",
    function () {

        const smoothLinks =
            document.querySelectorAll(
                'a[href^="#"]'
            );

        smoothLinks.forEach(function (link) {

            link.addEventListener(
                "click",
                function (event) {

                    const targetId =
                        this.getAttribute("href");

                    if (
                        !targetId ||
                        targetId === "#"
                    ) {
                        return;
                    }

                    const target =
                        document.querySelector(
                            targetId
                        );

                    if (target) {

                        event.preventDefault();

                        target.scrollIntoView({
                            behavior: "smooth",
                            block: "start"
                        });

                    }

                }
            );

        });

    }
);


// =========================================================
// DAY / NIGHT MODE
// =========================================================

function setupThemeMode() {

    const modeButton =
        document.getElementById(
            "themeToggle"
        );

    const modeIcon =
        document.getElementById(
            "themeIcon"
        );

    if (!modeButton || !modeIcon) {
        return;
    }


    // -----------------------------------------------------
    // Load Saved Theme
    // -----------------------------------------------------

    const savedTheme =
        localStorage.getItem("theme");

    if (savedTheme === "dark") {

        document.body.classList.add(
            "dark-mode"
        );

        modeIcon.classList.remove(
            "bi-moon"
        );

        modeIcon.classList.add(
            "bi-sun"
        );

        modeButton.setAttribute(
            "aria-label",
            "Switch to day mode"
        );

        modeButton.setAttribute(
            "title",
            "Switch to day mode"
        );

    }


    // -----------------------------------------------------
    // Toggle Theme
    // -----------------------------------------------------

    modeButton.addEventListener(
        "click",
        function () {

            document.body.classList.toggle(
                "dark-mode"
            );

            const isDarkMode =
                document.body.classList.contains(
                    "dark-mode"
                );


            if (isDarkMode) {

                localStorage.setItem(
                    "theme",
                    "dark"
                );

                modeIcon.classList.remove(
                    "bi-moon"
                );

                modeIcon.classList.add(
                    "bi-sun"
                );

                modeButton.setAttribute(
                    "aria-label",
                    "Switch to day mode"
                );

                modeButton.setAttribute(
                    "title",
                    "Switch to day mode"
                );

            } else {

                localStorage.setItem(
                    "theme",
                    "light"
                );

                modeIcon.classList.remove(
                    "bi-sun"
                );

                modeIcon.classList.add(
                    "bi-moon"
                );

                modeButton.setAttribute(
                    "aria-label",
                    "Switch to night mode"
                );

                modeButton.setAttribute(
                    "title",
                    "Switch to night mode"
                );

            }

        }
    );

}


// Start Theme Mode
document.addEventListener(
    "DOMContentLoaded",
    setupThemeMode
);


// =========================================================
// DATA-SAVER MODE
// =========================================================

function setupDataSaverMode() {

    const toggle =
        document.getElementById(
            "dataModeToggle"
        );

    const videoContainer =
        document.getElementById(
            "videoContainer"
        );

    const audioContainer =
        document.getElementById(
            "audioContainer"
        );

    const videoQualityBox =
        document.querySelector(
            ".video-quality-box"
        );

    const videoPlayer =
        document.getElementById(
            "videoPlayer"
        );

    const audioPlayer =
        document.getElementById(
            "audioPlayer"
        );

    const audioSource =
        audioPlayer
            ? audioPlayer.querySelector(
                "source"
            )
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


            // =================================================
            // DATA-SAVER ON
            // =================================================

            if (toggle.checked) {

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


                const audioPath =
                    audioSource.getAttribute(
                        "src"
                    );


                // Check audio path
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


                // -------------------------------------------------
                // Start audio at video position
                // -------------------------------------------------

                function startAudioAtVideoPosition() {

                    audioPlayer.currentTime =
                        videoTime;

                    audioPlayer.play().catch(
                        function (error) {

                            console.log(
                                "Audio playback error:",
                                error
                            );

                        }
                    );

                }


                // Audio metadata already available
                if (
                    audioPlayer.readyState >= 1
                ) {

                    startAudioAtVideoPosition();

                } else {

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


            // =================================================
            // DATA-SAVER OFF
            // =================================================

            else {

                const audioTime =
                    audioPlayer.currentTime;


                console.log(
                    "Switching to Normal Mode"
                );

                console.log(
                    "Audio position:",
                    audioTime
                );


                // Stop audio
                audioPlayer.pause();


                // Restore video position
                videoPlayer.currentTime =
                    audioTime;


                // Hide audio
                audioContainer.style.display =
                    "none";


                // Show video
                videoContainer.style.display =
                    "block";


                // Show quality selector
                videoQualityBox.style.display =
                    "flex";


                // Continue video
                videoPlayer.play().catch(
                    function (error) {

                        console.log(
                            "Video playback error:",
                            error
                        );

                    }
                );

            }

        }
    );

}


// Start Data-Saver Mode
setupDataSaverMode();


// =========================================================
// END OF A/L TECHHUB MAIN SCRIPT
// =========================================================