import { router } from '@inertiajs/vue3';
import { ref } from 'vue';
import { route } from 'ziggy-js';

export interface WorkerCertificateForm {
    certificate_name: string;
    expired_date: string | null;
    document: File | null;
}

type CertificateField = keyof WorkerCertificateForm;

export type WorkerCertificateErrors = Partial<Record<CertificateField, string>>;

function initialForm(): WorkerCertificateForm {
    return {
        certificate_name: '',
        expired_date: null,
        document: null,
    };
}

export function useWorkerCertificate(workerId: number) {
    const form = ref<WorkerCertificateForm>(initialForm());
    const errors = ref<WorkerCertificateErrors>({});
    const loading = ref(false);

    function resetForm(): void {
        form.value = initialForm();
        errors.value = {};
    }

    function setDocument(file: File | null): void {
        form.value.document = file;
        delete errors.value.document;
    }

    function validate(): boolean {
        const validationErrors: WorkerCertificateErrors = {};
        const name = form.value.certificate_name.trim();
        const file = form.value.document;

        if (!name) {
            validationErrors.certificate_name = 'Nama sertifikat wajib diisi.';
        } else if (name.length > 255) {
            validationErrors.certificate_name =
                'Nama sertifikat maksimal 255 karakter.';
        }

        if (
            form.value.expired_date &&
            Number.isNaN(
                new Date(`${form.value.expired_date}T00:00:00`).getTime(),
            )
        ) {
            validationErrors.expired_date = 'Tanggal kedaluwarsa tidak valid.';
        }

        if (!file) {
            validationErrors.document = 'Dokumen sertifikat wajib diunggah.';
        } else {
            const allowedExtensions = ['pdf', 'jpg', 'jpeg', 'png', 'webp'];

            const extension = file.name.split('.').pop()?.toLowerCase();

            if (!extension || !allowedExtensions.includes(extension)) {
                validationErrors.document =
                    'Format harus PDF, JPG, JPEG, PNG, atau WEBP.';
            } else if (file.size > 10 * 1024 * 1024) {
                validationErrors.document = 'Ukuran dokumen maksimal 10 MB.';
            }
        }

        errors.value = validationErrors;

        return Object.keys(validationErrors).length === 0;
    }

    function create(onSuccess: () => void): void {
        if (loading.value || !validate()) {
            return;
        }

        loading.value = true;

        router.post(
            route('worker.certificates.store', {
                worker: workerId,
            }),
            {
                certificate_name: form.value.certificate_name.trim(),
                expired_date: form.value.expired_date || null,
                document: form.value.document,
            },
            {
                forceFormData: true,
                preserveScroll: true,

                onSuccess: () => {
                    resetForm();
                    onSuccess();
                },

                onError: (serverErrors) => {
                    errors.value = {
                        certificate_name: serverErrors.certificate_name,
                        expired_date: serverErrors.expired_date,
                        document: serverErrors.document,
                    };
                },

                onFinish: () => {
                    loading.value = false;
                },
            },
        );
    }

    return {
        form,
        errors,
        loading,
        resetForm,
        setDocument,
        validate,
        create,
    };
}
