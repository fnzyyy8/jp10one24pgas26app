export interface Worker {
    id: number;
    id_card_number: string;
    name: string;
    based: string;
    phone_number: string;
    email: string;
    work_status: 'not active' | 'active' | 'on work';
    last_follow_up: string;
    work_scopes?: {
        id: number;
        name: string;
    }[];
    photo_url? : string;
    created_at?: string;
    updated_at?: string;
}
