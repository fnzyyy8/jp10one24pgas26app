import { router, useForm } from '@inertiajs/vue3';
import type {
    User,
    UserDivision,
    UserRole,
} from '@/pages/UserManagement/type/index.type';
import { route } from 'ziggy-js';
const roleOptions: { title: string; value: UserRole }[] = [
    {
        title: 'Super Admin',
        value: 'super_admin',
    },

    {
        title: 'Admin',
        value: 'admin',
    },

    {
        title: 'Manager',
        value: 'manager',
    },

    {
        title: 'Staff',
        value: 'staff',
    },

    {
        title: 'Guest',
        value: 'guest',
    },
];

const divisionOptions: { title: string; value: UserDivision }[] = [
    {
        title: 'SITE',
        value: 'site',
    },
    {
        title: 'PSCM',
        value: 'pscm',
    },
    {
        title: 'VENDOR',
        value: 'vendor',
    },
];
export function useUserManagementActions() {
    const formEdit = useForm({
        name: '',
        email: '',
        role: '',
        division: '',
        position: '',
        password: '',
    });

    const approveUser = (user: User) => {
        router.patch(
            route('user-management.approve', user.id),
            {},
            {
                preserveScroll: false,
            },
        );
    };



    return {
        formEdit,
        roleOptions,
        divisionOptions,
        approveUser,
    };
}
