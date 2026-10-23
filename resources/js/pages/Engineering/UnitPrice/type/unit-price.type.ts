interface ItemDetail {
    id: number;
    section_id: number;
    category_id?: number | null;
    sub_category_id?: number | null;
    name: string;
    unit: string;
    sort_order: number;
}

interface SubCategory {
    id: number;
    name: string;
    sort_order: number;
    itemDetails?: ItemDetail[];
}
interface Category {
    id: number;
    name: string;
    sort_order: number;
    itemDetails?: ItemDetail[];
    subCategories?: SubCategory[];
}

export interface Section {
    id: number;
    name: string;
    sort_order: number;
    itemDetails?: ItemDetail[];
    categories?: Category[];
}

export interface UnitPrice {
    id: number;
    name: string;
    item_detail_id: number;
    isFreeIssueMaterial: boolean;
    itemDetails?: ItemDetail;
}

export interface PriceList {
    id: number;
    name: string;
    number: string;
    client: string;
}

export interface UnitPricePageProps {
    priceList: PriceList;
    unitPrices: UnitPrice[];
    items: Section[];
}
