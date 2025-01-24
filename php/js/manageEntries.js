document.addEventListener("DOMContentLoaded", () => {
    const deleteButtons = document.querySelectorAll(".delete-entry");
    const editButtons = document.querySelectorAll(".edit-entry");

    deleteButtons.forEach(button => {
        button.addEventListener("click", () => {
            const entryId = button.dataset.id;
            fetch(`/a2/php/deleteEntry.php?id=${entryId}`, { method: "DELETE" })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        alert(data.message);
                        location.reload();
                    } else {
                        alert("Error: " + data.message);
                    }
                });
        });
    });

    editButtons.forEach(button => {
        button.addEventListener("click", () => {
            const entryId = button.dataset.id;
            const newValue = prompt("Enter the updated value:");
            if (newValue) {
                fetch(`/a2/php/editEntry.php`, {
                    method: "POST",
                    body: JSON.stringify({ id: entryId, value: newValue }),
                    headers: {
                        "Content-Type": "application/json"
                    }
                })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            alert(data.message);
                            location.reload();
                        } else {
                            alert("Error: " + data.message);
                        }
                    });
            }
        });
    });
});
