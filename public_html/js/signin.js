// Get references to DOM elements
const navbar = document.querySelector('.navbar');
const menuBtn = document.querySelector('#menu-btn');
const closeBtn = document.querySelector('#close-btn');

// Event listener for menu button click
menuBtn.addEventListener('click', () => {
    navbar.classList.toggle('active');
    toggleButtonVisibility(); // Call function to toggle button visibility
});

// Event listener for close button click
closeBtn.addEventListener('click', () => {
    navbar.classList.remove('active');
    toggleButtonVisibility(); // Call function to toggle button visibility
});

// Function to toggle visibility of menu button based on navbar state
function toggleButtonVisibility() {
    menuBtn.style.display = navbar.classList.contains('active') ? 'none' : 'inline-block';
    closeBtn.style.display = navbar.classList.contains('active') ? 'inline-block' : 'none';
}

// Event listener for window scroll
window.addEventListener('scroll', () => {
    navbar.classList.remove('active'); // Ensure navbar remains inactive on scroll
    toggleButtonVisibility(); // Adjust button visibility on scroll
});

// Event listener to close navbar when click is made outside
document.body.addEventListener('click', (event) => {
    if (!navbar.contains(event.target) && event.target !== menuBtn) {
        navbar.classList.remove('active');
        toggleButtonVisibility(); // Call function to toggle button state
    }
});

// Call the function to toggle the visibility of the buttons initially
toggleButtonVisibility();