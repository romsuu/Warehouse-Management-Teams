document.addEventListener("DOMContentLoaded", () => {
    console.log("manageJobs.js has loaded!"); // Debugging Log

    const jobForm = document.getElementById("addJobForm");
    const jobsTable = document.getElementById("jobsTable");

    if (!jobForm || !jobsTable) {
        console.error("Job form or table not found! Ensure HTML has the correct elements.");
        return;
    }

    function getFetchURL() {
        return "/a2/php/manageJobs.php";  // Corrected fetch path
    }

    // Prevent page refresh on form submission
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
            console.log("Response received:", data);
            alert(data.message);
            if (data.success) {
                loadJobs(); // Reload job list dynamically
                jobForm.reset();
            } else {
                console.error("Error:", data.message);
            }
        })
        .catch(error => {
            console.error("Error adding job:", error);
            alert("Failed to add job. Check console for details.");
        });
    });

    // Load Jobs Without Reloading Page
    function loadJobs() {
        fetch(getFetchURL() + "?action=get")
            .then(response => {
                if (!response.ok) {
                    throw new Error(`HTTP error! Status: ${response.status}`);
                }
                return response.json();
            })
            .then(data => {
                console.log("Jobs loaded:", data); // Debugging Log
                if (data.success && data.jobs.length > 0) {
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
                } else {
                    jobsTable.innerHTML = "<tr><td colspan='3'>No jobs available.</td></tr>";
                }
            })
            .catch(error => console.error("Error loading jobs:", error));
    }

    loadJobs(); // Initial load of job data
});
