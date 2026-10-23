<script setup lang="ts">
import { computed, ref, watch } from 'vue';
import { useFormatNumber } from '@/composable/useFormatNumber';
import FormUpdateUserManagement from '@/pages/UserManagement/components/form/FormUpdateUserManagement.vue';
import { useUserManagementActions } from '@/pages/UserManagement/composables/useUserManagementActions';
import type {
    User,
    UserAction,
    UserRole,
} from '@/pages/UserManagement/type/index.type';

const props = defineProps<{
    users: User[];
}>();

const { approveUser } = useUserManagementActions();

// State lokal agar aksi dummy tidak mengubah props secara langsung.
const localUsers = ref<User[]>([]);

watch(
    () => props.users,
    (users) => {
        localUsers.value = users.map((user) => ({ ...user }));
    },
    { immediate: true },
);

const headers = [
    { title: 'No', key: 'no', sortable: false, width: 70 },
    { title: 'Name', key: 'name' },
    { title: 'Email', key: 'email' },
    { title: 'Role', key: 'role' },
    { title: 'Status', key: 'is_active' },
    { title: 'Verified By', key: 'verified_by' },
    { title: 'Verified At', key: 'verified_at' },
    {
        title: 'Actions',
        key: 'actions',
        sortable: false,
        align: 'end' as const,
        width: 80,
    },
];

const roleConfig: Record<UserRole, { label: string; color: string }> = {
    super_admin: { label: 'Super Admin', color: 'deep-purple' },
    admin: { label: 'Admin', color: 'primary' },
    manager: { label: 'Manager', color: 'info' },
    staff: { label: 'Staff', color: 'success' },
    guest: { label: 'Guest', color: 'secondary' },
};

const search = ref('');
const selectedUser = ref<User | null>(null);
const editDialog = ref(false);
const deleteDialog = ref(false);

const editableUser = ref({
    name: '',
    email: '',
    role: 'staff' as UserRole,
});

const filteredUsers = computed(() => {
    const keyword = search.value.trim().toLowerCase();

    if (!keyword) {
        return localUsers.value;
    }

    return localUsers.value.filter((user) =>
        [
            user.id,
            user.name,
            user.email,
            user.role,
            user.verified_by ?? '',
            user.verified_at ?? '',
        ].some((value) => String(value).toLowerCase().includes(keyword)),
    );
});

const isApproved = (user: User): boolean => {
    return user.verified_at !== null;
};

const handleAction = (action: UserAction, user: User): void => {
    selectedUser.value = user;

    switch (action) {
        case 'approve':
            approveUser(user);
            break;

        case 'toggle-active':
            // Dummy: hanya mengubah state frontend.
            user.is_active = !user.is_active;
            break;

        case 'edit':
            openEditDialog(user);
            break;

        case 'delete':
            deleteDialog.value = true;
            break;
    }
};

const openEditDialog = (user: User): void => {
    editableUser.value = {
        name: user.name,
        email: user.email,
        role: user.role,
    };

    editDialog.value = true;
};

const confirmDelete = (): void => {
    if (!selectedUser.value) {
        return;
    }

    // Dummy: menghapus dari tabel lokal saja.
    localUsers.value = localUsers.value.filter(
        (user) => user.id !== selectedUser.value!.id,
    );

    deleteDialog.value = false;
    selectedUser.value = null;
};

const { formatDateTime } = useFormatNumber();
</script>

<template>
    <div>
        <div class="d-flex mb-4 justify-end">
            <v-text-field
                v-model="search"
                label="Search users"
                placeholder="Name, email, role..."
                prepend-inner-icon="mdi-magnify"
                variant="outlined"
                density="compact"
                clearable
                hide-details
                max-width="320"
            />
        </div>

        <v-data-table
            :headers="headers"
            :items="filteredUsers"
            item-value="id"
            hover
        >
            <template v-slot:[`item.no`]="{ index }">
                {{ index + 1 }}
            </template>
            <template v-slot:[`item.role`]="{ value }">
                <v-chip
                    size="small"
                    :color="roleConfig[value as UserRole].color"
                >
                    {{ roleConfig[value as UserRole].label }}
                </v-chip>
            </template>

            <template v-slot:[`item.is_active`]="{ value }">
                <v-chip
                    size="small"
                    :color="value ? 'success' : 'error'"
                    variant="tonal"
                >
                    {{ value ? 'Active' : 'Inactive' }}
                </v-chip>
            </template>

            <template v-slot:[`item.verified_by`]="{ value }">
                {{ value ?? '-' }}
            </template>

            <template v-slot:[`item.verified_at`]="{ value }">
                {{ formatDateTime(value) ?? '-' }}
            </template>

            <template v-slot:[`item.actions`]="{ item }">
                <v-menu location="bottom end">
                    <template #activator="{ props: menuProps }">
                        <v-btn
                            v-bind="menuProps"
                            icon="mdi-dots-vertical"
                            variant="text"
                            size="small"
                            aria-label="User actions"
                        />
                    </template>

                    <v-list density="compact" min-width="190">
                        <v-list-item
                            :disabled="isApproved(item)"
                            prepend-icon="mdi-check-circle-outline"
                            :title="isApproved(item) ? 'Approved' : 'Approve'"
                            @click="handleAction('approve', item)"
                        />

                        <v-list-item
                            :prepend-icon="
                                item.is_active
                                    ? 'mdi-account-off-outline'
                                    : 'mdi-account-check-outline'
                            "
                            :title="item.is_active ? 'Deactivate' : 'Activate'"
                            @click="handleAction('toggle-active', item)"
                        />

                        <v-divider class="my-1" />

                        <v-list-item
                            prepend-icon="mdi-pencil-outline"
                            title="Advance Edit"
                            @click="handleAction('edit', item)"
                        />

                        <v-list-item
                            prepend-icon="mdi-delete-outline"
                            title="Delete"
                            class="text-error"
                            @click="handleAction('delete', item)"
                        />
                    </v-list>
                </v-menu>
            </template>

            <template #no-data>
                <div class="text-medium-emphasis py-8 text-center">
                    No users found.
                </div>
            </template>
        </v-data-table>
        <FormUpdateUserManagement v-model="editDialog" />

        <!-- Delete Confirmation -->
        <v-dialog v-model="deleteDialog" max-width="400">
            <v-card title="Delete User">
                <v-card-text>
                    Are you sure you want to delete
                    <strong>{{ selectedUser?.name }}</strong
                    >? This action cannot be undone.
                </v-card-text>

                <v-card-actions>
                    <v-spacer />

                    <v-btn variant="text" @click="deleteDialog = false">
                        Cancel
                    </v-btn>

                    <v-btn color="error" @click="confirmDelete"> Delete </v-btn>
                </v-card-actions>
            </v-card>
        </v-dialog>
    </div>
</template>
