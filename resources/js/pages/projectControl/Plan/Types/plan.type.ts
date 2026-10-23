export interface Boq {
    id: number;
    price_list_id: number;
    project_name: string;
    project_number: string;
    client: string;
    area: string;
    detailed_area: string;
    startDate: string;
    endDate: string;
}

export interface PlanSection {
    id: number;
    name: string;
    categories: PlanCategory[];
    plans: Plan[];
}

export interface PlanCategory {
    id: number;
    name: string;
    subCategories: PlanSubCategory[];
    plans: Plan[];
}

interface PlanSubCategory {
    id: number;
    name: string;
    plans: Plan[];
}

export interface Plan {
    id: number;
    boq_id: number;
    unit_price_id: number;

    section: string;
    category: string;
    subCategory: string;

    name: string;
    price: number;
    unit: string;
    volume: number | null;

    percentage: number;
}

export interface Section {
    id: number;
    name: string;
    categories: Category[];
    unitPrices: UnitPrice[];
}

interface Category {
    id: number;
    name: string;
    subCategories: SubCategory[];
    unitPrices: UnitPrice[];
}

interface SubCategory {
    id: number;
    name: string;
    unitPrices: UnitPrice[];
}

export interface UnitPrice {
    id: number;
    name: string;
    price: number;
    unit: string;
    volume: number;
}
