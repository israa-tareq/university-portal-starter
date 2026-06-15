document.addEventListener('DOMContentLoaded', function () {
    lucide.createIcons();

    document.querySelector('.profile-wrapper').addEventListener('click', function () {
        const profile = document.getElementById('profileBtn');
        const arrow = document.getElementById('profileArrow');
        const dropdown = document.getElementById('profileDropdown');

        profile.classList.toggle('expanded');
        dropdown.classList.toggle('open');

        if (profile.classList.contains('expanded')) {
            arrow.setAttribute('data-lucide', 'chevron-up');
        } else {
            arrow.setAttribute('data-lucide', 'chevron-down');
        }

        lucide.createIcons();
    });

    document.addEventListener('click', function (e) {
        const wrapper = document.querySelector('.profile-wrapper');
        if (!wrapper.contains(e.target)) {
            document.getElementById('profileBtn').classList.remove('expanded');
            document.getElementById('profileDropdown').classList.remove('open');
            document.getElementById('profileArrow').setAttribute('data-lucide', 'chevron-down');
            lucide.createIcons();
        }
    });
});