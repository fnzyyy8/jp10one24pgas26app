import { useForm } from '@inertiajs/vue3';
import { computed, ref, watch } from 'vue';
import type { Project } from '@/pages/projects/types';
import { route } from 'ziggy-js';

export function useProjectEditActions() {
    const form = useForm({
        id: 0,
        price_list_id: null as number | null,
        project_name: '',
        project_code: '',
        project_number: '',
        budget: 0,
        area: '',
        client: '',
        start_date: '',
        end_date: '',
        isMultipleArea: false,
    });
    const isEditOpen = ref(false);
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

    const openEditModal = (id: number, project: Project) => {
        form.id = id;
        form.price_list_id = project.price_list_id;
        form.project_name = project.project_name;
        form.project_code = project.project_code;
        form.project_number = project.project_number;
        form.budget = project.budget ? Number(project.budget) : 0;
        form.area = project.area;
        form.client = project.client;
        form.isMultipleArea = Boolean(project.isMultipleArea);

        dateStart.value = new Date(project.start_date);
        dateEnd.value = new Date(project.end_date);

        isEditOpen.value = true;
    };

    const submit = () => {
        form.start_date = dateStart.value
            ? dateStart.value.toLocaleDateString('en-CA')
            : '';
        form.end_date = dateEnd.value
            ? dateEnd.value.toLocaleDateString('en-CA')
            : '';

        form.put(route('projects.update', form.id), {
            onSuccess: () => {
                isEditOpen.value = false;
                form.reset();
            },
        });
    };

    return {
        form,
        isEditOpen,
        dateStart,
        dateEnd,
        minDateEnd,
        openEditModal,
        submit,
    };
}
