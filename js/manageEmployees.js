document.addEventListener("DOMContentLoaded", () => {
    console.log("✅ manageEmployees.js loaded!");

    function loadEmployees() {
        fetch("/php/getEmployees.php")
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    const employeesTable = document.getElementById("employeesTable");
                    employeesTable.innerHTML = "";
                    data.employees.forEach(employee => {
                        employeesTable.innerHTML += `
                            <tr>
                                <td>${employee.employee_name}</td>
                                <td>${employee.team_name}</td>
                                <td>
                                    <button class="edit-employee" data-id="${employee.id}">Edit</button>
                                    <button class="delete-employee" data-id="${employee.id}">Delete</button>
                                </td>
                            </tr>`;
                    });
                }
            })
            .catch(error => console.error("❌ Error loading employees:", error));
    }

    document.getElementById("addEmployeeForm")?.addEventListener("submit", (e) => {
        e.preventDefault();
        const formData = new FormData(e.target);

        fetch("/php/manageEmployees.php", {
            method: "POST",
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                alert("✅ " + data.message);
                loadEmployees();
            } else {
                alert("❌ " + data.message);
            }
        })
        .catch(error => console.error("❌ Error adding employee:", error));
    });

    document.addEventListener("click", (event) => {
        if (event.target.classList.contains("edit-employee")) {
            const employeeId = event.target.dataset.id;
            const employeeName = prompt("Edit Employee Name:");
            const teamId = prompt("Enter New Team ID:");

            if (employeeName && teamId) {
                const formData = new FormData();
                formData.append("editEmployeeId", employeeId);
                formData.append("editEmployeeName", employeeName);
                formData.append("editTeamId", teamId);

                fetch("/php/editEmployee.php", {
                    method: "POST",
                    body: formData
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        alert("✅ " + data.message);
                        loadEmployees();
                    } else {
                        alert("❌ " + data.message);
                    }
                })
                .catch(error => console.error("❌ Error updating employee:", error));
            }
        }

        if (event.target.classList.contains("delete-employee")) {
            const employeeId = event.target.dataset.id;
            if (confirm("Are you sure you want to delete this employee?")) {
                fetch("/php/deleteEmployee.php", {
                    method: "POST",
                    body: new URLSearchParams({ employeeId })
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        alert("✅ " + data.message);
                        loadEmployees();
                    } else {
                        alert("❌ " + data.message);
                    }
                })
                .catch(error => console.error("❌ Error deleting employee:", error));
            }
        }
    });

    loadEmployees();
});
