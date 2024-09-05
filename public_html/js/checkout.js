document.addEventListener('DOMContentLoaded', () => {
    initializeCart();
    handlePlaceOrder();
});

function initializeCart() {
    loadCartFromLocalStorage();
    updateCartContent();
    updateCartTotal();
    setUpEventListeners();
}

function setUpEventListeners() {
    document.addEventListener('click', handleCartUpdate);
    document.getElementById('clear-cart').addEventListener('click', clearCart);
}

function handleCartUpdate(event) {
    if (event.target.classList.contains('increment')) {
        updateQuantity(event.target.previousElementSibling, 1);
    } else if (event.target.classList.contains('decrement')) {
        updateQuantity(event.target.nextElementSibling, -1);
    }
}

function updateQuantity(quantityInput, change) {
    const newValue = parseInt(quantityInput.value) + change;
    if (newValue > 0 && newValue <= 5) {
        quantityInput.value = newValue;
        saveCartToLocalStorage();
        updateCartTotal();
    } else {
        alert(`Quantity must be between 1 and 5. Current value: ${newValue}`);
    }
    if (newValue === 0) {
        const cartItem = quantityInput.closest('.cart-item');
        const itemName = cartItem.querySelector('[data-name]').textContent;
        cartItem.remove();
        saveCartToLocalStorage();
        updateCartContent();
        updateCartTotal();
        alert(`"${itemName}" has been removed from your cart.`);
    }
}

function updateCartContent() {
    const cartItems = document.querySelectorAll('.cart-item');
    const cartEmptyMessage = document.getElementById('cart-empty-message');
    const clearCartButton = document.getElementById('clear-cart');
    const placeOrderButton = document.getElementById('place-order-btn');

    const hasItems = cartItems.length > 0;
    cartEmptyMessage.style.display = hasItems ? 'none' : 'block';
    clearCartButton.style.display = hasItems ? 'block' : 'none';
    placeOrderButton.style.display = hasItems ? 'block' : 'none';
}

function updateCartTotal() {
    const cartItems = document.querySelectorAll('.cart-item');
    let total = 0;

    cartItems.forEach(item => {
        const price = parseFloat(item.querySelector('.price').textContent.replace('R', ''));
        const quantity = parseInt(item.querySelector('.quantity').value, 10);
        total += price * quantity;
    });

    const totalFixed = total.toFixed(2);
    document.getElementById('cart-total').textContent = `Total: R${totalFixed}`;
    document.getElementById('total-input').value = totalFixed;
}

function saveCartToLocalStorage() {
    const cartItems = document.querySelectorAll('.cart-item');
    const cartArray = Array.from(cartItems).map(item => ({
        id: item.querySelector('[data-id]').textContent,  // Ensure each cart item has a data-id attribute
        name: item.querySelector('[data-name]').textContent,
        price: item.querySelector('.price').textContent,
        image: item.querySelector('img').src,
        quantity: item.querySelector('.quantity').value
    }));

    localStorage.setItem('cart', JSON.stringify(cartArray));
}

function loadCartFromLocalStorage() {
    const cartArray = JSON.parse(localStorage.getItem('cart')) || [];
    cartArray.forEach(item => {
        const cartItemHTML = `
            <div class="cart-item">
                <img src="${item.image}" alt="">
                <div class="content">
                    <h3 data-name="${item.name}" data-id="${item.id}">${item.name}</h3>
                    <div class="price">${item.price}</div>
                    <div class="quantity-container">
                        <button class="decrement">-</button>
                        <input type="number" class="quantity" value="${item.quantity || 1}" min="1" max="5">
                        <button class="increment">+</button>
                    </div>
                </div>
            </div>
        `;
        document.getElementById('cart-items').insertAdjacentHTML('beforeend', cartItemHTML);
    });
}

function clearCart() {
    document.getElementById('cart-items').innerHTML = '';
    localStorage.removeItem('cart');
    updateCartContent();
    updateCartTotal();
}

function handlePlaceOrder() {
    document.getElementById('checkout-form').addEventListener('submit', function(event) {
        const cartItems = JSON.parse(localStorage.getItem('cart')) || [];
        const productIds = cartItems.map(item => item.id).join(',');
        const totalCost = document.getElementById('cart-total').textContent.replace('Total: R', '');

        document.getElementById('total-input').value = totalCost;
        document.getElementById('cart-items-input').value = productIds;
    });
}
