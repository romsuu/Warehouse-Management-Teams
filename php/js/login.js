document.addEventListener("DOMContentLoaded", () => {
    console.log("login.js has loaded! ✅");

    const loginForm = document.getElementById("loginForm");

    if (!loginForm) {
        console.error("❌ Login form not found!");
        return;
    }

    loginForm.addEventListener("submit", (e) => {
        e.preventDefault(); // Prevent default form submission

        const formData = new FormData(loginForm);

        fetch("/a2/php/login.php", { // ✅ Corrected fetch path
            method: "POST",
            body: formData,
        })
        .then(response => {
            if (!response.ok) {
                throw new Error(`HTTP error! Status: ${response.status}`);
            }
            return response.text(); // Read response as text first
        })
        .then(text => {
            try {
                const data = JSON.parse(text); // Try parsing JSON
                console.log("Login response:", data);
                if (data.success) {
                    alert("Login successful!");
                    window.location.href = data.redirect; // ✅ Redirect on success
                } else {
                    showError(data.message);
                }
            } catch (error) {
                console.error("Invalid JSON response:", text);
                showError("Unexpected server response. Check console for details.");
            }
        })
        .catch(error => {
            console.error("❌ Error:", error);
            showError("Login failed. Check console for details.");
        });
    });

    function showError(message) {
        const messageBox = document.getElementById("messageBox");
        messageBox.textContent = message;
        messageBox.style.backgroundColor = "#f44336";
        messageBox.style.color = "#fff";
        messageBox.style.padding = "10px";
        messageBox.style.marginTop = "10px";
        messageBox.style.borderRadius = "5px";
        messageBox.style.textAlign = "center";
    }
});
