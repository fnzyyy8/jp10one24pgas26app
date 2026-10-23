export interface PriceList {
    id: number;
    name: string;
    number: string;
    client: string;
    sections: Section[];
}

export interface Section {
    id: number;
    name: string;
    categories?: Category[];
    itemDetails?: ItemDetail[];
}

interface Category {
    id: number;
    name: string;
    subCategories?: SubCategory[];
    itemDetails?: ItemDetail[];
}

interface SubCategory {
    id: number;
    name: string;
    itemDetails?: ItemDetail[];
}

interface ItemDetail {
    id: number;
    name: string;
    unit: string;
    price: number;
}
