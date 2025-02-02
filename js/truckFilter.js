document.getElementById('searchInput').addEventListener('keyup', function () {
    let query = this.value;
    fetch(`/php/vehicleSearch.php?query=${query}`)
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                document.getElementById('truckList').innerHTML = data.data.map(truck => 
                    `<tr>
                        <td>${truck.carrier}</td>
                        <td>${truck.truck_number}</td>
                        <td>${truck.trailer_number}</td>
                        <td>${truck.pallets}</td>
                        <td>${truck.ibc}</td>
                        <td>${truck.arrival_date}</td>
                    </tr>`).join('');
            }
        })
        .catch(error => console.error("Error filtering trucks:", error));
});
