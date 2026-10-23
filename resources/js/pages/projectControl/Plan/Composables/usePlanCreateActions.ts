import { useForm } from '@inertiajs/vue3';
import { toValue, watchEffect } from 'vue';
import type { MaybeRefOrGetter } from 'vue';
import { route } from 'ziggy-js';

export function usePlanCreateActions(
    boqId: MaybeRefOrGetter<number>,
    isMultipleCustomer: MaybeRefOrGetter<boolean>,
    onSuccessCallBack?: () => void,
) {
    const createForm = useForm({
        boq_id: 0,
        customer_category: '' as string | string[],
        section: '',
        category: '',
        sub_category: '',
        item_detail: '',
        volume: 0,
        unit: '',
        unit_price: 0,
    });

    watchEffect(() => {
        const isMultiple = toValue(isMultipleCustomer);

        if (!isMultiple) {
            createForm.customer_category = ['rumah tangga'];
        }
    });

    const submitCreateForm = () => {
        createForm.boq_id = toValue(boqId);

        createForm.post(route('plan.create', toValue(boqId)), {
            preserveScroll: true,
            onSuccess: () => {
                if (onSuccessCallBack) {
                    onSuccessCallBack();
                }

                createForm.reset();
            },
        });
    };

    return {
        createForm,
        submitCreateForm,
    };
}
