// Example starter JavaScript for disabling form submissions if there are invalid fields
(function() {
    'use strict'

    // Fetch all the forms we want to apply custom Bootstrap validation styles to
    var forms = document.querySelectorAll('.needs-validation')

    // Loop over them and prevent submission
    Array.prototype.slice.call(forms)
        .forEach(function(form) {
            form.addEventListener('submit', function(event) {
                if (!form.checkValidity()) {
                    event.preventDefault()
                    event.stopPropagation()
                }

                form.classList.add('was-validated')
            }, false)
        })
})();

function delete_job(id) {
    $('#j_id').val(id);
}

function delete_company(id) {
    $('#c_id').val(id);
}

function delete_category(id) {
    $('#cat_id').val(id);
}

function delete_arbeit(id) {
    $('#arb_id').val(id);
}

function delete_arbeitsort(id) {
    $('#sort_id').val(id);
}