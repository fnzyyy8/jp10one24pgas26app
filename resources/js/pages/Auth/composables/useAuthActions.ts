import { useForm } from '@inertiajs/vue3';
import { route } from 'ziggy-js';

export function useAuthActions() {
    const formSubmit = useForm({
        name: '',
        email: '',
        division: '',
        position: '',
    });

    const submitRegister = () => {
        formSubmit.post(route('register.create'), {
            preserveScroll: true,
        });
    };

    return {
        formSubmit,
        submitLoading: formSubmit.processing,
        submitRegister,
    };
}
