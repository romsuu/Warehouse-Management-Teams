document.addEventListener("DOMContentLoaded", () => {
    console.log("✅ functions.js loaded!");

    function showTab(tabId) {
        document.querySelectorAll(".tab-content").forEach(tab => tab.style.display = "none");
        document.getElementById(tabId).style.display = "block";
    }

    showTab("manage-jobs"); // Default tab

    function fetchData(url, callback) {
        fetch(url)
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    callback(data);
                } else {
                    console.error("❌ Error:", data.message);
                }
            })
            .catch(error => console.error("❌ Fetch error:", error));
    }

    function loadJobs() {
        fetchData("/php/getJobs.php", (data) => {
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
        });
    }

    function loadPincodes() {
        fetchData("/php/getPincodes.php", (data) => {
            const pincodesTable = document.getElementById("pincodesTable");
            pincodesTable.innerHTML = "";
            data.pincodes.forEach(pincode => {
                pincodesTable.innerHTML += `
                    <tr>
                        <td>${pincode.pincode}</td>
                        <td>${pincode.role}</td>
                        <td>
                            <button class="delete-pincode" data-id="${pincode.id}">Delete</button>
                        </td>
                    </tr>`;
            });
        });
    }

    document.getElementById("refreshJobs")?.addEventListener("click", loadJobs);
    document.getElementById("refreshPincodes")?.addEventListener("click", loadPincodes);
});
