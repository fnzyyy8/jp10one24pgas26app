export interface Boq {
    id: number;
    planId: number;

    projectName: string;
    projectNumber: string;
    client: string;
    area: string;
    detailedArea: string;

    startDate: string;
    endDate: string;
}

export interface ItemDetail {
    section: string;
    category: string;
    subCategory: string;
    name: string;

    volume: number;
    totalVolume: number;
}

export interface PlanDetail {
    id: number;
    date: string;
    volume: number;
    unit: string;
}
