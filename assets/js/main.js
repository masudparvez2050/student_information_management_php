// Form validation
document.addEventListener('DOMContentLoaded', function() {
    const forms = document.querySelectorAll('form');
    forms.forEach(form => {
        if (form.getAttribute('novalidate') === null) {
            form.addEventListener('submit', function(event) {
                if (!form.checkValidity()) {
                    event.preventDefault();
                    event.stopPropagation();
                }
                form.classList.add('was-validated');
            });
        }
    });

    // Phone number validation
    const phoneInputs = document.querySelectorAll('input[type="tel"]');
    phoneInputs.forEach(input => {
        input.addEventListener('input', function(e) {
            let value = e.target.value.replace(/\D/g, '');
            if (value.length > 11) {
                value = value.substring(0, 11);
            }
            e.target.value = value;
        });
    });

    // Student ID validation (only allow numbers and letters)
    const studentIdInput = document.getElementById('student_id');
    if (studentIdInput) {
        studentIdInput.addEventListener('input', function(e) {
            e.target.value = e.target.value.replace(/[^a-zA-Z0-9]/g, '');
        });
    }
});

// Auto-hide alerts after 5 seconds
const alerts = document.querySelectorAll('.alert:not(.alert-permanent)');
alerts.forEach(alert => {
    setTimeout(() => {
        alert.classList.add('fade');
        setTimeout(() => alert.remove(), 150);
    }, 5000);
});

// Confirm delete action
function deleteStudent(id, name) {
    const modalElement = document.getElementById('deleteModal');
    if (modalElement) {
        const modal = new bootstrap.Modal(modalElement);
        document.getElementById('deleteId').value = id;
        document.getElementById('studentName').textContent = name;
        modal.show();
    }
}

// Handle search form submission
const searchForm = document.querySelector('.search-form');
if (searchForm) {
    searchForm.addEventListener('submit', function(event) {
        const searchInput = this.querySelector('input[name="search"]');
        const departmentSelect = this.querySelector('select[name="department"]');
        
        if (!searchInput.value && !departmentSelect.value) {
            event.preventDefault();
            alert('Please enter a search term or select a department');
        }
    });
}

// Print functionality
function printStudentList() {
    window.print();
}

// Export to CSV
function exportToCSV() {
    const table = document.querySelector('.table');
    if (!table) return;

    let csv = [];
    const rows = table.querySelectorAll('tr');
    
    rows.forEach(row => {
        const cols = row.querySelectorAll('td, th');
        const rowData = Array.from(cols)
            .map(col => '"' + (col.innerText || '').replace(/"/g, '""') + '"')
            .join(',');
        csv.push(rowData);
    });

    const csvContent = csv.join('\n');
    const blob = new Blob([csvContent], { type: 'text/csv;charset=utf-8;' });
    const link = document.createElement('a');
    const url = URL.createObjectURL(blob);
    
    link.setAttribute('href', url);
    link.setAttribute('download', 'students.csv');
    link.style.visibility = 'hidden';
    
    document.body.appendChild(link);
    link.click();
    document.body.removeChild(link);
}

// Handle file upload preview
const photoInput = document.querySelector('input[type="file"][accept="image/*"]');
if (photoInput) {
    photoInput.addEventListener('change', function(event) {
        const preview = document.getElementById('photoPreview');
        if (preview && event.target.files && event.target.files[0]) {
            const reader = new FileReader();
            reader.onload = e => preview.src = e.target.result;
            reader.readAsDataURL(event.target.files[0]);
        }
    });
}

// Department statistics chart (if Chart.js is included)
const statsChart = document.getElementById('departmentStats');
if (typeof Chart !== 'undefined' && statsChart) {
    const ctx = statsChart.getContext('2d');
    const data = JSON.parse(statsChart.dataset.stats || '{}');
    
    new Chart(ctx, {
        type: 'bar',
        data: {
            labels: Object.keys(data),
            datasets: [{
                label: 'Students per Department',
                data: Object.values(data),
                backgroundColor: 'rgba(0, 123, 255, 0.5)',
                borderColor: 'rgba(0, 123, 255, 1)',
                borderWidth: 1
            }]
        },
        options: {
            scales: {
                y: {
                    beginAtZero: true,
                    stepSize: 1
                }
            }
        }
    });
}
