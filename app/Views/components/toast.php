<!-- TOAST GLOBAL -->
<div class="toast-container position-fixed bottom-0 start-50 translate-middle p-3">


    <div id="globalToast"
         class="toast align-items-center text-white border-0 shadow"
         role="alert"
         data-bs-delay="4500">

        <div class="d-flex">
            <div class="toast-body d-flex align-items-center gap-2" id="toastContent">
                <!-- contenido dinámico -->
            </div>
            <button type="button"
                    class="btn-close btn-close-white me-2 m-auto"
                    data-bs-dismiss="toast"></button>
        </div>

    </div>

</div>

<script>

document.addEventListener('DOMContentLoaded', function () {

    const toastEl = document.getElementById('globalToast');
    const toastContent = document.getElementById('toastContent');

    <?php if (session()->getFlashdata('success')): ?>
        toastEl.classList.remove('bg-danger');
        toastEl.classList.add('bg-success');

        toastContent.innerHTML = `
            <i class="bi bi-check-circle-fill"></i>
            <span><?= esc(session()->getFlashdata('success')) ?></span>
        `;

        new bootstrap.Toast(toastEl).show();

    <?php elseif (session()->getFlashdata('error')): ?>
        toastEl.classList.remove('bg-success');
        toastEl.classList.add('bg-danger');

        toastContent.innerHTML = `
            <i class="bi bi-x-circle-fill"></i>
            <span><?= esc(session()->getFlashdata('error')) ?></span>
        `;

        new bootstrap.Toast(toastEl).show();

    <?php endif; ?>

});

</script>