import { useForm } from '@inertiajs/vue3';
import { ref } from 'vue';
import type { PriceList } from '@/pages/Engineering/PriceList/type/price-list.type';
import { route } from 'ziggy-js';
const isCreateOpen = ref(false);
const isUpdateOpen = ref(false);

export function usePriceListActions() {
    const selectedPriceList = ref<PriceList | null>(null);

    const openCreateModal = () => {
        isCreateOpen.value = true;
    };

    const formDelete = useForm({});

    const openUpdateModal = (PriceList: PriceList) => {
        selectedPriceList.value = PriceList;
        isUpdateOpen.value = true;
    };

    const submitDelete = (id: number) => {
        formDelete.delete(route('price-list.delete', id));
    };

    const redirectToPriceListShow = (id: number) => {
        formDelete.get(route('price-list.show', id));
    };

    return {
        isCreateOpen,
        isUpdateOpen,
        selectedPriceList,
        openCreateModal,
        openUpdateModal,
        submitDelete,
        redirectToPriceListShow,
    };
}
