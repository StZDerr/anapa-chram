let nameCount = 10;

function renderNameInputs(count) {
    const list = document.getElementById("prayer-names-list");
    list.innerHTML = "";
    for (let i = 1; i <= count; i++) {
        const input = document.createElement("input");
        input.type = "text";
        input.className = "form-control mb-2";
        input.placeholder = `Имя ${i}`;
        input.name = `names[]`;
        list.appendChild(input);
    }
}

document.addEventListener("DOMContentLoaded", function () {
    if (document.getElementById("prayer-names-list")) {
        renderNameInputs(nameCount);
        document
            .getElementById("add-names-btn")
            .addEventListener("click", function (e) {
                e.preventDefault();
                nameCount += 10;
                renderNameInputs(nameCount);
            });
    }
});
