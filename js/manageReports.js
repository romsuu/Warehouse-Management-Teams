document.addEventListener("DOMContentLoaded", () => {
    console.log("✅ manageReports.js loaded!");

    function loadReports() {
        fetch("/php/getReports.php")
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    const reportsTable = document.getElementById("reportsTable");
                    reportsTable.innerHTML = "";
                    data.reports.forEach(report => {
                        reportsTable.innerHTML += `
                            <tr>
                                <td>${report.date}</td>
                                <td>${report.team}</td>
                                <td>${report.total_rows}</td>
                                <td>
                                    <button class="view-report" data-id="${report.id}">View</button>
                                    <button class="delete-report" data-id="${report.id}">Delete</button>
                                </td>
                            </tr>`;
                    });
                }
            })
            .catch(error => console.error("❌ Error loading reports:", error));
    }

    document.addEventListener("click", (event) => {
        if (event.target.classList.contains("view-report")) {
            const reportId = event.target.dataset.id;
            window.location.href = `/php/viewReport.php?id=${reportId}`;
        }

        if (event.target.classList.contains("delete-report")) {
            const reportId = event.target.dataset.id;
            if (confirm("Are you sure you want to delete this report?")) {
                fetch("/php/deleteReport.php", {
                    method: "POST",
                    body: new URLSearchParams({ reportId })
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        alert("✅ " + data.message);
                        loadReports();
                    } else {
                        alert("❌ " + data.message);
                    }
                })
                .catch(error => console.error("❌ Error deleting report:", error));
            }
        }
    });

    loadReports();
});
