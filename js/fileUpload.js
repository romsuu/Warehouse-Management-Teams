document.getElementById('uploadProtocolForm').addEventListener('submit', function (event) {
    event.preventDefault();
    let formData = new FormData(this);

    fetch('/php/fileUploadHandler.php', {
        method: 'POST',
        body: formData
    })
    .then(response => response.json())
    .then(data => alert(data.message))
    .catch(error => console.error("Error uploading file:", error));
});
