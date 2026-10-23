import { useForm } from '@inertiajs/vue3';
import { ref, toValue } from 'vue';
import type { MaybeRefOrGetter } from 'vue';
import { route } from 'ziggy-js';

const date = ref<Date | null>(null);
export function useRecordPriceCreateActions(
    unitPriceId: MaybeRefOrGetter<number>,
    priceListId: MaybeRefOrGetter<number>,
    onSuccessCallback?: () => void,
) {
    const form = useForm({
        unit_price_id: 0,
        date: '',
        name: '',
        notes: '',
        price: 0,
    });

    const submitForm = () => {
        form.unit_price_id = toValue(unitPriceId);
        form.date = date.value ? date.value.toLocaleDateString('en-CA') : '';

        form.post(
            route('record.price.create', { priceListId: toValue(priceListId) }),
            {
                onSuccess: () => {
                    form.reset();

                    if (onSuccessCallback) {
                        onSuccessCallback();
                    }
                },
            },
        );
    };

    return {
        form,
        date,
        submitForm,
    };
}
