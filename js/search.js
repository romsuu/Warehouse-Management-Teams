document.addEventListener("DOMContentLoaded", function () {
    const searchInput = document.getElementById("search");
    searchInput.addEventListener("input", function () {
        const query = searchInput.value.toLowerCase();
        document.querySelectorAll(".searchable").forEach(item => {
            item.style.display = item.textContent.toLowerCase().includes(query) ? "block" : "none";
        });
    });
});
