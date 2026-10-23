export interface User {
    id: number;
    name: string;
    email: string;
    role: UserRole;
    division: UserDivision;
    position: UserPosition;
    is_active: boolean;
    verified_by: number | null;
    verified_at: string | null;
}

export type UserAction = 'approve' | 'toggle-active' | 'edit' | 'delete';

export type UserRole = 'super_admin' | 'admin' | 'manager' | 'staff' | 'guest';
export type UserDivision = 'site' | 'pscm' | 'vendor';
export type UserPosition =
    | 'Project Control'
    | 'Administration and Contract'
    | 'Finance'
    | 'HSSE'
    | 'QAQC'
    | 'Engineering'
    | 'General Affair'
    | 'Procurement'
    | 'Logistic';
