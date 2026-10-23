import { useForm } from '@inertiajs/vue3';
import { route } from 'ziggy-js';

export function usePriceListCreateActions(onSuccessCallback?: () => void) {
    const formCreate = useForm({
        name: '',
        number: '',
        client: '',
    });

    const submitCreate = () => {
        formCreate.post(route('price-list.create'), {
            onSuccess: () => {
                formCreate.reset();

                if (onSuccessCallback) {
                    onSuccessCallback();
                }
            },
            onError: (e) => {
                console.log(e);
            },
        });
    };

    return {
        formCreate,
        submitCreate,
    };
}
