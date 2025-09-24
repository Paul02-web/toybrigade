document.addEventListener('DOMContentLoaded', () => {
    const shipForm = document.getElementById('shippingForm');
    const payForm = document.getElementById('paymentForm');
    const shippingMethod = document.querySelector('select[name="shippingMethod"]');
    
    // Shipping costs
    const shippingCosts = {
        'standard': 150,
        'express': 350,
        'pickup': 0
    };
    
    // Update order summary with shipping cost
    function updateOrderSummary() {
        const selectedMethod = shippingMethod.value;
        const shippingCost = shippingCosts[selectedMethod];
        const subtotal = parseFloat(document.getElementById('co-sub').textContent.replace('₱', '').replace(',', ''));
        
        document.getElementById('co-ship').textContent = `₱${shippingCost.toFixed(2)}`;
        document.getElementById('co-total').textContent = `₱${(subtotal + shippingCost).toFixed(2)}`;
    }
    
    // Initialize shipping cost
    updateOrderSummary();
    
    // Update shipping cost when method changes
    shippingMethod.addEventListener('change', updateOrderSummary);
    
    function go(step) {
        document.getElementById('step-1').classList.toggle('d-none', step!==1);
        document.getElementById('step-2').classList.toggle('d-none', step!==2);
        document.getElementById('step-3').classList.toggle('d-none', step!==3);
        
        const b1 = document.getElementById('b1');
        const b2 = document.getElementById('b2');
        const b3 = document.getElementById('b3');
        [b1,b2,b3].forEach((b,i)=>{
            b.className = 'bubble ' + (i+1<step ? 'bubble-done' : i+1===step ? 'bubble-active' : 'bubble-next');
        });
        
        // Update review section in step 3
        if (step === 3) {
            updateReviewSection();
        }
    }

    // Update review section with order details
    function updateReviewSection() {
        const reviewItems = document.getElementById('review-items');
        const summaryItems = document.getElementById('sum-list').innerHTML;
        const shippingMethodText = document.querySelector('select[name="shippingMethod"] option:checked').textContent;
        const shippingCost = document.getElementById('co-ship').textContent;
        const total = document.getElementById('co-total').textContent;
        
        reviewItems.innerHTML = `
            <div class="mb-3">
                <h6>Order Items:</h6>
                ${summaryItems}
            </div>
            <div class="mb-2">
                <strong>Shipping Method:</strong> ${shippingMethodText}
            </div>
            <div class="mb-2">
                <strong>Shipping Cost:</strong> ${shippingCost}
            </div>
            <div class="mb-3">
                <strong>Total:</strong> ${total}
            </div>
        `;
    }

    // Shipping form submit
    if(shipForm) {
        shipForm.addEventListener('submit', function(e) {
            e.preventDefault();
            
            // Basic form validation
            const inputs = shipForm.querySelectorAll('input[required], select[required]');
            let isValid = true;
            
            inputs.forEach(input => {
                if (!input.value.trim()) {
                    isValid = false;
                    input.classList.add('is-invalid');
                } else {
                    input.classList.remove('is-invalid');
                }
            });

            if (isValid) {
                go(2);
            }
        });
    }

    // Payment form submit
    if(payForm) {
        payForm.addEventListener('submit', function(e) {
            e.preventDefault();
            
            // Basic payment validation
            const method = payForm.querySelector('select[name="method"]').value;
            let isValid = true;

            if(method === 'card') {
                const cardFields = payForm.querySelectorAll('#cardBlock input, #cardBlock2 input, #cardBlock3 input');
                cardFields.forEach(field => {
                    if(!field.value.trim()) {
                        isValid = false;
                        field.classList.add('is-invalid');
                    } else {
                        field.classList.remove('is-invalid');
                    }
                });
            }

            if(isValid) {
                go(3);
            }
        });
    }

    // Back buttons
    document.getElementById('backToShipping')?.addEventListener('click', () => go(1));
    document.getElementById('backToPayment')?.addEventListener('click', () => go(2));
    
    // Toggle card fields based on payment method
    const paymentMethod = document.querySelector('select[name="method"]');
    const cardBlocks = [
        document.getElementById('cardBlock'),
        document.getElementById('cardBlock2'),
        document.getElementById('cardBlock3')
    ];
    
    function toggleCardFields() {
        const isCard = paymentMethod.value === 'card';
        cardBlocks.forEach(block => {
            if (block) {
                block.style.display = isCard ? 'block' : 'none';
            }
        });
    }
    
    paymentMethod.addEventListener('change', toggleCardFields);
    toggleCardFields(); // Initial call
});