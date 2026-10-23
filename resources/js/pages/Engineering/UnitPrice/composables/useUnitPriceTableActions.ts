import { computed, ref, toValue, watch } from 'vue';
import type { MaybeRefOrGetter } from 'vue';
import type {
    Section,
    UnitPrice,
} from '@/pages/Engineering/UnitPrice/type/unit-price.type';

export function useUnitPriceTableActions(
    items: MaybeRefOrGetter<Section[]>,
    unitPrices: MaybeRefOrGetter<UnitPrice[]>,
) {
    const selectedItemIds = ref<number[]>([]);
    const originalItemIds = ref<number[]>([]);

    watch(
        () => toValue(unitPrices),
        (newUnitPrices) => {
            const ids = newUnitPrices.map(
                (unitPrice) => unitPrice.item_detail_id,
            );
            selectedItemIds.value = [...ids];
            originalItemIds.value = [...ids];
        },
        {
            immediate: true,
        },
    );

    const allAvailableItemIds = computed<number[]>(() => {
        const ids = new Set<number>();
        const rawItems = toValue(items);

        if (!Array.isArray(rawItems)) {
            return [];
        }

        rawItems.forEach((section) => {
            section.itemDetails?.forEach((item) => ids.add(item.id));

            section.categories?.forEach((category) => {
                category.itemDetails?.forEach((item) => ids.add(item.id));

                category.subCategories?.forEach((subCategory) => {
                    subCategory.itemDetails?.forEach((item) =>
                        ids.add(item.id),
                    );
                });
            });
        });

        return [...ids];
    });

    const isAllSelected = computed({
        get: () =>
            allAvailableItemIds.value.length > 0 &&
            selectedItemIds.value.length === allAvailableItemIds.value.length,

        set: (value: boolean) => {
            selectedItemIds.value = value ? [...allAvailableItemIds.value] : [];
        },
    });

    const isIndeterminate = computed(() => {
        return (
            selectedItemIds.value.length > 0 &&
            selectedItemIds.value.length < allAvailableItemIds.value.length
        );
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
        allAvailableItemIds,
        isAllSelected,
        isIndeterminate,
        hasChange,
    };
}
