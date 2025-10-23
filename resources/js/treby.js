document.addEventListener("DOMContentLoaded", () => {
    // Модальное окно треб
    const trebyModal = document.getElementById("trebyModal");
    if (trebyModal) {
        trebyModal.addEventListener("show.bs.modal", (event) => {
            const button = event.relatedTarget;
            const type = button.getAttribute("data-type");
            const price = button.getAttribute("data-price");

            const modalTypeInput = trebyModal.querySelector("#trebyType");
            const modalAmountInput = trebyModal.querySelector("#trebyAmount");

            if (modalTypeInput) modalTypeInput.value = type;
            if (modalAmountInput) modalAmountInput.value = price;
        });
    }

    // Валидация формы треб
    const trebyForm = document.getElementById("trebyForm");
    if (trebyForm) {
        trebyForm.addEventListener("submit", (event) => {
            event.preventDefault();
            event.stopPropagation();

            if (!trebyForm.checkValidity()) {
                trebyForm.classList.add("was-validated");
                return;
            }

            // Здесь будет отправка данных на сервер
            alert(
                "Форма требы успешно отправлена! (Интеграция с платежной системой в разработке)"
            );

            // Закрыть модальное окно
            const modal = bootstrap.Modal.getInstance(trebyModal);
            if (modal) modal.hide();

            // Очистить форму
            trebyForm.reset();
            trebyForm.classList.remove("was-validated");
        });
    }

    // Валидация формы пожертвования
    const donationForm = document.getElementById("donationForm");
    if (donationForm) {
        donationForm.addEventListener("submit", (event) => {
            event.preventDefault();
            event.stopPropagation();

            if (!donationForm.checkValidity()) {
                donationForm.classList.add("was-validated");
                return;
            }

            // Здесь будет отправка данных на сервер
            alert(
                "Форма пожертвования успешно отправлена! (Интеграция с платежной системой в разработке)"
            );

            // Закрыть модальное окно
            const donationModal = document.getElementById("donationModal");
            const modal = bootstrap.Modal.getInstance(donationModal);
            if (modal) modal.hide();

            // Очистить форму
            donationForm.reset();
            donationForm.classList.remove("was-validated");
        });
    }
});
