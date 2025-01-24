document.addEventListener("DOMContentLoaded", () => {
    const form = document.getElementById("dataForm");

    form.addEventListener("submit", (e) => {
        e.preventDefault();

        const formData = new FormData(form);

        fetch("php/submitData.php", {
            method: "POST",
            body: formData,
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                alert(data.message);
                location.reload();
            } else {
                alert("Error: " + data.message);
            }
        })
        .catch(error => console.error("Error:", error));
    });
});
