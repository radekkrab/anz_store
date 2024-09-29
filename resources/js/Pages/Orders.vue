<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head } from '@inertiajs/vue3';
import { ref } from 'vue';

const props = defineProps({
    orders: {
        type: Array,
        required: true,
    },
});

const orders = ref([...props.orders]);

function deleteOrder(orderId) {
    axios.delete('/orders/' + orderId)
      .then(responce => {
        console.log('Заказ успешно удалён');
        orders.value = orders.value.filter(o => o.id !== orderId);
      })
      .catch(error => {
        console.error('Ошибка удаления заказа', error);
      });
}

</script>

<template>

    <Head title="Dashboard" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="text-xl font-semibold leading-tight text-gray-800 dark:text-gray-200">
                Мои заказы
            </h2>
        </template>

        <div class="py-12">
            <table class="min-w-full divide-y divide-gray-200 bg-gray-800 shadow-md rounded-lg overflow-hidden">
                <thead class="bg-gray-200">
                    <tr>
                        <th class="text-xl text-gray-800 px-6 py-3 text-left">ID заказа:</th>
                        <th class="text-xl text-gray-800 px-6 py-3 text-left">Дата заказа:</th>
                        <th class="text-xl text-gray-800 px-6 py-3 text-left">Товары:</th>
                        <th class="text-xl text-gray-800 px-6 py-3 text-left">Общая стоимость:</th>
                        <th class="text-xl text-gray-800 px-6 py-3 text-left">Действие</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    <tr v-for="order in orders" :key="order.id"
                        class="text-xl text-gray-800 hover:bg-gray-100">
                        <td class="px-6 py-4">{{ order.id }}</td>
                        <td class="px-6 py-4">{{ new Date(order.created_at).toLocaleString() }}</td>
                        <td class="px-6 py-4">{{ order.products.map(product => product.name).join(', ') }}</td>
                        <td class="px-6 py-4">{{ order.total_price }}₽</td>
                        <td class="px-6 py-4">
                            <button @click="deleteOrder(order.id)"
                                class="text-red-600 hover:text-red-800 font-semibold">Удалить
                                заказ</button>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>

    </AuthenticatedLayout>
</template>
