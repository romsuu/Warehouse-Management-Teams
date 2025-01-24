document.addEventListener("DOMContentLoaded", () => {
    console.log("adminPanel.js has loaded!"); // Debugging Log

    const jobForm = document.getElementById("addJobForm");
    const jobsTable = document.getElementById("jobsTable");

    if (!jobForm || !jobsTable) {
        console.error("Job form or table not found! Ensure correct HTML structure.");
        return;
    }

    function getFetchURL() {
        return "/a2/php/manageJobs.php";  // Ensure correct fetch path
    }

    // Add Job
    jobForm.addEventListener("submit", function (e) {
        e.preventDefault();

        let formData = new FormData(this);
        formData.append("action", "add");

        console.log("Sending job data:", Object.fromEntries(formData)); // Debugging Log

        fetch(getFetchURL(), {
            method: "POST",
            body: formData,
        })
        .then(response => response.json())
        .then(data => {
            alert(data.message);
            if (data.success) {
                loadJobs(); // Reload job list
            }
        })
        .catch(error => {
            console.error("Error adding job:", error);
            alert("Failed to add job. Check console for details.");
        });
    });

    // Load Jobs on Page Load
    function loadJobs() {
        fetch(getFetchURL() + "?action=get")
            .then(response => {
                if (!response.ok) {
                    throw new Error('Network response was not ok');
                }
                return response.json();
            })
            .then(data => {
                console.log("Jobs loaded:", data);
                if (data.success) {
                    let rows = "";
                    data.jobs.forEach(job => {
                        rows += `<tr>
                            <td>${job.job_name}</td>
                            <td>${job.multiplier}</td>
                            <td>
                                <button class="edit-job" data-id="${job.id}">Edit</button>
                                <button class="delete-job" data-id="${job.id}">Delete</button>
                            </td>
                        </tr>`;
                    });
                    jobsTable.innerHTML = rows;
                }
            })
            .catch(error => console.error("Error loading jobs:", error));
    }

    loadJobs(); // Initial load of job data
});
