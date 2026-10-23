export interface User {
    id: number;
    name: string;
    email: string;
    division: string | null;
    position: string | null;
}

export interface ProfileField {
    label: string;
    value: string;
    icon: string;
}
