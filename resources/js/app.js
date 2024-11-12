import logo from '../images/logo1.jpg';
import Choices from 'choices.js';
import 'choices.js/public/assets/styles/choices.css';
import './bootstrap';
import 'flowbite';


// Preloader Fade-Out
$(window).on('load', function () {
    setTimeout(function () {
        $('#preloader').fadeOut('slow', function () {
            $(this).remove();
        });
    }, 1000);
});

// Navbar Scroll Animation
document.addEventListener("DOMContentLoaded", function () {
    const navbar = document.getElementById("navbar");
    const header = document.getElementById("header");

    if (navbar && header) {
        const headerHeight = header.offsetHeight;

        window.addEventListener("scroll", function () {
            if (window.scrollY >= headerHeight) {
                navbar.classList.add("fixed-navbar");
                document.body.style.paddingTop = `${navbar.offsetHeight}px`; // Prevent content jumping
            } else {
                navbar.classList.remove("fixed-navbar");
                document.body.style.paddingTop = "0"; // Reset padding when not fixed
            }
        });
    }
});

// Initialize AOS (Animate On Scroll)
window.onload = function() {
    AOS.init({
        duration: 1000,
        easing: 'ease-in-out',
        once: true,
        offset: 200,
        anchorPlacement: 'top-bottom',
    });
    AOS.refresh();
};

// Modal Handling for Cookie and Terms
window.addEventListener('load', function() {
    const modalElement = document.getElementById('hotel-service-modal');
    const cookieModal = document.getElementById('cookie-consent-modal');

    if (modalElement && cookieModal) {
        const modal = new Modal(modalElement);
        modal.show();

        // Show Cookie Modal After Terms Modal Closes
        function showCookieModal() {
            cookieModal.classList.remove('hidden');
        }

        // Event Listeners for Terms Modal Buttons
        ['accept-modal', 'decline-modal', 'close-modal'].forEach(id => {
            const btn = document.getElementById(id);
            if (btn) {
                btn.addEventListener('click', function() {
                    modal.hide();
                    showCookieModal();
                });
            }
        });

        // Event Listeners for Cookie Modal Buttons
        ['accept-cookies', 'decline-cookies'].forEach(id => {
            const btn = document.getElementById(id);
            if (btn) {
                btn.addEventListener('click', function() {
                    cookieModal.classList.add('hidden');
                });
            }
        });
    }
});

// Mobile Menu Toggle
document.addEventListener('DOMContentLoaded', function () {
    const navbarToggler = document.getElementById('navbar-toggler');
    const mobileMenu = document.getElementById('mobile-menu');

    if (navbarToggler && mobileMenu) {
        navbarToggler.addEventListener('click', function () {
            mobileMenu.classList.toggle('hidden');
        });
    }
});

// Alert Box Functionality
function showAlert() {
    const alertBox = document.getElementById('custom-alert');
    if (alertBox) {
        alertBox.classList.remove('hidden');
        setTimeout(() => {
            alertBox.classList.add('hidden');
        }, 5000);
    }
}

// Date Formatting Function (Not needed if using Flowbite's Datepicker)
function formatDate(date) {
    const year = date.getFullYear();
    const month = (`0${date.getMonth() + 1}`).slice(-2); // Months are zero-based
    const day = (`0${date.getDate()}`).slice(-2);
    return `${year}-${month}-${day}`;
}

// Combined DOMContentLoaded for Booking Form and Choices.js
document.addEventListener('DOMContentLoaded', () => {
    // Booking Form Elements
    const checkinInput = document.getElementById('checkin');
    const checkoutInput = document.getElementById('checkout');
    const categorySelect = document.getElementById('category');
    const typeSelect = document.getElementById('type');

    // Ensure all elements are present
    if (!checkinInput || !checkoutInput || !categorySelect || !typeSelect) {
        console.warn('Booking form elements are missing.');
        return;
    }

    // Initialize Flowbite's Datepicker
    if (window.Flowbite && window.Flowbite.Datepicker) {
        const checkinDatepicker = new window.Flowbite.Datepicker(checkinInput, {
            dateFormat: 'Y-m-d',
            minDate: new Date(),
            autoHide: true,
            theme: 'light', // Customize as needed
            onSelect: (selectedDate) => {
                if (selectedDate) {
                    // Create a new date object for the day after the selected check-in date
                    const nextDay = new Date(selectedDate);
                    nextDay.setDate(nextDay.getDate() + 1);
                    // Update the minDate of checkout
                    checkoutDatepicker.setOptions({
                        minDate: nextDay
                    });
                } else {
                    // Reset to default minDate if no date is selected
                    checkoutDatepicker.setOptions({
                        minDate: new Date(Date.now() + 86400000) // Tomorrow
                    });
                }
            }
        });

        const checkoutDatepicker = new window.Flowbite.Datepicker(checkoutInput, {
            dateFormat: 'Y-m-d',
            minDate: new Date(Date.now() + 86400000), // Tomorrow
            autoHide: true,
            theme: 'light', // Customize as needed
        });
    } else {
        console.error('Flowbite Datepicker is not available.');
    }

    // Define Type Options Based on Category
    const typeOptions = {
        rooms: [
            { value: 'single_bedroom', label: 'Single Bedroom' },
            { value: 'triple_bedroom', label: 'Triple Bedroom' },
            { value: 'dormitory_type', label: 'Dormitory Type' }
        ],
        activity: [
            { value: 'package_1', label: 'Package 1' },
            { value: 'package_2', label: 'Package 2' },
            { value: 'package_3', label: 'Package 3' },
            { value: 'package_4', label: 'Package 4' }
        ],
        cottages: [
            { value: 'umbrella', label: 'Umbrella' },
            { value: 'small', label: 'Small' },
            { value: 'big', label: 'Big' },
            { value: 'deluxe', label: 'Deluxe' }
        ],
        function_hall: [
            { value: 'function_hall_1', label: 'Function Hall 1' }
        ]
    };

    // Initialize Choices.js for Category and Type
    const categoryChoices = new Choices(categorySelect, {
        searchEnabled: false,
        placeholder: true,
        placeholderValue: 'Select Category',
        shouldSort: false,
        itemSelectText: '',
    });

    const typeChoices = new Choices(typeSelect, {
        searchEnabled: false,
        placeholder: true,
        placeholderValue: 'Select Type',
        shouldSort: false,
        itemSelectText: '',
    });

    // Function to Populate Type Options
    function populateTypeOptions(category) {
        typeChoices.clearChoices();

        if (typeOptions[category]) {
            typeChoices.setChoices(typeOptions[category], 'value', 'label', true);
        }

        // Optionally, reset the selection to placeholder
        typeChoices.setChoiceByValue('');
    }

    // Event Listener for Category Change
    categorySelect.addEventListener('change', (event) => {
        // Choices.js provides the selected value in event.detail.value
        const selectedCategory = event.detail.value;
        populateTypeOptions(selectedCategory);
    });
});


//Notif


