import { useForm } from '@inertiajs/vue3';
import { computed, ref, watch } from 'vue';
import { route } from 'ziggy-js';

export function useProjectCreateActions(onSuccessCallback?: () => void) {
    const form = useForm({
        price_list_id: null,
        project_name: '',
        project_code: '',
        project_number: '',
        category: '',
        budget: 0,
        area: '',
        start_date: '',
        end_date: '',
        status: '',
        isMultipleArea: false,
    });

    const dateStart = ref<Date | null>(null);
    const dateEnd = ref<Date | null>(null);

    const minDateEnd = computed(() => dateStart.value || undefined);

    watch(dateStart, (newDateStart) => {
        if (newDateStart) {
            if (!dateEnd.value || dateEnd.value < newDateStart) {
                dateEnd.value = new Date(newDateStart);
            }
        }
    });

    const submitForm = () => {
        form.start_date = dateStart.value
            ? dateStart.value.toLocaleDateString('en-CA')
            : '';

        form.end_date = dateEnd.value
            ? dateEnd.value.toLocaleDateString('en-CA')
            : '';

        form.post(route('projects.create'), {
            preserveScroll: true,
            onSuccess: () => {
                form.reset();
                dateStart.value = null;
                dateEnd.value = null;

                if (onSuccessCallback) {
                    onSuccessCallback();
                }
            },
        });
    };

    return {
        form,
        dateStart,
        dateEnd,
        loading: form.processing,
        submitForm,
        minDateEnd,
    };
}
