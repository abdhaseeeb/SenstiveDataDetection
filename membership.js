src="https://unpkg.com/swiper/swiper-bundle.min.js"

    var swiper = new Swiper('.swiper', {
      spaceBetween: 30,
      centeredSlides: true,
      autoplay: {
        delay: 2500,
        disableOnInteraction: false,
      },
      pagination: {
        el: '.swiper-pagination',
        clickable: true,
      },
    });
document.addEventListener('DOMContentLoaded', function() {
// Dynamic Plan Selection
const subscribeButtons = document.querySelectorAll('.btn.subscribe');
subscribeButtons.forEach(button => {
    button.addEventListener('click', function() {
        clearSelections();
        this.classList.add('selected');
        alert(`You have selected the ${this.previousElementSibling.previousElementSibling.textContent} Plan.`);
    });
});

function clearSelections() {
    subscribeButtons.forEach(button => {
        button.classList.remove('selected');
    });
}

// Form Validation (Assuming there's a form with id 'signup-form')
const form = document.getElementById('signup-form');
if (form) {
    form.addEventListener('submit', function(event) {
        event.preventDefault();
        if (validateForm(this)) {
            this.submit();
        } else {
            alert('Please fill out the form correctly.');
        }
    });
}

function validateForm(form) {
    const email = form.querySelector('input[type="email"]');
    const emailRegex = /^[a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,6}$/;
    return emailRegex.test(email.value);
}

// Interactive Features List
document.querySelectorAll('.feature').forEach(feature => {
    feature.addEventListener('click', function() {
        const description = this.querySelector('p');
        if (description.style.display === 'none' || description.style.display === '') {
            description.style.display = 'block';
        } else {
            description.style.display = 'none';
        }
    });
});
});

var swiper = new Swiper('.swiper', {
spaceBetween: 30,
centeredSlides: true,
autoplay: {
delay: 2500,
disableOnInteraction: false,
},
pagination: {
el: '.swiper-pagination',
clickable: true,
},
});
