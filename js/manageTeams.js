document.addEventListener("DOMContentLoaded", () => {
    console.log("✅ manageTeams.js has loaded!");

    // Load Teams
    function loadTeams() {
        fetch("/php/manageTeams.php")
            .then(response => response.text())
            .then(html => {
                document.getElementById("manage-teams").innerHTML = html;
                attachTeamListeners();
            })
            .catch(error => console.error("❌ Error loading teams:", error));
    }

    // Handle Add Team
    document.getElementById("addTeamForm")?.addEventListener("submit", (e) => {
        e.preventDefault();
        const formData = new FormData(e.target);

        fetch("/php/manageTeams.php", {
            method: "POST",
            body: formData,
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                alert("✅ " + data.message);
                loadTeams();
            } else {
                alert("❌ " + data.message);
            }
        })
        .catch(error => console.error("❌ Error adding team:", error));
    });

    // Attach Listeners for Delete
    function attachTeamListeners() {
        document.querySelectorAll(".delete-team").forEach(button => {
            button.addEventListener("click", function () {
                const teamId = this.dataset.id;
                if (confirm("Are you sure you want to delete this team?")) {
                    const formData = new FormData();
                    formData.append("delete_team_id", teamId);

                    fetch("/php/manageTeams.php", {
                        method: "POST",
                        body: formData,
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            alert("✅ " + data.message);
                            loadTeams();
                        } else {
                            alert("❌ " + data.message);
                        }
                    })
                    .catch(error => console.error("❌ Error deleting team:", error));
                }
            });
        });
    }

    // Load Teams on Page Load
    loadTeams();
});
