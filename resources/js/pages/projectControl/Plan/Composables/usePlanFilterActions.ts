import { computed, ref } from 'vue';

export function usePlanFilterActions() {
    const selectedCustomer = ref([]);
    const selectedSection = ref([]);
    const selectedCategory = ref([]);
    const selectedSubCategory = ref([]);

    const activeFilterCount = computed(() => {
        let count = 0;

        if (selectedCustomer.value.length > 0) {
            count++;
        }

        if (selectedSection.value.length > 0) {
            count++;
        }

        if (selectedCategory.value.length > 0) {
            count++;
        }

        if (selectedSubCategory.value.length > 0) {
            count++;
        }

        return count;
    });

    const resetFilter = () => {
        selectedCustomer.value = [];
        selectedSection.value = [];
        selectedCategory.value = [];
        selectedSubCategory.value = [];
    };

    return {
        selectedCustomer,
        selectedSection,
        selectedCategory,
        selectedSubCategory,
        activeFilterCount,
        resetFilter,
    };
}
