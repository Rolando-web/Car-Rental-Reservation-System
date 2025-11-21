 let selectedPaymentMethod = null;
   
   function openReturnModal(reservationId, totalAmount) {
     selectedPaymentMethod = null;
     document.getElementById('returnModal').classList.remove('hidden');
     document.getElementById('modalTotalAmount').textContent = parseFloat(totalAmount).toFixed(2);
     document.getElementById('payReservationId').value = reservationId;
     document.getElementById('payAmount').value = totalAmount;
     document.getElementById('payNowBtn').disabled = true;
     
     // Reset all payment option styling
     document.querySelectorAll('.payment-option').forEach(btn => {
       btn.classList.remove('border-blue-600', 'bg-blue-50', 'border-green-600', 'bg-green-50');
       btn.classList.add('border-gray-300');
     });
   }
   
   function closeReturnModal() {
     document.getElementById('returnModal').classList.add('hidden');
   }
   
   function selectPaymentMethod(method) {
     selectedPaymentMethod = method;
     document.getElementById('paymentMethod').value = method;
     
     // Update styling
     document.querySelectorAll('.payment-option').forEach(btn => {
       btn.classList.remove('border-blue-600', 'bg-blue-50', 'border-green-600', 'bg-green-50');
       btn.classList.add('border-gray-300');
     });
     
     const selectedBtn = document.querySelector(`[data-method="${method}"]`);
     selectedBtn.classList.remove('border-gray-300');
     if (method === 'Online') {
       selectedBtn.classList.add('border-blue-600', 'bg-blue-50');
     } else {
       selectedBtn.classList.add('border-green-600', 'bg-green-50');
     }
     
     // Enable Pay Now button
     document.getElementById('payNowBtn').disabled = false;
   }
   
   function submitPayment() {
     if (!selectedPaymentMethod) return;
     const reservationId = document.getElementById('payReservationId').value;
     document.getElementById('payForm').submit();
     
     // After form submission, disable and update button
     setTimeout(() => {
       const returnBtn = document.getElementById('returnBtn_' + reservationId);
       if (returnBtn) {
         returnBtn.disabled = true;
         returnBtn.textContent = 'PAID';
         returnBtn.classList.remove('bg-blue-600', 'hover:bg-blue-700');
         returnBtn.classList.add('bg-gray-500', 'cursor-not-allowed');
       }
       closeReturnModal();
     }, 500);
   }
   
   // Check if payment was successful and update button on page load
   document.addEventListener('DOMContentLoaded', function() {
     const params = new URLSearchParams(window.location.search);
     if (params.get('payment') === 'success') {
       const reservationId = params.get('reservation');
       const returnBtn = document.getElementById('returnBtn_' + reservationId);
       if (returnBtn) {
         returnBtn.disabled = true;
         returnBtn.textContent = 'PAID';
         returnBtn.classList.remove('bg-blue-600', 'hover:bg-blue-700');
         returnBtn.classList.add('bg-gray-500', 'cursor-not-allowed');
       }
     }
   });