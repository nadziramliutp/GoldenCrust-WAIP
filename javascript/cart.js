let cart = [];

// Load cart from localStorage on page load
document.addEventListener("DOMContentLoaded", () => {
  const storedCart = localStorage.getItem("cart");
  if (storedCart) {
    cart = JSON.parse(storedCart);
    displayCart();
  }
});

function addToCart(name, price) {
  // Validate login status before adding to cart
  fetch('php/check-login.php')
    .then(response => response.json())
    .then(data => {
      if (data.loggedIn) {
        console.log(`Adding ${name} priced at RM${price.toFixed(2)} to cart`);

        // Store cart item in localStorage
        let cart = JSON.parse(localStorage.getItem("cart")) || [];
        const existingItem = cart.find(item => item.name === name);

        let qty = 1; // Default quantity
        if (existingItem) {
          existingItem.qty += 1;
          existingItem.total = existingItem.qty * existingItem.price;
          qty = existingItem.qty; // Update qty for database
        } else {
          cart.push({
            name: name,
            price: price,
            qty: qty,
            total: price
          });
        }

        // Update localStorage with the cart data
        localStorage.setItem("cart", JSON.stringify(cart));

        // Store the cart item in the database
        fetch('php/add-to-cart.php', {
          method: 'POST',
          headers: { 'Content-Type': 'application/json' },
          body: JSON.stringify({ name: name, price: price, qty: 1 }) // Send qty as 1 for new items
        })
          .then(response => response.json())
          .then(data => {
            if (data.success) {
              alert(name + " is added to the cart!");
            } else {
              alert('Failed to add item to cart in database.');
            }
          })
          .catch(error => console.error('Error adding item to cart:', error));
      } else {
        // Redirect user to login page if not logged in
        alert('You need to log in to add items to the cart.');
        window.location.href = 'http://goldencrust.atwebpages.com/GoldenCrust/login.php';
      }
    })
    .catch(error => console.error('Error validating login status:', error));
}


// Fetch the cart from the server (database) and display it
function displayCart() {
  const tableBody = document.getElementById("cart-table-body");
  if (!tableBody) return;

  tableBody.innerHTML = ""; // Clear table body

  // Fetch cart data from server
  fetch('php/get-cart.php')
    .then(response => response.json())
    .then(cart => {
      if (cart.success === false) {
        alert(cart.message); // Handle error if user is not logged in
        return;
      }

      // Render the cart
      cart.forEach(item => {
        const price = parseFloat(item.price); // Ensure price is a number
        const total = parseFloat(item.total); // Ensure total is a number

        const row = `
          <tr>
            <td>${item.name}</td>
            <td>${item.qty}</td>
            <td>RM ${price.toFixed(2)}</td>
            <td>RM ${total.toFixed(2)}</td>
            <td><button class="btn btn-danger btn-sm" onclick="removeFromCart(${item.id})">Remove</button></td>
          </tr>
        `;
        tableBody.innerHTML += row;
      });
    })
    .catch(error => console.error('Error fetching cart data:', error));
}

function removeFromCart(itemId) {
  let cart = JSON.parse(localStorage.getItem("cart")) || [];
  cart = cart.filter(item => item.id !== itemId); // Remove the item by ID
  localStorage.setItem("cart", JSON.stringify(cart));

  // Remove the item from the database
  fetch('php/remove-from-cart.php', {
    method: 'POST',
    headers: { 'Content-Type': 'application/json' },
    body: JSON.stringify({ id: itemId })
  })
    .then(response => response.json())
    .then(data => {
      if (data.success) {
        alert("Item removed from cart!");
        displayCart();  // Refresh the cart display
      } else {
        alert("Failed to remove item from cart.");
      }
    })
    .catch(error => console.error('Error removing item from cart:', error));
}
