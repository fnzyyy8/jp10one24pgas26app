import { useForm } from '@inertiajs/vue3';
import type { MaybeRefOrGetter } from 'vue';
import { watch } from 'vue';
import { computed } from 'vue';
import { toValue } from 'vue';
import { ref } from 'vue';
import type { Section } from '@/pages/projectControl/Plan/Types/plan.type';
import { route } from 'ziggy-js';

export function     useUpdatePlanActions(
    boqId: MaybeRefOrGetter<number>,
    section: MaybeRefOrGetter<Section[]>,
    plans: MaybeRefOrGetter<any[]>,
) {
    const selectedItemIds = ref<number[]>([]);
    const originalItemIds = ref<number[]>([]);

    const form = useForm({
        unit_price_ids: [] as number[],
    });

    const allAvailableItemIds = computed<number[]>(() => {
        const rawSection = toValue(section);

        if (!Array.isArray(rawSection)) {
            return [];
        }

        const ids = new Set<number>();

        const collectIds = (items?: Array<{ id: number }>) => {
            items?.forEach((item) => ids.add(item.id));
        };

        rawSection.forEach((section) => {
            collectIds(section.unitPrices);
            section.categories?.forEach((category) => {
                collectIds(category.unitPrices);
                category.subCategories?.forEach((subCategory) => {
                    collectIds(subCategory.unitPrices);
                });
            });
        });

        return Array.from(ids);
    });

    watch(
        () => toValue(plans),
        (newPlans) => {
            if (!Array.isArray(newPlans)) {
                return;
            }

            const ids = newPlans.map((plan) => plan.unit_price_id);
            selectedItemIds.value = [...ids];
            originalItemIds.value = [...ids];
        },
        {
            immediate: true,
            deep: true,
        },
    );

    const hasChange = computed(() => {
        if (selectedItemIds.value.length !== originalItemIds.value.length) {
            return true;
        }

        const originalSet = new Set(originalItemIds.value);

        return selectedItemIds.value.some((id) => !originalSet.has(id));
    });

    const isIndeterminate = computed(() => {
        const totalAvailable = allAvailableItemIds.value.length;
        const totalSelected = selectedItemIds.value.length;

        return totalSelected > 0 && totalSelected < totalAvailable;
    });

    const isAllSelected = computed({
        get: () => {
            const totalAvailable = allAvailableItemIds.value.length;
            const totalSelected = selectedItemIds.value.length;

            return totalAvailable > 0 && totalSelected === totalAvailable;
        },

        set: (value: boolean) => {
            selectedItemIds.value = value ? [...allAvailableItemIds.value] : [];
        },
    });

    const isSaving = computed(() => form.processing);
    const handleSave = () => {
        form.unit_price_ids = [...selectedItemIds.value];

        form.post(route('plan.sync', toValue(boqId)), {
            preserveScroll: true,
            onSuccess: () => {
                originalItemIds.value = [...selectedItemIds.value];
            },
            onError:(e) => {
                console.log(e);
            }
        });
    };

    return {
        selectedItemIds,
        allAvailableItemIds,
        isAllSelected,
        isIndeterminate,
        hasChange,
        isSaving,
        handleSave,
    };
}
