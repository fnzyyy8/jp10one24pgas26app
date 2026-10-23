export interface SectionOption {
    id: number;
    name: string;
    sort_order: number;
}

export interface CategoryOption {
    id: number;
    section_id: number;
    name: string;
    sort_order: number;
}

export interface SubCategoryOption {
    id: number;
    category_id: number;
    name: string;
    sort_order: number;
}

export interface ItemDetailOptions {
    sections: SectionOption[];
    categories: CategoryOption[];
    subCategories: SubCategoryOption[];
}

export interface ItemDetail {
    id: number;
    name: string;
    unit: string;
    sort_order: number;
}

interface Category {
    id: number;
    name: string;
    sort_order: number;
    itemDetails?: ItemDetail[];
    subCategories?: SubCategory[];
}

interface SubCategory {
    id: number;
    name: string;
    sort_order: number;
    itemDetails?: ItemDetail[];
}

export interface Section {
    id: number;
    name: string;
    sort_order: number;
    itemDetails?: ItemDetail[];
    categories?: Category[];
}
