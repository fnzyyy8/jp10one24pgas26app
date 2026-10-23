export interface PlanDetailGridRow {
    name: string;
    volume: number | string;
    totalVolume: number | string;
    [field: string]: string | number;
}

export interface PlanDetailMonthGroup {
    monthYear: string;
    dates: string[];
    count: number;
}

