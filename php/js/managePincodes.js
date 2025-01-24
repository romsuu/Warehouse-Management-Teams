document.addEventListener("DOMContentLoaded", () => {
    const pincodeTable = document.getElementById("pincodeTable");
    const addPincodeForm = document.getElementById("addPincodeForm");

    function loadPincodes() {
        fetch("/a2/php/managePincodes.php")
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    let rows = "";
                    data.pincodes.forEach(pincode => {
                        rows += `<tr>
                                <td>${pincode.pincode}</td>
                                <td>${pincode.role_name}</td>
                                <td>
                                    <button onclick="deletePincode(${pincode.id})">Delete</button>
                                </td>
                            </tr>`;
                    });
                    pincodeTable.innerHTML = rows;
                } else {
                    pincodeTable.innerHTML = "<tr><td colspan='3'>No pincodes found.</td></tr>";
                }
            })
            .catch(error => console.error("Error loading pincodes:", error));
    }

    addPincodeForm.addEventListener("submit", function (e) {
        e.preventDefault();

        const formData = new FormData(addPincodeForm);
        fetch("/a2/php/managePincodes.php", {
            method: "POST",
            body: formData,
        })
        .then(response => response.json())
        .then(data => {
            alert(data.message);
            if (data.success) loadPincodes();
        })
        .catch(error => console.error("Error adding pincode:", error));
    });

    loadPincodes();
});
