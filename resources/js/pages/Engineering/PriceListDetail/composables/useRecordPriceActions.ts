import { useForm } from '@inertiajs/vue3';
import { ref, toValue } from 'vue';
import type { MaybeRefOrGetter } from 'vue';
import { route } from 'ziggy-js';

export function useRecordPriceActions(
    priceListId: MaybeRefOrGetter<number>,
    onSuccessCallback?: () => void,
) {
    const isCreateOpen = ref(false);
    const form = useForm({});

    const openCreateDialog = () => {
        isCreateOpen.value = true;
    };

    const submitDelete = (id: number) => {
        form.delete(
            route('record.price.delete', {
                priceListId: toValue(priceListId),
                id: id,
            }),
            {
                onSuccess: () => {
                    if (onSuccessCallback) {
                        onSuccessCallback();
                    }
                },
            },
        );
    };

    return {
        isCreateOpen,
        openCreateDialog,
        submitDelete,
    };
}
