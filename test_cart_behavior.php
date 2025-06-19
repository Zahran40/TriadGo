<?php
echo "=== CART BEHAVIOR TEST ===\n";
echo "Testing cart delete behavior directly\n\n";

// Test localStorage behavior simulation
echo "Step 1: Simulating localStorage cart operations\n";

// Simulate cart with sample data
$cart = [
    [
        'id' => 1,
        'name' => 'Premium Coffee Beans',
        'price' => 0.10,
        'quantity' => 2
    ],
    [
        'id' => 2,
        'name' => 'Organic Tea Leaves',
        'price' => 0.10,
        'quantity' => 1
    ]
];

echo "Initial cart: " . json_encode($cart, JSON_PRETTY_PRINT) . "\n\n";

// Simulate removing item at index 0
array_splice($cart, 0, 1);
echo "After removing index 0: " . json_encode($cart, JSON_PRETTY_PRINT) . "\n\n";

// Simulate removing last item
array_splice($cart, 0, 1);
echo "After removing last item: " . json_encode($cart, JSON_PRETTY_PRINT) . "\n";
echo "Cart is empty: " . (empty($cart) ? "YES" : "NO") . "\n\n";

echo "Step 2: Creating JavaScript test to run in browser\n";

$jsTest = <<<'JS'
// === CART DELETE TEST ===
console.log("=== CART DELETE BEHAVIOR TEST ===");

// Step 1: Clear cart first
localStorage.removeItem('importCart');
console.log("1. Cart cleared");

// Step 2: Add test items
const testCart = [
    {
        id: 1,
        name: "Premium Coffee Beans",
        price: 0.10,
        quantity: 2,
        origin: "Indonesia",
        weight: "1",
        sku: "COF-001",
        image: "/eksportir.png"
    },
    {
        id: 2,
        name: "Organic Tea Leaves", 
        price: 0.10,
        quantity: 1,
        origin: "Sri Lanka",
        weight: "0.5",
        sku: "TEA-001",
        image: "/eksportir.png"
    }
];

localStorage.setItem('importCart', JSON.stringify(testCart));
console.log("2. Test items added:", JSON.parse(localStorage.getItem('importCart')));

// Step 3: Test remove function
function testRemoveItem(index) {
    console.log(`3. Testing remove item at index ${index}`);
    const cart = JSON.parse(localStorage.getItem('importCart')) || [];
    console.log("Before remove:", cart);
    
    cart.splice(index, 1);
    localStorage.setItem('importCart', JSON.stringify(cart));
    
    console.log("After remove:", JSON.parse(localStorage.getItem('importCart')));
    console.log("Cart length:", JSON.parse(localStorage.getItem('importCart')).length);
    
    // Check if it gets refilled
    setTimeout(() => {
        const checkCart = JSON.parse(localStorage.getItem('importCart')) || [];
        console.log("Cart after 1 second:", checkCart);
        if (checkCart.length > cart.length) {
            console.log("❌ BUG DETECTED: Cart was auto-refilled!");
        } else {
            console.log("✅ Cart delete working correctly");
        }
    }, 1000);
}

// Test removing first item
testRemoveItem(0);

// Test removing all items after 2 seconds
setTimeout(() => {
    console.log("4. Testing remove all items");
    localStorage.removeItem('importCart');
    console.log("All items removed");
    
    setTimeout(() => {
        const finalCheck = JSON.parse(localStorage.getItem('importCart')) || [];
        console.log("Final cart check:", finalCheck);
        if (finalCheck.length > 0) {
            console.log("❌ BUG DETECTED: Empty cart was auto-refilled!");
        } else {
            console.log("✅ Empty cart working correctly");
        }
    }, 1000);
}, 2000);
JS;

echo "Copy and paste this JavaScript code in browser console:\n";
echo "=====================================\n";
echo $jsTest;
echo "\n=====================================\n";

echo "Or run this test by visiting: http://localhost/TriadGo/public/cart-test.html\n";
?>
