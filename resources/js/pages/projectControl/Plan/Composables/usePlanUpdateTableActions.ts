import { computed, ref, toValue, watch } from 'vue';
import type { MaybeRefOrGetter } from 'vue';
import type { Section } from '@/pages/projectControl/Plan/Types/plan.type';

const selectedItemIds = ref<number[]>([]);
const originalItemIds = ref<number[]>([]);
export function usePlanUpdateTableActions(
    unitPrices: MaybeRefOrGetter<Section[]>,
    plans: MaybeRefOrGetter<any[]>,
) {
    const isIndeterminate = computed(() => {
        return (
            selectedItemIds.value.length > 0 &&
            selectedItemIds.value.length < allAvailableItemsIds.value.length
        );
    });

    watch(
        () => toValue(plans),
        (newPlans) => {
            const ids = newPlans.map((plan) => plan.unit_price_id);
            selectedItemIds.value = [...ids];
            originalItemIds.value = [...ids];
        },
        {
            immediate: true,
        },
    );

    const allAvailableItemsIds = computed<number[]>(() => {
        const ids = new Set<number>();
        const rawUnitPrices = toValue(unitPrices);

        if (!Array.isArray(rawUnitPrices)) {
            return [];
        }

        rawUnitPrices.forEach((section) => {
            section.unitPrices?.forEach((item) => {
                ids.add(item.id);
            });
            section.categories?.forEach((category) => {
                category.unitPrices?.forEach((item) => {
                    ids.add(item.id);
                });
                category.subCategories?.forEach((subCategory) => {
                    subCategory.unitPrices?.forEach((item) => {
                        ids.add(item.id);
                    });
                });
            });
        });

        return [...ids];
    });

    const isAllSelected = computed({
        get: () =>
            allAvailableItemsIds.value.length > 0 &&
            selectedItemIds.value.length === allAvailableItemsIds.value.length,

        set: (value: boolean) => {
            selectedItemIds.value = value
                ? [...allAvailableItemsIds.value]
                : [];
        },
    });

    const hasChange = computed(() => {
        const current = [...selectedItemIds.value].sort((a, b) => a - b);
        const original = [...originalItemIds.value].sort((a, b) => a - b);

        return (
            current.length !== original.length ||
            current.some((id, index) => id !== original[index])
        );
    });

    return {
        selectedItemIds,
        allAvailableItemsIds,
        isAllSelected,
        isIndeterminate,
        hasChange,
    };
}
