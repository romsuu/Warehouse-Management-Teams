document.addEventListener("DOMContentLoaded", () => {
    console.log("✅ manageTrucks.js loaded!");

    function loadTrucks() {
        fetch("/php/getTrucks.php")
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    const truckTable = document.getElementById("truckTable");
                    truckTable.innerHTML = "";
                    data.trucks.forEach(truck => {
                        truckTable.innerHTML += `
                            <tr>
                                <td>${truck.carrier}</td>
                                <td>${truck.truck_number}</td>
                                <td>${truck.trailer_number}</td>
                                <td>${truck.pallets} / ${truck.ibc}</td>
                                <td>${truck.arrival_date}</td>
                                <td>
                                    <button class="edit-truck" data-id="${truck.id}">Edit</button>
                                    <button class="delete-truck" data-id="${truck.id}">Delete</button>
                                </td>
                            </tr>`;
                    });
                }
            })
            .catch(error => console.error("❌ Error loading trucks:", error));
    }

    document.getElementById("addTruckForm")?.addEventListener("submit", (e) => {
        e.preventDefault();
        const formData = new FormData(e.target);

        fetch("/php/manageTrucks.php", {
            method: "POST",
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                alert("✅ " + data.message);
                loadTrucks();
            } else {
                alert("❌ " + data.message);
            }
        })
        .catch(error => console.error("❌ Error adding truck:", error));
    });

    document.addEventListener("click", (event) => {
        if (event.target.classList.contains("edit-truck")) {
            const truckId = event.target.dataset.id;
            const carrier = prompt("Edit Carrier:");
            const truckNumber = prompt("Edit Truck Number:");
            const trailerNumber = prompt("Edit Trailer Number:");
            const pallets = prompt("Edit Pallets:");
            const ibc = prompt("Edit IBC:");
            const arrivalDate = prompt("Edit Arrival Date:");

            if (carrier && truckNumber) {
                const formData = new FormData();
                formData.append("truckId", truckId);
                formData.append("carrier", carrier);
                formData.append("truckNumber", truckNumber);
                formData.append("trailerNumber", trailerNumber);
                formData.append("pallets", pallets);
                formData.append("ibc", ibc);
                formData.append("arrivalDate", arrivalDate);

                fetch("/php/editTruck.php", {
                    method: "POST",
                    body: formData
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        alert("✅ " + data.message);
                        loadTrucks();
                    } else {
                        alert("❌ " + data.message);
                    }
                })
                .catch(error => console.error("❌ Error updating truck:", error));
            }
        }

        if (event.target.classList.contains("delete-truck")) {
            const truckId = event.target.dataset.id;
            if (confirm("Are you sure you want to delete this truck?")) {
                fetch("/php/deleteTruck.php", {
                    method: "POST",
                    body: new URLSearchParams({ truckId })
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        alert("✅ " + data.message);
                        loadTrucks();
                    } else {
                        alert("❌ " + data.message);
                    }
                })
                .catch(error => console.error("❌ Error deleting truck:", error));
            }
        }
    });

    loadTrucks();
});
