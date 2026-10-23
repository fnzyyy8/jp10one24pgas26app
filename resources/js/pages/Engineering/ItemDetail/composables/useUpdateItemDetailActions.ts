import { useForm } from '@inertiajs/vue3';
import { watch } from 'vue';
import type { Ref } from 'vue';

import type { ItemDetail } from '@/pages/Engineering/ItemDetail/types/item-detail.type';
import { route } from 'ziggy-js';

export function useUpdateItemDetailActions(
    itemDetailRef: Ref<ItemDetail | null>,
    onSuccessCallback?: () => void,
) {
    const formUpdate = useForm({
        name: '',
        unit: '',
        sort_order: 0,
    });

    watch(itemDetailRef, (itemDetail) => {
        if (itemDetail) {
            formUpdate.name = itemDetail.name;
            formUpdate.unit = itemDetail.unit;
            formUpdate.sort_order = itemDetail.sort_order;
        }
    });

    const submitUpdate = () => {
        formUpdate.put(route('item-details.update', itemDetailRef.value?.id), {
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
