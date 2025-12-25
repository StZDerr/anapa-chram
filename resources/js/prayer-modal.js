let nameCount = 10;

function renderNameInputs(count, values = []) {
    const list = document.getElementById("prayer-names-list");
    if (!list) return;
    list.innerHTML = "";
    for (let i = 0; i < count; i++) {
        const input = document.createElement("input");
        input.type = "text";
        input.className = "form-control mb-2";
        input.placeholder = `Имя ${i + 1}`;
        input.name = `names[]`;
        input.value = values[i] ?? "";
        list.appendChild(input);
    }
    nameCount = count;
}

function getNames() {
    return Array.from(
        document.querySelectorAll('#prayer-names-list input[name="names[]"]')
    ).map((i) => i.value);
}

function showMessage(text, timeout = 2500) {
    // Простой временный уведомитель
    const msg = document.createElement("div");
    msg.className = "alert alert-info";
    msg.style.position = "fixed";
    msg.style.right = "20px";
    msg.style.bottom = "20px";
    msg.style.zIndex = 2000;
    msg.textContent = text;
    document.body.appendChild(msg);
    setTimeout(() => msg.remove(), timeout);
}

function fallbackCopy(text) {
    const ta = document.createElement("textarea");
    ta.value = text;
    ta.style.position = "fixed";
    ta.style.left = "-9999px";
    document.body.appendChild(ta);
    ta.select();
    try {
        document.execCommand("copy");
        showMessage("Скопировано в буфер обмена ✅");
    } catch (e) {
        showMessage(
            "Не удалось автоматически скопировать. Вставьте текст вручную."
        );
    }
    document.body.removeChild(ta);
}

function copyNames() {
    const names = getNames();
    // сохраняем порядок и количество: даже пустые строки учитываются
    const text = names.join("\n");
    if (navigator.clipboard && navigator.clipboard.writeText) {
        navigator.clipboard
            .writeText(text)
            .then(() => {
                showMessage("Скопировано в буфер обмена ✅");
            })
            .catch(() => fallbackCopy(text));
    } else {
        fallbackCopy(text);
    }
}

function pasteNamesFromText(text) {
    if (!text) {
        showMessage("Вставка пустая");
        return;
    }
    // нормализуем и убираем завершающий пустой перевод строки (если случайно скопили)
    const lines = text.replace(/\r/g, "").split("\n");
    if (lines.length && lines[lines.length - 1] === "") lines.pop();
    if (!lines.length) {
        showMessage("Вставка не содержит имен");
        return;
    }
    renderNameInputs(lines.length, lines);
    showMessage(
        `Вставлено ${lines.length} ${pluralize(
            lines.length,
            "имя",
            "имени",
            "имён"
        )} ✅`
    );
}

function pasteFromClipboard() {
    if (navigator.clipboard && navigator.clipboard.readText) {
        navigator.clipboard
            .readText()
            .then((text) => {
                if (text) pasteNamesFromText(text);
                else showManualPasteOverlay(); // пустой буфер — открываем ручной ввод
            })
            .catch(() => showManualPasteOverlay());
    } else {
        showManualPasteOverlay();
    }
}

function showManualPasteOverlay(prefill = "") {
    // Временный оверлей с textarea для ручной вставки
    const overlay = document.createElement("div");
    overlay.style.position = "fixed";
    overlay.style.left = 0;
    overlay.style.top = 0;
    overlay.style.right = 0;
    overlay.style.bottom = 0;
    overlay.style.background = "rgba(0,0,0,0.5)";
    overlay.style.zIndex = 2001;
    overlay.style.display = "flex";
    overlay.style.alignItems = "center";
    overlay.style.justifyContent = "center";

    const box = document.createElement("div");
    box.style.background = "#fff";
    box.style.padding = "16px";
    box.style.maxWidth = "600px";
    box.style.width = "100%";
    box.style.boxShadow = "0 6px 18px rgba(0,0,0,0.2)";

    const ta = document.createElement("textarea");
    ta.style.width = "100%";
    ta.style.height = "200px";
    ta.placeholder = "Вставьте имена — по одному на строку";
    ta.value = prefill;

    const btns = document.createElement("div");
    btns.className = "d-flex gap-2 mt-2 justify-content-end";

    const ok = document.createElement("button");
    ok.className = "btn btn-primary";
    ok.textContent = "Вставить";
    ok.addEventListener("click", () => {
        pasteNamesFromText(ta.value);
        document.body.removeChild(overlay);
    });

    const cancel = document.createElement("button");
    cancel.className = "btn btn-secondary";
    cancel.textContent = "Отмена";
    cancel.addEventListener("click", () => document.body.removeChild(overlay));

    btns.appendChild(cancel);
    btns.appendChild(ok);

    box.appendChild(ta);
    box.appendChild(btns);
    overlay.appendChild(box);
    document.body.appendChild(overlay);
}

function pluralize(n, one, two, many) {
    // простая русская форма
    n = Math.abs(n);
    if (n % 10 === 1 && n % 100 !== 11) return one;
    if ([2, 3, 4].includes(n % 10) && ![12, 13, 14].includes(n % 100))
        return two;
    return many;
}

document.addEventListener("DOMContentLoaded", function () {
    if (document.getElementById("prayer-names-list")) {
        renderNameInputs(nameCount);

        document
            .getElementById("add-names-btn")
            .addEventListener("click", function (e) {
                e.preventDefault();
                // Забираем текущие значения
                const existing = getNames(); // сохраняет порядок
                const newCount = nameCount + 10;
                // Формируем массив значений нужной длины (существующие + пустые)
                const values = [];
                for (let i = 0; i < newCount; i++) {
                    values[i] = existing[i] ?? "";
                }
                // Перерисовываем поля с сохранёнными значениями
                renderNameInputs(newCount, values);
                // Переводим фокус на первый только что добавленный инпут
                const inputs = document.querySelectorAll(
                    '#prayer-names-list input[name="names[]"]'
                );
                if (inputs.length > existing.length) {
                    inputs[existing.length].focus();
                }
            });

        const copyBtn = document.getElementById("copy-names-btn");
        const pasteBtn = document.getElementById("paste-names-btn");

        if (copyBtn)
            copyBtn.addEventListener("click", function (e) {
                e.preventDefault();
                copyNames();
            });

        if (pasteBtn)
            pasteBtn.addEventListener("click", function (e) {
                e.preventDefault();
                pasteFromClipboard();
            });
    }
});
