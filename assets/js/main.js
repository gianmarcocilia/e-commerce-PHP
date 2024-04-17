// Counter badge carrello
const counter = document.querySelector('#counter');
counter.innerHTML = '<?php echo $cart_total->tot_quantity ?>';

// Modal product delete
const allButtons = document.querySelectorAll('.button-delete');
allButtons.forEach(button => {
    button.addEventListener('click', (event) => {
        event.preventDefault();
        const deleteModal = new bootstrap.Modal('#my-modal');
        deleteModal.show();

        const title = button.getAttribute('data-title');
        document.getElementById('title-delete').innerHTML = title;

        const id = button.getAttribute('data-id');
        const setId = document.querySelector('.product_id');
        setId.value = id;
    })
})

