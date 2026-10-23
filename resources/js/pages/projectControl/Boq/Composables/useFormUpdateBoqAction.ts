import { useForm } from '@inertiajs/vue3';
import { watch } from 'vue';
import type { Ref } from 'vue';
import type { Boq } from '@/pages/projectControl/Boq/Types/boq.type';
import { route } from 'ziggy-js';

export function useFormUpdateBoqAction(
    boqRef: Ref<Boq | null>,
    onSuccessCallback?: () => void,
) {
    const formUpdate = useForm({
        detailed_area: '',
        isMultipleCustomer: false,
    });

    watch(
        boqRef,
        (boq) => {
            if (boq) {
                formUpdate.detailed_area = boq.detailed_area ?? '';
                formUpdate.isMultipleCustomer = Boolean(boq.isMultipleCustomer);
            }
        },
        { immediate: true },
    );

    const submitUpdate = () => {
        formUpdate.put(route('boq.update', boqRef.value?.id), {
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
