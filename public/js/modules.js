document.addEventListener('DOMContentLoaded', function () {
    // Live search
    const searchInput = document.getElementById('module-search');
    const rows = document.querySelectorAll('.module-row');

    if (searchInput && rows.length) {
        searchInput.addEventListener('input', function () {
            const query = this.value.toLowerCase().trim();
            rows.forEach(function (row) {
                const name = row.querySelector('.module-row-name');
                if (name) {
                    row.style.display = name.textContent.toLowerCase().includes(query) ? 'flex' : 'none';
                }
            });
        });
    }

    // Delete confirmation
    function attachDeleteListener(deleteBtn) {
        deleteBtn.addEventListener('click', function (e) {
            e.preventDefault();
            const form = deleteBtn.closest('form');
            const actionsDiv = deleteBtn.closest('.module-row-actions');
            const row = deleteBtn.closest('.module-row');
            const originalHTML = actionsDiv.innerHTML;

            // Move form out of actionsDiv so it survives the innerHTML replacement
            row.appendChild(form);
            form.style.display = 'none';

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
                form.remove();
                actionsDiv.innerHTML = originalHTML;
                row.classList.remove('confirming-delete');
                lucide.createIcons();
                attachDeleteListener(actionsDiv.querySelector('.btn-delete'));
            });
        });
    }

    document.querySelectorAll('.btn-delete').forEach(attachDeleteListener);
});
