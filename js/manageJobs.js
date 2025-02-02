document.addEventListener("DOMContentLoaded", () => {
    console.log("✅ manageJobs.js loaded!");

    function loadJobs() {
        fetch("/php/getJobs.php")
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    const jobsTable = document.getElementById("jobsTable");
                    jobsTable.innerHTML = "";
                    data.jobs.forEach(job => {
                        jobsTable.innerHTML += `
                            <tr>
                                <td>${job.job_name}</td>
                                <td>${job.multiplier}</td>
                                <td>
                                    <button class="edit-job" data-id="${job.id}">Edit</button>
                                    <button class="delete-job" data-id="${job.id}">Delete</button>
                                </td>
                            </tr>`;
                    });
                }
            })
            .catch(error => console.error("❌ Error loading jobs:", error));
    }

    document.getElementById("addJobForm")?.addEventListener("submit", (e) => {
        e.preventDefault();
        const formData = new FormData(e.target);

        fetch("/php/manageJobs.php", {
            method: "POST",
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                alert("✅ " + data.message);
                loadJobs();
            } else {
                alert("❌ " + data.message);
            }
        })
        .catch(error => console.error("❌ Error adding job:", error));
    });

    document.addEventListener("click", (event) => {
        if (event.target.classList.contains("edit-job")) {
            const jobId = event.target.dataset.id;
            const jobName = prompt("Edit Job Name:");
            const multiplier = prompt("Edit Multiplier:");

            if (jobName && multiplier) {
                const formData = new FormData();
                formData.append("editJobId", jobId);
                formData.append("editJobName", jobName);
                formData.append("editMultiplier", multiplier);

                fetch("/php/editJob.php", {
                    method: "POST",
                    body: formData
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        alert("✅ " + data.message);
                        loadJobs();
                    } else {
                        alert("❌ " + data.message);
                    }
                })
                .catch(error => console.error("❌ Error updating job:", error));
            }
        }

        if (event.target.classList.contains("delete-job")) {
            const jobId = event.target.dataset.id;
            if (confirm("Are you sure you want to delete this job?")) {
                fetch("/php/deleteJob.php", {
                    method: "POST",
                    body: new URLSearchParams({ jobId })
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        alert("✅ " + data.message);
                        loadJobs();
                    } else {
                        alert("❌ " + data.message);
                    }
                })
                .catch(error => console.error("❌ Error deleting job:", error));
            }
        }
    });

    loadJobs();
});
