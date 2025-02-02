document.addEventListener("DOMContentLoaded", function () {
    fetch('/php/truckArrivalStatus.php')
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                document.getElementById('truckStatus').innerHTML = data.data.map(truck => 
                    `<li>${truck.truck_number} - ${truck.status}</li>`).join('');
            }
        })
        .catch(error => console.error("Error loading truck status:", error));
});
