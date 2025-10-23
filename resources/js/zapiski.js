document.addEventListener("DOMContentLoaded", () => {
    // Модальное окно записок
    const zapiskiModal = document.getElementById("zapiskiModal");
    if (zapiskiModal) {
        zapiskiModal.addEventListener("show.bs.modal", (event) => {
            const button = event.relatedTarget;
            const type = button.getAttribute("data-type");
            const price = button.getAttribute("data-price");

            const modalTypeInput = zapiskiModal.querySelector("#zapiskiType");
            const modalAmountInput =
                zapiskiModal.querySelector("#zapiskiAmount");

            if (modalTypeInput) modalTypeInput.value = type;
            if (modalAmountInput) modalAmountInput.value = price;
        });
    }

    // Валидация формы
    const zapiskiForm = document.getElementById("zapiskiForm");
    if (zapiskiForm) {
        zapiskiForm.addEventListener("submit", (event) => {
            event.preventDefault();
            event.stopPropagation();

            if (!zapiskiForm.checkValidity()) {
                zapiskiForm.classList.add("was-validated");
                return;
            }

            // Здесь будет отправка данных на сервер
            alert(
                "Форма успешно отправлена! (Интеграция с платежной системой в разработке)"
            );

            // Закрыть модальное окно
            const modal = bootstrap.Modal.getInstance(zapiskiModal);
            if (modal) modal.hide();

            // Очистить форму
            zapiskiForm.reset();
            zapiskiForm.classList.remove("was-validated");
        });
    }
});
