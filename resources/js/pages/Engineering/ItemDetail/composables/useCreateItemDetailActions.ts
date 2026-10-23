import { useForm } from '@inertiajs/vue3';
import { computed, ref, watch } from 'vue';

import type {
    ItemDetailOptions,
    SectionOption,
    CategoryOption,
    SubCategoryOption,
} from '@/pages/Engineering/ItemDetail/types/item-detail.type';

import { route } from 'ziggy-js';
export function useCreateItemDetailActions(
    options: ItemDetailOptions,
    onSuccessCallback?: () => void,
) {
    const formCreate = useForm({
        section: {
            id: null as number | null,
            name: '',
            sort_order: 0,
        },

        category: {
            id: null as number | null,
            name: '',
            sort_order: 0,
        },

        subCategory: {
            id: null as number | null,
            name: '',
            sort_order: 0,
        },

        itemDetail: {
            scope: '',
            name: '',
            sort_order: 0,
            unit: '',
        },
    });

    type ScopeFilter =
        'Rumah Tangga' | 'Pelanggan Kecil' | 'Komersial Industri';
    const selectedSection = ref<SectionOption | string | null>(null);
    const selectedCategory = ref<CategoryOption | string | null>(null);
    const selectedSubCategory = ref<SubCategoryOption | string | null>(null);
    const selectedScope = ref<ScopeFilter>('Rumah Tangga');

    const scopeOptions = [
        { value: 'RT', title: 'Rumah Tangga' },
        { value: 'PK', title: 'Pelanggan Kecil' },
        { value: 'KI', title: 'Komersial Industri' },
    ];

    const availableCategories = computed(() => {
        if (!formCreate.section.id) {
            return [];
        }

        return options.categories.filter(
            (cat) => cat.section_id === formCreate.section.id,
        );
    });

    const availableSubCategories = computed(() => {
        if (!formCreate.category.id) {
            return [];
        }

        return options.subCategories.filter(
            (subCat) => subCat.category_id === formCreate.category.id,
        );
    });

    const isSectionSortReadonly = computed(
        () => formCreate.section.id !== null,
    );

    const isCategorySortReadonly = computed(
        () => formCreate.category.id !== null,
    );

    const isSubCategorySortReadonly = computed(
        () => formCreate.subCategory.id !== null,
    );

    watch(selectedSection, (value) => {
        selectedCategory.value = null;
        selectedSubCategory.value = null;

        if (!value) {
            formCreate.section.id = null;
            formCreate.section.name = '';
            formCreate.section.sort_order = 0;

            return;
        }

        if (typeof value === 'object') {
            formCreate.section.id = value.id;
            formCreate.section.name = value.name;
            formCreate.section.sort_order = value.sort_order;
        } else {
            formCreate.section.id = null;
            formCreate.section.name = value;
            formCreate.section.sort_order = 0;
        }
    });

    watch(selectedCategory, (value) => {
        selectedSubCategory.value = null;

        if (!value) {
            formCreate.category.id = null;
            formCreate.category.name = '';
            formCreate.category.sort_order = 0;

            return;
        }

        if (typeof value === 'object') {
            formCreate.category.id = value.id;
            formCreate.category.name = value.name;
            formCreate.category.sort_order = value.sort_order;
        } else {
            formCreate.category.id = null;
            formCreate.category.name = value;
            formCreate.category.sort_order = 0;
        }
    });

    watch(selectedSubCategory, (value) => {
        if (!value) {
            formCreate.subCategory.id = null;
            formCreate.subCategory.name = '';
            formCreate.subCategory.sort_order = 0;

            return;
        }

        if (typeof value === 'object') {
            formCreate.subCategory.id = value.id;
            formCreate.subCategory.name = value.name;
            formCreate.subCategory.sort_order = value.sort_order;
        } else {
            formCreate.subCategory.id = null;
            formCreate.subCategory.name = value;
            formCreate.subCategory.sort_order = 0;
        }
    });

    const submitCreate = () => {
        formCreate.itemDetail.scope = selectedScope.value;
        formCreate.post(route('item-details.create'), {
            onSuccess: () => {
                console.log(formCreate.itemDetail);
                formCreate.reset();
                onSuccessCallback?.();
                selectedSection.value = null;
                selectedCategory.value = null;
                selectedSubCategory.value = null;
                selectedScope.value = 'Rumah Tangga'
            },

            onError: (errors) => {
                console.log(errors);
            },
        });
    };

    const reset = () => {
        formCreate.reset();
        formCreate.clearErrors();

        selectedSection.value = '';
        selectedCategory.value = null;
        selectedSubCategory.value = null;
    };

    return {
        formCreate,

        sections: options.sections,
        categories: availableCategories,
        subCategories: availableSubCategories,
        scopeOptions,

        selectedSection,
        selectedCategory,
        selectedSubCategory,
        selectedScope,

        isSectionSortReadonly,
        isCategorySortReadonly,
        isSubCategorySortReadonly,

        submitCreate,
        reset,
    };
}
