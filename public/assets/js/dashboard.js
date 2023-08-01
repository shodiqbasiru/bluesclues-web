// dashboard for filter
document.addEventListener('DOMContentLoaded', function() {
    const dropdown = document.querySelector('.dropdown');
    const filterDropdown = document.getElementById('filterDropdown');
    const monthYearForm = document.getElementById('filterMonthYearForm');
    const yearOnlyForm = document.getElementById('filterYearOnlyForm');

    dropdown.addEventListener('click', function(event) {
        const target = event.target;
        if (target.classList.contains('dropdown-item')) {
            const selectedOption = target.getAttribute('data-filter');

            if (selectedOption === 'monthYear') {
                monthYearForm.style.display = 'block';
                yearOnlyForm.style.display = 'none';
                filterDropdown.textContent = 'Filter by Month and Year';
            } else if (selectedOption === 'yearOnly') {
                monthYearForm.style.display = 'none';
                yearOnlyForm.style.display = 'block';
                filterDropdown.textContent = 'Filter by Year';
            }
        }
    });
});


// dashboard order for modal
var myModal = new bootstrap.Modal(document.getElementById('proofModal'));

// Optional: Close the modal when the "Close" button is clicked
document.getElementById('proofModal').addEventListener('hide.bs.modal', function() {
    myModal.hide();
});