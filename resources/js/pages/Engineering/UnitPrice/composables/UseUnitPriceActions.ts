import { useForm } from '@inertiajs/vue3';
import type { MaybeRefOrGetter } from 'vue';
import { computed, watch } from 'vue';
import { ref } from 'vue';
import { toValue } from 'vue';
import type {
    PriceList,
    Section,
    UnitPrice,
} from '@/pages/Engineering/UnitPrice/type/unit-price.type';
import { route } from 'ziggy-js';

export function useUnitPriceActions(
    priceList: MaybeRefOrGetter<PriceList>,
    unitPrices: MaybeRefOrGetter<UnitPrice[]>,
    sections: MaybeRefOrGetter<Section[]>,
) {
    const selectedItemIds = ref<number[]>([]);
    const originalItemIds = ref<number[]>([]);

    const form = useForm({
        item_detail_ids: [] as number[],
    });

    const allAvailableItemIds = computed<number[]>(() => {
        const rawSection = toValue(sections);

        if (!Array.isArray(rawSection)) {
            return [];
        }

        const ids = new Set<number>();

        const collectId = (items?: Array<{ id: number }>) => {
            items?.forEach((item) => ids.add(item.id));
        };

        rawSection.forEach((sections) => {
            collectId(sections.itemDetails);
            sections.categories?.forEach((category) => {
                collectId(category.itemDetails);
                category.subCategories?.forEach((subCategory) => {
                    collectId(subCategory.itemDetails);
                });
            });
        });

        return Array.from(ids);
    });

    watch(
        () => toValue(unitPrices),
        (newUnitPrices) => {
            if (!Array.isArray(newUnitPrices)) {
                return;
            }

            const ids = newUnitPrices.map(
                (unitPrice) => unitPrice.item_detail_id,
            );
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
        form.transform(() => ({
            item_detail_ids: [...selectedItemIds.value],
        })).post(route('unit-price.sync', toValue(priceList).id), {
            preserveScroll: true,
            onSuccess: () => {
                originalItemIds.value = [...selectedItemIds.value];
            },
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
