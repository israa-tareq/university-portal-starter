document.addEventListener('DOMContentLoaded', function () {
    // Live search filter
    const searchInput = document.getElementById('department-search');
    const rows = document.querySelectorAll('.department-row');
    searchInput.addEventListener('input', function () {
        const query = this.value.toLowerCase().trim();
        rows.forEach(function (row) {
            const name = row.querySelector('.department-row-name').textContent.toLowerCase();
            row.style.display = name.includes(query) ? 'flex' : 'none';
        });
    });

    // Reusable delete confirmation handler
    function attachDeleteListener(deleteBtn) {
        deleteBtn.addEventListener('click', function (e) {
            e.preventDefault();
            const form = deleteBtn.closest('form');
            const actionsDiv = deleteBtn.closest('.department-row-actions');
            const row = deleteBtn.closest('.department-row');
            const originalHTML = actionsDiv.innerHTML;

            // Add red tint to the row
            row.classList.add('confirming-delete');

            actionsDiv.innerHTML = `
                <span class="delete-confirm-text">Delete?</span>
                <button type="button" class="btn-confirm-delete">Yes, delete</button>
                <button type="button" class="btn-cancel-delete">Cancel</button>
            `;

            actionsDiv.querySelector('.btn-confirm-delete').addEventListener('click', function () {
                form.submit();
            });

            actionsDiv.querySelector('.btn-cancel-delete').addEventListener('click', function () {
                actionsDiv.innerHTML = originalHTML;
                // Remove red tint on cancel
                row.classList.remove('confirming-delete');
                lucide.createIcons();
                attachDeleteListener(actionsDiv.querySelector('.btn-delete'));
            });
        });
    }

    document.querySelectorAll('.btn-delete').forEach(attachDeleteListener);
});