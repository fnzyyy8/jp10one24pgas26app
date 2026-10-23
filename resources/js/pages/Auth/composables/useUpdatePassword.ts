import { useForm } from '@inertiajs/vue3';
import { ref } from 'vue';
import { route } from 'ziggy-js';

export function useUpdatePassword() {
    const showCurrentPassword = ref(false);
    const showNewPassword = ref(false);
    const showPasswordConfirmation = ref(false);

    const passwordForm = useForm({
        current_password: '',
        password: '',
        password_confirmation: '',
    });

    function updatePassword() {
        passwordForm.put(route('profile.password.update'), {
            preserveScroll: true,
            onSuccess: () => {
                passwordForm.reset();
                resetPasswordVisibility();
            },
        });
    }

    function resetPasswordVisibility() {
        showCurrentPassword.value = false;
        showNewPassword.value = false;
        showPasswordConfirmation.value = false;
    }

    return {
        passwordForm,
        showCurrentPassword,
        showNewPassword,
        showPasswordConfirmation,
        updatePassword,
    };
}
