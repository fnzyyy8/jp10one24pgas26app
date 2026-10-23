export interface Project {
    id: number;
    price_list_id: null | number;
    status: string;
    project_name: string;
    project_code: string;
    project_number: string;
    budget: number;
    area: string;
    client: string;
    start_date: string;
    end_date: string;
    isMultipleArea: boolean;
}

export interface PriceListOption {
    id: number;
    name: string;
}
