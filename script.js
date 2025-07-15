const showForm = (idIndex) => {
    document.querySelectorAll(".form-box").forEach(form => form.classList.remove("active"));
    document.getElementById(idIndex).classList.add("active")
}