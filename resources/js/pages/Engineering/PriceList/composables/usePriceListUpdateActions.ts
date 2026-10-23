import { useForm } from '@inertiajs/vue3';
import type { Ref } from 'vue';
import { watch } from 'vue';

import type { PriceList } from '@/pages/Engineering/PriceList/type/price-list.type';
import { route } from 'ziggy-js';

export function usePriceListUpdateActions(
    priceListRef: Ref<PriceList | null>,
    onSuccessCallback?: () => void,
) {
    const formUpdate = useForm({
        name: '',
        number: '',
        client: '',
    });

    watch(
        priceListRef,
        (priceList) => {
            if (priceList) {
                formUpdate.name = priceList.name;
                formUpdate.number = priceList.number;
                formUpdate.client = priceList.client
            }
        },
        { immediate: true },
    );

    const submitUpdate = () => {
        formUpdate.put(route('price-list.update', priceListRef.value?.id), {
            onSuccess: () => {
                formUpdate.reset();

                if (onSuccessCallback) {
                    onSuccessCallback();
                }
            },
        });
    };

    return {
        formUpdate,
        submitUpdate,
    };
}
