<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, usePage } from '@inertiajs/vue3';
import { ref } from 'vue';
import Modal from '@/Components/Modal.vue';



let products = JSON.parse(localStorage.getItem('cart')) || [];

let totalPrice = parseFloat((products.reduce((acc, product) => acc + (product.price * product.quantity), 0)).toFixed(2));

let showModal = ref(false);

let showModal2 = ref(false);

let message = ref('');

function checkout() {
    if (!products.length) {
        alert('Корзина пуста!');
        return;
    }
    axios.post('/checkout', { products, totalPrice })
        .then(response => {
            localStorage.removeItem('cart');
            products = [];
            totalPrice = 0;
            showModal2.value = true;
        })
        .catch(error => {
            message.value = 'Ошибка при оформлении заказа: ' + error.response.data.message;
            showModal.value = true;
        });
}

function handleClose() {
    showModal2.value = false;
    window.location.href = '/orders';
}

</script>

<template>

    <Head title="Dashboard" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="text-xl font-semibold leading-tight text-gray-800 dark:text-gray-200 mb-10">
                Оформление заказа
            </h2>
            <ol class="list-decimal pl-5 text-gray-800 dark:text-gray-200">
                <li v-for="product in products" :key="product.id" class="text-xl">
                    <h2 class="text-xl text-gray-50 font-semibold mb-2 inline">{{ product.name }}</h2>
                    <p class="text-lg text-gray-50 mb-4 inline ml-3">Количество: {{ product.quantity }}</p>
                    <p class="text-lg text-gray-50 mb-4 inline ml-3">Цена: {{ parseFloat((product.price *
                        product.quantity).toFixed(2)) }}₽</p>
                </li>
            </ol>
            <div class="flex justify-between items-center mt-5">
                <p class="text-lg text-gray-50">Итого: {{ totalPrice }}₽</p>
                <button @click="checkout()"
                    class="bg-blue-500 hover:bg-blue-700 text-white font-bold p-2 rounded-md">Оформить заказ</button>
            </div>
            <Modal v-if="showModal2" :show="showModal2" @close="handleClose" title="Успех"
                message="Заказ успешно оформлен!">
                <template #default>
                    <p class="text-white p-4">Ваш заказ был успешно оформлен. Спасибо за покупку!</p>
                </template>
            </Modal>
            <Modal v-if="showModal" :show="showModal" @close="showModal = false" title="Ошибка" :message="message">
                <template #default>
                    <p class="text-white p-4">{{ message }}</p>
                </template>
            </Modal>
        </template>
    </AuthenticatedLayout>
</template>
