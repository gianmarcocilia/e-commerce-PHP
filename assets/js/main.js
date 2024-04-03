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

// Carosello categorie
const carousel = document.querySelector('#carousel');
  let currentIndex = 0;

  function showSlide(index) {
    const slideWidth = carousel.querySelector('.carousel-item').offsetWidth;
    carousel.style.transform = `translateX(-${slideWidth * index}px)`;
    currentIndex = index;
  }

  function nextSlide() {
    if (currentIndex < carousel.children.length - 1) {
      showSlide(currentIndex + 1);
    }
  }

  function prevSlide() {
    if (currentIndex > 0) {
      showSlide(currentIndex - 1);
    }
  }

  // Payment
  var button = document.querySelector('#submit-button');

braintree.dropin.create({
  authorization: 'sandbox_g42y39zw_348pk9cgf3bgyw2b',
  selector: '#dropin-container'
}, function (err, instance) {
  button.addEventListener('click', function () {
    instance.requestPaymentMethod(function (err, payload) {
      // Submit payload.nonce to your server
    });
  })
});