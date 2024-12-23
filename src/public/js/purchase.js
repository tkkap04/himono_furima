document.addEventListener('DOMContentLoaded', () => {
    const stripe = Stripe(document.getElementById('stripe-key').dataset.key);
    const elements = stripe.elements();

    const card = elements.create('card', {
        hidePostalCode: true,
    });
    card.mount('#card-element');

    const showModalButton = document.getElementById('show-card-modal');
    const closeModalButton = document.getElementById('close-modal');
    const modal = document.getElementById('card-modal');
    const submitPaymentButton = document.getElementById('submit-payment-button');

    // モーダル表示
    showModalButton.addEventListener('click', () => {
        modal.style.display = 'flex';
    });

    // モーダルを閉じる
    closeModalButton.addEventListener('click', () => {
        modal.style.display = 'none';
    });

    // カード情報を送信
    submitPaymentButton.addEventListener('click', async (event) => {
        event.preventDefault();

        try {
            const { error, paymentMethod } = await stripe.createPaymentMethod({
                type: 'card',
                card: card,
            });

            if (error) {
                document.getElementById('card-errors').textContent = error.message;
                return;
            }

            // フォームに追加して送信
            const cardForm = document.getElementById('card-payment-form');
            const hiddenInput = document.createElement('input');
            hiddenInput.type = 'hidden';
            hiddenInput.name = 'payment_method';
            hiddenInput.value = paymentMethod.id;
            cardForm.appendChild(hiddenInput);

            cardForm.submit();
        } catch (e) {
            console.error('Unexpected Error:', e);
            document.getElementById('card-errors').textContent = '予期しないエラーが発生しました。';
        }
    });

    // モーダル外クリックで閉じる
    window.addEventListener('click', (event) => {
        if (event.target === modal) {
            modal.style.display = 'none';
        }
    });
});
