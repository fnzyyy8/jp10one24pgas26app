<script setup lang="ts">
import { useUserManagementActions } from '@/pages/UserManagement/composables/useUserManagementActions';

const dialog = defineModel<boolean>({ default: false });

const { roleOptions, divisionOptions } = useUserManagementActions();
</script>

<template>
    <v-dialog v-model="dialog" width="700">
        <v-card>
            <div class="grid gap-2 p-3">
                <div class="mb-5">
                    <h1>Edit User</h1>
                </div>
                <div class="grid grid-cols-2 gap-2">
                    <v-text-field label="Nama" />
                    <v-text-field label="Email" />
                </div>
                <v-select :items="roleOptions" label="Role" />
                <div class="grid grid-cols-2 gap-2">
                    <v-select :items="divisionOptions" label="Division" />
                    <v-select :items="roleOptions" label="Position" />
                </div>
                <v-text-field
                    label="Password"
                    append-inner-icon="mdi-dice-multiple"
                />
                <div class="flex justify-end gap-3">
                    <v-btn text="Submit" color="success" />
                    <v-btn text="Batal" color="error" />
                </div>
            </div>
        </v-card>
    </v-dialog>
</template>

<style scoped></style>
