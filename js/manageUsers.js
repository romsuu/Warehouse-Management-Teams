document.addEventListener("DOMContentLoaded", () => {
    console.log("✅ manageUsers.js loaded!");

    function loadUsers() {
        fetch("/php/getUsers.php")
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    const usersTable = document.getElementById("usersTable");
                    usersTable.innerHTML = "";
                    data.users.forEach(user => {
                        usersTable.innerHTML += `
                            <tr>
                                <td>${user.username}</td>
                                <td>${user.role}</td>
                                <td>
                                    <button class="edit-user" data-id="${user.id}">Edit</button>
                                    <button class="delete-user" data-id="${user.id}">Delete</button>
                                </td>
                            </tr>`;
                    });
                }
            })
            .catch(error => console.error("❌ Error loading users:", error));
    }

    document.getElementById("addUserForm")?.addEventListener("submit", (e) => {
        e.preventDefault();
        const formData = new FormData(e.target);

        fetch("/php/manageUsers.php", {
            method: "POST",
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                alert("✅ " + data.message);
                loadUsers();
            } else {
                alert("❌ " + data.message);
            }
        })
        .catch(error => console.error("❌ Error adding user:", error));
    });

    document.addEventListener("click", (event) => {
        if (event.target.classList.contains("edit-user")) {
            const userId = event.target.dataset.id;
            const username = prompt("Edit Username:");
            const role = prompt("Edit Role:");

            if (username && role) {
                const formData = new FormData();
                formData.append("editUserId", userId);
                formData.append("editUsername", username);
                formData.append("editRole", role);

                fetch("/php/editUser.php", {
                    method: "POST",
                    body: formData
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        alert("✅ " + data.message);
                        loadUsers();
                    } else {
                        alert("❌ " + data.message);
                    }
                })
                .catch(error => console.error("❌ Error updating user:", error));
            }
        }

        if (event.target.classList.contains("delete-user")) {
            const userId = event.target.dataset.id;
            if (confirm("Are you sure you want to delete this user?")) {
                fetch("/php/deleteUser.php", {
                    method: "POST",
                    body: new URLSearchParams({ userId })
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        alert("✅ " + data.message);
                        loadUsers();
                    } else {
                        alert("❌ " + data.message);
                    }
                })
                .catch(error => console.error("❌ Error deleting user:", error));
            }
        }
    });

    loadUsers();
});
