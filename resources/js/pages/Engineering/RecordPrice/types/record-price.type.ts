export interface RecordPrice {
    id: number;
    date: string;
    price: number;
    notes: string;
    created_at: string;
}

export interface UnitPrice {
    id: number;
    section: string;
    category: string;
    subCategory: string;
    name: string;
    unit: string;
}
