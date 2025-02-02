function sendTruckEmail(email, truckDetails) {
    fetch('/php/emailNotification.php', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify({ email: email, details: truckDetails })
    })
    .then(response => response.json())
    .then(data => alert(data.message))
    .catch(error => console.error("Error sending email:", error));
}
