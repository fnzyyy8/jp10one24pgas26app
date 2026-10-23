export interface Boq {
    id: number;
    project_number: string;
    project_area: string;
    project_name: string;
    project_budget: number;
    detailed_area: string;
    isMultipleCustomer: boolean;
    planBudget: number;
}

interface ProjectType {
    id: number;
    project_name: string;
}
export interface FormBoqOptions {
    categories?: string[];
    projects?: ProjectType[];
}

export interface FormBoqProps {
    formBoqOptions?: FormBoqOptions;
}
