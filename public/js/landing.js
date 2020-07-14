document.addEventListener("turbolinks:load", () => {
    (document.querySelectorAll(".notification .delete") || []).forEach((deleteButton) => {
        let notification = deleteButton.parentNode;
        deleteButton.addEventListener("click", () => {
            notification.parentNode.removeChild(notification);
        });
    });
});