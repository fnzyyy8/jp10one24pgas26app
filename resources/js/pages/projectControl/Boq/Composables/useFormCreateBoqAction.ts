import { useForm } from '@inertiajs/vue3';
import type { Ref } from 'vue';
import { watch } from 'vue';
import { computed, ref } from 'vue';
import { route } from 'ziggy-js';

export function useFormCreateBoqAction(
    projectsRef: Ref<any[] | undefined>,
    onSuccessCallback?: () => void,
) {
    // Create
    const selectedCategory = ref<string | null>(null);

    const formCreate = useForm({
        project_id: null as number | null,
        detailed_area: '',
        isMultipleCustomer: false,
    });

    watch(selectedCategory, () => {
        formCreate.project_id = null;
    });

    const filteredProjects = computed(() => {
        if (!selectedCategory.value || !projectsRef.value) {
            return [];
        }

        return projectsRef.value.filter((project) => {
            return (
                project.category == selectedCategory.value ||
                project.category_id == selectedCategory.value
            );
        });
    });

    const resetCreateForm = () => {
        formCreate.reset();
        formCreate.clearErrors();
        selectedCategory.value = null;
    };

    const submitCreateForm = () => {
        formCreate.post(route('boq.create'), {
            onSuccess: () => {
                resetCreateForm();

                if (onSuccessCallback) {
                    onSuccessCallback();
                }
            },
        });
    };

    return {
        formCreate,
        selectedCategory,
        filteredProjects,
        submitCreateForm,
        resetCreateForm,
    };
}
