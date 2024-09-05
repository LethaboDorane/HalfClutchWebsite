const navbar = document.querySelector('.navbar');
const searchForm = document.querySelector('.search-form');
const cartItem = document.querySelector('.cart-items-container');
const menuBtn = document.querySelector('#menu-btn');
const closeBtn = document.querySelector('#close-btn');
const checkoutButton = document.getElementById('checkout-link');
const cartTotalElement = document.getElementById('cart-total');

menuBtn.addEventListener('click', toggleNavbar);
closeBtn.addEventListener('click', toggleNavbar);
document.querySelector('#search-btn').addEventListener('click', toggleSearchForm);
document.querySelector('#cart-btn').addEventListener('click', toggleCart);
window.addEventListener('scroll', closeAll);

document.body.addEventListener('click', (event) => {
    const clickedElement = event.target;

    if (!navbar.contains(clickedElement) && clickedElement !== menuBtn) {
        navbar.classList.remove('active');
        toggleButtonState();
    }

    if (!searchForm.contains(clickedElement) && clickedElement !== document.querySelector('#search-btn')) {
        searchForm.classList.remove('active');
    }

    if (!cartItem.contains(clickedElement) && clickedElement !== document.querySelector('#cart-btn')) {
        cartItem.classList.remove('active');
        updateCartContent(); // Call updateCartContent() when clicking outside the cart to check if it's empty
    }
});

function toggleNavbar() {
    navbar.classList.toggle('active');
    searchForm.classList.remove('active');
    toggleButtonState();
}

function toggleSearchForm() {
    searchForm.classList.toggle('active');
    navbar.classList.remove('active');
    toggleButtonState();
}

function toggleCart() {
    cartItem.classList.toggle('active');
    navbar.classList.remove('active');
    searchForm.classList.remove('active');
    toggleButtonState();
    updateCartContent(); // Call updateCartContent() when toggling the cart to check if it's empty
}

function closeAll() {
    navbar.classList.remove('active');
    searchForm.classList.remove('active');
    cartItem.classList.remove('active');
    toggleButtonState();
}

function toggleButtonState() {
    const isNavbarActive = navbar.classList.contains('active');
    menuBtn.style.display = isNavbarActive ? 'none' : 'inline-block';
    closeBtn.style.display = isNavbarActive ? 'inline-block' : 'none';
}

toggleButtonState();

// Add to cart function 
const addToCartButtons = document.querySelectorAll('.add-to-cart');

addToCartButtons.forEach(button => {
    button.addEventListener('click', () => {
        const box = button.closest('.box');
        const productName = box.querySelector('h3').textContent;
        const productPrice = box.querySelector('.price').textContent;
        const productImage = box.querySelector('img').src;

        // Check if the item is already in the cart
        const existingCartItem = document.querySelector(`#cart-items [data-name="${productName}"]`);
        if (existingCartItem) {
            alert('This item is already in the cart.');
            return; // Exit the function if the item is already in the cart
        }

        const cartItemHTML = `
            <div class="cart-item">
                <img src="${productImage}" alt="">
                <div class="content">
                    <h3 data-name="${productName}">${productName}</h3>
                    <div class="price">${productPrice}</div>
                    <button class="remove-from-cart"><i class="fas fa-times"></i></button> <!-- Updated remove button with Font Awesome icon -->
                </div>
            </div>
        `;
        document.getElementById('cart-items').insertAdjacentHTML('beforeend', cartItemHTML);
        saveCartToLocalStorage();
        updateCartContent(); // Call updateCartContent() after adding item to cart
        showCheckoutButton(); // Call showCheckoutButton() after adding item to cart
        updateCartTotal(); // Call updateCartTotal() after adding item to cart
    });
});

// Add event listener for remove button
document.addEventListener('click', event => {
    if (event.target.classList.contains('fa-times')) { // Check if the clicked element is the Font Awesome "times" icon
        const cartItem = event.target.closest('.cart-item');
        cartItem.remove();
        saveCartToLocalStorage();
        updateCartContent(); // Call updateCartContent() after removing item from cart
        showCheckoutButton(); // Call showCheckoutButton() after removing item from cart
        updateCartTotal(); // Call updateCartTotal() after removing item from cart
    }
});

function updateCartContent() {
    const cartItems = document.querySelectorAll('.cart-item');
    const cartEmptyMessage = document.getElementById('cart-empty-message');

    if (cartItems.length < 1) {
        cartEmptyMessage.style.display = 'block'; // Show the "cart is empty" message
    } else {
        cartEmptyMessage.style.display = 'none'; // Hide the "cart is empty" message
    }
}

function showCheckoutButton() {
    const cartItems = document.querySelectorAll('.cart-item');
    if (cartItems.length > 0) {
        checkoutButton.style.display = 'block'; // Show the checkout button
        cartTotalElement.style.display = 'block'; // Show the cart total
    } else {
        checkoutButton.style.display = 'none'; // Hide the checkout button
        cartTotalElement.style.display = 'none'; // Hide the cart total
    }
}

showCheckoutButton(); // Initial call to set the state of the checkout button and total

function updateCartTotal() {
    const cartItems = document.querySelectorAll('.cart-item');
    let total = 0;

    cartItems.forEach(item => {
        const priceText = item.querySelector('.price').textContent;
        const price = parseFloat(priceText.replace('R', ''));
        total += price;
    });

    cartTotalElement.textContent = `Total: R${total.toFixed(2)}`;
}

function saveCartToLocalStorage() {
    const cartItems = document.querySelectorAll('.cart-item');
    const cartArray = [];

    cartItems.forEach(item => {
        const name = item.querySelector('[data-name]').textContent;
        const price = item.querySelector('.price').textContent;
        const image = item.querySelector('img').src;

        cartArray.push({ name, price, image });
    });

    localStorage.setItem('cart', JSON.stringify(cartArray));
}

function loadCartFromLocalStorage() {
    const cartArray = JSON.parse(localStorage.getItem('cart')) || [];

    cartArray.forEach(item => {
        const cartItemHTML = `
            <div class="cart-item">
                <img src="${item.image}" alt="">
                <div class="content">
                    <h3 data-name="${item.name}">${item.name}</h3>
                    <div class="price">${item.price}</div>
                    <button class="remove-from-cart"><i class="fas fa-times"></i></button>
                </div>
            </div>
        `;
        document.getElementById('cart-items').insertAdjacentHTML('beforeend', cartItemHTML);
    });
    updateCartContent();
    showCheckoutButton();
    updateCartTotal(); // Initial call to set the total cost
}

// Load the cart items when the page loads
window.addEventListener('load', loadCartFromLocalStorage);