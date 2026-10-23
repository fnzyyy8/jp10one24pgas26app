<script setup lang="ts">
import { onMounted } from 'vue';
import { useBreadcrumb } from '@/composable/useBreadcrumb';
import TableUserManagement from '@/pages/UserManagement/components/TableUserManagement.vue';
import type { User } from '@/pages/UserManagement/type/index.type';

defineProps<{
    users: User[];
}>();

const { setBreadcrumbs } = useBreadcrumb();

onMounted(() =>
    setBreadcrumbs([
        {
            title: 'USER',
            disabled: true,
        },
    ]),
);
</script>

<template>
    <div>
        <v-row>
            <v-col>
                <v-card>
                    <div class="p-3">
                        <TableUserManagement :users="users" />
                    </div>
                </v-card>
            </v-col>
        </v-row>
    </div>
</template>

<style scoped></style>
